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
		if(Input::post())
		{
			$val = Validation::forge();

			$val->add('username', __('tonichelp.label.name'))->add_rule('required')->add_rule('min_length', 2)->add_rule('max_length', 32);
			$val->add('email', __('tonichelp.label.email'))->add_rule('required')->add_rule('valid_email');
			$val->add('password', __('tonichelp.label.password'))->add_rule('required')->add_rule('min_length', 8);
			$val->add('repeat_password', __('tonichelp.label.repeat_password'))->add_rule('required')->add_rule('match_field', 'password');

			$val->add('name', __('tonichelp.label.name'))->add_rule('required');
			$val->add('default_email', __('tonichelp.label.default_email'))->add_rule('required')->add_rule('valid_email');

			$val->add('db_name', __('tonichelp.label.name'))->add_rule('required');
			$val->add('db_username', __('tonichelp.label.username'))->add_rule('required');
			$val->add('db_password', __('tonichelp.label.password'))->add_rule('required');
			$val->add('db_prefix', __('tonichelp.label.table_prefix'));
			$val->add('db_engine', __('tonichelp.label.table_engine'))->add_rule('required')->add_rule('valid_string', array('numeric'));

			if($val->run())
			{
				
			}
		}

		return Response::forge(View::forge('installer/index'));
	}

}