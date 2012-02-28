<?php

namespace Fuel\Migrations;

class Install
{

	public function up()
	{
		\Config::load('db', true);

		$engine  = \Config::get('db.default.engine');
		$charset = \Config::get('db.default.charset');

		/**
		 * Sentry Package
		 *
		 * We let the user select the DB Engine (yeah, we are so cool and TokuDB rocks!),
		 * so we need to create there the sentry tables. Anyway, they can have some
		 * modifications like users_metadata so it's not so ugly to have it here. :-)
		 *
		 * They are also created in first instance because our tables will have constraint
		 * poiting to Sentrys tables.
		 */
		\DBUtil::create_table('users',
			array(
				'id'                  => array('constraint' => 11,  'type' => 'int', 'auto_increment' => true),
				'username'            => array('constraint' => 50,  'type' => 'varchar'),
				'email'               => array('constraint' => 254, 'type' => 'varchar'),
				'password'            => array('constraint' => 81,  'type' => 'varchar'),
				'password_reset_hash' => array('constraint' => 81,  'type' => 'varchar'),
				'temp_password'       => array('constraint' => 81,  'type' => 'varchar'),
				'remember_me'         => array('constraint' => 81,  'type' => 'varchar'),
				'activation_hash'     => array('constraint' => 81,  'type' => 'varchar'),
				'last_login'          => array('constraint' => 11,  'type' => 'int'),
				'ip_address'          => array('constraint' => 50,  'type' => 'varchar'),
				'updated_at'          => array('constraint' => 11,  'type' => 'int', 'null' => true),
				'created_at'          => array('constraint' => 11,  'type' => 'int'),
				'status'              => array('constraint' => 1,   'type' => 'tinyint'),
				'activated'           => array('contsraint' => 1,   'type' => 'tinyint'),
			),
			array('id'), true, $engine, $charset
		);

		\DBUtil::create_table('users_metadata',
			array(
				'user_id'    => array('constraint' => 11, 'type' => 'int'),
				'first_name' => array('constraint' => 50, 'type' => 'varchar'),
				'last_name'  => array('constraint' => 50, 'type' => 'varchar'),
			),
			array('user_id'), true, $engine, $charset
		);

		\DBUtil::create_table('groups',
			array(
				'id'       => array('constraint' => 11,  'type' => 'int', 'auto_increment' => true),
				'name'     => array('constraint' => 200, 'type' => 'varchar'),
				'level'    => array('constraint' => 11,  'type' => 'int'),
				'is_admin' => array('constraint' => 1,   'type' => 'tinyint'),
				'parent' => array('constraint' => 11, 'type' => 'int'),
			),
			array('id'), true, $engine, $charset
		);

		\DBUtil::create_table('users_suspended',
			array(
				'id'              => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
				'login_id'        => array('constraint' => 50, 'type' => 'varchar'),
				'attempts'        => array('constraint' => 50, 'type' => 'int'),
				'ip'              => array('constraint' => 25, 'type' => 'varchar'),
				'last_attempt_at' => array('constraint' => 11, 'type' => 'int'),
				'suspended_at'    => array('constraint' => 11, 'type' => 'int'),
				'unsuspend_at'    => array('constraint' => 11, 'type' => 'int'),
			),
			array('id'), true, $engine, $charset
		);

		\DBUtil::create_table('users_groups',
			array(
				'user_id'  => array('constraint' => 11, 'type' => 'int'),
				'group_id' => array('constraint' => 11, 'type' => 'int'),
			),
			array(), true, $engine, $charset
		);


		/**
		 * TonicHelp tables
		 *
		 * Our base installaton of TonicHelp
		 */
		\DBUtil::create_table('tickets',
			array(
				'id'           => array('constraint' => 11,  'type' => 'int', 'auto_increment' => true),
				'creator_id'   => array('constraint' => 11,  'type' => 'int'),
				'asigned_id'   => array('constraint' => 11,  'type' => 'int'),
				'updater_id'   => array('constraint' => 11,  'type' => 'int'),
				'type'         => array('constraint' => 11,  'type' => 'int',    'unsigned' => true, 'default' => '0', 'comment' => '0:default'),
				'status'       => array('constraint' => 11,  'type' => 'int',    'unsigned' => true, 'default' => '0', 'comment' => '0:new'),
				'subject'      => array('constraint' => 128, 'type' => 'varchar'),
				'priority'     => array('constraint' => 11,  'type' => 'int',    'unsigned' => true, 'default' => '0', 'comment' => '0:default'),
				'resolution'   => array('constraint' => 11,  'type' => 'int',    'unsigned' => true, 'default' => '0', 'comment' => '0:not resolved'),
				'is_answered'  => array('constraint' => 1,   'type' => 'tinyint', 'default' => '0'),
				'received_at'  => array('constraint' => 11,  'type' => 'int',    'null' => true),
				'created_at'   => array('constraint' => 11,  'type' => 'int',    'null' => true),
				'read_at'      => array('constraint' => 11,  'type' => 'int',    'null' => true),
				'updated_at'   => array('constraint' => 11,  'type' => 'int',    'null' => true),
				'closed_at'    => array('constraint' => 11,  'type' => 'int',    'null' => true),
			),
			array('id'), true, $engine, $charset,
			array(
				array(
					'constraint' => 'fk_tickets_users_creator',
					'key' => 'creator_id',
					'reference' => array(
						'table' => 'users',
						'column' => 'id',
					),
					'on_update' => 'NO ACTION',
					'on_delete' => 'NO ACTION',
				),
				array(
					'constraint' => 'fk_tickets_users_asigned',
					'key' => 'asigned_id',
					'reference' => array(
						'table' => 'users',
						'column' => 'id',
					),
					'on_update' => 'NO ACTION',
					'on_delete' => 'NO ACTION',
				),
				array(
					'constraint' => 'fk_tickets_users_updater',
					'key' => 'updater_id',
					'reference' => array(
						'table' => 'users',
						'column' => 'id',
					),
					'on_update' => 'NO ACTION',
					'on_delete' => 'NO ACTION',
				),
			)
		);

		\DBUtil::create_table('tickets_metadata',
			array(
				'tickets_id'   => array('constraint' => 11,  'type' => 'int'),
				'message'      => array('type' => 'text'),
			),
			array('tickets_id'), true, $engine, $charset,
			array(
				array(
					'constraint' => 'fk_tickets_metadata_tickets_tickets_id',
					'key' => 'tickets_id',
					'reference' => array(
						'table' => 'tickets',
						'column' => 'id',
					),
					'on_update' => 'NO ACTION',
					'on_delete' => 'NO ACTION',
				),
			)
		);

		\DBUtil::create_table('tickets_messages',
			array(
				'id'           => array('constraint' => 11,  'type' => 'int', 'auto_increment' => true),
				'tickets_id'   => array('constraint' => 11,  'type' => 'int'),
				'user_id'      => array('constraint' => 11,  'type' => 'int'),
				'message'      => array('type' => 'text'),
				'received_at'  => array('constraint' => 11,  'type' => 'int'),
				'created_at'   => array('constraint' => 11,  'type' => 'int'),
				'read_at'      => array('constraint' => 11,  'type' => 'int',    'null' => true),
			),
			array('id'), true, $engine, $charset,
			array(
				array(
					'constraint' => 'fk_tickets_messages_tickets_tickets_id',
					'key' => 'tickets_id',
					'reference' => array(
						'table' => 'tickets',
						'column' => 'id',
					),
					'on_update' => 'NO ACTION',
					'on_delete' => 'NO ACTION',
				),
				array(
					'constraint' => 'fk_tickets_messages_users_user',
					'key' => 'user_id',
					'reference' => array(
						'table' => 'users',
						'column' => 'id',
					),
					'on_update' => 'NO ACTION',
					'on_delete' => 'NO ACTION',
				),
			)
		);

		\DBUtil::create_table('logs',
			array(
				'id'           => array('constraint' => 11,  'type' => 'int', 'auto_increment' => true),
				'user_id'      => array('constraint' => 11,  'type' => 'int',     'null' => true),
				'type'         => array('constraint' => "'error', 'warning', 'debug', 'info'", 'type' => 'enum', 'null' => true),
				'message'      => array('constraint' => 255, 'type' => 'varchar'),
				'ip_address'   => array('constraint' => 64,  'type' => 'varchar', 'null' => true),
				'user_agent'   => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
				'created_at'   => array('constraint' => 11,  'type' => 'int',    'null' => true),
				
			),
			array('id'), true, $engine, $charset,
			array(
				array(
					'constraint' => 'fk_tickets_users_user',
					'key' => 'user_id',
					'reference' => array(
						'table' => 'users',
						'column' => 'id',
					),
					'on_update' => 'NO ACTION',
					'on_delete' => 'NO ACTION',
				),
			)
		);

		\DBUtil::create_table('settings',
			array(
				'key'          => array('constraint' => 128, 'type' => 'varchar'),
				'value'        => array('type' => 'text',                     'null' => true),
				'user_id'      => array('constraint' => 11,  'type' => 'int', 'null' => true),
				'updated_at'   => array('constraint' => 11,  'type' => 'int', 'null' => true),
			),
			array('key'), true, $engine, $charset,
			array(
				array(
					'constraint' => 'fk_settings_users_user',
					'key' => 'user_id',
					'reference' => array(
						'table' => 'users',
						'column' => 'id',
					),
					'on_update' => 'NO ACTION',
					'on_delete' => 'NO ACTION',
				),
			)
		);
	}

	public function down()
	{
		\DBUtil::drop_table('users');
		\DBUtil::drop_table('groups');
		\DBUtil::drop_table('users_metadata');
		\DBUtil::drop_table('users_groups');
		\DBUtil::drop_table('users_suspended');
		\DBUtil::drop_table('tickets');
		\DBUtil::drop_table('tickets_metadata');
		\DBUtil::drop_table('tickets_messages');
		\DBUtil::drop_table('logs');
		\DBUtil::drop_table('settings');
	}

}