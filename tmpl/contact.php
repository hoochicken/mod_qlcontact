<?php

/**
 * mod_qlcontact
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 * @var     $contact     ?Contact
 *
 */

use Hoochicken\Module\Qlcontact\Site\Helper\Contact;

defined('_JEXEC') or die;

if (empty($contact)) return;
?>

<div class="category">
    <h2><?= $contact->getName() ?> (<?= $contact->getId() ?>)</h2>
    <div class="description">
        <?= $contact->getDescription() ?>
    </div>
</div>
