<?php
/**
 * @package		mod_qlcontact
 * @copyright	Copyright (C) 2013 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$document=JFactory::getDocument();
$document->addStyleSheet(JURI::base().'modules/mod_qlcontact/css/styles.css');

if (1==$params->get('showData') AND isset($data) AND is_object($data) AND 0<count($data)) require(dirname(__FILE__).'/default_data.php');
if (1==$params->get('showText')) require(dirname(__FILE__).'/default_text.php');
if (1==$params->get('showForm')) require(dirname(__FILE__).'/default_form.php');
if (1==$params->get('showLink') AND false!=$link) require(dirname(__FILE__).'/default_link.php');