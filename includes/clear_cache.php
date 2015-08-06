<?php

/**
 * YouTube Information Widget
 *
 * As of v. 2.0, this PHP file is used to clear cache through admin widgets area, and it simply modifies an option for cache clearing process used by this plugin.
 */

// loads blog header file
require_once( '../../../../wp-blog-header.php' );
// little JavaScript to close window after 3 seconds
$script = "<script>setTimeout (function() {window.close();},3000);</script>";
// locks non admin users away
if ( ! current_user_can( 'manage_options' ) )
	die("Access restricted to admins only.$script");
// option
$force_update = esc_attr(get_option( 'yiw_force_update' ));
// success message
$success = _e("YouTube Information Widget database cache is being cleared soon..<br><i>Closing tab in 3 seconds...</i>");
$success .= $script;
// adds option if not exists, otherwise updates
if ( $force_update = '' ) {
	add_option( 'yiw_force_update', '1' );
	echo $success;
} else {
	update_option( 'yiw_force_update', '1' );
	echo $success;
}
