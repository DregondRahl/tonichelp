<?php

class Validation extends Fuel\Core\Validation
{
	/**
	 * Loads in the validation config file
	 *
	 * @return  void
	 */
	public static function _init()
	{
		\Config::load('validation', true);
	}
}