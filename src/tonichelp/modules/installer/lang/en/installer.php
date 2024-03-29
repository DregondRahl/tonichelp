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

return array(

	/**
	 * Installer
	 */
	'installer' => array(
		'title'                 => 'TonicHelp Installer',

		'step_1' => array(
			'title'                     => 'Step 1',
			'caption'                   => 'Settings',
			'introduction'              => "With two steps you'll configure your TonicHelp application.",
			'admin_user'                => 'Administrator user',
			'general_config'            => 'General configuration',
			'general_name_help'         => 'This will be the name of the application.',
			'general_email_help'        => 'By default emails will be sent from this direction',
			'mysql_database'            => 'MySQL database',
			'mysql_prefix_help'         => 'Prefix the database tables, ie: <strong>th_</strong>',
			'mysql_engine_default'      => 'default',
			'mysql_engine_help'         => "If you don't know what is that, better don't touch it.",
		),

		'step_2' => array(
			'title'                     => 'Step 2',
			'caption'                   => 'Confirmation',
			'introduction'              => 'Did you have an old TonicHelp installation? Run this process will delete old tables. If you want another instance of TonicHelp, just use a database prefix.',
		),

		'errors' => array(
			'invalid_path'              => "File cannot be created or writed. Does the directory ':path' exists and is writable?",
			'write_config'              => "The config file ':path' can't be wrote.",
			'create_database'           => "The database ':dbname' can't be created. Do you have rights?",
			'invalid_delete'			=> "The file/path can't be deleted. Does ':path' exists and have rights?",
			'migration_exists'          => "It seems that TonicHelp has already been installed...",
		),
	),

);