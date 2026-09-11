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

namespace Hoochicken\Module\Qlcontact\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;


class QlcontactHelper
{
	/**
	 * Method to get the items the helper calls the model to get the items
	 *
	 * @param   Registry  $params  The module parameters
	 * @param   object $app     The application object
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function getMessage($params, $app)
	{
		// Get the message from the $params
		$message = $params->get('my-message', 'Fallback Message can be noted here');

		return $message;
	}
}