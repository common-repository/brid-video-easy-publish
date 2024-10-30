<?php

/**
 * BridShortcode class will manage all shortcode manipulation
 * @package plugins.brid.lib
 * @author Brid Dev Team, contact@brid.tv
 * @version 1.1
 */

class BridShortcode
{
	/**
	 * Brid widget short code
	 * [brid_widget items="25" player="1" height="540" type="1"] //YT
	 * [brid_widget items="25" player="1" height="540" type="0"] //Brid videos
	 * [brid_widget items="25" player="1" height="540" type="0" autoplay="1"] //Brid videos with autoplay
	 * [brid_widget items="25" player="1" height="540" type="0" player="1789"] //Brid videos with player id 1789
	 * [brid_widget items="25" player="1" height="540" type="1" category="14"] //Youtube Brid videos from category id 14
	 * [brid_widget items="25" player="1" height="540" type="0" category="14"] //Brid videos from category id 14
	 * Type is for playlist type 0/1 yt or brid
	 */
	public $fbArticles = false;

	//Check enqueued scripts
	private static function checkScriptEnqueued($name, $handle)
	{
		$list = 'enqueued';
		if (wp_script_is($handle, $list)) {
			return;
		} else {
			wp_register_script($name, $handle);
			wp_print_scripts($name, $handle, array(), null, false);
		}
	}

	public static function brid_widget($attrs, $content)
	{
		global $wp_widget_factory;

		extract(shortcode_atts(array(
			'widget_name' => 'BridPlaylist_Widget',
			'items' => 10,
			'height' => 360,
			'player' => BridOptions::getOption('player'),
			'category' => null,
			'autoplay' => null,
			'color' => 0,
			'type' => 0
		), $attrs));

		$widget_name = wp_specialchars($widget_name);

		if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')) :
			$wp_class = 'WP_Widget_' . ucwords(strtolower($class));

			if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')) :
				return '<p>' . sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"), '<strong>' . $wp_class . '</strong>') . '</p>';
			else :
				$class = $wp_class;
			endif;
		endif;

		$widget = BridOptions::getOption('widget');

		if (!$widget) {
			$output = '<p>Brid Playlist widget is available for paid plans only.</p>';
		} else {
			ob_start();
			self::checkScriptEnqueued('jquery', 'jquery');
			wp_register_script('brid.widget.min.js', CLOUDFRONT . 'widget/brid.widget.min.js', array(), null);
			wp_print_scripts('brid.widget.min.js', CLOUDFRONT . 'widget/brid.widget.min.js', array(), null);

			$instance['items'] = $items;
			$instance['height'] = $height;
			$instance['playerId'] = $player;
			$instance['bgColor'] = $color;
			$instance['playlist_id'] = $type;
			if ($category !== NULL) {
				$instance['category_id'] = $category;
			}

			if ($autoplay !== NULL) {
				$instance['autoplay'] = $autoplay;
			}

			the_widget($widget_name, $instance, array(
				'widget_id' => 'brid-arbitrary-instance-' . $id,
				'before_widget' => '',
				'after_widget' => '',
				'before_title' => '',
				'after_title' => ''
			));
			$output = ob_get_contents();
			ob_end_clean();
		}
		return $output;
	}

	public static function endsWith($haystack, $needle)
	{
		$length = strlen($needle);
		if ($length == 0) {
			return true;
		}

		return (substr($haystack, -$length) === $needle);
	}

	private static function createReady($method)
	{
		if ($method != null) {
			$method = substr($method, 1);
			$method = ',"onReady":' . $method;
		}
		return $method;
	}

	// Used for seo data duration conversion to ISO standard
	private static function dateInterval($duration)
	{
		if (!is_numeric($duration)) return "";

		$duration = (int) $duration;

		if ($duration != null) {
			$output = "PT";

			$hours = (int) floor($duration / 3600);
			$mins = (int) ($duration / 60) % 60;
			$seconds = (int) $duration % 60;

			if ($hours != 0) {
				$output .= $hours . "H";
			}
			if ($mins != 0) {
				$output .= $mins . "M";
			}
			if ($seconds != 0) {
				$output .= $seconds . "S";
			} elseif ($mins != 0) {
				$output .= "0S";
			}
		} else {
			$output = "";
		}
		return $output;
	}

	/**
	 * Render short code into brid iframe
	 */
	public static function brid_shortcode($attrs)
	{
		$url = array();
		$url[] = isset($attrs['type']) ? $attrs['type'] : 'iframe';	//action
		$partnerId = BridOptions::getOption('site');
		$playerId = BridOptions::getOption('player');

		$requestURI = $_SERVER["REQUEST_URI"];
		$params['amp'] = 0;
		$params['fbArticles'] = 0;

		$unpacked_attributes = [];
		foreach ($attrs as $value) {
			$value_prop = explode('=', $value);
			$value_prop[1] = empty($value_prop[1]) ? '' : $value_prop[1];
			$unpacked_attributes[strtolower($value_prop[0])] = urldecode(trim($value_prop[1], '"'));
		}
		$attrs = array_merge($unpacked_attributes, $attrs);

		include_once(ABSPATH . 'wp-admin/includes/plugin.php');

		if (is_plugin_active('amp-wp-master/amp.php') || is_plugin_active('amp/amp.php') || is_plugin_active('accelerated-mobile-pages/accelerated-moblie-pages.php')) {

			if (BridShortcode::endsWith($requestURI, "/amp") || BridShortcode::endsWith($requestURI, "/amp/") || BridShortcode::endsWith($requestURI, "?amp=1")) {
				$params['amp'] = 1;
			}
		}

		$onReadyMethod = BridOptions::getOption('onready');
		if ($onReadyMethod != null) {
			$onReadyMethod = ',' . $onReadyMethod;
			if (isset($attrs['bridonready'])) {
				$onReadyMethod = ',' . $attrs['bridonready'];
			}
		} else {
			if (isset($attrs['bridonready'])) {
				$onReadyMethod = ',' . $attrs['bridonready'];
			}
		}

		//OUTSTREAM UNITS
		if (isset($attrs['outstreamunit'])) {

			$randomNum = mt_rand(100000, 999999);

			$append = '';

			if (isset($attrs['placeholder'])) {

				$append = ',"placeholder":"true"';

				if (isset($attrs['placeholder_img'])) {
					$append .= ',"placeholder_img":"' . $attrs['placeholder_img'] . '"';
				}
				if (isset($attrs['placeholder_type'])) {
					$append .= ',"placeholder_type":"og_image"';
				}
			}

			$embedCode = '';
			$embedCode .= '<script data-cfasync="false" type="text/javascript" src="' . CLOUDFRONT . 'player/build/brid.outstream.min.js"></script>';
			if ($attrs['outstreamunittype'] != 'inslide') $embedCode .= '<div id="Brid_' . $randomNum . '" class="brid" style="width: ' . $attrs['width'] . '; height: ' . $attrs['height'] . ';"></div>';
			$embedCode .= '<script type="text/javascript"> $bos("Brid_' . $randomNum . '", {"id":"' . $attrs['outstreamunit'] . '","width":"' . $attrs['width'] . '","height":"' . $attrs['height'] . '","stats":{"wps":1}' . $append . '}' . $onReadyMethod . '); </script>';

			$async_embed_option = BridOptions::getOption('async_embed', true);
			if ($async_embed_option) {
				$onReadyMethod = self::createReady($onReadyMethod);
				$embedCode = '';
				$embedCode .= '<div id="Brid_' . $randomNum . '" class="brid"></div>';
				$embedCode .= '<script type="text/javascript"> var _bos = _bos||[]; _bos.push({ "div": "Brid_' . $randomNum . '", "obj": {"id":"' . $attrs['outstreamunit'] . '","width":"' . $attrs['width'] . '","height":"' . $attrs['height'] . '","stats":{"wps":1}' . $append . '}' . $onReadyMethod . '}); </script>';
				$embedCode .= '<script type="text/javascript" async src="' . CLOUDFRONT . 'player/build/brid.outstream.min.js"></script>';
			}

			if ($params['amp'] == 1) {
				if (isset($attrs['outstreamunittype']) &&  ($attrs['outstreamunittype'] == "incontent" || $attrs['outstreamunittype'] == "invideo")) {
					$embedCode = '<!--WP embed code AMP outstream - Brid Ver.' . BRID_PLUGIN_VERSION . ' -->';
					$embedCode .= '<amp-brid-player autoplay data-partner="' . $partnerId . '" data-player="0" data-outstream="' . $attrs['outstreamunit'] . '" layout="responsive" width="' . $attrs["width"] . '" height="' . $attrs["height"] . '"> </amp-brid-player>';
				} else {
					$embedCode = "";
				}
			}

			return $embedCode;
		}

		$modes = array('video', 'playlist', 'latest', 'tag', 'source');

		$mode = 'video';
		$id = DEFAULT_VIDEO_ID;

		$appendStyle = '';
		if (isset($attrs['align']) && $attrs['align'] == 'center') {
			$appendStyle = 'style="margin:0px auto;display:inline-block"';
		}
		if (isset($attrs['style']) && !empty($attrs['style'])) {
			$appendStyle = 'style="' . $attrs['style'] . '"';
		}

		foreach ($modes as $k => $v) {
			if (isset($attrs[$v])) {
				$mode = $v;
				$id = $attrs[$v];
				break;
			}
		}

		$partner_id = BridOptions::getOption('site');
		$url[] = $mode; //mode
		$iframeId[] = $id; //content id
		$iframeId[] = $partner_id; //partner id
		//Force player override
		$playerOptions = array();
		$seoOptions = array();

		$playerOptions['id'] = isset($attrs['player']) ? (string) $attrs['player'] : (string) BridOptions::getOption('player');	//player id;
		$playerOptions['stats'] = array('wp' => 1);
		$playerOptions['title'] = isset($attrs['title']) ? $attrs['title'] : '';
		if (isset($attrs['carousel'])) $params['carousel'] = true;

		$seoOptions['description'] = isset($attrs['description']) ? preg_replace("/\n/", " ", $attrs['description']) : '';
		$seoOptions['duration'] = self::dateInterval(isset($attrs['duration']) ? $attrs['duration'] : '');
		$seoOptions['uploaddate'] = isset($attrs['uploaddate']) ? $attrs['uploaddate'] : '';
		$seoOptions['thumbnailurl'] = isset($attrs['image']) ? $attrs['image'] : '';
		$seoOptions['contenturl'] = isset($attrs['contenturl']) ? $attrs['contenturl'] : '';

		if (isset($attrs['autoplay'])) {
			if ($attrs['autoplay'] == "true") {
				$playerOptions['autoplay'] = true;
			}
			if ($attrs['autoplay'] == "false") {
				$playerOptions['autoplay'] = false;
			}
		}

		if ($mode == 'video' || $mode == 'playlist') {
			$playerOptions[$mode] = (string) $id;
		} else {
			$playerOptions['playlist']['id'] = $id;
			$playerOptions['playlist']['mode'] = $mode;
			$playerOptions['playlist']['items'] = isset($attrs['items']) ? $attrs['items'] : 1;
			$playerOptions['video_type'] = isset($attrs['video_type']) ? $attrs['video_type'] : 0;	//video type[Brid|Yt]
		}

		$url = array_merge($url, $iframeId);
		$size = BridShortcode::getSize();

		$playerOptions['width'] = (string)(isset($attrs['width']) ? $attrs['width'] : $size['width']);
		$playerOptions['height'] = (string)(isset($attrs['height']) ? $attrs['height'] : $size['height']);

		if (isset($attrs['playlist'])) {
			$data = 'data-playlist="' . $playerOptions["playlist"] . '"';
			$dataFbInstant = 'playlist/' . $playerOptions["playlist"];
		} else {
			$data = 'data-video="' . $playerOptions["video"] . '"';
			$dataFbInstant = 'video/' . $playerOptions["video"];
		}

		//fb instant articles iframe src
		$iframeSrc = CLOUDFRONT . 'services/iframe/' . $dataFbInstant . '/' . $partnerId . '/' . $playerId . '/0/1/';

		if (is_plugin_active('fb-instant-articles/facebook-instant-articles.php')) {
			if (function_exists('is_transforming_instant_article') && is_transforming_instant_article()) {
				$params['fbArticles'] = 1;
			}
		}

		// $divId = post id + counter
		$postId = get_the_ID();
		static $counter = 1;

		// $divId = $postId . "_" . $counter;
		// $divId = substr(time(), 2);
		$divId = $counter . microtime(true) * 10000;

		$counter++;

		$googleSeo = BridOptions::getOption('google_seo', true);

		if ($googleSeo == 1 && ($seoOptions["description"] != "" || $seoOptions["duration"] != "" || $seoOptions["uploaddate"] != "" || $seoOptions["thumbnailurl"] != "" || $seoOptions["contenturl"] != "")) {
			$seoString1 = 'itemprop="video" itemscope itemtype="http://schema.org/VideoObject"';
			$seoString2 = '<meta itemprop="name" content="' . $playerOptions["title"] . '" />';
			$seoString2 .= '<meta itemprop="description" content="' . $seoOptions["description"] . '" />';
			$seoString2 .= '<meta itemprop="duration" content="' . $seoOptions["duration"] . '" />';
			$seoString2 .= '<meta itemprop="uploadDate" content="' . $seoOptions["uploaddate"] . '" />';
			$seoString2 .= '<meta itemprop="thumbnailURL" content="' . $seoOptions["thumbnailurl"] . '" />';
			$seoString2 .= '<meta itemprop="contentUrl" content="' . $seoOptions["contenturl"] . '" />';
		} else {
			$seoString1 = '';
			$seoString2 = '';
		}

		if ($params['amp'] == 1) {
			$autoplayAmp = "";
			if (isset($playerOptions['autoplay']) && $playerOptions['autoplay']) {
				$autoplayAmp = "autoplay";
			}
			$embedCode = '<!--WP embed code AMP PLAYER - Brid Ver.' . BRID_PLUGIN_VERSION . ' -->';
			if ($googleSeo == 1 && ($seoOptions["description"] != "" || $seoOptions["duration"] != "" || $seoOptions["uploaddate"] != "" || $seoOptions["thumbnailurl"] != "")) {
				$embedCode .= '<script type="application/ld+json">';
				$embedCode .= '{';
				$embedCode .= '"@context": "http://schema.org",';
				$embedCode .= '"@type": "VideoObject",';
				$embedCode .= '"name": "' . $playerOptions["title"] . '",';
				$embedCode .= '"description": "' . $seoOptions["description"] . '",';
				$embedCode .= '"thumbnailUrl": "' . $seoOptions["thumbnailurl"] . '",';
				$embedCode .= '"uploadDate": "' . $seoOptions["uploaddate"] . '",';
				$embedCode .= '"duration": "' . $seoOptions["duration"] . '"';
				$embedCode .= '}';
				$embedCode .= '</script>';
			}
			$embedCode .= '<amp-brid-player ' . $autoplayAmp . ' data-partner="' . $partnerId . '" data-player="' . $playerOptions["id"] . '" ' . $data . ' layout="responsive" width="' . $playerOptions["width"] . '" height="' . $playerOptions["height"] . '"> </amp-brid-player>';
		} else if (isset($params['carousel'])) {
			unset($playerOptions['video']);
			$playerOptions['carousel'] = $attrs['carousel'];
			$embedCode =  '<!--WP embed code PLAYER - Brid Ver.' . BRID_PLUGIN_VERSION . ' -->';
			$embedCode .=  '<script data-cfasync="false" type="text/javascript" src="' . CLOUDFRONT . 'player/build/brid.min.js"></script>';
			$embedCode .= '<div id="Brid_' . $divId . '" class="brid" ' . $appendStyle . ' ' . $seoString1 . '>';
			$embedCode .= $seoString2;
			$embedCode .= '</div>';
			$embedCode .= '<script type="text/javascript">$bp("Brid_' . $divId . '", ' . json_encode($playerOptions) . $onReadyMethod . ');</script>';
		} else {

			if ($appendStyle == '') {
				$appendStyle = 'style="width: ' . $playerOptions['width'] . '; height: ' . $playerOptions['height'] . ';"';
			}

			$embedCode =  '<!--WP embed code PLAYER - Brid Ver.' . BRID_PLUGIN_VERSION . ' -->';
			$embedCode .=  '<script data-cfasync="false" type="text/javascript" src="' . CLOUDFRONT . 'player/build/brid.min.js"></script>';
			$embedCode .= '<div id="Brid_' . $divId . '" class="brid" ' . $appendStyle . ' ' . $seoString1 . '>';
			$embedCode .= $seoString2;
			$embedCode .= '</div>';
			$embedCode .= '<script type="text/javascript">$bp("Brid_' . $divId . '", ' . json_encode($playerOptions) . $onReadyMethod . ');</script>';

			$async_embed_option = BridOptions::getOption('async_embed', true);
			if ($async_embed_option) {
				$onReadyMethod = self::createReady($onReadyMethod);
				$embedCode = '<!--WP embed code ASYNC PLAYER - Brid Ver.' . BRID_PLUGIN_VERSION . ' -->';
				$embedCode .= '<div id="Brid_' . $divId . '" class="brid" ' . $appendStyle . ' ' . $seoString1 . '>';
				$embedCode .= $seoString2;
				$embedCode .= '</div>';
				$embedCode .= '<script type="text/javascript"> var _bp = _bp||[]; _bp.push({ "div": "Brid_' . $divId . '", "obj": ' . json_encode($playerOptions) . $onReadyMethod . '}); </script>';
				$embedCode .= '<script type="text/javascript" async src="' . CLOUDFRONT . 'player/build/brid.min.js"></script>';
			}
		}

		if ($params['fbArticles'] == 1) {
			$embedCode = '<!--Fb instant articles  ' . class_exists('Instant_Articles_Post') . ' -->';
			$embedCode .= '<iframe>';
			$embedCode .=  '<script data-cfasync="false" type="text/javascript" src="' . CLOUDFRONT . 'player/build/brid.min.js"></script>';
			$embedCode .= '<div id="Brid_' . $divId . '" class="brid" ' . $appendStyle . '></div>';
			$embedCode .= '<script type="text/javascript">$bp("Brid_' . $divId . '", ' . json_encode($playerOptions) . ');</script>';
			$embedCode .= '</iframe>';
		}

		return $embedCode;
	}

	/**
	 * Render short code for override YT players
	 */
	public static function brid_override_yt_shortcode($attrs)
	{
		$partnerId = BridOptions::getOption('site');
		$playerId = BridOptions::getOption('player');
		$sizeSettings = BridShortcode::getSize();

		$size['width'] = strval(isset($attrs['width']) ? $attrs['width'] : $sizeSettings['width']);
		$size['height'] = strval(isset($attrs['height']) ? $attrs['height'] : $sizeSettings['height']);

		$id = $attrs['src'];

		$image = 'https://i.ytimg.com/vi/' . $id . '/hqdefault.jpg';

		$postId = get_the_ID();
		static $counter = 1;

		// $divId = $postId . "_" . $counter;
		$divId = substr(time(), 2);

		$counter++;

		$embedCode = '<!--WP embed code replace YT object - Brid Ver.' . BRID_PLUGIN_VERSION . ' --><script data-cfasync="false" type="text/javascript" src="' . CLOUDFRONT . 'player/build/brid.min.js"></script><div id="Brid_' . $divId . '" class="brid" style="width: ' . $size['width'] . '; height: ' . $size['height'] . ';"></div>';

		$embedCode .= '<script type="text/javascript"> $bp("Brid_' . $divId . '", {"id":"' . $playerId . '", "video": {"src" : "' . $id . '", "poster":"' . $image . '"}, "width":"' . $size['width'] . '","height":"' . $size['height'] . '","stats":{"wps":1}}); </script>';

		return $embedCode;
	}

	/* Get Player size */
	public static function getSize()
	{
		$aspect = BridOptions::getOption('aspect');
		if ($aspect == '1') {
			return BridShortcode::aspectSize();
		}
		return array('width' => BridOptions::getOption('width'), 'height' => BridOptions::getOption('height'));
	}

	/*
	 * Replace default video with Brid embed code
	 */
	public static function replace_video_code($atts, $content = null)
	{
		$partnerId = BridOptions::getOption('site');
		$playerId = BridOptions::getOption('player');
		$size = BridShortcode::getSize();
		$src = '';

		$feat_image = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));

		$postId = get_the_ID();
		static $counter = 1;

		// $divId = $postId . "_" . $counter;
		$divId = substr(time(), 2);

		$counter++;
		//Front-end part
		$src .= "<!--WP embed code replace Video object - Brid Ver {BRID_PLUGIN_VERSION} --><script type='text/javascript' src='{CLOUDFRONT}player/build/brid.min.js'></script><div id='Brid_{$divId}' class='brid' style='width: {$size['width']}; height: {$size['height']};'></div><script type='text/javascript'> $bp('Brid_{$divId}', {\"id\":\"{$playerId}\", \"stats\":{\"wps\":1}, \"video\": {src: \"{$atts['mp4']}\", name: \"{htmlspecialchars(get_the_title())}\", image:\"{$feat_image}\"}, \"width\":\"{$size['width']}\", \"height\":\"{$size['height']}\"});</script>";

		return $src;
	}

	/*
	 * Get rand_id for brid player
	 */
	private static function genRandId()
	{
		$tl = strlen(time());
		return substr(time(), ($tl - 8), $tl) . rand();
	}

	/*
     * Get responsive aspect size
     */
	public static function aspectSize()
	{
		$width = null;
		try {
			$embed_size_w = intval(get_option('embed_size_w'));

			global $content_width;
			if (empty($content_width)) {
				$content_width = $GLOBALS['content_width'];
			}

			$width = $embed_size_w ? $embed_size_w : ($content_width ? $content_width : BridOptions::getOption('width'));
		} catch (Exception $ex) {
		}

		$width = intval(preg_replace('/\D/', '', $width)); //may have px

		//Protect width
		if (!is_numeric($width) || $width == 0 || $width < 200) {
			$width = BridOptions::getOption('width');
		}

		// attempt to get aspect ratio correct height from oEmbed
		$height = round(($width * 9) / 16, 0);

		return array('width' => $width, 'height' => $height);
	}
}

$overrideDefaultVideo = BridOptions::getOption('ovr_def', true);
//Override default video object
if ($overrideDefaultVideo) {
	add_shortcode('video', array('BridShortcode', 'replace_video_code'));
}
//Shortcode for Brid YT
add_shortcode('brid_override_yt', array('BridShortcode', 'brid_override_yt_shortcode'));

//Brid shortcode functionn
add_shortcode('brid', array('BridShortcode', 'brid_shortcode'));
add_shortcode('brid_widget', array('BridShortcode', 'brid_widget'));
