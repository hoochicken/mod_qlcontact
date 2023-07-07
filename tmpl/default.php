<?php
/**
 * @package        mod_qlcontact
 * @copyright    Copyright (C) 2023 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_qlcontact/css/styles.css');

if (1 == $params->get('showData') && isset($data) && is_object($data) && 0 < (is_countable($data) ? count($data) : 0)) require(__DIR__ . '/default_data.php');
if (1 == $params->get('showText')) require(__DIR__ . '/default_text.php');
if (1 == $params->get('showForm')) require(__DIR__ . '/default_form.php');
if (1 == $params->get('showLink') && false != $link) require(__DIR__ . '/default_link.php');