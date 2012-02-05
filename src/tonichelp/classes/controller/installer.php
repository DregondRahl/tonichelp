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

class Controller_Installer extends \Controller
{
	
	public function before()
	{
		parent::before();
		
		// Check if the application is installed
		if (file_exists(realpath(APPPATH.'config/tonichelp.php')) AND (bool) Config::get('tonichelp.to_install') === false)
		{
			// We don't let the user know that the controller exists
			throw new HttpNotFoundException;
		}
	}

	public function action_index()
	{
		return Response::forge(View::forge('installer/index'));
	}

}