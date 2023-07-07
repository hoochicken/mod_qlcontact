<?php
/**
 * @package		mod_qlcontact
 * @copyright	Copyright (C) 2023 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
if (is_object($data) && isset($data->{$k.'_name'}) && ''!=$data->{$k.'_name'})$linktext=$data->{$k.'_name'};
elseif (is_array($data) && isset($data[$k.'_name']) && ''!=$data[$k.'_name'])$linktext=$data[$k.'_name'];
else $linktext=$v;
echo '<a class="'.$k.'" target="_blank" href="'.$v.'">'.$linktext.'</a>';
unset($linktext);