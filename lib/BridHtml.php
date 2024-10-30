<?php

/**
 * BridHtml class will manage all Html actions (will display forms or return responses for saved or requested actions)
 * @package plugins.brid.lib
 * @author Brid Dev Team, contact@brid.tv
 * @version 1.1
 */
class BridHtml
{

	public static $video_partner_id = null;

	public static function monetizeVideo()
	{

		$return = array('success' => false, 'msg' => 'Error');

		$api = new BridAPI();

		if (!empty($_POST) && isset($_POST['id']) && isset($_POST['monetize']) && isset($_POST['video_type'])) {
			$videoId = intval($_POST['id']);
			$video_type = intval($_POST['video_type']);
			$monetize = intval($_POST['monetize']);
			$partner = null;
			$partner_id = BridOptions::getOption('site');
			//Save submit
			if ($video_type) {
				$_POST['id'] = $partner_id;
				$partner = $api->updatePartnerField($_POST);
			}
			$data = array();
			$data['id'] = $videoId;
			$data['partner_id'] = $partner_id;
			$data['monetize'] = $monetize;

			$v = $api->editVideo($data, true);

			$return['success'] = true;
			$return['msg'] = 'Success';
			$return['Video'] = $v;
			$return['Partner'] = $partner;
		}
		header('Content-Type: application/json');
		echo json_encode($return);
		die();
	}

	public static function timeFormat($timeData, $format = 'F jS, Y')
	{
		$date = explode('-', $timeData); //2020-02-19

		if (strlen($date[0]) === 2) {
			$date = DateTime::createFromFormat('d-m-Y', $timeData);
		} else {
			$date = DateTime::createFromFormat('Y-m-d', $timeData);
		}

		return $date->format($format);
	}

	public static function format_time($t, $f = ':') // t = seconds, f = separator
	{
		$hours = (int) floor($t / 3600);
		$mins = (int) ($t / 60) % 60;
		$seconds = (int) $t % 60;

		$a = array();

		if ($hours != 0) {
			$a[] = sprintf("%02d", $hours);
		}
		if ($mins != 0) {
			$a[] = sprintf("%02d", $mins);
		} else {
			$a[] = '00';
		}
		if ($seconds != 0) {
			$a[] = sprintf("%02d", $seconds);
		} else {
			$a[] = '00';
		}
		return implode($f, $a);
	}
	public static function getPath($options = array())
	{
		return (!isset($options['type']) || !isset($options['id'])) ? '' : UGC . 'partners/' . $options['id'] . '/' . $options['type'] . '/';
	}

	/**
	 * Wp Callback, List all players by ajax call
	 * ajax.php?action=brid_api_get_players
	 * - Will display and populate listPlayersSite div with all available players for the selected partner(site)
	 * - Should receive $_POST['id'] (selected site id)
	 * - By default response is JSON object
	 * - If id is invalid throw error (json)
	 * @see http://codex.wordpress.org/AJAX_in_Plugins
	 * @return {String|JsonObject} players
	 **/
	public static function brid_api_get_players()
	{
		try {
			if (isset($_POST['id']) && is_numeric($_POST['id'])) {
				$partnerId = intval($_POST['id']);
				$api = new BridAPI();
				$players = $api->call(array('url' => 'players/' . $partnerId), false); //false for do not decode (json expected)

				echo $players;
			} else {
				throw new Exception('Invalid partner id');
			}
		} catch (Exception $e) {

			echo json_encode(array('error' => $e->getMessage()));
		}

		die(); // this is required to return a proper result (By wordpress site)

	}

	/**
	 * Get videos
	 */
	private static function getVideos()
	{
		//Maybe parner has been deleted from cms?
		$partner_id = BridOptions::getOption('site');
		if (empty($partner_id)) {
			BridHtml::error('Invalid partner id. Go to <a href="admin.php?page=brid-video-config-setting">settings page</a>.');
		}
		$api = new BridAPI();

		// need to be object
		$return = $api->getVideosPost($partner_id, true);
		// here we convert to array
		$return = json_decode(json_encode($return), true);

		if (!empty($return['message'])) {
			BridHtml::error($return['message']);
		}
		return $return;
	}

	/**
	 * [VIDEO LSIT]
	 * Get paginated video list by partner id
	 */
	public static function videos()
	{
		//Sanitize search text if there is any
		if (isset($_POST['search'])) {
			$_POST['search'] = sanitize_text_field($_POST['search']);
			$_SESSION['Brid.Video.Search'] = $_POST['search'];
		}
		if ($_SESSION['Brid.Video.Search']) {
			$_POST['search'] = $_SESSION['Brid.Video.Search'];
		}

		$subaction = isset($_POST['subaction']) ? sanitize_text_field($_POST['subaction']) : '';
		$mode = isset($_POST['mode']) ? sanitize_text_field($_POST['mode']) : '';
		$playlistType = isset($_POST['playlistType']) ? sanitize_text_field($_POST['playlistType']) : 0;

		//Turn off buttons and quick icons if we are on post screen
		$buttonsOff = isset($_POST['buttons']) ? sanitize_text_field($_POST['buttons']) : false;

		$videosDataset = self::getVideos();
		$partnerData = BridHtml::getPartnerData(true);
		$user = $partnerData['User'];
		$sites = $user['Sites'] ?? [];

		//Is there anu search string set?
		$search = '';
		if (isset($_SESSION['Brid.Video.Search'])) {
			$search = $_SESSION['Brid.Video.Search'];
		}

		//require videos list view
		require_once(BRID_PLUGIN_DIR . '/html/list/library/videos.php');
		die(); // this is required to return a proper result (By wordpress site)

	}
	public static function displayError($partnerData)
	{
		if (isset($partnerData['error'])) {

			echo '<div class="brid-api-error">
					<p>
					<a href="https://cms.target-video.com/" title="Visit TargetVideo Platform" target="_blank">
		<img src="' . BRID_PLUGIN_URL . 'img/logo_brid.tv.svg" alt="TargetVideo Platform" width="220px">
	</a>
					</p>
					<p>' . $partnerData['error_description'] . '</p>
					<p>
					' . __('Plese visit') . ' <a href="' . admin_url('admin.php?page=brid-video-config-setting') . '">' . __('TargetVideo settings page') . '</a> ' . __('to re-authentificate your plugin.') . '
					</p>
				</div>';
		}
	}

	/**
	 * Wp Callback, What will happen on Brid Video Media Library page cick
	 *
	 */
	public static function manage_videos()
	{
		$partnerData = BridHtml::getPartnerData(true);

		// if (empty($partnerData['message'])) {
		if (!isset($partnerData['message'])) {
			$videosDataset = self::getVideos();
			$user = isset($partnerData['User']) ? $partnerData['User'] : null;

			if ($user == null) {
				return;
			}

			$sites = $user['Sites'] ?? [];
			$platform = isset($partnerData['Platform']) ? $partnerData['Platform'] : null;
			$search = '';
			wp_enqueue_media(); //include media for browsing files in Add/Edit Video screen

			require_once(BRID_PLUGIN_DIR . '/html/manage.php');
		} else {
			BridHtml::error($partnerData['message']);
		}
	}

	public static function error($msg)
	{
		wp_die('<h5 style="display: inline-flex;
		justify-content: center;
		width: 100%;
		align-items: center;
		height: 100%;
		font-size: 16px;">' . $msg . '</h5>');
	}

	/**
	 * List playlists
	 */
	public static function playlists()
	{

		$api = new BridAPI();

		$partner_id = BridOptions::getOption('site');

		//Turn off buttons and quick icons if we are on post screen
		$buttonsOff = isset($_POST['buttons']) ? sanitize_text_field($_POST['buttons']) : false;

		//Sanitize search text if there is any
		if (isset($_POST['search'])) {
			$_POST['search'] = sanitize_text_field($_POST['search']);
		}
		$playlists = $api->playlists($partner_id, true);

		//Is there anu search string set?
		$search = '';
		if (isset($_SESSION['Brid.Playlist.Search'])) {
			$search = $_SESSION['Brid.Playlist.Search'];
		}

		//require videos list view
		require_once(BRID_PLUGIN_DIR . '/html/list/library/playlists.php');

		die(); // this is required to return a proper result (By wordpress site)
	}

	/**
	 * ffmpeg info
	 */
	public static function ffmpegInfo()
	{
		$ffmpeg_info = array();

		if (isset($_POST) && !empty($_POST) && isset($_POST['url'])) {

			$api = new BridAPI();

			header('Content-type: application/json');

			//Get Video Info
			echo  $api->ffmpegInfo($_POST, 'json');
		}

		die();
	}

	/**
	 * reupload video callback
	 */
	public static function replaceVideo()
	{
		if (isset($_POST) && !empty($_POST) && isset($_POST['id'])) {

			$api = new BridAPI();

			header('Content-type: application/json');

			//Get Video Info
			echo $api->replaceVideo($_POST, 'json');
		}

		die();
	}
	/**
	 * Edit playlist
	 */
	public static function editPlaylist()
	{
		$api = new BridAPI();

		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['id']) && isset($_POST['insert_via'])) {

			//Save submit
			echo $api->editPlaylist($_POST, 'json');
		} else {
			//Get Video Info via partner id
			if (!empty($_POST) && isset($_POST['id']) && is_numeric($_POST['id'])) {

				$playlistData = $api->playlist((int)$_POST['id'], true);
				$playlist = $playlistData->data;
				require_once(BRID_PLUGIN_DIR . '/html/form/edit_playlist.php');
			}
		}

		die(); // this is required to return a proper result (By wordpress site)
	}

	/**
	 * Add videos to the playlist
	 */
	public static function addVideoPlaylist()
	{
		$playlist_id = 0;

		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['ids'])) {
			$_POST['partner_id'] = BridOptions::getOption('site');

			$api = new BridAPI();

			echo $api->addVideoPlaylist($_POST, 'json');
		} else {
			$playlist_id = (int)$_POST['id'];
			$playlistType = isset($_POST['playlistType']) ? sanitize_text_field($_POST['playlistType']) : 0;
			require_once(BRID_PLUGIN_DIR . '/html/form/add_video_playlist.php');
		}

		die(); // this is required to return a proper result (By wordpress site)
	}

	/**
	 * ADD Playlist
	 */
	public static function addPlaylist()
	{
		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via'])) {

			$api = new BridAPI();
			echo $api->addPlaylist($_POST, 'json');
			die();
		} else {
			$videoType = isset($_GET['video_type']) ? sanitize_text_field($_GET['video_type']) : '';
			$playlistType = isset($_GET['playlistType']) ? sanitize_text_field($_GET['playlistType']) : 0;

			require_once(BRID_PLUGIN_DIR . '/html/form/add_playlist.php');
		}

		die(); // this is required to return a proper result (By wordpress site)
	}

	/**
	 * Add Youtube
	 */
	public static function addYoutube()
	{
		$api = new BridAPI();
		$partnerData = self::getPartnerData();
		$tagsTaxonomies = $partnerData['TagsTaxonomies'];

		require_once(BRID_PLUGIN_DIR . '/html/form/add_youtube.php');

		die(); // this is required to return a proper result (By wordpress site)
	}

	/**
	 * Edit video
	 */
	public static function editVideo()
	{
		// maybe we can get the entire view here from API
		$api = new BridAPI();

		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['id']) && isset($_POST['insert_via'])) {
			// strip slashes from name and description (adding slashes in view so we can populate fields trough js)
			$_POST['name'] = stripslashes($_POST['name']);
			$_POST['description'] = stripslashes($_POST['description']);

			//Save submit
			echo $api->editVideo($_POST, 'json');
			die();
		} else {
			//Get Video Info
			if (!empty($_POST) && isset($_POST['id']) && is_numeric($_POST['id'])) {

				$video = $api->video((int)$_POST['id'], true);
				self::$video_partner_id = $video->Video->partner_id; // Use partner ID of video owner
				$partnerData = BridHtml::getPartnerData(); // true disables cache for development
				$descriptors = isset($partnerData["Descriptiors"]) ? $partnerData["Descriptiors"] : null;
				$user = $api->userinfo('array');
				$permissions = $user['permissions'];

				$ads = array();
				if (isset($video->Ad)) {
					$ads = $video->Ad;
				}

				//GET TEMPORARY CREDENTIALS
				$aws_credentials = $api->aws_credentials('array');

				$upload_path = 'tmp/' . BRID_ENV . '/';

				$upload = !empty($aws_credentials) ? 1 : 0;

				$amIEncoded = ($video->Video->encoded || $video->Video->fetched) ? 1 : 0;

				$partner = $api->partner(BridOptions::getOption('site'), true);

				$upload_path_snapshot = BRID_ENV . '/partners/' . $partner->Partner->id . '/snapshot/';

				$upload_path_cc = BRID_ENV . '/partners/' . $partner->Partner->id . '/vtt/';

				$upload_limit = self::getUploadLimit($partnerData);

				$tagsAlert = $partnerData['Partner']['attention_to_tags'];

				//cc
				$cc = null;
				if (!empty($video->Video->tracks)) {
					foreach ($video->Video->tracks as $track) {
						if ($track->kind === 'captions') {
							$cc = $track->src;
						}
					}
				}

				require_once(BRID_PLUGIN_DIR . '/html/form/edit_video.php');
			}
		}

		die(); // this is required to return a proper result (By wordpress site)

	}

	public static function seek_snapshot()
	{
		$api = new BridAPI();
		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['Video']['id']) && isset($_POST['Video']['time_from_video']) && isset($_POST['Partner']['id'])) {
			$_POST['Video']['id'] = intval($_POST['Video']['id']);
			$_POST['Partner']['id'] = intval($_POST['Partner']['id']);

			//Save submit
			echo $api->seek_snapshot($_POST, 'json');
		} else {
			var_dump($_POST);
		}
		die();
	}

	public static function new_snapshot()
	{
		$api = new BridAPI();
		if (
			!empty($_POST) && isset($_POST['action']) && isset($_POST['Video']['id']) && isset($_POST['Video']['upload_snapshot'])
			&& isset($_POST['Video']['path']) && isset($_POST['Video']['field']) && isset($_POST['Partner']['id'])
		) {
			$_POST['Video']['id'] = (int)$_POST['Video']['id'];
			$_POST['Partner']['id'] = (int)$_POST['Partner']['id'];

			//Save submit
			echo $api->new_snapshot($_POST, 'json');
		} else {
			http_response_code(400);
			echo '{"message": "Bad request. post params"}';
		}
		die();
	}

	public static function resync_carousel()
	{
		$api = new BridAPI();
		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['Carousel']['id'])) {
			$_POST['Carousel']['id'] = (int)$_POST['Carousel']['id'];

			//Save submit
			echo $api->resync_carousel($_POST, 'json');
		} else {
			var_dump($_POST);
		}
		die();
	}

	public static function carousel_parse_url()
	{
		$api = new BridAPI();
		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['Slide']['url'])) {
			//submit
			$res = $api->carousel_parse_url($_POST);

			if (!empty($res->code) && $res->code !== 200) {
				http_response_code($res->code);
			}
			header('Content-type: application/json');
			echo json_encode($res);
		} else {
			http_response_code(400);
			echo '{"message": "Slide url param is required"}';
		}
		die();
	}

	public static function addAdTags()
	{
		$api = new BridAPI();
		$mode = 'add';
		if (!empty($_POST) && isset($_POST['action'])) {
			//Save submit
			echo $api->addAdTag($_POST, 'json');
		} else {
			$select_box_id = isset($_GET['select_box_id']) ? sanitize_text_field($_GET['select_box_id']) : 0;
			$append_to_stack = isset($_GET['append_to_stack']) ? (int)$_GET['append_to_stack'] : 0;
			$ad_tag_type = isset($_GET['ad_tag_type']) ? sanitize_text_field($_GET['ad_tag_type']) : 0;

			require_once(BRID_PLUGIN_DIR . '/html/form/addAdTags.php');
		}

		die();
	}

	public static function editAdTags()
	{
		$api = new BridAPI();
		$mode = 'edit';
		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['id'])) {
			// unset partner_id on edit
			unset($_POST['partner_id']);
			//Save submit
			echo $api->editAdTag((int)$_POST['id'], $_POST, 'json');
		} else {
			//Get Video Info
			if (!empty($_GET) && isset($_GET['id']) && is_numeric($_GET['id'])) {

				$adTag = $api->adTag((int)$_GET['id'], 'array');

				require_once(BRID_PLUGIN_DIR . '/html/form/addAdTags.php');
			}
		}

		die();
	}

	/**
	 * Delete ad tags
	 */
	public static function deleteAdTags()
	{
		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['id']) && is_numeric($_POST['id'])) {
			$api = new BridAPI();
			$_POST['id'] = intval($_POST['id']);
			echo $api->deleteAdTags($_POST, 'json');
		}
		die();
	}

	public static function askMonetize()
	{
		$applyForAdProgram = 0;

		$partnerData = BridHtml::getPartnerData();

		$applyForAdProgram = $partnerData['Partner']['apply_ad_program'];

		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via'])) {

			$api = new BridAPI();
			$_POST['id'] = BridOptions::getOption('site');

			header('Content-type: application/json');

			echo $api->askForMonetization($_POST, 'json');
		} else {
			global $current_user;
			get_currentuserinfo();

			require_once(BRID_PLUGIN_DIR . '/html/form/ask_monetization.php');
			die();
		}

		die(); // this is required to return a proper result (By wordpress site)
	}

	/**
	 *  Upload video
	 */
	public static function uploadVideo($internal = false)
	{

		$api = new BridAPI();

		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via'])) {
			//Save submit
			try {
				echo  $api->addVideo($_POST, 'json');
			} catch (Exception $e) {
				echo $e->getMessage();
			}
			die();
		} else {
			//GET TEMPORARY CREDENTIALS
			$aws_credentials = $api->aws_credentials('array');

			$upload_path = 'tmp/' . BRID_ENV . '/';

			$upload = !empty($aws_credentials) ? 1 : 0;

			$partner = BridOptions::getOption('site');
			$partnerData = self::getPartnerData(true);
			$upload_limit = self::getUploadLimit($partnerData);
			$autosave = $partnerData['User']['disable_video_autosave'] ? 0 : 1;
			$tagsAlert = $partnerData['Partner']['attention_to_tags'];
			$default_exchange_rule = BridOptions::getOption('default_exchange_rule');
			$exchangeRules = $partnerData['ExchangeRules'];
			$tagsTaxonomies = $partnerData['TagsTaxonomies'];

			require_once(BRID_PLUGIN_DIR . '/html/form/upload_video.php');
		}

		if (!$internal)
			die(); // this is required to return a proper result (By wordpress site)
	}

	/**
	 * ADD video
	 */
	public static function addVideo($internal = false)
	{
		$api = new BridAPI();

		if (!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via'])) {
			//Save submit
			try {
				echo  $api->addVideo($_POST, 'json');
			} catch (Exception $e) {
				echo $e->getMessage();
			}
			die();
		} else {
			$partnerData = BridHtml::getPartnerData(); // true disables cache for development
			$tagsAlert = $partnerData['Partner']['attention_to_tags'];
			$default_exchange_rule = BridOptions::getOption('default_exchange_rule');
			$exchangeRules = $partnerData['ExchangeRules'];
			$tagsTaxonomies = $partnerData['TagsTaxonomies'];

			require_once(BRID_PLUGIN_DIR . '/html/form/add_video.php');
		}

		if (!$internal)
			die(); // this is required to return a proper result (By wordpress site)
	}

	/**
	 * List players for Brid Playlist Widget
	 */
	public static function playersList()
	{
		$api = new BridAPI();

		$partnerId = intval(BridOptions::getOption('site'));

		echo $api->call(array('url' => 'players/' . $partnerId), false); //false for do not decode (json expected)
		die();
	}

	/**
	 * Remove item from playlsit
	 */
	public static function removeVideoPlaylist()
	{

		$api = new BridAPI();
		$_POST['id'] = isset($_POST['id']) ? (int)$_POST['id'] : 0;
		$_POST['video_id'] = isset($_POST['video_id']) ? (int)$_POST['video_id'] : 0;
		$_POST['partner_id'] = (int)BridOptions::getOption('site');
		if ($_POST['id'] != 0 && $_POST['video_id'] != 0)
			echo $api->removeVideoPlaylist($_POST, 'json');
		die();
	}

	/**
	 * Sort videos in playlist
	 */
	public static function sortVideos()
	{

		if (!empty($_POST) && isset($_POST['action'])) {
			$api = new BridAPI();
			$_POST['partner_id'] = intval(BridOptions::getOption('site'));
			echo $api->sortVideos($_POST, 'json');
		}
		die();
	}

	/**
	 * Clear all playlist items
	 */
	public static function clearPlaylist()
	{
		$api = new BridAPI();
		$_POST['partner_id'] = intval(BridOptions::getOption('site'));
		echo $api->clearPlaylist($_POST, 'json');
		die();
	}

	/**
	 * Delete video
	 */
	public static function deleteVideos()
	{
		if (!empty($_POST) && isset($_POST['action'])) {
			$api = new BridAPI();
			$_POST['partner_id'] = intval(BridOptions::getOption('site'));
			$_POST['ids'] = sanitize_text_field($_POST['data']['Video']['ids']);
			echo $api->deleteVideos($_POST, 'json');
		}
		die();
	}

	/**
	 * Delete playlist
	 */
	public static function deletePlaylists()
	{
		if (!empty($_POST) && isset($_POST['action'])) {
			$api = new BridAPI();
			$_POST['partner_id'] = intval(BridOptions::getOption('site'));
			$_POST['ids'] = sanitize_text_field($_POST['data']['Playlist']['ids']);
			echo $api->deletePlaylists($_POST, 'json');
		}
		die();
	}

	/**
	 * Check YouTube Url
	 * Api needs:
	 * $_POST['url'] = 'http://www.youtube.com?v=32124'
	 */
	public static function checkUrl()
	{
		if (isset($_POST['external_url']) && !empty($_POST['external_url'])) {
			$api = new BridAPI();
			$_post['url'] = sanitize_text_field($_POST['external_url']);
			echo $api->checkUrl($_post, 'json');
		}
		die();
	}

	/**
	 * Fetch YouTube Video
	 * Api needs:
	 * $_POST['videoUrl'] = 'http://www.youtube.com?v=32124'
	 * $_POST['partner_id'] = 1
	 */
	public static function fetchVideo()
	{
		if (isset($_POST['videoUrl']) && !empty($_POST['videoUrl'])) {
			$api = new BridAPI();
			$_post['partner_id'] = BridOptions::getOption('site');
			$_post['videoUrl'] = sanitize_text_field($_POST['videoUrl']);
			echo $api->fetchVideoViaUrl($_post, 'json');
		}
		die();
	}

	/**
	 * Change Video or Playlist status flag
	 */
	public static function changeStatus()
	{
		header('Content-type: application/json');
		$api = new BridAPI();
		$_POST['partner_id'] = BridOptions::getOption('site');
		//Change status
		echo $api->changeStatus($_POST, 'json');
		die();
	}

	public static function updatePartnerField()
	{
		if (!empty($_POST['name']) && isset($_POST['value'])) {
			//Maybe partner has been deleted from cms?
			$api = new BridAPI();
			//Get partner Info
			$_POST['id'] = BridOptions::getOption('site');
			$name = sanitize_text_field($_POST['name']);
			$_POST[$name] = sanitize_text_field($_POST['value']);
			$partner = $api->updatePartnerField($_POST);
		}

		die();
	}

	public static function updatePartnerId()
	{
		if (!empty($_GET['id'])) {
			BridOptions::updateOption('site', (int)$_POST['id']);
		}

		die();
	}

	//icon
	public static function addPostButton($context)
	{
		$options = array_merge(get_option('brid_options'), BridShortcode::getSize());

		$context .= "<div class='bridAjax' style='cursor: pointer' id='bridQuickPostIcon' href='" . admin_url('admin-ajax.php') . "?action=bridVideoLibrary'>
		    <img src='" . BRID_PLUGIN_URL . "/img/brid_tv.png'/></div><script>var convertedVideos = []; var BridOptions = " . json_encode(array_merge($options, array('ServicesUrl' => CLOUDFRONT))) . "; jQuery('.bridAjax').colorbox({innerWidth:'80%', innerHeight:'580px', className: 'bridColorbox'});</script>";

		return $context;
	}

	/*
     * Fancy checkbox option
     *
     * $opt array values
     * name = brid_options[ovr_def]
     * id = 'ovr_def'
     * value = 1/0
     * title = REPLACE DEFAULT PLAYER WITH BRID PLAYER
     * desc = Will try to replace all default wordpress video tags with Brid.tv player. Videos will be automatically monetized with your Ad Tag Url.
     * method = jsMethodToggle
     * marginTop -optional
     * marginBottom - optional
     */
	public static function checkbox($opt)
	{
		if (!isset($opt['id'])) {
			echo "Checkbox Error: Id missing chechbox";
			return false;
		}
		if (!isset($opt['name'])) {
			echo "Checkbox Error: Name missing chechbox";
			return false;
		}
		if (!isset($opt['value'])) {
			echo "Checkbox Error: Value missing chechbox";
			return false;
		}
		$opt['value'] = intval($opt['value']);
		if (!isset($opt['title'])) {
			echo "Checkbox Error: Id missing chechbox";
			return false;
		}
		$c = 'none';
		$inp = '';
		if ($opt['value']) {


			$c = 'block';
			$inp = 'checked';
		}
		$dataMethod = '';
		if (isset($opt['method'])) {
			$dataMethod = 'data-method="' . $opt['method'] . '"';
		}
		$marginTop = '20';
		if (isset($opt['marginTop'])) {
			$marginTop = intval($opt['marginTop']);
		}
		$marginBottom = '0';
		if (isset($opt['marginBottom'])) {
			$marginBottom = intval($opt['marginBottom']);
		}
		$paddingTop = '20';
		if (isset($opt['paddingTop'])) {
			$paddingTop = intval($opt['paddingTop']);
		}
		$paddingBottom = '10';
		if (isset($opt['paddingBottom'])) {
			$paddingBottom = intval($opt['paddingBottom']);
		}

?>

		<div class="checkboxRowSettings" style="padding-bottom:<?php echo $paddingBottom; ?>px;padding-top:<?php echo $paddingTop; ?>px;margin-top:<?php echo $marginTop; ?>px;margin-bottom:<?php echo $marginBottom; ?>px;">
			<div id="checkbox-<?php echo $opt['id']; ?>" class="bridCheckbox" <?php echo $dataMethod; ?> data-name="<?php echo $opt['id']; ?>">
				<div class="checkboxContent">
					<img src="<?php echo BRID_PLUGIN_URL; ?>img/checked.png" class="checked" style="display:<?php echo $c; ?>" alt="">
					<input type="hidden" name="<?php echo $opt['name']; ?>" class="singleCheckbox <?php echo $inp; ?>" id="<?php echo $opt['id']; ?>" value="<?php echo $opt['value']; ?>" data-value="<?php echo $opt['value']; ?>" style="display:none;">
				</div>
				<div class="checkboxText"><?php echo $opt['title']; ?></div>
				<?php if (isset($opt['desc'])) { ?>
					<div class="flashFalbackWarring"><?php echo $opt['desc']; ?></div>
				<?php } ?>
			</div>
		</div>
<?php
	}

	public static function dynamics()
	{
		$api = new BridAPI();

		require_once(BRID_PLUGIN_DIR . '/html/form/dynamic.php');

		die();
	}

	//Un-authorize user only
	public static function unauthorizeBrid()
	{
		$api = new BridAPI();
		self::clearSessionCache();
		delete_option('brid_options');
		if (isset($_GET['red'])) {
			wp_redirect(admin_url('admin.php?page=brid-video-config-setting'));
		}
		die();
	}

	public static function admin_notice_message()
	{
		if (!BridOptions::areThere() && !isset($_GET['code'])) {
			echo '<div class="updated" style="background-color: rgba(255, 0, 0, 0.1); border: 2px solid rgba(255, 0, 0, 0.5);text-align:center;"><p>You must <a href="options-general.php?page=brid-video-config-setting" id="ConfigureBrid">configure</a> the Brid Video plugin before you start using it.</p></div>';
		}
	}

	/**
	 * Send premium request
	 * @throws Exception
	 */
	public static function bridPremium()
	{
		try {
			if (isset($_POST['premium']) && is_numeric($_POST['premium'])) {

				$premium = intval($_POST['premium']);

				$api = new BridAPI();

				$response = $api->call(array('url' => 'premium/' . BridOptions::getOption('site') . '/' . $premium), 'json');
				/**
				 * We have send premium request
				 * set partner to be external
				 */
				BridOptions::updateOption('question', '1');
				echo $response;
			} else {
				throw new Exception('Invalid request data');
			}
		} catch (Exception $e) {

			echo json_encode(array('error' => $e->getMessage()));
		}

		die(); // this is required to return a proper result (By wordpress site)

	}
	/**
	 * Grab user data and store it into cache
	 * @param boolean $ignoreCache
	 * @return boolean|unknown|unknown
	 */
	public static function getUserData($ignoreCache = false)
	{
		$cacheSessionKey = 'user_array';

		//Read from session
		$getFromSession = self::getSessionCache($cacheSessionKey);
		if (!$ignoreCache) {
			if (!empty($getFromSession)) {
				if (!headers_sent()) {
					header('Brid-Get-Cache: yes');
				}
				return $getFromSession;
			}
		}
		$api = new BridAPI();

		$user = $api->userinfo('array');

		//Write to session
		self::setSessionCache($cacheSessionKey, $user);
		if (!headers_sent()) {

			header('Brid-Set-Cache: yes');
		}

		return $user;
	}

	/**
	 * Grab Partner data and store it into cache
	 * @param string $ignoreCache
	 */
	public static function getPartnerData($ignoreCache = false)
	{
		// Because of Exchange Rules, we need video owner parner id
		$partnerId = self::$video_partner_id ?? BridOptions::getOption('site', true);

		$cacheSessionKey = 'partner_' . $partnerId . '_array';

		if (!$ignoreCache) {
			//Read from session
			$getFromSession = self::getSessionCache($cacheSessionKey);

			if (!empty($getFromSession)) {
				if (!headers_sent()) {
					header('X-Brid-Get-Cache: yes');
				}
				return $getFromSession;
			}
		}
		$api = new BridAPI();

		$partnerData = $api->call(array('url' => 'partner/getData/' . (int)$partnerId), 'array');

		if (is_object($partnerData)) {
			self::setSessionCache($cacheSessionKey, null);
			BridHtml::displayError(["error" => true, "error_description" => "Malformed auth header"]);
			die();
		}

		if (!isset($partnerData['error'])) {
			// permissions fix
			if (empty($partnerData['User']['permissions']) && !empty($partnerData['User']['Plan']['permissions'])) {
				$partnerData['User']['permissions'] = $partnerData['User']['Plan']['permissions'];
			}
			//Write to session
			self::setSessionCache($cacheSessionKey, $partnerData);
			if (!headers_sent()) {

				header('X-Brid-Set-Cache: yes');
			}
		} else {
			if (!headers_sent()) {
				header('X-Brid-Api-Error:' . $partnerData['error_description']);
			}

			self::setSessionCache($cacheSessionKey, null);
			BridHtml::displayError($partnerData);
			die;
		}

		return $partnerData;
	}

	/**
	 * Get data from session store
	 * @param string $name
	 */
	public static function getSessionCache($url)
	{

		self::checkSessionExpire($url);
		return (isset($_SESSION['Brid.Cache'][$url]['data']) && !empty($_SESSION['Brid.Cache'][$url]['data'])) ? $_SESSION['Brid.Cache'][$url]['data'] : false;
	}

	private static function checkSessionExpire($url)
	{
		if (!empty($_SESSION['Brid.Cache'][$url]['expire'])) {

			$time_in_future = $_SESSION['Brid.Cache'][$url]['expire'];

			if ($time_in_future < strtotime('now')) {
				self::clearSessionCacheByKey($url);
			}
		} else {
			$_SESSION['Brid.Cache'][$url]['expire'] = strtotime('now') + 600;
		}
	}

	/**
	 * Set data into Session
	 * @param string $url
	 * @param array|object|string $data
	 */
	public static function setSessionCache($url, $data)
	{
		if (!empty($data)) {

			if (!isset($_SESSION['Brid.Cache'])) {
				$_SESSION['Brid.Cache'] = [];
			}
			if (!isset($_SESSION['Brid.Cache'][$url])) {

				$_SESSION['Brid.Cache'][$url] = [];
			}
			$_SESSION['Brid.Cache'][$url]['data'] = $data;
			$_SESSION['Brid.Cache'][$url]['expire'] = strtotime('now') + 600;
		}
	}

	/**
	 * Clear session cache
	 */
	public static function clearSessionCacheByKey($url)
	{
		$_SESSION['Brid.Cache'][$url] = [];
	}

	public static function clearSessionCache()
	{
		$_SESSION['Brid.Cache'] = [];
	}

	//Convert brid iframe into brid short code before saving into DB
	public static function my_filter_brid_iframe_to_short($content)
	{
		$reg = "#<iframe[^>]+>.*?</iframe>#is";
		$iframes = array();

		if (preg_match_all($reg, $content, $matches)) {

			foreach ($matches[0] as $key => $match) {

				$iframe = $matches[0][$key];

				$iframe = stripslashes($iframe);

				$iframes[] = $iframe;
				//Title
				$title = 'No title';
				$src = '';
				$shortcode = '';
				if (preg_match('/src=\"(.*)\"/isU', $iframe, $m)) {


					if (isset($m[1])) {

						if (strpos($m[1], CLOUDFRONT) !== false) {

							$src = str_replace(CLOUDFRONT, '', $m[1]);

							if (preg_match('/title=\"(.*)\"/isU', $iframe, $m)) {

								if (isset($m[1])) {
									$title = $m[1];
								}
							}
							//Params
							$d = explode('/', $src);

							if ($src != '' && isset($d[2]) && isset($d[3]) && isset($d[5])) {

								$shortcode = '[brid ' . $d[2] . '="' . $d[3] . '" player="' . $d[5] . '" title="' . addslashes($title) . '"]';

								$content = str_replace($iframe, $shortcode, $content);
							}
						}
					}
				}
			}
		}

		return $content;
	}

	public static function uploaded_cc()
	{
		$api = new BridAPI();
		if (!empty($_POST) && isset($_POST['action'], $_POST['id'], $_POST['partner_id'], $_POST['cc'])) {
			$_POST['id'] = (int)$_POST['id'];
			$_POST['partner_id'] = (int)$_POST['partner_id'];

			//Save submit
			$res = $api->updated_cc($_POST, 'json');
			echo $res;
		} else {
			var_dump($_POST);
		}
		die();
	}

	public static function remove_cc()
	{
		$api = new BridAPI();
		if (!empty($_POST) && isset($_POST['action'], $_POST['id'], $_POST['partner_id'])) {
			$_POST['id'] = (int)$_POST['id'];
			$_POST['partner_id'] = (int)$_POST['partner_id'];

			//Save submit
			$res = $api->remove_cc($_POST, 'json');
			echo $res;
		} else {
			var_dump($_POST);
		}
		die();
	}

	public static function getInfoFromYoutubeDirect()
	{
		$id = $_GET['id'];
		$args = array(
			'method' => 'GET',
		);
		$url = 'https://www.youtube.com/watch?v=' . $id;

		$response = wp_remote_request($url, $args);
		$code = wp_remote_retrieve_response_code($response);
		$body = false;
		$error = false;

		if (!is_wp_error($response)) {
			$entity = wp_remote_retrieve_body($response);
			if ($entity) {
				$body = $entity;
			}
		} else {
			$body = $response;
			$error = $response->get_error_message();
		}

		$data['items'] = [];

		if (strpos($body, 'Video unavailable') === FALSE) {

			$title = explode('"title" content="', $body);
			$title = explode('"', $title[1]);
			$title = $title[0];

			$author = explode('","author":"', $body);
			$author = explode('",', $author[1]);
			$author = $author[0];

			$published = explode('"datePublished" content="', $body);
			$published = explode('"', $published[1]);
			$published = $published[0];

			$data['items'] = [
				'id' => $id,
				'snippet' => [
					'title' => $title,
					'channelTitle' => $author,
					'publishedAt' => $published,
					'thumbnails' => [
						'default' => [
							'url' => 'https://i.ytimg.com/vi/' . $id . '/hqdefault.jpg',
						]
					]
				]
			];
		}

		echo json_encode($data);
		die();
	}

	public static function getUploadLimit($partnerData)
	{
		$upload_limit_user = $partnerData['User']['upload_limit'];
		$upload_limit_partner = $partnerData['Partner']['upload_limit'];
		$owerwrite_permissions = $partnerData['Partner']['owerwrite_permissions'];

		// if $owerwrite_permissions is on than we use partner limit
		if ($owerwrite_permissions == true) {
			$upload_limit = $upload_limit_partner;
		} else {
			$upload_limit = $upload_limit_user;
		}

		return $upload_limit;
	}
}



//Pre save filter to brid code
add_filter('content_save_pre', array('BridHtml', 'my_filter_brid_iframe_to_short'), 9, 1);

/* -------- ADD TO POST -------- */
add_action('wp_ajax_dynamics', array('BridHtml', 'dynamics'));							//Colorbox to open post screen
/* -------- PLAYLIST -------- */
add_action('wp_ajax_sortVideos', array('BridHtml', 'sortVideos')); 						//Sort videos in playlist edit mode
add_action('wp_ajax_removeVideoPlaylist', array('BridHtml', 'removeVideoPlaylist')); 	//Remove single item from playlist
add_action('wp_ajax_clearPlaylist', array('BridHtml', 'clearPlaylist')); 				//Remove all items - clearPlaylist
add_action('wp_ajax_addPlaylist', array('BridHtml', 'addPlaylist'));					//Tab click get Add playlist view
add_action('wp_ajax_addVideoPlaylist', array('BridHtml', 'addVideoPlaylist'));			//Add videos into playlist
add_action('wp_ajax_playlists', array('BridHtml', 'playlists'));						//Tab click get Playlist view
add_action('wp_ajax_editPlaylist', array('BridHtml', 'editPlaylist'));					//Edit playlist action
add_action('wp_ajax_deletePlaylists', array('BridHtml', 'deletePlaylists'));			//Delete playlist/s action

/* ad tags */
add_action('wp_ajax_addAdTags', array('BridHtml', 'addAdTags'));		    //Add ad tags
add_action('wp_ajax_editAdTags', array('BridHtml', 'editAdTags'));		    //Edit ad tags

/* -------- VIDEO -------- */
add_action('wp_ajax_askMonetize', array('BridHtml', 'askMonetize'));		//Ask for monetization program
//add_action('wp_ajax_loadAdBox', array('BridHtml', 'loadAdBox'));		    //Load selected ad tags
add_action('wp_ajax_bridAction', array('BridHtml', 'bridAction'));			//Tab click get Videos view
add_action('wp_ajax_videos', array('BridHtml', 'videos'));					//Tab click get Videos view
add_action('wp_ajax_addVideo', array('BridHtml', 'addVideo'));				//Add video via url or via upload
add_action('wp_ajax_uploadVideo', array('BridHtml', 'uploadVideo'));	    //Add video via url or via upload
add_action('wp_ajax_addYoutube', array('BridHtml', 'addYoutube')); 			//Add youtube video action
add_action('wp_ajax_editVideo', array('BridHtml', 'editVideo'));		    //Edit video action
add_action('wp_ajax_ffmpegInfo', array('BridHtml', 'ffmpegInfo'));			//Get video ffmpeg info
add_action('wp_ajax_replaceVideo', array('BridHtml', 'replaceVideo'));		//replace/reencode video after upload
add_action('wp_ajax_deleteAdTags', array('BridHtml', 'deleteAdTags'));		//Delete ad tags action
add_action('wp_ajax_deleteVideos', array('BridHtml', 'deleteVideos'));		//Delete videos action
add_action('wp_ajax_checkUrl', array('BridHtml', 'checkUrl'));				//Check youtube url
add_action('wp_ajax_fetchVideo', array('BridHtml', 'fetchVideo'));			//Fetch Video
add_action('wp_ajax_deleteAd', array('BridHtml', 'deleteAd'));				//Delete Ad item from Video
add_action('wp_ajax_adBox', array('BridHtml', 'adBox'));					//Get Add Ad form for Video Monetization
add_action('wp_ajax_adBoxUnit', array('BridHtml', 'adBoxUnit'));			//Get Add Ad form for outstream unit Video Monetization
add_action('wp_ajax_playersList', array('BridHtml', 'playersList'));
add_action('wp_ajax_seek_snapshot', array('BridHtml', 'seek_snapshot'));	//get video snapshot on specified time
add_action('wp_ajax_new_snapshot', array('BridHtml', 'new_snapshot'));	//update video snapshot and thumbnail
add_action('wp_ajax_resync_carousel', array('BridHtml', 'resync_carousel'));	//resync carousel
add_action('wp_ajax_carousel_parse_url', array('BridHtml', 'carousel_parse_url'));	//carousel parse url
add_action('wp_ajax_uploaded_cc', array('BridHtml', 'uploaded_cc'));	//upload captions
add_action('wp_ajax_remove_cc', array('BridHtml', 'remove_cc'));	//remove captions
add_action('wp_ajax_getInfoFromYoutubeDirect', array('BridHtml', 'getInfoFromYoutubeDirect'));	//baypass google api

/* -------- PLAYLIST & VIDEO -------- */
add_action('wp_ajax_changeStatus', array('BridHtml', 'changeStatus'));		//Change Status on video or playlist

/*--------- PARTNER -------------- */
add_action('wp_ajax_updatePartnerId', array('BridHtml', 'updatePartnerId'));		//Update partner id
add_action('wp_ajax_updatePartnerField', array('BridHtml', 'updatePartnerField'));	//Update partner field
add_action('wp_ajax_bridPremium', array('BridHtml', 'bridPremium')); //Send premium request
//Try to create crossdomain.xml
add_action('wp_ajax_createCrossdomain', array('BridHtml', 'createCrossdomain')); //Send premium request
add_action('wp_ajax_monetizeVideo', array('BridHtml', 'monetizeVideo')); //Monetize videos
add_action('wp_ajax_unauthorizeBrid', array('BridHtml', 'unauthorizeBrid')); //Unauthorize account
