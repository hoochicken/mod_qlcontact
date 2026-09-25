<?php

/**
 * mod_qlcontact
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 * @var     $category     ?Category
 *
 */

use Hoochicken\Module\Qlcontact\Site\Helper\Category;

defined('_JEXEC') or die;

if (empty($category)) return;
?>

<div class="category">
    <h3><?= $category->getTitle() ?> (<?= $category->getId() ?>)</h3>
    <div class="description">
        <?= $category->getDescription() ?>
    </div>
    <div class="categories">
        <?php foreach ($category->getContacts() as $contact) : ?>
            <?php require __DIR__ . '/contact.php'; ?>
        <?php endforeach; ?>
    </div>
</div>
