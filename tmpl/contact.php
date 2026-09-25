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
    <div class="position">
        <?= $contact->getPosition() ?>
    </div>
    <div class="email">
        <?= $contact->getEmail() ?>
    </div>
    <div class="telephone">
        <?= $contact->getTelephone() ?>
    </div>
    <div class="misv">
        <?= $contact->getMisc() ?>
    </div>
</div>
