<?php
/**
 * @package                                     <mod_qlcontact>
 *
 * @author                                      <HoochickenCompany> | <Me> <email>
 * @copyright                                   Copyright(R) year by  <HoochickenCompany> | <Me>
 * @license                                     GNU General Public License version 2 or later; see LICENSE.txt
 * @link                                        <mywebsite>
 * @since                                       1.0.0
 *
 */

namespace Hoochicken\Module\Qlcontact\Site\Dispatcher;

defined('_JEXEC') or die;

use Hoochicken\Module\Qlcontact\Site\Helper\Category;
use Hoochicken\Module\Qlcontact\Site\Helper\Contact;
use Hoochicken\Module\Qlcontact\Site\Helper\ParametersBasic;
use Hoochicken\Module\Qlcontact\Site\Helper\ParametersCustom;
use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;
use Joomla\CMS\Uri\Uri;
use Joomla\Database\DatabaseDriver;
use Joomla\Database\DatabaseInterface;
use Joomla\Registry\Registry;
use Hoochicken\Module\Qlcontact\Site\Helper\QlcontactHelper;

class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    private ?DatabaseDriver $database = null;

    protected function getLayoutData()
    {
        $this->database = Factory::getContainer()->get(DatabaseInterface::class);

        $params = new Registry($this->module->params);
        $parametersBasic = new ParametersBasic($params, $this->module);
        $parametersCustom = new ParametersCustom($params, $this->module);

        // get categories
        $categories = $parametersCustom->isDisplayTypeSubcategories()
            ? $this->getSubcategories($parametersCustom->getParentCategory())
            : (
            $parametersCustom->isDisplayTypeCategory()
                ? [$this->getCategory($parametersCustom->getCategory())]
                : []);
        $categories = array_filter($categories);

        // get contacts
        $categoryIds = array_map(fn(Category $category) => $category->getId(), $categories);
        $contacts = $this->getContacts($categoryIds);
        $categories = $this->mapContactsToCategories($categories, $contacts);

        // build display data
        $data = parent::getLayoutData();
        $data['parametersBasic'] = $parametersBasic;
        $data['parametersCustom'] = $parametersCustom;
        $data['subcategories'] = $categories;
        return $data;
    }

    /**
     * @param int $category
     * @return Category
     */
    private function getCategory(int $category): ?Category
    {
        $query = $this->database->getQuery(true);
        $query
            ->select(['id', 'title', 'description'])
            ->from('#__categories')
            ->where([
                'id = ' . $category,
                'published = 1'
            ]);
        $this->database->setQuery($query);
        $data = $this->database->loadAssoc();
        if (empty($data)) {
            return null;
        }
        return Category::init($data);
    }

    /**
     * @param int $category
     * @return Category[]
     */
    private function getSubcategories(int $category): array
    {
        $query = $this->database->getQuery(true);
        $query
            ->select(['id', 'title', 'description'])
            ->from('#__categories')
            ->where([
                'parent_id = ' . $category,
                'published = 1'
            ]);
        $this->database->setQuery($query);
        $data = $this->database->loadAssocList();
        return array_map(fn($item) => Category::init($item), $data);
    }

    /**
     * @param int[] $categories
     * @return Contact[]
     */
    private function getContacts(array $categories): array
    {
        if (empty($categories)) {
            return [];
        }
        $query = $this->database->getQuery(true);
        $query
            ->select([
                'id',
                'catid',
                'name',
                'con_position AS position',
                'telephone',
                'email_to AS email',
                'misc',
            ])
            ->from('#__contact_details')
            ->where([
                sprintf('catid IN(%s)', implode(',', $categories)),
                'published = 1'
            ]);
        $this->database->setQuery($query);
        $data = $this->database->loadAssocList();
        return array_map(fn($item) => Contact::init($item), $data);
    }

    /**
     * @param Category[] $categories
     * @param Contact[] $contacts
     * @return Category[]
     */
    private function mapContactsToCategories(array $categories, array $contacts): array
    {
        foreach ($categories as $category) {
            $contactsOfCat = array_filter($contacts, static fn(Contact $contact) => $contact->getCatId() === $category->getId());
            $category->setContacts($contactsOfCat);
        }
        return $categories;
    }
}
