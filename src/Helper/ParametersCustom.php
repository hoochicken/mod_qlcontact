<?php
/**
 * mod_qlcontact
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qlcontact\Site\Helper;

use Joomla\Registry\Registry;
use stdClass;

require_once __DIR__ . '/ParametersBasicInterface.php';
require_once __DIR__ . '/ParametersCustomInterface.php';

class ParametersCustom extends ParametersBasic implements ParametersBasicInterface, ParametersCustomInterface
{
    public function __construct(Registry $params, stdClass $module)
    {
        parent::__construct($params, $module);
    }

    public function getMessage(): string
    {
        return (string)$this->params->get('message', 'default message');
    }

    public function isDisplayTypeSubcategories(): bool
    {
        return 'subcategories' === $this->getDisplayType();
    }

    public function isDisplayTypeCategory(): bool
    {
        return 'category' === $this->getDisplayType();
    }

    public function isDisplayTypeContact(): bool
    {
        return 'single' === $this->getDisplayType();
    }

    public function getCategory(): int
    {
        return (int)$this->params->get('category', 0);
    }

    public function getContact(): int
    {
        return (int)$this->params->get('single', 0);
    }

    public function getParentCategory(): int
    {
        return (int)$this->params->get('parentCategory', 0);
    }

    private function getDisplayType(): string
    {
        return (string)$this->params->get('display_type', 'category');
    }

    public function isDisplayCategories(): bool
    {
        return $this->isSubcategoriesAndDisplayContacts() || $this->isCategoryAndDisplayContacts();
    }

    public function isSubcategoriesAndDisplayContacts(): bool
    {
        return $this->isDisplayTypeSubcategories() && $this->params->get('subcategories_display_contacts', false);
    }

    public function isCategoryAndDisplayContacts(): bool
    {
        return $this->isDisplayTypeCategory() && $this->params->get('category_display_contacts', false);
    }
}
