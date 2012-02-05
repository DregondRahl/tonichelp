<?php
/**
 * TonicHelp is a opensource support ticket system/helpdesk.
 *
 * @package    TonicHelp
 * @version    1.0
 * @author     TonicHelp Development Team
 * @license    -- to be decided --
 * @copyright  2012 TonicHelp Development Team
 * @link       http://tonichelp.com
 */

class BaseController extends \Controller
{
	
	public function before()
	{
		parent::before();

		// Check if the application is installed
		if (!file_exists(realpath(APPPATH.'config/tonichelp.php')) OR Config::get('tonichelp.to_install'))
		{
			Response::redirect('installer');
		}
	}

}