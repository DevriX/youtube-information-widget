<?php

/*
Plugin Name: YouTube Information Widget
Plugin URI: http://wordpress.org/plugins/
Description: This plugin allows you to embed information about your YouTube channel, including the last uploads, popular uploads, channel statistics including subscribers count, views count, and the about information, and also, a subscribe button next to your channel icon. comes with a settings page where you can update your options.
Author: Samuel Elh
Version: 1.0
Author URI: http://profiles.wordpress.org/elhardoum/
*/

add_action('admin_menu', 'ytio_create_menu');

function ytio_create_menu() {
	add_options_page( 'YouTube information widget settings', 'YouTube info widget', 'manage_options', 'ytio_settings', 'ytio_settings_page' );
	add_action( 'admin_init', 'register_ytio_settings' );
}


add_action('admin_menu', 'ytio_cach');

function ytio_cach() {
	add_options_page( 'Cache cleared!', null, 'manage_options', 'ytio_clear_cache', 'ytio_clear_cache_page' );
	
}

function ytio_clear_cache_page() {
?>
<div class="wrap ytio">
<?php
	delete_transient( 'ytio_channel_id_tr' );
	delete_transient( 'ytio_name_tr' );
	delete_transient( 'ytio_about_summary_tr' );
	delete_transient( 'ytio_thumb_tr' );
	delete_transient( 'ytio_view_count_tr' );
	delete_transient( 'ytio_subs_count_tr' );
	delete_transient( 'ytio_comment_count_tr' );
	delete_transient( 'ytio_video_count_tr' );
	delete_transient( 'ytio_last_uploads_tr' );
	delete_transient( 'ytio_popular_uploads_tr' );
?>


<div class="wrap">

	<div style="">Cache successfully emptied! click to go back to YouTube information widget settings page.</div>
	
	<a href="options-general.php?page=ytio_settings" style="background: #2ea2cc;padding: .7em 1em;color: #fff;line-height: 4;text-decoration: none;">Go back</a>

</div>
<?php 
}



function ytio_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=ytio_settings">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'ytio_settings_link' );

function register_ytio_settings() {
	register_setting( 'ytio-settings-group', 'ytio_username' );
	register_setting( 'ytio-settings-group', 'ytio_id' );
	register_setting( 'ytio-settings-group', 'ytio_max_results' );
	register_setting( 'ytio-settings-group', 'ytio_embed_width' );
	register_setting( 'ytio-settings-group', 'ytio_embed_height' );
}

function ytio_settings_page() {
?>
<div class="wrap ytio">
<fieldset  style="border: 1px solid #D5D5D5; padding: 1em;">
	<legend style="padding: 0 1em;font-weight: 600;text-decoration: underline;">YouTube Information Widget Settings</legend>

<form method="post" action="options.php" id="ytio-form">
    <?php settings_fields( 'ytio-settings-group' ); ?>
    <?php do_settings_sections( 'ytio-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><label for="ytio_username">Channel Username</label></th>
        <td><input type="text" name="ytio_username" value="<?php echo esc_attr( get_option('ytio_username') ); ?>" id="ytio_username" />
		<span class="ytio-help ytio-help-user">help</span>
		</td>
        </tr>
		
		<tr id="ytio-help-user" class="ytio-help ytio-hid">
		<th scope="row"></th>
		<td class="ytio-help">Example: <u>mullenweg</u> : http://youtube.com/user/<b>mullenweg</b></td>
		</tr>
		
		
        <tr valign="top">
        <th scope="row"><label for="ytio_id">Or, Channel ID</label></th>
        <td><input type="text" name="ytio_id" value="<?php echo esc_attr( get_option('ytio_id') ); ?>" id="ytio_id" />
		<span class="ytio-help ytio-help-id">help</span>
		</td>
        </tr>
		
		<tr id="ytio-help-id" class="ytio-help ytio-hid">
		<th scope="row"></th>
		<td class="ytio-help">Help retrieving your channel ID: <a href="https://support.google.com/youtube/answer/3250431?hl=en" target="_blank">YouTube User ID and Channel ID</a></td>
		</tr>
		
		
        <tr valign="top">
        <th scope="row"><label for="ytio_max">Max. videos to show</label></th>
        <td><input type="number" name="ytio_max_results" value="<?php echo esc_attr( get_option('ytio_max_results') ); ?>" id="ytio_max" min="1" max="20" /><span class="ytio-help ytio-help-max">help</span><br class="clear" />
		<sub><?php echo ytio_max_res_msg(); ?></sub>
		</td>
        </tr>
		
		<tr id="ytio-help-max" class="ytio-help ytio-hid">
		<th scope="row"></th>
		<td class="ytio-help">Maximum number of videos to show in both "last uploads" and "popular uploads" tabs. leave empty for 2 videos.</td>
		</tr>
		
		
		<tr valign="top">
        <th scope="row"><label for="ytio_em_width">Embed width</label></th>
        <td><input type="number" name="ytio_embed_width" value="<?php echo ytio_embed_width_ret(); ?>" id="ytio_em_width" min="100" max="2000" />
		<span class="ytio-help ytio-help-width">help</span><br class="clear" />
		<sub><?php echo ytio_embed_width_ret_msg(); ?></sub>
		</td>
        </tr>
		
		<tr id="ytio-help-width" class="ytio-help ytio-hid">
		<th scope="row"></th>
		<td class="ytio-help">The width for the videos shown in "last uploads" and "popular uploads" tabs. example : 400 ( pixels ). the default value is auto.</td>
		</tr>
		
		
        <tr valign="top">
        <th scope="row"><label for="ytio_em_height">Embed height</label></th>
        <td><input type="number" name="ytio_embed_height" value="<?php echo ytio_embed_height_ret(); ?>" id="ytio_em_height" min="100" max="2000" />
		<span class="ytio-help ytio-help-height">help</span><br class="clear" />
		<sub><?php echo ytio_embed_height_ret_msg(); ?></sub>
		</td>
        </tr>
		
		<tr id="ytio-help-height" class="ytio-help ytio-hid">
		<th scope="row"></th>
		<td class="ytio-help">The height for the videos shown in "last uploads" and "popular uploads" tabs. example : 250 ( pixels ). the default value is auto.</td>
		</tr>
		
    </table>
	
	<br />
	<div id="ytio-clear-cache" style="display: none;">
		<a href="options-general.php?page=ytio_clear_cache">Clear cache</a>
		<img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-includes/images/spinner.gif">
		<span style="display: none;">Cleared! now save your changes :)</span>
	</div>

    <?php submit_button(); ?>

</form>

</fieldset>
<br />

<fieldset style="border: 1px solid #D5D5D5; padding: 1em;">
	<legend style="padding: 0 1em;font-weight: 600;text-decoration: underline;">Widget Preview:</legend>
	<?php ytio_widget(); ?>
</fieldset>

</div>

<?php } 

function ytio_user_id() {
	if(empty(esc_attr( get_option('ytio_username') ))) {
		return esc_attr( get_option('ytio_id') );
	} else {
		return esc_attr( get_option('ytio_username') );
	}
}

function ytio_max_res() {
	if(empty(esc_attr( get_option('ytio_max_results') ))) {
		return esc_attr( '2' );
	} else {
		return esc_attr( get_option('ytio_max_results') );
	}
}

function ytio_max_res_msg() {
	if(empty(esc_attr( get_option('ytio_max_results') ))) {
		return 'Current setting: <b>2</b> (default)';
	}
}

function ytio_embed_width_ret() {
	if(empty(esc_attr( get_option('ytio_embed_width') ))) {
		return esc_attr( 'auto' );
	} else {
		return esc_attr( get_option('ytio_embed_width') );
	}
}

function ytio_embed_width_ret_msg() {
	if(empty(esc_attr( get_option('ytio_embed_width') ))) {
		return 'Current setting: <b>auto</b> (default)';
	}
}

function ytio_embed_height_ret() {
	if(empty(esc_attr( get_option('ytio_embed_height') ))) {
		return esc_attr( 'auto' );
	} else {
		return esc_attr( get_option('ytio_embed_height') );
	}
}

function ytio_embed_height_ret_msg() {
	if(empty(esc_attr( get_option('ytio_embed_height') ))) {
		return 'Current setting: <b>auto</b> (default)';
	}
}

// NEW DATA BEGINS : YOUTUBE API V3


function ytio_user_or_id() {
	if(empty(esc_attr( get_option('ytio_username') ))) {
		return '&id=';
	} else {
		return '&forUsername=';
	}
}



function ytio_api_1() {
	return 'https://www.googleapis.com/youtube/v3/channels?part=snippet'. ytio_user_or_id(). ytio_user_id(). '&key=AIzaSyB9OPUPAtVh3_XqrByTwBTSDrNzuPZe8fo';
}

function ytio_channel_id() {
	$json_data = get_transient('ytio_channel_id_tr');
    if ($json_data === false) {
        $url = ytio_api_1();
        $json = file_get_contents($url);
        $json_data = json_decode($json, false);
        set_transient('ytio_channel_id_tr', $json_data, 3600);
    }
	return $json_data->items[0]->id;
}

function ytio_name() {
	$json_data = get_transient('ytio_name_tr');
    if ($json_data === false) {
        $url = ytio_api_1();
        $json = file_get_contents($url);
        $json_data = json_decode($json, false);
        set_transient('ytio_name_tr', $json_data, 3600);
    }
	echo $json_data->items[0]->snippet->title;
}

function ytio_about_summary() {
	$json_data = get_transient('ytio_about_summary_tr');
    if ($json_data === false) {
        $url = ytio_api_1();
        $json = file_get_contents($url);
        $json_data = json_decode($json, false);
        set_transient('ytio_about_summary_tr', $json_data, 3600);
    }
	if(empty( $json_data->items[0]->snippet->description )) {
		return false;
	} else {
		echo '<p><strong>About:</strong><br class="clear" />'. $json_data->items[0]->snippet->description . '</p>';
	}
}

function ytio_thumb() {
	$json_data = get_transient('ytio_thumb_tr');
    if ($json_data === false) {
        $url = ytio_api_1();
        $json = file_get_contents($url);
        $json_data = json_decode($json, false);
        set_transient('ytio_thumb_tr', $json_data, 3600);
    }
	echo $json_data->items[0]->snippet->thumbnails->high->url;
}

function ytio_api_2() {
	return 'https://www.googleapis.com/youtube/v3/channels?part=statistics'. ytio_user_or_id(). ytio_user_id(). '&key=AIzaSyB9OPUPAtVh3_XqrByTwBTSDrNzuPZe8fo';
}


function ytio_view_count() {
	$json_data = get_transient('ytio_view_count_tr');
    if ($json_data === false) {
        $url = ytio_api_2();
        $json = file_get_contents($url);
        $json_data = json_decode($json, false);
        set_transient('ytio_view_count_tr', $json_data, 3600);
    }
	$num = $json_data->items[0]->statistics->viewCount;
	$msg = '<p><strong>Total upload views:</strong><br class="clear" />';
		if(empty ($num) ) {
			return false;
		} else {
			if( $num < 1000 ) return $msg. $num. '</p>';
			$x = round($num);
			$x_number_format = number_format($x);
			$x_array = explode(',', $x_number_format);
			$x_parts = array(' thousand', ' million', ' billion', ' trillion');
			$x_count_parts = count($x_array) - 1;
			$x_display = $x;
			$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
			$x_display .= $x_parts[$x_count_parts - 1];
			return  $msg . $x_display . '</p>';
		}
}

function ytio_subs_count() {
	$json_data = get_transient('ytio_subs_count_tr');
    if ($json_data === false) {
        $url = ytio_api_2();
        $json = file_get_contents($url);
        $json_data = json_decode($json, false);
        set_transient('ytio_subs_count_tr', $json_data, 3600);
    }
	$num = $json_data->items[0]->statistics->subscriberCount;
	$msg = '<p><strong>Total subscribers:</strong><br class="clear" />';
		if(empty ($num) ) {
			return false;
		} else {
			if( $num < 1000 ) return $msg. $num. '</p>';
			$x = round($num);
			$x_number_format = number_format($x);
			$x_array = explode(',', $x_number_format);
			$x_parts = array(' thousand', ' million', ' billion', ' trillion');
			$x_count_parts = count($x_array) - 1;
			$x_display = $x;
			$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
			$x_display .= $x_parts[$x_count_parts - 1];
			return  $msg . $x_display . '</p>';
		}
}

function ytio_comment_count() {
    $json_data = get_transient('ytio_comment_count_tr');
    if ($json_data === false) {
        $url = ytio_api_2();
        $json = file_get_contents($url);
        $json_data = json_decode($json, false);
        set_transient('ytio_comment_count_tr', $json_data, 3600);
    }
	$num = $json_data->items[0]->statistics->commentCount;
	$msg = '<p><strong>Total comments:</strong><br class="clear" />';
		if(empty ($num) ) {
			return false;
		} else {
			if( $num < 1000 ) return $msg. $num. '</p>';
			$x = round($num);
			$x_number_format = number_format($x);
			$x_array = explode(',', $x_number_format);
			$x_parts = array(' thousand', ' million', ' billion', ' trillion');
			$x_count_parts = count($x_array) - 1;
			$x_display = $x;
			$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
			$x_display .= $x_parts[$x_count_parts - 1];
			return  $msg . $x_display . '</p>';
		}
}

function ytio_video_count() {
    $json_data = get_transient('ytio_video_count_tr');
    if ($json_data === false) {
        $url = ytio_api_2();
        $json = file_get_contents($url);
        $json_data = json_decode($json, false);
        set_transient('ytio_video_count_tr', $json_data, 3600);
    }
	$num = $json_data->items[0]->statistics->videoCount;
	$msg = '<p><strong>Total uploads:</strong><br class="clear" />';
		if(empty ($num) ) {
			return false;
		} else {
			if( $num < 1000 ) return $msg. $num. '</p>';
			$x = round($num);
			$x_number_format = number_format($x);
			$x_array = explode(',', $x_number_format);
			$x_parts = array(' thousand', ' million', ' billion', ' trillion');
			$x_count_parts = count($x_array) - 1;
			$x_display = $x;
			$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
			$x_display .= $x_parts[$x_count_parts - 1];
			return  $msg . $x_display . '</p>';
		}
}

function ytio_api_3() {
	return 'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='. ytio_channel_id(). '&maxResults='. ytio_max_res() .'&key=AIzaSyB9OPUPAtVh3_XqrByTwBTSDrNzuPZe8fo&type=video';
}

function ytio_last_uploads() {
    $json_data = get_transient('ytio_last_uploads_tr');
    if ($json_data === false) {
        $url = ytio_api_3();
        $json = file_get_contents($url);
        $json_data = json_decode($json, false);
        set_transient('ytio_last_uploads_tr', $json_data, 3600);
    }
    foreach ( $json_data->items as $item ) {
        $id = $item->id->videoId;
		$width = ytio_embed_width_ret();
		$height = ytio_embed_height_ret();
        echo '<iframe id="ytplayer" type="text/html" width="' . $width . '" height="' . $height . '" 
            src="//www.youtube.com/embed/' . $id . '?rel=0&showinfo=1"
            frameborder="0" allowfullscreen></iframe><br class="clear" />';
    }
	if(empty( $id ) ) {
			echo '<p>Apologize, nothing found for this channel.</p>';
		} else {
			echo '<a href="'. ytio_uploads_more_link(). '" title="more uploads of this channel on YouTube">Browse more »</a>';
	}
}
	
function ytio_api_4() {
	return 'https://www.googleapis.com/youtube/v3/search?order=viewCount&part=snippet&channelId='. ytio_channel_id(). '&maxResults='. ytio_max_res() .'&key=AIzaSyB9OPUPAtVh3_XqrByTwBTSDrNzuPZe8fo&type=video';
}



function ytio_popular_uploads() {
    $json_data = get_transient('ytio_popular_uploads_tr');
    if ($json_data === false) {
        $url = ytio_api_4();
        $json = file_get_contents($url);
        $json_data = json_decode($json, false);
        set_transient('ytio_popular_uploads_tr', $json_data, 3600);
    }
    foreach ( $json_data->items as $item ) {
        $id = $item->id->videoId;
		$width = ytio_embed_width_ret();
		$height = ytio_embed_height_ret();
        echo '<iframe id="ytplayer" type="text/html" width="' . $width . '" height="' . $height . '" 
            src="//www.youtube.com/embed/' . $id . '?rel=0&showinfo=1"
            frameborder="0" allowfullscreen></iframe><br class="clear" />';
    }
	if(empty( $id ) ) {
			echo '<p>Apologize, nothing found for this channel.</p>';
	} else {
			echo '<a href="'. ytio_popular_more_link(). '" title="more popular uploads of this channel on YouTube">Browse more »</a>';
	}

}

function ytio_info() {

$var =  ytio_about_summary(). ytio_subs_count(). ytio_video_count(). ytio_view_count(). ytio_comment_count();

if(empty( $var )) {
	echo '<p>Apologize, nothing found for this channel.[v i]</p>';
} else {
	echo $var;
}
}

function ytio_user_or_channel() {
	if(empty(esc_attr( get_option('ytio_username') ))) {
		return 'channel';
	} else {
		return 'user';
}
}
function ytio_uploads_more_link() {
	return 'http://www.youtube.com/'. ytio_user_or_channel(). '/'. ytio_user_id(). '/videos';
}

function ytio_popular_more_link() {
	return 'http://www.youtube.com/'. ytio_user_or_channel(). '/'. ytio_user_id(). '/videos?sort=p&flow=grid&view=0';
}
function ytio_subs_button() {
?>
<script src="https://apis.google.com/js/platform.js"></script>
<div class="g-ytsubscribe" data-channel<?php
if(empty(esc_attr( get_option('ytio_username') ))) {
	echo 'id';
}
?>="<?php echo ytio_user_id(); ?>" data-layout="default" data-count="default">
	<a href="<?php echo ytio_channel_link(); ?>?sub_confirmation=1">subscribe</a>
</div>
<?php

}
function ytio_channel_link() {
	echo 'http://www.youtube.com/'. ytio_user_or_channel(). '/'. ytio_user_id();
}


add_action( 'wp_enqueue_scripts', 'ytio_enq_scripts' );

function ytio_enq_scripts() {
	wp_register_script('ytio-js-1', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', array('jquery'),'1', true);
	wp_register_script('ytio-js-2', plugin_dir_url( __FILE__ ) . 'includes/main.js', array('jquery'),'1.0', true);
	wp_enqueue_script('ytio-js-1');
	wp_enqueue_script('ytio-js-2');
}

add_action( 'wp_enqueue_scripts', 'ytio_enq_styles' );  

function ytio_enq_styles() {
    wp_enqueue_style('ytio-css', plugin_dir_url( __FILE__ ) . 'includes/style.css' );
}

// Enqueue Script in the settings page

add_action( 'admin_enqueue_scripts', 'ytio_enq_admin_scripts' );

function ytio_enq_admin_scripts() {
	wp_register_script('ytio-admin-js-1', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', array('jquery'),'1', true);
	wp_register_script('ytio-admin-js-2', plugin_dir_url( __FILE__ ) . 'includes/main.js', array('jquery'),'1.0', true);
	wp_register_script('ytio-admin-js-3', plugin_dir_url( __FILE__ ) . 'includes/admin/main.js', array('jquery'),'1.0', true);	
	wp_enqueue_script('ytio-admin-js-1');
	wp_enqueue_script('ytio-admin-js-2');
	wp_enqueue_script('ytio-admin-js-3');
}

add_action( 'admin_enqueue_scripts', 'ytio_enq_admin_styles' );  

function ytio_enq_admin_styles() {
    wp_enqueue_style('ytio-widget-css', plugin_dir_url( __FILE__ ) . 'includes/style.css' );
    wp_enqueue_style('ytio-admin-css', plugin_dir_url( __FILE__ ) . 'includes/admin/style.css' );
}


// DB


register_activation_hook( __FILE__, 'my_plugin_create_db' );

function my_plugin_create_db() {
	global $wpdb;
	$version = get_option( 'ytio_version', '1.0' );
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'ytio_db';
	$sql = "CREATE TABLE $table_name (
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	views smallint(5) NOT NULL,
	clicks smallint(5) NOT NULL,
	UNIQUE KEY id (id)
	) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	if ( version_compare( $version, '2.0' ) < 0 ) {
		$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		views smallint(5) NOT NULL,
		clicks smallint(5) NOT NULL,
		blog_id smallint(5) NOT NULL,
		UNIQUE KEY id (id)
		) $charset_collate;";
		dbDelta( $sql );
		update_option( 'ytio_version', '2.0' );
	}
}


// END BD

function ytio_widget() {

	if(empty(esc_attr( get_option('ytio_username') )) && empty(esc_attr( get_option('ytio_id') ))) {
		?>

<div id="ytio-container" style="padding: 1em;">
	<h2>Please fill out a YouTube username or channel ID first </h2>
	<sub> – YouTube information widget plugin</sub>
</div>
<br style="clear: both" />

<?php } else {
		?>
		
<div id="ytio-container">
	<section id="ytio-avatar">
		<div id="ytio-left" class="inline">
			<a href="<?php ytio_channel_link(); ?>" title="<?php echo ytio_name(); ?>">
				<img src="<?php ytio_thumb(); ?>" height="90" width="90" alt="<?php echo ytio_name(); ?>" />
			</a>
		</div>
		<div id="ytio-right" class="inline">
			<a href="<?php ytio_channel_link(); ?>">
				<span><?php echo ytio_name(); ?></span>
			</a><br  class="clear" />
			<?php ytio_subs_button(); ?>
		</div>
	</section>

	<section id="ytio-uploads">
		<div id="ytio-switch">
			<span id="sw-st" class="active">Last uploads</span>
			<span id="sw-nd">Popular uploads</span>
			<span id="sw-rd">Info</span>
		</div>
		<div style="padding: 1em;">
			<div id="ytio-last-uploads">
				<?php ytio_last_uploads(); ?>
			</div>
			<div id="ytio-popular-uploads" class="ytio-hid">
				<?php ytio_popular_uploads(); ?>
			</div>
			<div id="ytio-stats" class="ytio-hid">
				<?php ytio_info(); ?>
			</div>
		</div>
	</section>
</div>
<br style="clear: both;"></br>

<?php
}
}

// The widget

class ytio_widget extends WP_Widget {

function __construct() {
	parent::__construct(
		'ytio_widget', 
		__('YouTube Information Widget', 'ytio_widget_domain'), 
		array( 'description' => __( 'embed your YouTube channel content', 'ytio_widget_domain' ), ) 
	);
}

public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	echo $args['before_widget'];
	if ( ! empty( $title ) )
	echo $args['before_title'] . $title . $args['after_title'];
	echo __( ytio_widget(), 'ytio_widget_domain' );
	echo $args['after_widget'];
}
		
public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
	} else {
		$title = __( '', 'ytio_widget_domain' );
}

?>
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget title:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php
	if(empty(esc_attr( get_option('ytio_username') )) && empty(esc_attr( get_option('ytio_id') ))) { 
		echo 'Please update the plug-in <a href="options-general.php?page=ytio_settings">settings</a> first.';
	} else {
		echo '<a href="options-general.php?page=ytio_settings">Settings</a>';
	}
	echo '<br /><br />'; 
}
	
public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	return $instance;
}
}

function ytio_load_widget() {
	register_widget( 'ytio_widget' );
}
add_action( 'widgets_init', 'ytio_load_widget' );

// The end !
