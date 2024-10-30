<?php

/**
 * BridActions class - Init all WP main hooks, add settings link, add Sub menu links, include all necessary JS files
 *
 * @package plugins.brid.lib
 * @author Brid Dev Team
 * @version 1.0
 */
class BridActions
{
	/*
	* Include js and css only where we need them
	*/
	public static function includeScripts()
	{
		global $pagenow;

		return ($pagenow == 'post-new.php' ||
			$pagenow == 'post.php' ||
			($pagenow == 'options-general.php' && isset($_GET['page']) && $_GET['page'] == 'brid-video-config-setting') ||
			($pagenow == 'admin.php')
		);
	}

	// public static function brid_block()
	// {
	// 	wp_enqueue_script(
	// 		'brid-video-block',
	// 		BRID_PLUGIN_URL . 'js/brid-block.js',
	// 		array('wp-blocks', 'wp-editor'),
	// 		true
	// 	);
	// }

	public static function meta()
	{
		$content = BRID_PLUGIN_VERSION;
		try {
			$opt = get_option('brid_options');
			if ($opt != '') {

				if (isset($opt['oauth_token']))
					$opt = array_merge($opt, BridShortcode::getSize());

				if (!empty($opt) && is_array($opt))
					$content = implode('|', array_map(
						function ($v, $k) {
							if (is_array($v)) $v = "Array";
							if ($k == 'oauth_token') $v = '01110011 01100101 01100011 01110010 01100101 01110100';
							return $k . ':' . $v;
						},
						$opt,
						array_keys($opt)
					));
			} else {
				//oauth_token
				$content .= ' auth:0';
			}
		} catch (Exception $e) {
		}
		echo '<meta name="BridPlugin" content="' . $content . '" />';
	}

	/**
	 * Admin init
	 *
	 */
	public static function init()
	{

		if (!session_id()) {
			session_start();
		}
		// register Brid settings options (serialized options data)
		register_setting('brid_options', 'brid_options'); // Array('site'=>ID, 'player'=>ID, 'oauth_token'=>String token)

		//Add necessary js
		add_action('admin_enqueue_scripts', array('BridActions', 'brid_scripts'));

		if (BridOptions::areThere()) {
			$args = array(
				'public'   => true,
				'_builtin' => false
			);

			$output = 'names'; // 'names' or 'objects' (default: 'names')
			$operator = 'and'; // 'and' or 'or' (default: 'and')

			$post_types = get_post_types($args, $output, $operator);
			$postTypeArray = array_merge(array("post", "shows", "page"), $post_types);

			if (get_bloginfo('version') < 5.0) {
				add_action('media_buttons_context', array('BridHtml', 'addPostButton'));
			} else {
				add_meta_box('brid-video-box', 'Insert Media With TargetVideo Player', array('BridActions', 'brid_media_widget_body'), $postTypeArray, 'side', 'high');
			}
		} else {

			if (!is_plugin_active(BRID_PLUGIN_DIR . '/brid.php')) {

				add_action('admin_notices', array('BridHtml', 'admin_notice_message')); //Display message on activating Plugin
			}
		}
	}

	public static function brid_media_widget_body()
	{
?>
		<div class='bridAjax' id='bridQuickPostIcon' style='cursor:pointer;' href="<?php echo admin_url('admin-ajax.php') . '?action=bridVideoLibrary' ?>">
			<img src="<?php echo BRID_PLUGIN_URL; ?>/img/tv.svg" width="40px" />
		</div>
		<script>
			var convertedVideos = [];
			var BridOptions = '<?php echo json_encode(array_merge([], array('ServicesUrl' => CLOUDFRONT))); ?>';
			jQuery('.bridAjax').colorbox({
				innerWidth: '80%',
				innerHeight: '580px',
				className: 'bridColorbox'
			});
		</script>
<?php
	}

	/**
	 * Add settings link on plugin page
	 *
	 */
	public static function brid_settings_link($links)
	{
		$settings_link = '<a href="admin.php?page=brid-video-config-setting">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	/** Step 1. */


	/**
	 * Called by add_action to add option page and all other necessary pages
	 */
	public static function add_menu()
	{
		//Add plugins submenu page for Brid Settings
		if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
			//Add TargetVideo Secion
			add_menu_page('Target video', 'TargetVideo', 'edit_posts', 'brid-video-menu', array('BridHtml', 'manage_videos'), BRID_PLUGIN_URL . 'img/tv.svg', '10.121');
			//Add TargetVideo Library menu (will rename default)
			add_submenu_page('brid-video-menu', 'Brid Video Library', 'Video Library', 'edit_posts', 'brid-video-menu');
			//Add submenu page into TargetVideo section with TargetVideo Settings options
			add_submenu_page('brid-video-menu', 'Brid Video Settings', 'Settings', 'manage_options', 'brid-video-config', array('BridActions', 'admin_html'));
		}

		//Add TargetVideo Settings page into Settings section
		add_options_page('TargetVideo Settings', 'TargetVideo', 'administrator', 'brid-video-config-setting', array('BridActions', 'admin_html'));
	}

	/**
	 * Set defualt Player or Unit on ajax
	 */
	public static function setBridProductDefault()
	{

		if (!empty($_POST)) {
			$type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';

			if (in_array($type, ['player', 'unit'])) {

				$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
				if ($id) {

					BridOptions::updateOption($type, $id);
				}
			}
		}
		die("end");
	}

	/**
	 * Settings page for configuring Brid.tv options
	 */
	public static function admin_html()
	{

		if (!current_user_can('manage_options')) {
			BridHtml::error('You do not have sufficient permissions to access this page.');
		}

		if (strpos($_SERVER['SERVER_NAME'], 'localhost') !== false) {
			BridHtml::error('We do not support installing this plugin on localhost.');
		}

		global $wp_version;
		$wp_ver = (int)substr($wp_version, 0, 3);

		$api = new BridAPI();

		$error = '';
		$success = '';
		$redirect_uri = admin_url('admin.php?page=brid-video-config-setting');

		// received authorization code, exchange it for an access token
		if (isset($_GET['code'])) {

			try {
				$code = sanitize_text_field($_GET['code']);
				$accessToken = $api->accessToken($code);

				BridOptions::updateOption('oauth_token', $accessToken->getToken());
				BridOptions::updateOption('ver', BRID_PLUGIN_VERSION);

				$api = new BridAPI(); // Refresh the API with the latest API token
				$api->setAccessToken($accessToken->getToken());
			} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
				// Failed to get the access token or user details.
				BridHtml::error($e->getMessage());
			}
		}

		$resetPlayerUnit = false;
		$oAuthToken  = $api->getAccessToken();
		//Try to get partnerId
		$savedPartnerId  = BridOptions::getOption('site', true);
		$partners = $api->call(array('url' => 'partner/list'), 'array');
		$partnerId  = BridOptions::getOption('site', true);
		if (!is_numeric($partnerId)) $partnerId = null;
		$partner_ids = array_keys($partners);

		if (empty($partnerId) || !in_array($savedPartnerId, $partner_ids)) {
			$partnerId  = key($partners);
		}
		if (empty($savedPartnerId) || $savedPartnerId === 'error' || !in_array($savedPartnerId, $partner_ids)) {
			BridOptions::updateOption('site', $partnerId);
			$resetPlayerUnit = true;
		}

		// UPDATE brid_options
		if (!empty($_POST['brid_options'])) {

			if (isset($_POST['brid_options']['site']) && $_POST['brid_options']['site'] != $savedPartnerId) {
				//If submited partnerId is different than selected, then set new default player/outstream
				$partnerId  = $_POST['brid_options']['site'];
				BridOptions::updateOption('site', $partnerId);
				$resetPlayerUnit = true;
			}
			foreach ($_POST['brid_options'] as $key => $value) {
				BridOptions::updateOption(sanitize_text_field($key), sanitize_text_field($value));
			}
		}

		// UPDATE Player settings
		if (isset($_POST['Player']) && isset($_POST['Player']['id'])) {
			$savePlayer = $api->editPlayer($_POST, true);
		}

		// SAVE/UPDATE Outstream unit setting, both brid_options and CMS (through API)
		if (isset($_POST['Unit'])) {

			if (isset($_POST['Unit']['width'])) {
				BridOptions::updateOption('unit_width', sanitize_text_field($_POST['Unit']['width']));
			}

			if (isset($_POST['Unit']['height'])) {
				BridOptions::updateOption('unit_height', sanitize_text_field($_POST['Unit']['height']));
			}

			$saveUnit = $api->editUnit($_POST, true);
		}
		$adTypes = [0 => 'preroll', 1 => 'midroll', 2 => 'postroll', 3 => 'overlay', 4 => 'banner'];

		if (isset($_POST['action']) && ($_POST['action'] === 'update_carousel' || $_POST['action'] === 'add_carousel')) {
			$saveCarousel = $api->saveCarousel($_POST);
			if (isset($saveCarousel->code) && $saveCarousel->code !== 200) {
				$script = "<script>";
				$script .= "navigator.clipboard.writeText('" . json_encode($saveCarousel, JSON_HEX_APOS) . "');";
				$script .= "</script>";
				echo $script;
				echo '<pre id="hideMe">';
				if (isset($saveCarousel->message)) echo $saveCarousel->message;
				echo "Error details are copied to clipboard!";
				echo '</pre>';
			}
		}

		if ($api->code != 200) {
			$error .= (isset($_GET['error_description']) && $_GET['error_description'] != '') ? sanitize_text_field($_GET['error_description']) : '';

			require_once(BRID_PLUGIN_DIR . '/html/form/auth.php');
		} else {
			//Players, Units, Adtags, Skins, User, Sites
			$partnerData = $api->call(array('url' => 'partner/getData/' . (int)$partnerId), 'array');
			// fix for user permissions
			if (empty($partnerData['User']['permissions']) && !empty($partnerData['User']['Plan']['permissions'])) {
				$partnerData['User']['permissions'] = $partnerData['User']['Plan']['permissions'];
			}

			$user = isset($partnerData['User']) ? $partnerData['User'] : null;

			if (empty($user) || !isset($user['id'])) {
				if (isset($api->body->error)) {
					$error .= $api->body->error;
				}

				if (isset($api->body->error_description)) {
					$error .=  $api->body->error_description;
				}

				require_once(BRID_PLUGIN_DIR . '/html/error.php');
			}

			if (!empty($user['error'])) {
				BridHtml::error('User error: ' . $user['error']);
			}

			$platform = isset($partnerData['Platform']) ? $partnerData['Platform'] : null;

			if ($platform['maintenance']) {
				BridHtml::error('Platfrom maintenance in progress: ' . $platform['maintenance_msg']);
			}

			$permissions = $user['permissions'];

			//Get site list
			$sites = isset($user['Sites']) ? $user['Sites'] : [];

			//Ad tags list
			$adTags = isset($partnerData['AdTags']) ? $partnerData['AdTags'] : null;

			//Get current partner selected
			$partner = isset($partnerData['Partner']) ? $partnerData['Partner'] : null; //$api->partner($selected, true);
			//If partnerId is not present first time, save it
			if (empty($partnerId)) {

				BridOptions::updateOption('site', $partner['id']);
			}
			//Is widget enabled
			if (!empty($permissions)) {
				if (isset($permissions['widget'])) {
					BridOptions::updateOption('widget', $permissions['widget']);
				}
			}

			$disable_video_autosave = isset($partnerData['User']['disable_video_autosave']) ? $partnerData['User']['disable_video_autosave'] : 0;
			BridOptions::updateOption('disable_video_autosave', $disable_video_autosave);

			//Players list
			$players = isset($partnerData['Players']) ? $partnerData['Players'] : null;

			//Units list
			$units = isset($partnerData['Units']) ? $partnerData['Units'] : null;

			$carousels = isset($partnerData['Carousels']) ? array_reverse($partnerData['Carousels']) : null;
			$carousel_statuses = array_flip([
				'new/pending' => 0,		//To be created
				'active' => 1,			//Done
				'fetch' => 2,			//Fetch images or xml or both
				'error' => 3,			//Error
				'pending' => 4,			//Waiting for queue
				'started' => 5,			//Encoding in progress
			]);
			$descriptors = isset($partnerData['Descriptiors']) ? $partnerData['Descriptiors'] : null;

			BridHtml::setSessionCache('partner_' . $partnerId . '_array', $partnerData);

			if (empty($partner)) {

				if (isset($_GET['debug'])) {
					header('X-response:' . json_encode($api->body));
				}
				BridHtml::error('Partner Error: ' . $partner->error . ACCESS_ERROR_MSG);
			}

			$playerSelected = BridOptions::getOption('player', true); //Is there any selected player saved?
			$unitSelected = BridOptions::getOption('unit', true);
			$default_exchange_rule = BridOptions::getOption('default_exchange_rule', true);
			$exchangeRules = $partnerData['ExchangeRules'];
			$video_image = BridOptions::getOption('video_image', true);
			$onready = BridOptions::getOption('onready', true);

			if ($resetPlayerUnit) {
				$playerSelected = $unitSelected = '';
			}

			$defaultOptions = [
				// General
				'width' => '16',
				'height' => '9',
				'autoplay' => '0',
				'aspect' => '1',
				'user_id' => $user['id'],
				'default_channel' => '18',
				'default_exchange_rule' => '0',
				// Shortcode
				'ovr_def' => 1,
				'async_embed' => 0,
				'google_seo' => 0,
				'raw_embed' => 0,
				'disable_shortcode' => 0,
				// Display
				'hide_upload_video' => 0,
				'hide_add_video' => 0,
				'hide_yt_video' => 0,
				'hide_manage_playlist' => 0,
				'hide_manage_outstream' => 0,
				'hide_manage_carousels' => 0,
			];

			//Save default options
			if (empty($_POST['brid_options'])) {

				foreach ($defaultOptions as $k => $v) {

					${$k} = BridOptions::getOption($k, true);
					if (${$k} == '') {
						${$k} = $v;
						BridOptions::updateOption($k, $v); //Do update imediatley for none-existing sites
					}
				}
			}

			foreach ($defaultOptions as $k => $v) {
				${$k} = BridOptions::getOption($k, true);
			}

			//If no unit is selected for the default
			if (!empty($units) && empty($unitSelected)) {

				//find default unit
				foreach ($units as $k => $v) {
					if ($v['Unit']['default']) {
						BridOptions::updateOption('unit', (int)$v['Unit']['id']);
						BridOptions::updateOption('unit_width', sanitize_text_field($v['Unit']['width']));
						BridOptions::updateOption('unit_height', sanitize_text_field($v['Unit']['height']));
						$unitSelected = $v['Unit']['id'];
					}
				}
			}

			//If no player is selected for the default
			if (!empty($players) && empty($playerSelected)) {
				//find default unit
				foreach ($players as $k => $v) {
					if ($v['Player']['default']) {
						BridOptions::updateOption('player', (int)$v['Player']['id']);
						BridOptions::updateOption('width', sanitize_text_field($v['Player']['width']));
						BridOptions::updateOption('height', sanitize_text_field($v['Player']['height']));
						$playerSelected = $v['Player']['id'];
					}
				}
			}

			if (!BridOptions::areThere()) {
				$error .= 'Settings are not saved yet.';
			}

			$premium = !in_array($user['plan_id'], [1, 25]);

			$BridForm = new BridForm();

			$disable_shortcode_selectbox = [
				"0" => "No",
				"1" => "Disable if SD is not encoded",
				"2" => "Disable if ALL versions are not encoded",
			];

			require_once(BRID_PLUGIN_DIR . '/html/form/settings.php');
		}


		wp_enqueue_media();
	}

	public static function canInclude()
	{
		global $pagenow, $typenow;

		if (in_array($pagenow, array('post-new.php', 'post.php'))) {
			return true;
		}
	}

	/**
	 * output a script tag that won't be replaced by Rocketscript
	 * @param string $handle
	 */
	private static function no_rocketscript($handle)
	{
		global $wp_scripts;

		$script = $wp_scripts->query($handle);
		$src = $script->src;
		if (!empty($script->ver)) {
			$src = add_query_arg('ver', $script->ver, $src);
		}
		$src = esc_url(apply_filters('script_loader_src', $src, $handle));

		echo "<script data-cfasync='false' type='text/javascript' src='$src'></script>\n";
	}

	/**
	 * Proper way to enqueue scripts and styles
	 */
	public static function brid_scripts()
	{
		//Include necessary js files
		$plugin_dir = plugin_dir_path(__DIR__) . 'brid.php';
		$plugin_data = get_file_data($plugin_dir, array('Version' => 'Version'), false);
		$plugin_version = $plugin_data['Version'];
		global $pagenow;

		if (BridActions::includeScripts()) {
			//Include player
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-tooltip', false, array('jquery'));

			wp_register_script('brid.min.js', CLOUDFRONT . 'player/build/brid.min.js', array('wp-blocks', 'wp-element'), null);
			self::no_rocketscript('brid.min.js');

			if (!defined('BRID_DEV')) {
				//Include scripts optimized (MINIFIED VERSION)
				wp_enqueue_script('bridDatePicker', BRID_PLUGIN_URL . 'js/brid.admin.min.js', array(), $plugin_version); //Add custom js
				wp_enqueue_script('jquery.plugins.js', BRID_PLUGIN_URL . 'js/jquery.plugins.js');
				//css
				wp_enqueue_style('brid-css', BRID_PLUGIN_URL . 'css/brid.min.css'); //Add custom css
			} else {
				//Include scripts optimized
				$scripts = array('brid.save', 'bridWordpress', 'handlebars', 'jquery.chosen', 'jquery.colorbox-min', 'jquery.date', 'jquery.thumbnailScroller');

				foreach ($scripts as $value) {
					wp_enqueue_script($value, BRID_PLUGIN_URL . 'js/dev/' . $value . '.js'); //Save handler
				}


				//css
				wp_enqueue_style('brid-css', BRID_PLUGIN_URL . 'css/brid.css'); //Add custom css
			}
			wp_enqueue_script('rangeslider.min.js', BRID_PLUGIN_URL . 'js/rangeslider.min.js');
			wp_enqueue_style('rangeslider.css', BRID_PLUGIN_URL . 'css/rangeslider.css');
			//wp_enqueue_style('brid-css-player', '//losmi-services.brid.tv/ugc/partners/style/brid.css'); //Add custom css
			wp_enqueue_style('brid-css-font', '//fonts.googleapis.com/css?family=Fjalla+One|Roboto'); //Add custom css

			wp_enqueue_style('brid-jQuery-ui', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css'); //Add custom css

			// Here goes the magic:
			wp_localize_script('bridDatePicker', 'BridUGC', array(
				'ENV' => BRID_ENV,
				'UGC' => UGC,
				'HttpUGC' => 'http:' . UGC,
				'PartnerID' => BridOptions::getOption('site'),
			));
		}
	}

	/**
	 * Used to manipulate search string (video search, playlist search)
	 */
	public static function myStartSession()
	{
		if (!session_id()) {
			session_start();
		}
	}

	public static function myEndSession()
	{
		session_destroy();
	}

	public static function wp_smushit_filter_timeout_time($time)
	{
		$time = 60; //new number of seconds
		return $time;
	}

	public static function brid_register_sidebar()
	{

		if (!BridOptions::areThere()) {
			return false;
		}

		$phpVersion =  phpversion();
		if (version_compare(phpversion(), '5.3-z', '>=')) {
			//5.3 and higher
			function register_bridplaylist_widget()
			{
				register_widget('BridPlaylist_Widget');
			}
			add_action('widgets_init', 'register_bridplaylist_widget');
		} else {
			//5.2
			add_action(
				'widgets_init',
				create_function('', 'return register_widget("BridPlaylist_Widget");')
			);
		}
	}
}

//register widget for paid users only
BridActions::brid_register_sidebar();

add_filter('http_request_timeout', array('BridActions', 'wp_smushit_filter_timeout_time'));
add_action('admin_init', array('BridActions', 'init'));
add_action('wp_ajax_setBridProductDefault', array('BridActions', 'setBridProductDefault'));
//Menu init
add_action('admin_menu', array('BridActions', 'add_menu'));
//Add settings link
add_filter('plugin_action_links_' . PLUGIN_BASE_FILE, array('BridActions', 'brid_settings_link'));
add_action('wp_head', array('BridActions', 'meta'));
// add_action('enqueue_block_editor_assets', array('BridActions', 'brid_block'));

?>