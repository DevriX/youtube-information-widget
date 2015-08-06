<?php

/*
Plugin Name: YouTube Information Widget
Plugin URI: https://wordpress.org/plugins/youtube-information-widget
Description: This plugin allows you to embed information about your YouTube channel, including the last uploads, popular uploads, channel statistics including subscribers count, views count, and the about information, and also, a subscribe button next to your channel icon. comes with a settings page where you can update your options.
Author: Samuel Elh
Version: 2.0
Author URI: http://go.elegance-style.com/sam
*/

// registers and creates a new widget for thi plugin
class yiw_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'yiw_widget', 
			__('YouTube Information Widget', 'yiw_widget_domain'), 
			array( 'description' => __( 'Embed information about your YouTube channel', 'yiw_widget_domain' ), ) 
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$product_id = apply_filters( 'widget_product_id', $instance['product_id'] );
		$max_vids = apply_filters( 'widget_max_vids', $instance['max_vids'] );
		$vid_h = apply_filters( 'widget_vid_h', $instance['vid_h'] );
		$vid_w = apply_filters( 'widget_vid_w', $instance['vid_w'] );
		$is_channel = apply_filters( 'widget_is_channel', $instance['is_channel'] );
		$is_channel_id = apply_filters( 'widget_is_channel_id', $instance['is_channel_id'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		echo yiw_widget_content( $product_id, $max_vids, $vid_h, $vid_w, $is_channel_id );
		echo $args['after_widget'];
	}
			
	public function form( $instance ) {

		$title = ( isset( $instance[ 'title' ] ) ) ? $instance[ 'title' ] : '';
		$product_id = ( isset( $instance[ 'product_id' ] ) ) ? $instance[ 'product_id' ] : '';
		$max_vids = ( isset( $instance[ 'max_vids' ] ) ) ? $instance[ 'max_vids' ] : '';
		$vid_h = ( isset( $instance[ 'vid_h' ] ) ) ? $instance[ 'vid_h' ] : '';
		$vid_w = ( isset( $instance[ 'vid_w' ] ) ) ? $instance[ 'vid_w' ] : '';
		$is_channel = ( isset( $instance[ 'is_channel' ] ) ) ? $instance[ 'is_channel' ] : '';
		$is_channel_id = ( isset( $instance[ 'is_channel_id' ] ) ) ? $instance[ 'is_channel_id' ] : '';

		echo $api_1;

		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>" style="font-weight:bold;"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat yiw-input" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'product_id' ); ?>" style="font-weight:bold;"><?php _e( 'Username / ID:' ); ?></label> 
				<sub style="display: block;padding-left: 1em;">Enter your YouTube channel username or ID.<br>Example: username: <code>mullenweg</code> (youtube.com/user/<b>mullenweg</b>).<br>Example channel ID: <code>UCF0pVplsI8R5kcAqgtoRqoA</code> (youtube.com/channel/<b>UCF0pVplsI8R5kcAqgtoRqoA</b>)</sub>
				<input class="widefat yiw-input" onchange="clearCache()" id="<?php echo $this->get_field_id( 'product_id' ); ?>" name="<?php echo $this->get_field_name( 'product_id' ); ?>" type="text" value="<?php echo esc_attr( $product_id ); ?>" />
				<br>
				<input class="widefat yiw-input" onchange="clearCache()" id="<?php echo $this->get_field_id( 'is_channel_id' ); ?>" name="<?php echo $this->get_field_name( 'is_channel_id' ); ?>" type="checkbox" <?php if ( esc_attr($is_channel_id) != '' ) echo "checked"; ?> />
				<label for="<?php echo $this->get_field_id( 'is_channel_id' ); ?>"><?php _e( 'This is a channel ID (not custom slug)' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'max_vids' ); ?>" style="font-weight:bold;"><?php _e( 'Max. videos:' ); ?></label> 
				<sub style="display: block;padding-left: 1em;">How many videos would you like to show in "last uploads" and "popular uploads" tabs? By default, <code>2</code> videos will show.</sub>
				<input class="widefat yiw-input" onchange="clearCache()" id="<?php echo $this->get_field_id( 'max_vids' ); ?>" name="<?php echo $this->get_field_name( 'max_vids' ); ?>" type="number" value="<?php echo esc_attr( $max_vids ); ?>" min="1" max="20" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'vid_h' ); ?>" style="font-weight:bold;"><?php _e( 'Video height:' ); ?></label>
				<sub style="display: block;padding-left: 1em;">Enter a height value for the videos shown in "last uploads" and "popular uploads" tabs. Example : <code>250</code> ( in pixels ). The default value is <code>auto</code>.</sub>
				<input class="widefat yiw-input" onchange="clearCache()" id="<?php echo $this->get_field_id( 'vid_h' ); ?>" name="<?php echo $this->get_field_name( 'vid_h' ); ?>" type="number" value="<?php echo esc_attr( $vid_h ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'vid_w' ); ?>" style="font-weight:bold;"><?php _e( 'Video width:' ); ?></label>
				<sub style="display: block;padding-left: 1em;">Enter a width value for the videos shown in "last uploads" and "popular uploads" tabs. Example : <code>400</code> ( in pixels ). The default value is <code>auto</code>.</sub>
				<input class="widefat yiw-input" onchange="clearCache()" id="<?php echo $this->get_field_id( 'vid_w' ); ?>" name="<?php echo $this->get_field_name( 'vid_w' ); ?>" type="number" value="<?php echo esc_attr( $vid_w ); ?>" />
			</p>
			<p id="yiw_admin_msg" style="display: none;">Clearing cache..</p>
			<p>
				<a href="<?php echo home_url('/') . "wp-content/plugins/youtube-information-widget/includes/clear_cache.php"; ?>" target="_new" class="yiw-cc-alt">Clear cache?</a>
				<span class="yiw-cc-msg"></span>
			</p>		

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['product_id'] = ( ! empty( $new_instance['product_id'] ) ) ? strip_tags( $new_instance['product_id'] ) : '';
		$instance['max_vids'] = ( ! empty( $new_instance['max_vids'] ) ) ? strip_tags( $new_instance['max_vids'] ) : '';
		$instance['vid_h'] = ( ! empty( $new_instance['vid_h'] ) ) ? strip_tags( $new_instance['vid_h'] ) : '';
		$instance['vid_w'] = ( ! empty( $new_instance['vid_w'] ) ) ? strip_tags( $new_instance['vid_w'] ) : '';
		$instance['is_channel'] = ( ! empty( $new_instance['is_channel'] ) ) ? strip_tags( $new_instance['is_channel'] ) : '';
		$instance['is_channel_id'] = ( ! empty( $new_instance['is_channel_id'] ) ) ? strip_tags( $new_instance['is_channel_id'] ) : '';

		return $instance;
	}
}

// adds jQuery scripts to head section of admin area if the browsed area is widgets.php ( widgets dashboard )
$request_uri = $_SERVER["REQUEST_URI"];
$pos_check = strpos($request_uri, '/widgets.php');

if ( is_numeric( $pos_check ) )
	add_action('admin_enqueue_scripts', 'yiw_admin_widgets_jquery');

function yiw_admin_widgets_jquery() {

	wp_deregister_script('jquery');
	wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false, null);
	wp_register_script('yiw-admin-cc', plugin_dir_url( __FILE__ ) . 'includes/admin_cc.js', false, null);
	wp_enqueue_script('jquery');
	wp_enqueue_script("yiw-admin-cc");

}

// the main function used to load widget content
function yiw_widget_content ( $product_id, $max_vids, $vid_h, $vid_w, $is_channel_id ) {

	if ( $product_id == '' ) {
		echo "<p> YouTube Information Widget needs to be configured, kindly fill out a YouTube username or channel ID from your dashboard widgets area. </p>";
		return false;
	}

	$last_update = esc_attr(get_option( 'yiw_last_update' ));
	$op_1 = esc_attr(get_option( 'yiw_op_1' ));
	$op_2 = esc_attr(get_option( 'yiw_op_2' ));
	$op_3 = esc_attr(get_option( 'yiw_op_3' ));
	$op_4 = esc_attr(get_option( 'yiw_op_4' ));
	$op_5 = esc_attr(get_option( 'yiw_op_5' ));
	$op_6 = esc_attr(get_option( 'yiw_op_6' ));
	$op_7 = esc_attr(get_option( 'yiw_op_7' ));
	$force_update = esc_attr(get_option( 'yiw_force_update' ));

	$date1 = $last_update;
	$date2 = time();
	$subTime = $date1 - $date2;
	$m = ($subTime/60)%60;
	$h = ($subTime/(60*60))%24;
	$cache_newed = '';

	// empties the existing cache, and gets fresh new one
	if ( $h <= -2 || $last_update == '' || $force_update == "1" ) {
		
		$max_vids_val = ( $max_vids == '' ) ? "2" : esc_attr( $max_vids );
		$vid_h_val = ( $vid_h == '' ) ? "auto" : esc_attr( $vid_h );
		$vid_w_val = ( $vid_w == '' ) ? "auto" : esc_attr( $vid_w );

		$key = "AIzaSyB9OPUPAtVh3_XqrByTwBTSDrNzuPZe8fo";
		$api_1_meta = ( $is_channel_id !== '' ) ? "&id=" . $product_id : "&forUsername=" . $product_id;
		$api_1 = "https://www.googleapis.com/youtube/v3/channels?part=snippet$api_1_meta&key=$key";

		$json_1 = file_get_contents($api_1);
		$json_data_1 = json_decode($json_1, false);

		$channel_id = $json_data_1->items[0]->id;
		$channel_name = esc_attr( $json_data_1->items[0]->snippet->title );
		$channel_thumb = esc_attr( $json_data_1->items[0]->snippet->thumbnails->high->url );

		$api_meta_all = "&id=$channel_id";

		$api_2 = "https://www.googleapis.com/youtube/v3/channels?part=statistics$api_meta_all&key=$key";
		$api_3 = "https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=$channel_id&maxResults=$max_vids_val&key=$key&type=video";
		$api_4 = "https://www.googleapis.com/youtube/v3/search?order=viewCount&part=snippet&channelId=$channel_id&maxResults=$max_vids_val&key=$key&type=video";

		$json_2 = file_get_contents($api_2);
		$json_data_2 = json_decode($json_2, false);
		$json_3 = file_get_contents($api_3);
		$json_data_3 = json_decode($json_3, false);
		$json_4 = file_get_contents($api_4);
		$json_data_4 = json_decode($json_4, false);

		$channel_link = "https://youtube.com/channel/$channel_id/";
		$subscribe_button = "
			<script src=\"https://apis.google.com/js/platform.js\"></script>
			<div class=\"g-ytsubscribe\" data-channelid=\"$channel_id\" data-layout=\"default\" data-count=\"default\">
				<a href=\"$channel_link?sub_confirmation=1\">subscribe</a>
			</div>
		";

		$last_uploads = "";
		$id_verify = '';

		foreach ( $json_data_3->items as $item ) {

			$id = $item->id->videoId;
			$id_verify .= $id;
			$last_uploads .=
			"<iframe id=\"ytplayer\" type=\"text/html\" width=\"$vid_w_val\" height=\"$vid_h_val\" src=\"//www.youtube.com/embed/$id?rel=0&showinfo=1\" frameborder=\"0\" allowfullscreen></iframe>
			<div style=\"height: .55em;\"></div>";

		}
		if ( $id_verify == '' )
			$last_uploads = "<p>Apologize, nothing found for this channel.</p>";
		else
			$last_uploads .= "<a href=\"" . $channel_link . "videos\" title=\"More uploads of $channel_name on YouTube\">Browse more &raquo;</a>";


		$popular_uploads = "";
		$id_verify = '';

		foreach ( $json_data_4->items as $item ) {

			$id = $item->id->videoId;
			$id_verify .= $id;
			$popular_uploads .=
			"<iframe id=\"ytplayer\" type=\"text/html\" width=\"$vid_w_val\" height=\"$vid_h_val\" src=\"//www.youtube.com/embed/$id?rel=0&showinfo=1\" frameborder=\"0\" allowfullscreen></iframe>
			<div style=\"height: .55em;\"></div>";

		}
		if ( $id_verify == '' )
			$popular_uploads = "<p>Apologize, nothing found for this channel.</p>";
		else
			$popular_uploads .= "<a href=\"" . $channel_link . "videos?sort=p&flow=grid&view=0\" title=\"More popular uploads of $channel_name on YouTube\">Browse more &raquo;</a>";


		$channel_info = '';

		$info_about = esc_attr( nl2br( $json_data_1->items[0]->snippet->description ) );
		$info_subs = esc_attr( yiw_pretty_num( $json_data_2->items[0]->statistics->subscriberCount ) );
		$info_vids = esc_attr( yiw_pretty_num( $json_data_2->items[0]->statistics->videoCount ) );
		$info_view = esc_attr( yiw_pretty_num( $json_data_2->items[0]->statistics->viewCount ) );
		$info_comment = esc_attr( yiw_pretty_num( $json_data_2->items[0]->statistics->commentCount ) );

		$channel_info .= ( $info_about != '' ) ? "<p><strong>About:</strong><br class=\"clear\"> $info_about </p>" : "";
		$channel_info .= ( $info_subs != '' ) ? "<p><strong>Total subscribers:</strong><br class=\"clear\"> $info_subs </p>" : "";
		$channel_info .= ( $info_vids != '' ) ? "<p><strong>Total uploads:</strong><br class=\"clear\"> $info_vids </p>" : "";
		$channel_info .= ( $info_view != '' ) ? "<p><strong>Total upload views:</strong><br class=\"clear\"> $info_view </p>" : "";
		$channel_info .= ( $info_comment != '' ) ? "<p><strong>Total comments:</strong><br class=\"clear\"> $info_comment </p>" : "";

		if ( $channel_info == '' )
			$channel_info = "<p>Apologize, nothing found for this channel.</p>";

		if ( $op_1 = '' )
			add_option( 'yiw_op_1', esc_attr( $channel_name ) );
		else
			update_option( 'yiw_op_1', esc_attr( $channel_name ) );
		if ( $op_2 = '' )
			add_option( 'yiw_op_2', esc_attr( $channel_link ) );
		else
			update_option( 'yiw_op_2', esc_attr( $channel_link ) );
		if ( $op_3 = '' )
			add_option('yiw_op_3', esc_attr( $channel_thumb ));
		else
			update_option( 'yiw_op_3', esc_attr( $channel_thumb ) );
		if ( $op_4 = '' )
			update_option( 'yiw_op_4', esc_attr( $subscribe_button ) );
		else
			update_option( 'yiw_op_4', esc_attr( $subscribe_button ) );
		if ( $op_5 = '' )
			add_option( 'yiw_op_5', esc_attr( $last_uploads ) );
		else
			update_option( 'yiw_op_5', esc_attr( $last_uploads ) );
		if ( $op_6 = '' )
			add_option( 'yiw_op_6', esc_attr( $popular_uploads) );
		else
			update_option( 'yiw_op_6', esc_attr( $popular_uploads) );
		if ( $op_7 = '' )
			add_option( 'yiw_op_7', esc_attr( $channel_info) );
		else
			update_option( 'yiw_op_7', esc_attr( $channel_info ) );
		if ( $last_update = '' )
			add_option( 'yiw_last_update', esc_attr( time() ) );
		else
			update_option( 'yiw_last_update', esc_attr( time() ) );
		if ( $force_update = '' )
			add_option( 'yiw_force_update', '0' );
		else
			update_option( 'yiw_force_update', '0' );

		?>
			<div id="ytio-container">
				<div id="ytio-avatar">
					<div id="ytio-left" class="inline">
						<a href="<?php echo html_entity_decode( $channel_link ); ?>" title="<?php echo html_entity_decode( $channel_name ); ?>">
							<img src="<?php echo html_entity_decode( $channel_thumb ); ?>" height="90" width="90" alt="<?php echo html_entity_decode( $channel_name ); ?>" />
						</a>
					</div>
					<div id="ytio-right" class="inline">
						<a href="<?php echo html_entity_decode( $channel_link ); ?>">
							<span><?php echo html_entity_decode( $channel_name ); ?></span>
						</a><br class="clear" />
						<?php echo html_entity_decode( $subscribe_button ); ?>
					</div>
				</div>

				<div id="ytio-uploads">
					<div id="ytio-switch">
						<span id="sw-st" onclick="yiw_tab_1(this)" class="active">Last uploads</span>
						<span id="sw-nd" onclick="yiw_tab_2(this)">Popular uploads</span>
						<span id="sw-rd" onclick="yiw_tab_3(this)">Info</span>
					</div>
					<div style="padding: 1em;">
						<div id="ytio-last-uploads">
							<?php echo html_entity_decode( $last_uploads ); ?>
						</div>
						<div id="ytio-popular-uploads" class="ytio-hid">
							<?php echo html_entity_decode( $popular_uploads ); ?>
						</div>
						<div id="ytio-stats" class="ytio-hid">
							<?php echo html_entity_decode( $channel_info ); ?>
						</div>
					</div>
				</div>
			</div>
			<br style="clear: both;"></br>
		<?php
		$cache_newed = '1';

	}

	// if cache clearing isn't needed, output the existing cache
	if ( $cache_newed == '' ) {
		?>
			<div id="ytio-container">
				<div id="ytio-avatar">
					<div id="ytio-left" class="inline">
						<a href="<?php echo html_entity_decode( $op_2 ); ?>" title="<?php echo html_entity_decode( $op_1 ); ?>">
							<img src="<?php echo html_entity_decode( $op_3 ); ?>" height="90" width="90" alt="<?php echo html_entity_decode( $op_1 ); ?>" />
						</a>
					</div>
					<div id="ytio-right" class="inline">
						<a href="<?php echo html_entity_decode( $op_2 ); ?>">
							<span><?php echo html_entity_decode( $op_1 ); ?></span>
						</a><br class="clear" />
						<?php echo html_entity_decode( $op_4 ); ?>
					</div>
				</div>

				<div id="ytio-uploads">
					<div id="ytio-switch">
						<span id="sw-st" onclick="yiw_tab_1(this)" class="active">Last uploads</span>
						<span id="sw-nd" onclick="yiw_tab_2(this)">Popular uploads</span>
						<span id="sw-rd" onclick="yiw_tab_3(this)">Info</span>
					</div>
					<div style="padding: 1em;">
						<div id="ytio-last-uploads">
							<?php echo html_entity_decode( $op_5 ); ?>
						</div>
						<div id="ytio-popular-uploads" class="ytio-hid">
							<?php echo html_entity_decode( $op_6 ); ?>
						</div>
						<div id="ytio-stats" class="ytio-hid">
							<?php echo html_entity_decode( $op_7 ); ?>
						</div>
					</div>
				</div>
			</div>
			<br style="clear: both;"></br>
		<?php
	}                        
}
// little function to return short numbers, like 1.4k instead of 1400
function yiw_pretty_num ( $num ) {

	if(empty ($num) ) {
			return false;
	} else {
		if( $num < 1000 )
			return $num;
		$x = round($num);
		$x_number_format = number_format($x);
		$x_array = explode(',', $x_number_format);
		$x_parts = array(' thousand', ' million', ' billion', ' trillion');
		$x_count_parts = count($x_array) - 1;
		$x_display = $x;
		$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
		$x_display .= $x_parts[$x_count_parts - 1];
		return $x_display;
	}

}

function yiw_load_widget() {
	register_widget( 'yiw_widget' );
}
add_action( 'widgets_init', 'yiw_load_widget' );

// puts the scripts (JS and CSS) in the head section of your blog if widget is active
if ( is_active_widget( false, false, 'yiw_widget', true ) ) {

	add_action( 'wp_enqueue_scripts', 'yiw_enqueue_scripts' );

	function yiw_enqueue_scripts() {
		wp_register_script("yiw-tab-toggle", plugin_dir_url( __FILE__ ) . "includes/tab-toggle.js");
		wp_enqueue_script("yiw-tab-toggle");
		wp_enqueue_style('ytio-css', plugin_dir_url( __FILE__ ) . 'includes/style.css' );
	}

}

// adds Settings and Donate links in the plugin's snippet in admin plugins list (plugins.php) 
function yiw_support_link( $links ) {
    $settings_link = '<a href="http://wordpress.org/support/plugin/youtube-information-widget" target="_new">' . __( 'Support' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
function yiw_donate_link( $links ) {
    $settings_link = '<a href="http://go.elegance-style.com/donate/" target="_new">' . __( 'Donate' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'yiw_support_link' );
add_filter( "plugin_action_links_$plugin", 'yiw_donate_link' );
