<?php

/**
 * BridJoyRide class will manage joyride options
 * @package plugins.brid.lib
 * @author Brid Dev Team, contact@brid.tv
 * @version 1.0
 */
class BridJoyRide
{
	//init
	public static function addThick()
	{

		add_thickbox();
		//Joyride
		wp_enqueue_style('wp-pointer');
		wp_enqueue_script('wp-pointer');
		wp_enqueue_script('wp-brid-joyride',  BRID_PLUGIN_URL . 'js/bridJoyRide.js');
	}
}

if (BridActions::includeScripts()) {
	add_action('admin_enqueue_scripts', array('BridJoyRide', 'addThick'));
}
