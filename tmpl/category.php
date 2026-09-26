<?php

/**
 * mod_qlcontact
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 * @var     $category     ?Category
 * @var     $parametersCustom    ParametersCustom
 */

use Hoochicken\Module\Qlcontact\Site\Helper\Category;
use Hoochicken\Module\Qlcontact\Site\Helper\ParametersCustom;

defined('_JEXEC') or die;

if (empty($category)) return;
?>

<div class="qlcontact category <?= $parametersCustom->getCategoryItemClass('col-md-12') ?>">
    <?php if ($parametersCustom->isSubcategoriesAndDisplayTitle() || $parametersCustom->isCategoryAndDisplayTitle()) : ?>
        <h3><?= $category->getTitle() ?> <?php if ($parametersCustom->isDebug()): ?>(<?= $category->getId() ?>)<?php endif; ?></h3>
        <div class="description">
            <?= $category->getDescription() ?>
        </div>
    <?php endif; ?>
    <?php if (($parametersCustom->isSubcategoriesAndDisplayContacts() || $parametersCustom->isCategoryAndDisplayContacts())
            && $category->hasContacts()): ?>
        <div class="contacts">
            <?php foreach ($category->getContacts() as $contact) : ?>
                <?php require __DIR__ . '/contact.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
