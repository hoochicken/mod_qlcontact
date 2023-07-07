<?php
/**
 * @package        mod_qlcontact
 * @copyright    Copyright (C) 2023 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

/** @var object $dataDisplay */
/** @var \Joomla\Registry\Registry $params */
// no direct access
defined('_JEXEC') or die;
    $arrLink = ['contact_params_linka', 'contact_params_linkb', 'contact_params_linkc', 'contact_params_linkd', 'contact_params_linke'];
    ?>
    <div class="qlcontact data">
        <dl>
            <?php
            if (is_object($dataDisplay) or is_array($dataDisplay)):
                foreach ($dataDisplay as $k => $v) :
                    if ((bool)$params->get('showlabels')) : ?>
                        <dt
                        class="<?php echo $k; ?>"><?php echo JText::_('MOD_QLCONTACT_' . strtoupper((string) $k)); ?></dt><?php
                    endif; ?>
                    <dd class="<?php echo $k; ?>">
                        <?php
                        if ('contact_image' == $k) require(__DIR__ . '/default_data_image.php');
                        elseif ('contact_email_to' == $k) require(__DIR__ . '/default_data_mail.php');
                        elseif ('contact_name' == $k) require(__DIR__ . '/default_data_name.php');
                        elseif (in_array($k, $arrLink)) require(__DIR__ . '/default_data_link.php');
                        else echo $v; ?>
                    </dd>
                <?php
                endforeach;
            endif;
            ?>
        </dl>
    </div>
