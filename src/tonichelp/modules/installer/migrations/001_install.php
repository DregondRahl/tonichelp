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
		 * Sentry
		 */
		\DBUtil::create_table('users', array(
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
			'updated_at'          => array('constraint' => 11,  'type' => 'int'),
			'created_at'          => array('constraint' => 11,  'type' => 'int'),
			'status'              => array('constraint' => 1,   'type' => 'tinyint'),
			'activated'           => array('contsraint' => 1,   'type' => 'tinyint'),
		), array('id'), true, $engine, $charset);

		\DBUtil::create_table('users_metadata', array(
			'user_id'    => array('constraint' => 11, 'type' => 'int'),
			'first_name' => array('constraint' => 50, 'type' => 'varchar'),
			'last_name'  => array('constraint' => 50, 'type' => 'varchar'),
		), array('user_id'), true, $engine, $charset);

		\DBUtil::create_table('groups', array(
			'id'       => array('constraint' => 11,  'type' => 'int', 'auto_increment' => true),
			'name'     => array('constraint' => 200, 'type' => 'varchar'),
			'level'    => array('constraint' => 11,  'type' => 'int'),
			'is_admin' => array('constraint' => 1,   'type' => 'tinyint'),
			'parent' => array('constraint' => 11, 'type' => 'int'),
		), array('id'), true, $engine, $charset);

		\DBUtil::create_table('users_suspended', array(
			'id'              => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'login_id'        => array('constraint' => 50, 'type' => 'varchar'),
			'attempts'        => array('constraint' => 50, 'type' => 'int'),
			'ip'              => array('constraint' => 25, 'type' => 'varchar'),
			'last_attempt_at' => array('constraint' => 11, 'type' => 'int'),
			'suspended_at'    => array('constraint' => 11, 'type' => 'int'),
			'unsuspend_at'    => array('constraint' => 11, 'type' => 'int'),
		), array('id'), true, $engine, $charset);

		\DBUtil::create_table('users_groups', array(
			'user_id'  => array('constraint' => 11, 'type' => 'int'),
			'group_id' => array('constraint' => 11, 'type' => 'int'),
		), array(), true, $engine, $charset);

		\DBUtil::create_table('tasks', array(
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
		), array('id'), true, $engine, $charset,
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

		\DBUtil::create_index('tasks', array('creator_id' => 'ASC', 'fk_tickets_users'));
		\DBUtil::create_index('tasks', array('asigned_id' => 'ASC', 'fk_tickets_users_asigned'));
		\DBUtil::create_index('tasks', array('updater_id' => 'ASC', 'fk_tickets_users_updater'));
		
		die;
	}

	public function down()
	{
		\DBUtil::drop_table('users');
		\DBUtil::drop_table('groups');
		\DBUtil::drop_table('users_metadata');
		\DBUtil::drop_table('users_groups');
		\DBUtil::drop_table('users_suspended');
	}

}

/*

-- -----------------------------------------------------
-- Table `tonichelp`.`tickets`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tonichelp`.`tickets` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `creator_id` INT(11) NOT NULL ,
  `asigned_id` INT(11) NOT NULL ,
  `updater_id` INT(11) NOT NULL ,
  `type` VARCHAR(32) NOT NULL DEFAULT 0 COMMENT '0 => default' ,
  `status` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 => new' ,
  `resolution` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 => Not resolved' ,
  `subject` VARCHAR(128) NOT NULL ,
  `priority` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 => Default' ,
  `is_answered` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1 = yes, if there is a reply it will change to 0' ,
  `received_at` INT NULL ,
  `created_at` INT NULL ,
  `read_at` VARCHAR(45) NULL ,
  `updated_at` INT NULL ,
  `closed_at` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_tickets_users` (`creator_id` ASC) ,
  INDEX `fk_tickets_users1` (`asigned_id` ASC) ,
  INDEX `fk_tickets_users2` (`updater_id` ASC) ,
  CONSTRAINT `fk_tickets_users`
	FOREIGN KEY (`creator_id` )
	REFERENCES `tonichelp`.`users` (`id` )
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
  CONSTRAINT `fk_tickets_users1`
	FOREIGN KEY (`asigned_id` )
	REFERENCES `tonichelp`.`users` (`id` )
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
  CONSTRAINT `fk_tickets_users2`
	FOREIGN KEY (`updater_id` )
	REFERENCES `tonichelp`.`users` (`id` )
	ON DELETE NO ACTION
	ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tonichelp`.`tickets_metadata`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tonichelp`.`tickets_metadata` (
  `tickets_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `message` TEXT NULL ,
  PRIMARY KEY (`tickets_id`) ,
  CONSTRAINT `fk_tickets_metadata_tickets1`
	FOREIGN KEY (`tickets_id` )
	REFERENCES `tonichelp`.`tickets` (`id` )
	ON DELETE NO ACTION
	ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tonichelp`.`tickets_messages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tonichelp`.`tickets_messages` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `ticket_id` INT UNSIGNED NOT NULL ,
  `user_id` INT(11) UNSIGNED NOT NULL ,
  `message` TEXT NULL ,
  `received_at` INT NULL ,
  `created_at` INT NULL ,
  `read_at` INT NULL ,
  PRIMARY KEY (`id`, `ticket_id`, `user_id`) ,
  INDEX `fk_tickets_messages_tickets1` (`ticket_id` ASC) ,
  INDEX `fk_tickets_messages_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_tickets_messages_tickets1`
	FOREIGN KEY (`ticket_id` )
	REFERENCES `tonichelp`.`tickets` (`id` )
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
  CONSTRAINT `fk_tickets_messages_users1`
	FOREIGN KEY (`user_id` )
	REFERENCES `tonichelp`.`users` (`id` )
	ON DELETE NO ACTION
	ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tonichelp`.`logs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tonichelp`.`logs` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `type` ENUM('error', 'warning', 'debug', 'info') NULL ,
  `message` VARCHAR(512) NULL ,
  `users_id` INT(11) NULL ,
  `ip_address` VARCHAR(64) NULL ,
  `user_agent` VARCHAR(256) NULL ,
  `created_at` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_logs_users1` (`users_id` ASC) ,
  CONSTRAINT `fk_logs_users1`
	FOREIGN KEY (`users_id` )
	REFERENCES `tonichelp`.`users` (`id` )
	ON DELETE NO ACTION
	ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tonichelp`.`settings`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tonichelp`.`settings` (
  `key` VARCHAR(64) NOT NULL ,
  `value` VARCHAR(256) NULL ,
  `updated_at` INT NULL ,
  PRIMARY KEY (`key`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
*/