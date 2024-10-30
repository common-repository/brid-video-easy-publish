<?php

/**
 * @class Simple class to work with serialized Brid options
 * @package plugins.brid.lib
 * @author Brid Dev Team
 * @version 1.0
 **/
class BridOptions
{

	private static $_options = null;

	private static $_instance = null;

	private static $_requiredOptions = array('oauth_token', 'site', 'player');

	public static function getInstance()
	{

		if (self::$_instance === null) self::$_instance = new BridOptions();
		return self::$_instance;
	}
	private function __construct()
	{
		self::loadOption();
	}

	private static function loadOption()
	{
		self::$_options = get_option('brid_options');
	}

	/**
	 * Get option value from the serialized option
	 * @param String $name
	 * @param Boolean $relaod
	 * @return Mixed
	 *
	 **/
	public static function getOption($name, $reload = false)
	{
		//Force reload
		if ($reload) self::loadOption();

		//If options are empty, try to load
		if (empty(self::$_options)) self::loadOption();

		//If they are not empty, try to get the array index
		if (!empty(self::$_options)) {

			if (isset(self::$_options[$name]))
				return self::$_options[$name];
		}

		return '';
	}

	/**
	 *	CHeck are there all required options set so we can use Api?
	 *  @return Boolean
	 **/
	public static function areThere()
	{
		//If options are empty, try to load
		if (empty(self::$_options)) self::loadOption();

		$is = true;
		foreach (self::$_requiredOptions as $key => $value) {
			if (!isset(self::$_options[$value])) {
				$is = false;
				break;
			}
		}
		return $is;
	}

	/**
	 *	Update single option in serialized array
	 *	@param String $name (index of the option array)
	 *  @param Mixed $value (Value to be stored)
	 **/
	public static function updateOption($name, $value = '')
	{
		//If options are empty, try to load
		$options = get_option('brid_options');

		if (!is_array($options)) {
			$options = [];
		}

		$options[$name] =  $value;

		update_option('brid_options', $options);
	}
}
