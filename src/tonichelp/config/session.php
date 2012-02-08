<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2012 Fuel Development Team
 * @link       http://fuelphp.com
 */

return array(
	/**
	 * global configuration
	*/

	// set it to false to prevent the static session from auto-initializing, know that it might make your session
	// expire sooner because it's not updated when it's not used. note that auto-initializing always loads the default driver
	'auto_initialize'	=> true,

	// if no session type is requested, use the default
	'driver'			=> 'cookie',

	// check for an IP address match after loading the cookie (optional, default = false)
	'match_ip'			=> false,

	// check for a user agent match after loading the cookie (optional, default = true)
	'match_ua'			=> true,

	// cookie domain  (optional, default = '')
	'cookie_domain' 	=> '',

	// cookie path  (optional, default = '/')
	'cookie_path'		=> '/',

	// cookie http_only flag  (optional, default = use the cookie class default)
	'cookie_http_only'	=> null,

	// if true, the session expires when the browser is closed (optional, default = false)
	'expire_on_close'	=> false,

	// session expiration time, <= 0 means 2 years! (optional, default = 2 hours)
	'expiration_time'	=> 7200,

	// session ID rotation time  (optional, default = 300)
	'rotation_time'		=> 300,

	// default ID for flash variables  (optional, default = 'flash')
	'flash_id'			=> 'flash',

	// if false, expire flash values only after it's used  (optional, default = true)
	'flash_auto_expire'	=> true,

	// for requests that don't support cookies (i.e. flash), use this POST variable to pass the cookie to the session driver
	'post_cookie_name'	=> '',

	/**
	 * specific driver configurations. to override a global setting, just add it to the driver config with a different value
	*/

	// special configuration settings for cookie based sessions
	'cookie'			=> array(
		'cookie_name'		=> 'tonichelp',				// name of the session cookie for cookie based sessions
	),
);


