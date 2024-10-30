<?php

/**
 * Adds BridPlaylist_Widget widget.
 * @package plugins.brid.lib
 * @author Brid Dev Team, contact@brid.tv
 * @version 1.1
 */
class BridPlaylist_Widget extends WP_Widget
{
	/**
	 * Register widget with WordPress.
	 */
	public function __construct()
	{
		parent::__construct(
			'brid_playlist_widget', // Base ID
			__('Brid Playlist Widget', 'brid_playlist_widget_domain'), // Name
			array(
				'description' => __('Embed a Brid player with your latest videos playlist.', 'brid_playlist_widget_domain'),

			) // Args
		);

		//Enqueue scripts only if widget is active
		add_action('wp_enqueue_scripts', array(__CLASS__, 'add_widget_js'));
	}

	private function genRandId()
	{
		$t = time();
		$tl = strlen($t);

		return substr(time(), ($tl - 8), $tl) . rand();
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

	//Check enqueued scripts
	private static function checkScriptEnqueued($name, $handle)
	{

		$list = 'enqueued';
		if (wp_script_is($handle, $list)) {
			return;
		} else {
			wp_register_script($name, $handle);
			wp_enqueue_script($handle, $handle, array(), null, false);
		}
	}

	public static function add_widget_js()
	{

		if (is_active_widget(false, false, 'brid_playlist_widget', true)) {

			wp_enqueue_script('jquery');
			wp_enqueue_style('bridWidgetCss', BRID_PLUGIN_URL . 'css/brid.widget.min.css'); //Add custom js
			wp_register_script('brid.widget.min.js', CLOUDFRONT . 'widget/brid.widget.min.js', array(), null);
			self::no_rocketscript('brid.widget.min.js');
		}
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance)
	{
		$widget = BridOptions::getOption('widget');

		echo $args['before_widget'];
		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}

		if (!$widget) {
?>
			<p>
			<div class="paidOnly">
				Brid.tv Playlist Widget is available for <a href="<?php echo "https://cms.brid.tv/users/login/?redirect=order"; ?>" target="_blank">*paid plans only</a>.
			</div>
			</p>
		<?php
			return;
		}

		$playerId = BridOptions::getOption('player');
		$siteId = BridOptions::getOption('site');
		$items = (isset($instance['items']) && !empty($instance['items'])) ? intval($instance['items']) : 10;
		$height = (isset($instance['height']) && !empty($instance['height'])) ? intval($instance['height']) : 360;
		$playlist_id = isset($instance['playlist_id']) ? $instance['playlist_id'] : 1;
		$category_id = isset($instance['category_id']) ? $instance['category_id'] : 0;
		$autoplay = (isset($instance['autoplay']) && !empty($instance['autoplay'])) ? intval($instance['autoplay']) : 0;
		$ratio = isset($instance['ratio']) ? intval($instance['ratio']) : 1;
		$randId = $this->genRandId();
		$color = (isset($instance['bgColor']) && !empty($instance['bgColor'])) ? $instance['bgColor'] : 0;
		$noImage = BRID_PLUGIN_URL . '/img/thumb_404.png';
		$isMobile = wp_is_mobile();

		wp_enqueue_style('bridWidgetCss', BRID_PLUGIN_URL . 'css/brid.widget.min.css'); //Add custom js

		if (isset($instance['playerId'])) {
			$playerId = $instance['playerId']; //must be string
		}

		if (isset($instance['player'])) {
			$playerId = $instance['player']; //must be string
		}

		$playlistUrl = CLOUDFRONT . 'services/dynamic/latest/0/' . $siteId . '/1/' . $items . '/' . $playlist_id . '.json';

		if ($playlist_id >= 2) {
			$type = ($playlist_id == 2) ? 1 : 0; // 2 => youtube, 3 => brid videos
			$playlistUrl =	CLOUDFRONT . 'services/dynamic/channel/' . $category_id . '/' . $siteId . '/1/' . $items . '/' . $type . '.json';
		}

		$config = array(
			'plugin_url' => BRID_PLUGIN_URL,
			'noImage' => 'img/thumb_404.png',
			'playlistType' => $playlist_id,
			'height' => $height,
			'categoryId' => $category_id,
			'stats' => array("wp" => true),
			'autoplay' => $autoplay,
			'items' => $items,
			'playerId' => $playerId,
			'playlist' => $playlistUrl,
			'id' => $randId,
			'color' => $color,
			'isMobile' => $isMobile,
			'thumbNumber' => 3, //Number of thumbs to display
			'ratio' => $ratio, //Thumb ration 1 for 16:9, 0 for 4:3
		);

		?>
		<!-- Wp Brid Playlist widget - Brid Ver. <?php echo BRID_PLUGIN_VERSION; ?>-->
		<div class="bridPlaylistWidget" id="<?php echo $randId; ?>"> </div>

		<script>
			$BridWidgets.init(<?php echo json_encode($config); ?>);
		</script>
		<?php

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance)
	{
		$partnerData = BridHtml::getPartnerData();

		$title = !empty($instance['title']) ? $instance['title'] : __('', 'text_domain');
		$playlist_id = isset($instance['playlist_id']) ? $instance['playlist_id'] : __('1', 'text_domain');
		$items = !empty($instance['items']) ? $instance['items'] : __('10', 'text_domain');
		$height = !empty($instance['height']) ? $instance['height'] : __('360', 'text_domain');
		$autoplay =  isset($instance['autoplay']) ? $instance['autoplay'] : 0;
		$category_id = 18;
		$playerId =  isset($instance['playerId']) ? $instance['playerId'] : BridOptions::getOption('player');
		$bgColor =  isset($instance['bgColor']) ? $instance['bgColor'] : '0';
		$ratio =  isset($instance['ratio']) ? $instance['ratio'] : 1;

		$siteId = BridOptions::getOption('site');

		$isWidgetEnabled = BridOptions::getOption('widget');

		if (!$isWidgetEnabled) { ?>

			<p>
			<div class="paidOnly">
				Brid.tv Playlist Widget is available for <a href="<?php echo "https://cms.brid.tv/users/login/?redirect=order"; ?>" target="_blank">*paid plans only</a>.
			</div>
			</p>
		<?php
			return;
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" placeholder="New Title" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('playlist_id'); ?>"><?php _e('Choose playlist:'); ?></label>
			<select class="widefat brid-categories" id="<?php echo $this->get_field_id('playlist_id'); ?>" name="<?php echo esc_attr($this->get_field_name('playlist_id')); ?>">
				<option value="0" <?php echo $playlist_id == 0 ? 'selected' : ''; ?>>Latest Videos</option>
				<option value="3" <?php echo $playlist_id == 3 ? 'selected' : ''; ?>>Latest Videos By Category</option>
			</select>
		</p>

		<input type="hidden" name="<?php echo $this->get_field_name('category_id'); ?>" value="18">

		<p>
			<label for="<?php echo $this->get_field_id('playerId'); ?>"><?php _e('Choose player:'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('playerId'); ?>" name="<?php echo $this->get_field_name('playerId'); ?>">
				<?php foreach ($partnerData['Players'] as $k => $v) { ?>
					<?php $selected = '';

					if ($v['Player']['id'] == $playerId) {
						$selected = 'selected';
					}
					?>
					<option value="<?php echo $v['Player']['id']; ?>" <?php echo $selected; ?>><?php echo $v['Player']['name']; ?></option>


				<?php } ?>
			</select>
		</p>

		<table>
			<tr>
				<td>
					<label for="<?php echo $this->get_field_id('bgColor'); ?>"><?php _e('Background:'); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('bgColor'); ?>" name="<?php echo $this->get_field_name('bgColor'); ?>">
						<option value="ffffff" <?php echo $bgColor == 'ffffff' ? 'selected' : ''; ?>>Light</option>
						<option value="000000" <?php echo $bgColor == '000000' ? 'selected' : ''; ?>>Dark</option>
						<option value=" " <?php echo $bgColor == '' ? 'selected' : ''; ?>>Transparent</option>
					</select>
				</td>
				<td>
					<label for="<?php echo $this->get_field_id('ratio'); ?>"><?php _e('Thumbnail ratio:'); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('ratio'); ?>" name="<?php echo $this->get_field_name('ratio'); ?>">
						<option value="0" <?php echo $ratio == 0 ? 'selected' : ''; ?>>4:3</option>
						<option value="1" <?php echo $ratio == 1 ? 'selected' : ''; ?>>16:9</option>
					</select>
				</td>

			</tr>
			<tr>
				<td>
					<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:'); ?></label>
					<input class="widefat" placeholder="Widget height" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>">

				</td>
				<td>
					<label for="<?php echo $this->get_field_id('items'); ?>"><?php _e('Items:'); ?></label>
					<input class="widefat" placeholder="Number of items to show" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>">

				</td>

			</tr>
		</table>

		<p>
			<label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Autoplay:'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>">
				<option value="0" <?php echo $autoplay == 0 ? 'selected' : ''; ?>>No</option>
				<option value="1" <?php echo $autoplay == 1 ? 'selected' : ''; ?>>Yes</option>
			</select>
		</p>
		<script>
			//On playlist type change
			jQuery(".brid-categories").change(function() {

				var id = jQuery(this).attr('id').replace('playlist_id', '') + 'categories_content_id';

				if (jQuery(this).children(":selected").val() == 2 || jQuery(this).children(":selected").val() == 3) { //categories
					jQuery('#' + id).show();

				} else {
					jQuery('#' + id).hide();
				}
			});
		</script>
<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance)
	{
		$instance = array();

		$instance['title'] = (!empty($new_instance['title'])) ? esc_html($new_instance['title']) : '';
		$instance['playlist_id'] = (!empty($new_instance['playlist_id'])) ? esc_html($new_instance['playlist_id']) : 0;
		$instance['items'] = (!empty($new_instance['items'])) ? intval(esc_html($new_instance['items'])) : 10;
		$instance['autoplay'] = (!empty($new_instance['autoplay'])) ? intval(esc_html($new_instance['autoplay'])) : 0;
		$instance['playerId'] = (!empty($new_instance['playerId'])) ? esc_html($new_instance['playerId']) : BridOptions::getOption('player');
		$instance['category_id'] = (!empty($new_instance['category_id'])) ? esc_html($new_instance['category_id']) : 0;
		$instance['bgColor'] = (!empty($new_instance['bgColor'])) ? esc_html($new_instance['bgColor']) : 0;
		$instance['ratio'] = isset($new_instance['ratio']) ? intval(esc_html($new_instance['ratio'])) : 1;
		$defaultHeight = 360;

		if (!empty($new_instance['height'])) {

			$h = intval(esc_html($new_instance['height']));

			$h = $h > 0 ? $h : $defaultHeight;

			if ($h < 260) { //Player 180 + thumbs
				$h = 260;
			}
			if ($h > 800) { //Player 180 + thumbs
				$h = 800;
			}
			$instance['height'] = $h;
		}

		return $instance;
	}
}
