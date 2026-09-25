<?php

/**
 * mod_qlcontact
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 * @var     $contact     ?Contact
 * @var     $parametersBasic     ParametersBasic
 * @var     $BASE_PATH   string
 */

use Hoochicken\Module\Qlcontact\Site\Helper\ParametersBasic;
use Hoochicken\Module\Qlcontact\Site\Helper\Contact;

defined('_JEXEC') or die;

if (empty($contact)) return;
?>

<div class="category-card">
    <h2><?= $contact->getName() ?> <?php if ($parametersBasic->isDebug()): ?>(<?= $contact->getId() ?>)<?php endif; ?></h2>

    <div class="position">
        <?= $contact->getPosition() ?>
    </div>
    <?php if ($contact->existsImage($BASE_PATH)): ?>
        <div class="image">
            <img src="<?= $contact->getImage() ?>" title="<?= $contact->getName() ?>" alt="<?= $contact->getName() ?>"/>
        </div>
    <?php endif; ?>
    <?php if ($contact->hasEmail()): ?>
    <div class="email">
        <a href="mailto:<?= $contact->getEmail() ?>"><?= $contact->getEmail() ?></a>
    </div>
    <?php endif; ?>
    <div class="telephone">
        <a href="tel:<?= $contact->getTelephoneNormalized() ?>"><?= $contact->getTelephone() ?></a>
    </div>
    <div class="mobile">
        <a href="tel:<?= $contact->getMobileNormalized() ?>"><?= $contact->getMobile() ?></a>
    </div>
    <div class="misc">
        <?= $contact->getMisc() ?>
    </div>
</div>
