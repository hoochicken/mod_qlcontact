<?php
/**
 * @package     Hoochicken\Module\Qlcontact
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qlcontact\Site\Dispatcher;

defined('_JEXEC') or die;

use Exception;
use Hoochicken\Module\Qlcontact\Site\Helper\DisplayData;
use Hoochicken\Module\Qlcontact\Site\Helper\DisplayDataInterface;
use Hoochicken\Module\Qlcontact\Site\Helper\ParametersCustom;
use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;
use Hoochicken\Module\Qlcontact\Site\Helper\QlcontactHelper;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Registry\Registry;

class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    private const HELPER_NAME = 'QlcontactHelper';
    private ?Registry $params = null;

    public function dispatch()
    {
        try {
            $this->loadLanguage();

            $displayData = $this->getLayoutData();
            if ($this->isProperDisplayCustom($displayData)) {
                return;
            }

            /** @var ParametersCustom $displayData */
            $displayData = $displayData['data'] ?? null;
            require ModuleHelper::getLayoutPath('mod_qlcontact', $displayData->getLayout());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function isProperDisplayCustom(array $displayData): bool
    {
        return empty($displayData) || !isset($displayData['data']) || ParametersCustom::class !== get_class($displayData['data']);
    }

    protected function getLayoutData()
    {
        try {
            $data = parent::getLayoutData();
            $this->params = new Registry($data['params']);

            $displayModel = $this->getLayoutDataRaw();
            return $displayModel->toArray();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    protected function getLayoutDataRaw(): DisplayDataInterface
    {
        $data = parent::getLayoutData();
        $this->params = new Registry($data['params']);

        /** @var QlcontactHelper $helper */
        $helper = $this->getHelperFactory()->getHelper(self::HELPER_NAME);

        $params = new ParametersCustom($this->params ?? null, $this->module);
        $displayData = new DisplayData($params);
        $displayData->setMessage($helper->getMessage($this->params, $this->getApplication()));

        return $displayData;
    }
}