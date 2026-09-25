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
use Hoochicken\Module\Qlcontact\Site\Helper\Database;
use Hoochicken\Module\Qlcontact\Site\Helper\MessageCollection;
use Hoochicken\Module\Qlcontact\Site\Helper\ParametersBasic;
use Hoochicken\Module\Qlcontact\Site\Helper\ParametersCustom;
use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;
use Joomla\Database\DatabaseDriver;
use Joomla\Database\DatabaseInterface;
use Joomla\Registry\Registry;

class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    private ?Database $database = null;

    protected function getLayoutData()
    {
        $this->database = new Database(Factory::getContainer()->get(DatabaseInterface::class), new MessageCollection());

        $params = new Registry($this->module->params);
        $parametersBasic = new ParametersBasic($params, $this->module);
        $parametersCustom = new ParametersCustom($params, $this->module);

        $categories = [];
        if ($parametersCustom->isDisplayTypeSubcategories()) {
            $categories = $parametersCustom->isDisplayTypeSubcategories()
                ? $this->database->getSubcategories($parametersCustom->getParentCategory())
                : [];
            $categories = array_filter($categories);
            $categoryIds = array_map(fn(Category $category) => $category->getId(), $categories);
            $contacts = $this->database->getContactsByCategoryId($categoryIds);
            $categories = $this->database->mapContactsToCategories($categories, $contacts);
        }

        $category = null;
        if ($parametersCustom->isDisplayTypeCategory() ) {
            $category = $this->database->getCategoryById($parametersCustom->getCategory());
            $contacts = $this->database->getContactsByCategoryId([$category->getId()]);
            $category->setContacts($contacts);;
        }

        $contact = $parametersCustom->isDisplayTypeContact()
            ? $this->database->getContactById($parametersCustom->getContact())
            : null;

        if ($parametersBasic->isDebug()) {
            print_r($this->database->getSqls());
        }

        // build display data
        $data = parent::getLayoutData();
        $data['parametersBasic'] = $parametersBasic;
        $data['parametersCustom'] = $parametersCustom;
        $data['subcategories'] = $categories;
        $data['category'] = $category;
        $data['contact'] = $contact;
        $data['BASE_PATH'] = JPATH_BASE;
        return $data;
    }
}
