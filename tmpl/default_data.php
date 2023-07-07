<?php
/**
 * @package		mod_qlcontact
 * @copyright	Copyright (C) 2013 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
if (count($data)>0) :

$arrLink=array('contact_params_linka','contact_params_linkb','contact_params_linkc','contact_params_linkd','contact_params_linke');
    ?>
<div class="qlcontact data">
    <dl>
        <?php
        if (is_object($dataDisplay) OR is_array($dataDisplay)):
            while(list($k,$v)=each($dataDisplay)):
                if (1==$params->get('showlabels')) : ?>
                    <dt class="<?php echo $k;?>"><?php echo JText::_('MOD_QLCONTACT_'.strtoupper($k)); ?></dt><?php
                endif; ?>
                <dd class="<?php echo $k;?>">
                    <?php
                    if ('contact_image'==$k) require(dirname(__FILE__).'/default_data_image.php');
                    elseif ('contact_email_to'==$k) require(dirname(__FILE__).'/default_data_mail.php');
                    elseif ('contact_name'==$k) require(dirname(__FILE__).'/default_data_name.php');
                    elseif (in_array($k,$arrLink)) require(dirname(__FILE__).'/default_data_link.php');
                    else echo $v; ?>
                </dd>
                <?php
            endwhile;
        endif;
        ?>
    </dl>
</div>
<?php endif;