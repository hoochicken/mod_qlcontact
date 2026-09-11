<?php
/**
 * @package     Hoochicken\Module\Qlcontact
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die;

use Hoochicken\Module\Qlcontact\Site\Helper\ParametersCustom;

/** @var ?ParametersCustom $displayData */
?>
asssssssssssssssssss
<<?= $displayData->getModuleTag() ?> class="<?php echo 'mod_qlcontact ' . $displayData->getModuleClassSuffix(); ?>">
    <?php if ($displayData->displayTitle()) : ?>
        <<?= $displayData->getTitleTag() ?>>
            <?= $displayData->getTitle() ?>
        </<?= $displayData->getTitleTag() ?>>
    <?php endif; ?>
    <div class="module-content">
        <?= $displayData->getMessage(); ?>
    </div>
</<?= $displayData->getModuleTag() ?>>