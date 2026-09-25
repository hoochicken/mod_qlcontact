<?php

namespace Hoochicken\Module\Qlcontact\Site\Helper;

use Joomla\Database\DatabaseDriver;

class Database
{
    private DatabaseDriver $db;

    private MessageCollection $sqls;

    public function __construct(DatabaseDriver $db, MessageCollection $sqls)
    {
        $this->db = $db;
        $this->sqls = $sqls;
    }

    public function getCategoryById(int $categoryId): ?Category
    {
        $query = $this->db->getQuery(true);
        $query
            ->select(['id', 'title', 'description'])
            ->from('#__categories')
            ->where([
                'id = ' . $categoryId,
                'published = 1'
            ]);
        $this->db->setQuery($query);
        $this->sqls->add(new MessageItem((string)$query));
        $data = $this->db->loadAssoc();
        if (empty($data)) {
            return null;
        }
        return Category::init($data);
    }

    /**
     * @param int $category
     * @return Category[]
     */
    public function getSubcategories(int $category): array
    {
        $query = $this->db->getQuery(true);
        $query
            ->select(['id', 'title', 'description'])
            ->from('#__categories')
            ->where([
                'parent_id = ' . $category,
                'published = 1'
            ]);
        $this->db->setQuery($query);
        $this->sqls->add(new MessageItem((string)$query));
        $data = $this->db->loadAssocList();
        return array_map(fn($item) => Category::init($item), $data);
    }

    /**
     * @param int[] $categories
     * @return Contact[]
     */
    public function getContactsByCategoryId(array $categories): array
    {
        if (empty($categories)) {
            return [];
        }
        $query = $this->db->getQuery(true);
        $query
            ->select([
                'id',
                'catid',
                'name',
                'con_position AS position',
                'mobile',
                'telephone',
                'email_to AS email',
                'misc',
                'image',
            ])
            ->from('#__contact_details')
            ->where([
                sprintf('catid IN(%s)', implode(',', $categories)),
                'published = 1'
            ]);
        $this->db->setQuery($query);
        $this->sqls->add(new MessageItem((string)$query));
        $data = $this->db->loadAssocList();
        return array_map(fn($item) => Contact::init($item), $data);
    }

    public function getContactById(int $id): ?Contact
    {
        $query = $this->db->getQuery(true);
        $query
            ->select([
                'id',
                'catid',
                'name',
                'con_position AS position',
                'mobile',
                'telephone',
                'email_to AS email',
                'misc',
                'image',
            ])
            ->from('#__contact_details')
            ->where([
                sprintf('id = %d', $id),
                'published = 1'
            ]);
        $this->db->setQuery($query);
        $this->sqls->add(new MessageItem((string)$query));
        $data = $this->db->loadAssoc();
        return empty($data) ? null : Contact::init($data);
    }

    /**
     * @param Category[] $categories
     * @param Contact[] $contacts
     * @return Category[]
     */
    public function mapContactsToCategories(array $categories, array $contacts): array
    {
        foreach ($categories as $category) {
            $contactsOfCat = array_filter($contacts, static fn(Contact $contact) => $contact->getCatId() === $category->getId());
            $category->setContacts($contactsOfCat);
        }
        return $categories;
    }

    public function getSqls(): array
    {
        return $this->sqls->get();
    }
}
