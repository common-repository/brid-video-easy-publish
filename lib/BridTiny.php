<?php

/**
 * BridTiny class will manage tinymce Brid player preview
 * @package plugins.brid.lib
 * @author Brid Dev Team, contact@brid.tv
 * @version 1.0
 */
class BridTiny
{
	//init
	public static function init_plugin()
	{
		if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
			add_filter('mce_external_plugins', array('BridTiny', 'add_plugin'));
		}
	}

	//TinyMce plugin to parse Brid Content
	public static function add_plugin($plugin_array)
	{
		$plugin_array['my_button_script'] = BRID_PLUGIN_URL . 'js/bridPlayerPreview.js';
		return $plugin_array;
	}
}

add_action('admin_init', array('BridTiny', 'init_plugin'));
