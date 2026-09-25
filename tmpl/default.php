<?php
/**
 * mod_qlcontact
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 * @var     $module     Module   The module object
 * @var     $params     Registry   The module params
 * @var     $contact     Contact
 * @var     $category     Category
 * @var     $subcategories    Category[]
 * @var     $parametersBasic     ParametersBasic                       The String that has been noted in the module settings and has been stored in the data array in our Dispatcher
 * @var     $parametersCustom    ParametersCustom                       The String that has been noted in the module settings and has been stored in the data array in our Dispatcher
 */

use Hoochicken\Module\Qlcontact\Site\Helper\Category;
use Hoochicken\Module\Qlcontact\Site\Helper\Contact;
use Hoochicken\Module\Qlcontact\Site\Helper\ParametersBasic;
use Hoochicken\Module\Qlcontact\Site\Helper\ParametersCustom;
use Joomla\CMS\Extension\Module;
use Joomla\CMS\Factory;
use Joomla\Registry\Registry;

defined('_JEXEC') or die;

Factory::getApplication()->getDocument()->getWebAssetManager()->registerAndUseStyle('module.qlcontact.styles', 'media/mod_qlcontact/css/styles.css');
?>
<div class="content">
<?php
if ($parametersCustom->isDisplayTypeSubcategories()) {
    require __DIR__ . '/subcategories.php';
} elseif ($parametersCustom->isDisplayTypeCategory()) {
    require __DIR__ . '/category.php';
} elseif ($parametersCustom->isDisplayTypeContact()) {
    require __DIR__ . '/contact.php';
}
?>
</div>
