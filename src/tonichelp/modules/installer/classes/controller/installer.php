<?php
/**
 * TonicHelp is a opensource support ticket system/helpdesk.
 *
 * @package    TonicHelp
 * @version    1.0
 * @author     TonicHelp Development Team
 * @license    BSD 3-Clause License
 * @copyright  2012 TonicHelp Development Team
 * @link       http://tonichelp.com
 */

namespace Installer;

class Controller_Installer extends \Controller
{
	
	public function before()
	{
		parent::before();
		
		// Check if the application is installed
		if (file_exists(realpath(APPPATH.'config/tonichelp.php')) AND (bool) \Config::get('tonichelp.to_install') === false)
		{
			// We don't let the user know that the controller exists
			throw new \HttpNotFoundException;
		}

		\Lang::load('installer', 'tonichelp');
	}

	public function action_index()
	{
		if (\Input::post())
		{
			$val = \Validation::forge();

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
			$val->add('db_engine', __('tonichelp.label.table_engine'))->add_rule('required');

			if ($val->run())
			{
				$hostname     = \Input::post('db_hostname');
				$dbname       = \Input::post('db_name');
				$username     = \Input::post('db_username');
				$password     = \Input::post('db_password');
				$table_prefix = \Input::post('db_prefix');
				$engine       = \Input::post('db_engine');

				// Database configuration schema
				$config = array(
					'default' => array(
						'connection'  => array(
							'dsn'        => 'mysql:host='.$hostname, // We save later the dbname
							'username'   => $username,
							'password'   => $password,
							'persistent' => false,
						),
						'table_prefix' => $table_prefix,
						'engine' => $engine,
					),
				);

				// Path for db config
				$basepath = APPPATH.'config/';
				$path     = $basepath.'production/';

				// We will create the production dir if not found
				if (!is_dir(realpath($path)))
				{
					try
					{
						\File::create_dir(realpath($basepath), 'production', 0777);
					}
					catch (\FileAccessException $e)
					{
						$error = __('tonichelp.installer.errors.invalid_path', array('path' => $basepath));
						
						return \Response::forge(\View::forge('index', array('error' => $error)));
					}
				}

				// If file doesn't exists, we will create it!
				if (!file_exists(realpath($path.'db.php')))
				{
					try
					{
						\File::create(realpath($path), 'db.php', null);	
					}
					catch (\InvalidPathException $e)
					{
						$error = __('tonichelp.installer.errors.invalid_path', array('path' => $path));
						
						return \Response::forge(\View::forge('index', array('error' => $error)));
					}
					catch (\FileAccessException $e)
					{
						// file exists so ignore that... we can replace the old config :-)!!
					}
				}

				// Ok, the file exists or has been created... now write our db config!
				try
				{
					\Config::save(realpath($path.'db.php'), $config);
				}
				catch (\FileAccessException $e)
				{
					$error = __('tonichelp.installer.errors.config', array('path' => $path.'db.php'));
						
					return \Response::forge(\View::forge('index', array('error' => $error)));
				}

				// Congrats! You've now a DB config but... does it work? ;-)
				try
				{
					// This will create the database (if exists, it will ignore it)
					\DBUtil::create_database($dbname);

					// Now we can setup the db file with the full dsn connection
					try
					{
						\Config::load(realpath($path.'db.php'), 'db');
						\Config::set('db.default.connection.dsn', 'mysql:host='.$hostname.';dbname='.$dbname);
						\Config::save(realpath($path.'db.php'), 'db');
					}
					catch (\FileAccessException $e)
					{
						$error = __('tonichelp.installer.errors.config', array('path' => $path.'db.php'));
							
						return \Response::forge(\View::forge('index', array('error' => $error)));
					}
				}
				catch (\Database_Exception $e)
				{
					$error = __('tonichelp.installer.errors.create_database', array('dbname' => $dbname));
						
					return \Response::forge(\View::forge('index', array('error' => $error)));
				}

				// General config vars on tonichelp config file (on next step will be migrated to DB too)
				$config = array(
					'to_install' => true, // This will force the installation process
					'site'       => array(
						'name'          => \Input::post('name'),
						'default_email' => \Input::post('default_email'),
					),
				);

				try
				{
					\Config::save('tonichelp', $config);
				}
				catch (\FileAccessException $e)
				{
					$error = __('tonichelp.installer.errors.config', array('path' => APPPATH.'config/tonichelp.php'));
						
					return \Response::forge(\View::forge('index', array('error' => $error)));
				}
				
				// Finally, we save temporaly username, password and email on Session
				$user_data = array(
					'username'  => \Input::post('username'),
					'password'  => \Input::post('password'),
					'email'     => \Input::post('email'),
				);

				\Session::set('user_data', $user_data);

				// To know if we had run the step 1
				\Session::set('step_1', true);

				// We are done, send the user to the confirmation page
				\Response::redirect('installer/confirm');
			}
		}

		return \Response::forge(\View::forge('index'));
	}

	public function action_confirm()
	{
		// Confirm that we had run the first step of the installer
		if (!\Session::get('step_1'))
			\Response::redirect('installer');

		if(\Input::post())
		{
			if(isset($_POST['cancel']))
			{
				// Delete the production db file
				$db_path = APPPATH.'config/production/db.php';

				if (file_exists(realpath($db_path)))
				{
					try
					{
						\File::delete(realpath($db_path));
					}
					catch (\OutsideAreaException $e)
					{
						
					}
					catch (\InvalidPathException $e)
					{
						$error = __('tonichelp.installer.errors.invalid_delete', array('path' => $db_path));

						return \Response::forge(\View::forge('confirm', array('error' => $error)));
					}
				}

				// Delete tonichelp config file
				$config_path = APPPATH.'config/tonichelp.php';

				if (file_exists(realpath($config_path)))
				{
					try
					{
						\File::delete(realpath($config_path));
					}
					catch (\OutsideAreaException $e)
					{
						
					}
					catch (\InvalidPathException $e)
					{
						$error = __('tonichelp.installer.errors.invalid_delete', array('path' => $config_path));

						return \Response::forge(\View::forge('confirm', array('error' => $error)));	
					}
				}

				// Clear Session data and return to step 1
				\Session::destroy();

				\Response::redirect('installer');
			}

			// We have the user confirmation, so run the migration task
			// to install the first schema
			$installer_migration = \Migrate::latest('installer', 'module');

			if((bool) $installer_migration === false)
			{
				$error = __('tonichelp.installer.errors.migration_exists', array('path' => $config_path));

				return \Response::forge(\View::forge('confirm', array('error' => $error)));	
			}

			/**
			 * Now we will try to install all the modules
			 */

			// First we need to know which modules and the order of them
			$modules = array();
			$after = array();

			foreach(\Config::get('module_paths') as $path)
			{
				foreach(\File::read_dir($path, 1) as $module => $value)
				{
					$module = str_replace(array('/', DS), '', $module);
					$module_config = null;
					
					if(empty($module) OR $module == 'installer')
						continue;

					$file_path = $path.DS.$module.DS.'config'.DS.'module.php';

					if(file_exists($file_path))
					{
						$module_config = include($file_path);

						if(!isset($module_config['install']))
						{
							$modules[] = $module;

							continue;
						}

						if(isset($module_config['install']['position']))
						{
							if($module_config['install']['position'] == 'before')
							{
								$key = array_search($module_config['install']['module'], $modules);
								
								if(false !== $key)
									$insert = \Arr::insert_before_key($modules, $module, $key);
								else
									$modules[] = $module;

								continue;
							}
							else
							{
								$key = array_search($module_config['install']['module'], $modules);
								
								if(false !== $key)
									\Arr::insert_after_key($modules, $module, $key);
								else
									$after[$module] = $module_config['install']['module'];

								continue;
							}
						}
						else
						{
							$modules[] = $module;
						}
					}
					else
					{
						$modules[] = $module;
					}
				}
			}

			/**
			 * If there is any after position we couldn't add it, we need to
			 * for each them and try to add it. If there is the position is not
			 * found we add it to the $modules array anyway.
			 */
			if(count($after) > 0)
			{
				foreach($after as $module => $after_module)
				{
					$key = array_search($after_module, $modules);	

					if(false !== $key)
						\Arr::insert_after_key($modules, $module, $key);
					else
						$modules[] = $module;
				}
			}

			// Finally, run migrations for each of it :-)
			foreach($modules as $module)
			{
				\Migrate::latest($module, 'module');
			}
		}

		return \Response::forge(\View::forge('confirm'));
	}

}