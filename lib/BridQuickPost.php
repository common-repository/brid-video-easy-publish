<?php

/**
 * BridHtml class will manage all forms from Post/Page screen
 * @package plugins.brid.lib
 * @author Brid Dev Team, contact@brid.tv
 * @version 1.0
 */

class BridQuickPost
{
	/**
	 * Main video library pop-up
	 */
	public static function bridVideoLibrary()
	{
		$partnerData = BridHtml::getPartnerData();

		if (!isset($partnerData['message'])) {
			$playerSelected  = BridOptions::getOption('player'); //Is there any selected player saved?
			$width  = BridOptions::getOption('width'); //Width
			$width =  $width != '' ?  $width : '640';

			$height  = BridOptions::getOption('height'); //Height
			$height =  $height != '' ?  $height : '480';

			$playerSettings = json_encode(array('id' => $playerSelected, 'width' => $width, 'height' => $height));

			$platform = isset($partnerData['Platform']) ? $partnerData['Platform'] : null;

			$user = $partnerData['User'];

			$CDN_Path = (empty($user['cdn_domain'])) ? UGC . "partners/" : "//" . $user['cdn_domain'];

			$upload = $user['permissions']['upload'];

			$disable_shortcode = BridOptions::getOption('disable_shortcode');

			require_once(BRID_PLUGIN_DIR . '/html/library.php');
		} else {
			BridHtml::error($partnerData['message']);
		}
		die();
	}

	/**
	 * [VIDEO LSIT Library from Post screen]
	 * Get paginated video list by partner id
	 */
	public static function videoLibraryPost($internal = false)
	{
		$api = new BridAPI();

		$partner_id = BridOptions::getOption('site');

		$partnerData = BridHtml::getPartnerData();

		$platform = isset($partnerData['Platform']) ? $partnerData['Platform'] : null;

		$players = $partnerData['Players'];

		//Sanitize search text if there is any
		$search = '';
		if (isset($_POST['search'])) {
			$search  = $_POST['search'] = sanitize_text_field($_POST['search']);
		}
		$searchTag = '';
		if (isset($_POST['searchTag'])) {
			$searchTag  = $_POST['searchTag'] = sanitize_text_field($_POST['searchTag']);
		}

		$subaction = isset($_POST['subaction']) ? $_POST['subaction'] : '';

		$mode = isset($_POST['mode']) ? sanitize_text_field($_POST['mode']) : '';

		$playlistType = isset($_POST['playlistType']) ? sanitize_text_field($_POST['playlistType']) : 0;

		//Turn off buttons and quick icons if we are on post screen
		$buttonsOff = isset($_POST['buttons']) ? sanitize_text_field($_POST['buttons']) : false;

		$_POST['limit'] = 8;
		//Get video list
		$videosDataset = $api->getVideosPost($partner_id, true);

		$sites = $partnerData['User']['Sites'] ?? [];

		$view = isset($_POST['view']) ? false : true;
		//Return json only
		if (!$view) {
			require_once(BRID_PLUGIN_DIR . '/html/list/videos/videos_list.php');
			die();
		}

		//require videos list view
		require_once(BRID_PLUGIN_DIR . '/html/list/videos/videoLibrary.php');

		if (!$internal)
			die(); // this is required to return a proper result (By wordpress site)
	}

	/*
	 * Add Youtube video
	 */
	public static function addYoutubePost()
	{
		$api = new BridAPI();
		$partnerData = BridHtml::getPartnerData();
		$tagsTaxonomies = $partnerData['TagsTaxonomies'];

		require_once(BRID_PLUGIN_DIR . '/html/form/post/add_youtube.php');

		die(); // this is required to return a proper result (By wordpress site)
	}

	/*
	 * List all playlists created to post them into Post
	 */
	public static function playlistLibraryPost($internal = false)
	{
		$api = new BridAPI();

		$partner_id = BridOptions::getOption('site');

		$partnerData = BridHtml::getPartnerData();

		$players = $partnerData['Players'];

		//Turn off buttons and quick icons if we are on post screen
		$mode = isset($_POST['mode']) ? sanitize_text_field($_POST['mode']) : '';
		$buttonsOff = isset($_POST['buttons']) ? sanitize_text_field($_POST['buttons']) : false;
		$playlistType = '';
		$subaction = '';
		$_POST['limit'] = 8;

		//Sanitize search text if there is any
		if (isset($_POST['search'])) {
			$_POST['search'] = sanitize_text_field($_POST['search']);
		}

		//Is there anu search string set?
		$search = '';
		if (isset($_SESSION['Brid.Playlist.Search'])) {
			$search = $_SESSION['Brid.Playlist.Search'];
		}

		$playlists = $api->playlists($partner_id, true);

		$view = isset($_POST['view']) ? false : true;
		//Return json only
		if (!$view) {
			require_once(BRID_PLUGIN_DIR . '/html/list/playlist/playlist_list.php');
			die();
		}

		require_once(BRID_PLUGIN_DIR . '/html/list/playlist/playlistLibrary.php');

		if (!$internal)
			die(); // this is required to return a proper result (By wordpress site)
	}

	/**
	 * ADD playlist quick
	 */
	public static function addPlaylistPost($internal = false)
	{
		$api = new BridAPI();
		$partner_id = BridOptions::getOption('site');
		//Sanitize search text if there is any
		if (isset($_POST['search'])) {
			$_POST['search'] = sanitize_text_field($_POST['search']);
		}

		$subaction = isset($_POST['subaction']) ? sanitize_text_field($_POST['subaction']) : '';

		$mode = isset($_POST['mode']) ? sanitize_text_field($_POST['mode']) : '';
		if (!isset($_POST['playlistType'])) {
			//regular videos
			$_POST['playlistType'] = 0;
		}

		$playlistType = isset($_POST['playlistType']) ? sanitize_text_field($_POST['playlistType']) : 0;

		//Turn off buttons and quick icons if we are on post screen
		$buttonsOff = isset($_POST['buttons']) ? sanitize_text_field($_POST['buttons']) : false;

		$_POST['limit'] = 8;
		//Is there anu search string set?
		$search = '';
		if (isset($_SESSION['Brid.Video.Search'])) {
			$search = $_SESSION['Brid.Video.Search'];
		}
		//Get video list
		$videosDataset = $api->getVideosPost($partner_id, true);

		$view = isset($_POST['view']) ? false : true;
		//Return json only
		if (!$view) {
			require_once(BRID_PLUGIN_DIR . '/html/list/playlist/video_list.php');
			die();
		}

		//require videos list view
		require_once(BRID_PLUGIN_DIR . '/html/list/playlist/addPlaylist.php');
		if (!$internal)
			die();
	}

	/**
	 * ADD video quick
	 */
	public static function addVideoPost($internal = false)
	{
		$api = new BridAPI();

		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via'])) {
			//Save submit
			echo $api->addVideo($_POST, 'json');
			die();
		} else {
			$partnerData = BridHtml::getPartnerData();

			$upload = $partnerData['User']['permissions']['upload'];

			$tagsAlert = $partnerData['Partner']['attention_to_tags'];

			$default_exchange_rule = BridOptions::getOption('default_exchange_rule');
			$exchangeRules = $partnerData['ExchangeRules'];
			$tagsTaxonomies = $partnerData['TagsTaxonomies'];

			require_once(BRID_PLUGIN_DIR . '/html/form/post/add_video.php');
		}
		if (!$internal)
			die(); // this is required to return a proper result (By wordpress site)
	}

	/**
	 * ADD outstream unit post
	 */
	public static function addUnitPost($internal = false)
	{
		$api = new BridAPI();

		//get units
		$partnerData = BridHtml::getPartnerData();

		$units = $partnerData['Units'];

		$selectedUnit = BridOptions::getOption('unit');

		if (empty($selectedUnit)) {
			foreach ($units as $unit) {
				if ($unit['Unit']['default'] == 1) {
					$selectedUnit = $unit['Unit']['id'];
					break;
				}
			}
		}

		require_once(BRID_PLUGIN_DIR . '/html/form/post/outstream_unit.php');

		if (!$internal) {
			die();
		}
	}

	/**
	 * ADD carousel post
	 */
	public static function addCarouselPost($internal = false)
	{
		$api = new BridAPI();

		//get units
		$partnerData = BridHtml::getPartnerData();

		$carousels = $partnerData['Carousels'];

		$selectedCarousel = BridOptions::getOption('carousel');

		if (empty($selectedCarousel)) {
			$selectedCarousel = $carousels[0]['Carousel']['id'];
		}

		require_once(BRID_PLUGIN_DIR . '/html/form/post/carousel.php');

		if (!$internal) {
			die();
		}
	}

	/*
	 * Show Upload form only for premium partners
	 */
	public static function uploadVideoPost()
	{
		$api = new BridAPI();
		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via'])) {
			//Save submit
			echo $api->addVideo($_POST, 'json');
			die();
		} else {
			$partnerData = BridHtml::getPartnerData();

			$api = new BridAPI();

			$aws_credentials = $api->aws_credentials('array');

			$upload_path = 'tmp/' . BRID_ENV . '/';

			// $partner = $partnerData['Partner'];
			$upload = $partnerData['User']['permissions']['upload'];

			$upload_limit = BridHtml::getUploadLimit($partnerData);
			$autosave = $partnerData['User']['disable_video_autosave'] ? 0 : 1;
			$tagsAlert = $partnerData['Partner']['attention_to_tags'];
			$default_exchange_rule = BridOptions::getOption('default_exchange_rule');
			$exchangeRules = $partnerData['ExchangeRules'];
			$tagsTaxonomies = $partnerData['TagsTaxonomies'];
		}
		require_once(BRID_PLUGIN_DIR . '/html/form/post/add_upload.php');

		die();
	}

	/*
	 *  Show quick Video or Playlist library
	 */
	public static function quickLibrary()
	{
		$file = isset($_POST['file']) ? sanitize_text_field($_POST['file']) : 'video_library';

		if (!in_array($file, array('video_library', 'playlist_library', 'widget_library', 'unit_library', 'carousel_library'))) {
			$file = 'video_library';
		}

		$playerSelected  = BridOptions::getOption('player'); //Is there any selected player saved?
		$width  = BridOptions::getOption('width'); //Width
		$width =  $width != '' ?  $width : '640';

		$height  = BridOptions::getOption('height'); //Height
		$height =  $height != '' ?  $height : '480';

		$playerSettings = json_encode(array('id' => $playerSelected, 'width' => $width, 'height' => $height));

		$partnerData = BridHtml::getPartnerData();
		$platform = isset($partnerData['Platform']) ? $partnerData['Platform'] : null;

		$user = $partnerData['User'];
		$upload = $user['permissions']['upload'];

		require_once(BRID_PLUGIN_DIR . '/html/' . $file . '.php');

		die();
	}

	public static function getRawEmbed()
	{
		if (!empty($_POST['shortcode'])) {
			$_POST['shortcode'] = stripslashes($_POST['shortcode']);
			$_POST['shortcode'] = preg_replace("/\n/", " ", $_POST['shortcode']);

			$raw_embed = do_shortcode($_POST['shortcode']);
		}

		echo $raw_embed;
		die();
	}

	public static function getVideosInfo()
	{
		$api = new BridAPI();
		$partner_id = BridOptions::getOption('site');
		//Get video list
		$videosDataset = $api->getVideosPost($partner_id, true);

		echo json_encode($videosDataset->data);
		die();
	}

	public static function getVideoInfo()
	{
		$api = new BridAPI();
		$video_id = sanitize_text_field($_POST['video_id']);
		// Get video info
		$video = $api->video($video_id);

		echo json_encode($video);
		die();
	}
}

//Add actions
add_action('wp_ajax_videoLibraryPost', array('BridQuickPost', 'videoLibraryPost'));	//List videos to add to post from post screen
add_action('wp_ajax_addYoutubePost', array('BridQuickPost', 'addYoutubePost')); 		//Add youtube video action
add_action('wp_ajax_playlistLibraryPost', array('BridQuickPost', 'playlistLibraryPost'));	//Open playlist library
add_action('wp_ajax_uploadVideoPost', array('BridQuickPost', 'uploadVideoPost'));			//Upload video
add_action('wp_ajax_addVideoPost', array('BridQuickPost', 'addVideoPost'));				//Add video via url or via upload
add_action('wp_ajax_addPlaylistPost', array('BridQuickPost', 'addPlaylistPost'));				//Add video via url or via upload
add_action('wp_ajax_quickLibrary', array('BridQuickPost', 'quickLibrary'));		//Switch between tabs in add quick video to post
add_action('wp_ajax_bridVideoLibrary', array('BridQuickPost', 'bridVideoLibrary'));	//Colorbox to open post screen
add_action('wp_ajax_getRawEmbed', array('BridQuickPost', 'getRawEmbed'));	// raw js embed code
add_action('wp_ajax_getVideosInfo', array('BridQuickPost', 'getVideosInfo'));	// refresh video status from videolist
add_action('wp_ajax_getVideoInfo', array('BridQuickPost', 'getVideoInfo'));		// refresh video status for one video
