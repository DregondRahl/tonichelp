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

			$val->add('db_hostname', __('tonichelp.label.hostname'))->add_rule('required');
			$val->add('db_name', __('tonichelp.label.name'))->add_rule('required');
			$val->add('db_username', __('tonichelp.label.username'))->add_rule('required');
			$val->add('db_password', __('tonichelp.label.password'))->add_rule('required');
			$val->add('db_prefix', __('tonichelp.label.table_prefix'));
			$val->add('db_engine', __('tonichelp.label.table_engine'))->add_rule('required')->add_rule('valid_string', array('numeric'));

			if($val->run())
			{
				$config = array('test' => 'vafoor');

				$path = realpath(APPPATH.'config/production/');

				// If file doesn't exists, we will create it!
				if(!file_exists($path.'/db.php'))
				{
					try
					{
						File::create($path, 'db.php', null);	
					}
					catch (InvalidPathException $e)
					{
						// directory can't be written
					}
					catch (FileAccessException $e)
					{
						// file exists so... we can replace the old config :-)!!
					}
				}

				Config::save($path.'/db.php', $config);


				/*
				$db_config = Config::load(realpath(APPPATH.'production/db.php'), 'db', true, true);

				Debug::dump(file_exists(realpath(APPPATH.'production/db.php')), $db_config, Config::get('db'));die;

				$hostname     = Input::post('db_hostname');
				$dbname       = Input::post('db_name');
				$username     = Input::post('db_username');
				$password     = Input::post('db_password');
				$table_prefix = Input::post('db_prefix');

				// First we try the database connection
				$config = array(
					'connection'  => array(
						'dsn'        => 'mysql:host='.$hostname,
						'username'   => $username,
						'password'   => $password,
						'persistent' => false,
					),
					'type'         => 'pdo',
					'identifier'   => '`',
					'table_prefix' => $table_prefix,
					'charset'      => 'utf8',
					'caching'      => false,
					'profiling'    => false,
				);

				$db = Database_Connection::instance($dbname, $config);

				DB::query('CREATE DATABASE '.DB::quote_identifier($dbname).' CHARACTER SET '.$config['charset'], \DB::UPDATE)->execute($dbname);*/
			}
		}

		return Response::forge(View::forge('installer/index'));
	}

}