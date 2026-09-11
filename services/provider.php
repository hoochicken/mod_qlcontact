<?php
/**
 * @package     Hoochicken\Module\Qlcontact
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\HelperFactory;
use Joomla\CMS\Extension\Service\Provider\Module;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class() implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container->registerServiceProvider(new ModuleDispatcherFactory('\\Hoochicken\\Module\\Qlcontact'));
        $container->registerServiceProvider(new HelperFactory('\\Hoochicken\\Module\\Qlcontact\\Site\\Helper'));
        $container->registerServiceProvider(new Module());
    }
};