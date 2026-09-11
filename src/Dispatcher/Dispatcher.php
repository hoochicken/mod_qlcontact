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
    // Get the module Parameters
        $params = new Registry($this->module->params);
        $data          = parent::getLayoutData();

        $helperName    = 'QlcontactHelper';
        $data['mymsg'] = $this->getHelperFactory()->getHelper($helperName)->getMessage($data['params'], $this->getApplication());
        return $data;
    }
}