<?php

/*
Plugin Name: YouTube Information Widget
Plugin URI: http://wordpress.org/plugins/
Description: this plugin allows users to embed their YouTube channels/accounts content including last 5 videos, and statistics about them.
Author: Samuel Elh
Version: 1.0
Author URI: http://go.elegance-style.com/sam
*/

// create custom plugin settings menu
add_action('admin_menu', 'ytio_create_menu');

function ytio_create_menu() {

	//create new top-level menu
	add_options_page( 'YouTube information widget settings', 'YouTube info widget', 'manage_options', 'ytio_settings', 'ytio_settings_page' );

	//call register settings function
	add_action( 'admin_init', 'register_ytio_settings' );
}

function ytio_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=ytio_settings">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'ytio_settings_link' );

function register_ytio_settings() {
	//register our settings
	register_setting( 'ytio-settings-group', 'ytio_username' );
	register_setting( 'ytio-settings-group', 'ytio_id' );
	register_setting( 'ytio-settings-group', 'ytio_max_results' );
	register_setting( 'ytio-settings-group', 'ytio_embed_width' );
	register_setting( 'ytio-settings-group', 'ytio_embed_height' );
}

function ytio_settings_page() {
?>
<div class="wrap">
<fieldset  style="border: 1px solid #D5D5D5; padding: 1em;">
	<legend style="padding: 0 1em;font-weight: 600;text-decoration: underline;">YouTube Information Widget Settings</legend>

<form method="post" action="options.php">
    <?php settings_fields( 'ytio-settings-group' ); ?>
    <?php do_settings_sections( 'ytio-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><label for="ytio_username">Channel Username</label></th>
        <td><input type="text" name="ytio_username" value="<?php echo esc_attr( get_option('ytio_username') ); ?>" id="ytio_username" />
		<span class="ytio-help">help</span>
		</td>
        </tr>
		
		<tr id="ytio-help-user" class="ytio-help">
		<th scope="row"></th>
		<td class="ytio-help">Help message here https://support.google.com/youtube/answer/3250431?hl=en</td>
		</tr>
		
		
        <tr valign="top">
        <th scope="row"><label for="ytio_id">Or, Channel ID</label></th>
        <td><input type="text" name="ytio_id" value="<?php echo esc_attr( get_option('ytio_id') ); ?>" id="ytio_id" />
		<span class="ytio-help">help</span>
		</td>
        </tr>
		
		<tr id="ytio-help-id" class="ytio-help">
		<th scope="row"></th>
		<td class="ytio-help">Help message here</td>
		</tr>
		
		
        <tr valign="top">
        <th scope="row"><label for="ytio_max">Max. videos to show</label></th>
        <td><input type="number" name="ytio_max_results" value="<?php echo esc_attr( get_option('ytio_max_results') ); ?>" id="ytio_max" min="1" max="20" /><span class="ytio-help">help</span><br class="clear" />
		<sub><?php echo ytio_max_res_msg(); ?></sub>
		</td>
        </tr>
		
		<tr id="ytio-help-max" class="ytio-help">
		<th scope="row"></th>
		<td class="ytio-help">Help message here</td>
		</tr>
		
		
		<tr valign="top">
        <th scope="row"><label for="ytio_em_width">Embed width</label></th>
        <td><input type="number" name="ytio_embed_width" value="<?php echo ytio_embed_width_ret(); ?>" id="ytio_em_width" min="100" max="2000" />
		<span class="ytio-help">help</span><br class="clear" />
		<sub><?php echo ytio_embed_width_ret_msg(); ?></sub>
		</td>
        </tr>
		
		<tr id="ytio-help-width" class="ytio-help">
		<th scope="row"></th>
		<td class="ytio-help">Help message here</td>
		</tr>
		
		
        <tr valign="top">
        <th scope="row"><label for="ytio_em_height">Embed height</label></th>
        <td><input type="number" name="ytio_embed_height" value="<?php echo ytio_embed_height_ret(); ?>" id="ytio_em_height" min="100" max="2000" />
		<span class="ytio-help">help</span><br class="clear" />
		<sub><?php echo ytio_embed_height_ret_msg(); ?></sub>
		</td>
        </tr>
		
		<tr id="ytio-help-height" class="ytio-help">
		<th scope="row"></th>
		<td class="ytio-help">Help message here</td>
		</tr>
		
    </table>
    
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
	if(empty(get_option('ytio_username'))) {
		return esc_attr( get_option('ytio_id') );
	} else {
		return esc_attr( get_option('ytio_username') );
	}
}

function ytio_max_res() {
	if(empty(get_option('ytio_max_results'))) {
		return esc_attr( '2' );
	} else {
		return esc_attr( get_option('ytio_max_results') );
	}
}

function ytio_max_res_msg() {
	if(empty(get_option('ytio_max_results'))) {
		return 'Current setting: <u>2</u> (default)';
	}
}

function ytio_embed_width_ret() {
	if(empty(get_option('ytio_embed_width'))) {
		return esc_attr( 'auto' );
	} else {
		return esc_attr( get_option('ytio_embed_width') );
	}
}

function ytio_embed_width_ret_msg() {
	if(empty(get_option('ytio_embed_width'))) {
		return 'Current setting: <u>auto</u> (default)';
	}
}

function ytio_embed_height_ret() {
	if(empty(get_option('ytio_embed_height'))) {
		return esc_attr( 'auto' );
	} else {
		return esc_attr( get_option('ytio_embed_height') );
	}
}

function ytio_embed_height_ret_msg() {
	if(empty(get_option('ytio_embed_height'))) {
		return 'Current setting: <u>auto</u> (default)';
	}
}

// NEW DATA BEGINS BASED ON V3 OF YOUTUBE API


function ytio_user_or_id() {
	if(empty(get_option('ytio_username'))) {
		return '&id=';
	} else {
		return '&forUsername=';
}
}

function ytio_api_1() {
	return 'https://www.googleapis.com/youtube/v3/channels?part=snippet'. ytio_user_or_id(). ytio_user_id(). '&key=AIzaSyB9OPUPAtVh3_XqrByTwBTSDrNzuPZe8fo';
}

function ytio_channel_id() {
	$url =  ytio_api_1();
	$json = file_get_contents($url);
	$json_data = json_decode($json, false);
	return $json_data->items[0]->id;
}

function ytio_name() {
	$url =  ytio_api_1();
	$json = file_get_contents($url);
	$json_data = json_decode($json, false);
	echo $json_data->items[0]->snippet->title;
}

function ytio_about_summary() {
	$url =  ytio_api_1();
	$json = file_get_contents($url);
	$json_data = json_decode($json, false);
	if(empty( $json_data->items[0]->snippet->description )) {
		return false;
	} else {
		echo '<strong>About:</strong><br class="clear" />'. $json_data->items[0]->snippet->description;
	}
}

function ytio_thumb() {
	$url =  ytio_api_1();
	$json = file_get_contents($url);
	$json_data = json_decode($json, false);
	echo $json_data->items[0]->snippet->thumbnails->high->url;
}

function ytio_api_2() {
	return 'https://www.googleapis.com/youtube/v3/channels?part=statistics'. ytio_user_or_id(). ytio_user_id(). '&key=AIzaSyB9OPUPAtVh3_XqrByTwBTSDrNzuPZe8fo';
}


function ytio_view_count() {
	$url =  ytio_api_2();
	$json = file_get_contents($url);
	$json_data = json_decode($json, false);
	$num = $json_data->items[0]->statistics->viewCount;
		if(empty ($num) ) {
			return false;
		} else {
			if( $num < 1000 ) return $num;
			$x = round($num);
			$x_number_format = number_format($x);
			$x_array = explode(',', $x_number_format);
			$x_parts = array(' thousand', ' million', ' billion', ' trillion');
			$x_count_parts = count($x_array) - 1;
			$x_display = $x;
			$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
			$x_display .= $x_parts[$x_count_parts - 1];
			$msg = '<p><strong>Total upload views:</strong><br class="clear" />';
			return  $msg . $x_display . '</p>';
		}
}

function ytio_subs_count() {
	$url =  ytio_api_2();
	$json = file_get_contents($url);
	$json_data = json_decode($json, false);
	$num = $json_data->items[0]->statistics->subscriberCount;
		if(empty ($num) ) {
			return false;
		} else {
			if( $num < 1000 ) return $num;
			$x = round($num);
			$x_number_format = number_format($x);
			$x_array = explode(',', $x_number_format);
			$x_parts = array(' thousand', ' million', ' billion', ' trillion');
			$x_count_parts = count($x_array) - 1;
			$x_display = $x;
			$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
			$x_display .= $x_parts[$x_count_parts - 1];
			echo  '<p><strong>Total subscribers:</strong><br class="clear" />'. $x_display . '</p>';
		}
}

function ytio_comment_count() {
	$url =  ytio_api_2();
	$json = file_get_contents($url);
	$json_data = json_decode($json, false);
	$num = $json_data->items[0]->statistics->commentCount;
		if(empty ($num) ) {
			return false;
		} else {
			if( $num < 1000 ) return $num;
			$x = round($num);
			$x_number_format = number_format($x);
			$x_array = explode(',', $x_number_format);
			$x_parts = array(' thousand', ' million', ' billion', ' trillion');
			$x_count_parts = count($x_array) - 1;
			$x_display = $x;
			$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
			$x_display .= $x_parts[$x_count_parts - 1];
			return  '<p><strong>Total comments:</strong><br class="clear" />'. $x_display . '</p>';
		}
}

function ytio_video_count() {
	$url =  ytio_api_2();
	$json = file_get_contents($url);
	$json_data = json_decode($json, false);
	$num = $json_data->items[0]->statistics->videoCount;
		if(empty ($num) ) {
			return false;
		} else {
			if( $num < 1000 ) return $num;
			$x = round($num);
			$x_number_format = number_format($x);
			$x_array = explode(',', $x_number_format);
			$x_parts = array(' thousand', ' million', ' billion', ' trillion');
			$x_count_parts = count($x_array) - 1;
			$x_display = $x;
			$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
			$x_display .= $x_parts[$x_count_parts - 1];
			$msg = '<p><strong>Total uploads:</strong><br class="clear" />';
			return  $msg . $x_display . '</p>';
		}
}

function ytio_api_3() {
	return 'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='. ytio_channel_id(). '&maxResults='. ytio_max_res() .'&key=AIzaSyB9OPUPAtVh3_XqrByTwBTSDrNzuPZe8fo&type=video';
}

function ytio_last_uploads() {
        $url = ytio_api_3();
        $json = file_get_contents($url);
        $json_data = json_decode($json, false);
        foreach ( $json_data->items as $item ) {
			$id = $item->id->videoId;
			echo '<iframe id="ytplayer" type="text/html" width="auto" height="auto" 
                src="http://www.youtube.com/embed/' . $id . '?rel=0&showinfo=1"
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
        $url = ytio_api_4();
        $json = file_get_contents($url);
        $json_data = json_decode($json, false);
        foreach ( $json_data->items as $item ) {
			$id = $item->id->videoId;
			echo '<iframe id="ytplayer" type="text/html" width="auto" height="auto" 
                src="http://www.youtube.com/embed/' . $id . '?rel=0&showinfo=1"
                frameborder="0" allowfullscreen></iframe><br class="clear" />';
		}
		if(empty( $id ) ) {
			echo '<p>Apologize, nothing found for this channel.</p>';
		} else {
			echo '<a href="'. ytio_popular_more_link(). '" title="more popular uploads of this channel on YouTube">Browse more »</a>';
		}
}

// end of api urls basted on V3 YOUTUBE API


function ytio_api_url() {
	return 'http://gdata.youtube.com/feeds/api/users/'. ytio_user_id() . '?v=2.1&prettyprint=true';
}

function ytio_name_ret_del() {
    $xmlData = file_get_contents( ytio_api_url() ); 
    $xml = new SimpleXMLElement($xmlData) or die("Error"); 
    return $xml;
}
function ytio_name_del() {
    $yt = ytio_name_ret();
    return $yt->author->name;
}

function ytio_user_or_channel() {
	if(empty(get_option('ytio_username'))) {
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
if(empty(get_option('ytio_username'))) {
	echo 'id';
}
?>="<?php echo ytio_user_id(); ?>" data-layout="default" data-count="default">
	<a href="<?php echo 'http://www.youtube.com/'. ytio_user_or_channel(). '/'. ytio_user_id(); ?>?sub_confirmation=1">subscribe</a>
</div>
<?php

}
function ytio_channel_link() {
	echo 'http://www.youtube.com/'. ytio_user_or_channel(). '/'. ytio_user_id();
}


add_action( 'wp_enqueue_scripts', 'ytio_enq_scripts' );

function ytio_enq_scripts() {
	wp_register_script('ytio-js-1', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', array('jquery'),'1', true);
	wp_register_script('ytio-js-2', plugin_dir_url( __FILE__ ) . 'files/main.js', array('jquery'),'1.2', true);
	wp_enqueue_script('ytio-js-1');
	wp_enqueue_script('ytio-js-2');
}

add_action( 'wp_enqueue_scripts', 'ytio_enq_styles' );  

function ytio_enq_styles() {
    wp_enqueue_style('ytio-css', plugin_dir_url( __FILE__ ) . 'files/style.css' );
}

// Enqueue Script in the settings page

add_action( 'admin_enqueue_scripts', 'ytio_enq_admin_scripts' );

function ytio_enq_admin_scripts() {
wp_register_script('ytio-admin-js-1', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', array('jquery'),'1', true);
wp_register_script('ytio-admin-js-2', plugin_dir_url( __FILE__ ) . 'files/main.js', array('jquery'),'1.2', true);
wp_enqueue_script('ytio-admin-js-1');
wp_enqueue_script('ytio-admin-js-2');
}

add_action( 'admin_enqueue_scripts', 'ytio_enq_admin_styles' );  

function ytio_enq_admin_styles() {
    wp_enqueue_style('ytio-admin-css', plugin_dir_url( __FILE__ ) . 'files/style.css' );
}

function ytio_widget() {

	if(empty(get_option('ytio_username')) && empty(get_option('ytio_id'))) {
		?>

<div id="ytio-container">
	<p>
		<h2>Please fill out a YouTube username or channel ID first</h2>
		<sub>– YouTube information widget plugin</sub>
	</p>
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
				<?php ytio_about_summary(); ?>
				<?php echo ytio_subs_count(); ?>
				<?php echo ytio_video_count(); ?>
				<?php echo ytio_view_count(); ?>
				<?php echo ytio_comment_count(); ?>
			</div>
		</div>
	</section>
</div>
<!-- #ytio-container -->
<br style="clear: both;"></br>

<?php
}
}

?>
<?php

// Creating the widget 
class ytio_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'ytio_widget', 

// Widget name will appear in UI
__('YouTube Information Widget', 'ytio_widget_domain'), 

// Widget description
array( 'description' => __( 'embed your YouTube channel content', 'ytio_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
echo __( ytio_widget(), 'ytio_widget_domain' );
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
} else {
$title = __( '', 'ytio_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<a href="options-general.php?page=ytio_settings">Settings</a>
<br /><br />
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
// ytio_last_uploads();
}
}

// Register and load the widget
function ytio_load_widget() {
	register_widget( 'ytio_widget' );
}
add_action( 'widgets_init', 'ytio_load_widget' );
