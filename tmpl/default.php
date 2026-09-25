<?php
/**
 * mod_qlcontact
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 * @var     $module     \Joomla\CMS\Module\Module   The module object
 * @var     $params     \Joomla\Registry\Registry   The module params
 * @var     $parametersBasic     \Hoochicken\Module\Qlcontact\Site\Helper\ParametersBasic                       The String that has been noted in the module settings and has been stored in the data array in our Dispatcher
 * @var     $parametersCustom    \Hoochicken\Module\Qlcontact\Site\Helper\ParametersCustom                       The String that has been noted in the module settings and has been stored in the data array in our Dispatcher
 *
 */

defined('_JEXEC') or die;

echo '<h1>' . $parametersCustom->getMessage() . '</h1>';