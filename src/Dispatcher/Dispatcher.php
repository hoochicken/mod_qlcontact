<?php
/**
 * @package                                     <mod_qlcontact>
 *
 * @author                                      <HoochickenCompany> | <Me> <email>
 * @copyright                                   Copyright(R) year by  <HoochickenCompany> | <Me>
 * @license                                     GNU General Public License version 2 or later; see LICENSE.txt
 * @link                                        <mywebsite>
 * @since                                       1.0.0
 *
 */

namespace Hoochicken\Module\Qlcontact\Site\Dispatcher;

defined('_JEXEC') or die;

use Hoochicken\Module\Qlcontact\Site\Helper\ParametersBasic;
use Hoochicken\Module\Qlcontact\Site\Helper\ParametersCustom;
use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;
use Hoochicken\Module\Qlcontact\Site\Helper\QlcontactHelper;

class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    protected function getLayoutData()
    {
        $params = new Registry($this->module->params);
        $parametersBasic = new ParametersBasic($params, $this->module);
        $parametersCustom = new ParametersCustom($params, $this->module);

        // var_dump($parametersBasic);
        // var_dump($parametersCustom);
        // Get the module Parameters

        $data          = parent::getLayoutData();

        $data['parametersBasic'] = $parametersBasic;
        $data['parametersCustom'] = $parametersCustom;
        return $data;
    }
}