<?php
/*
Plugin Name: Compression WP
Plugin URI: http://plugins.sonicity.eu/compression-plugin/
Description: Allows you to compress your webpages to save bandwidth and make your blog load faster!
Version: 1.0.2
Author: Sonicity
Author URI: http://www.sonicity.eu
*/


/*  Copyright 2010 Sonicity.EU - support@sonicity.eu

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Hook for adding admin menus
add_action('admin_menu', 'compression_add_pages');

// action function for above hook
function compression_add_pages() {
    add_options_page('Compression WP', 'Compression WP', 'administrator', 'compression', 'compression_options_page');
}

// compression_options_page() displays the page content for the Test Options submenu
function compression_options_page() {

    // variables for the field and option names 
	$opt_name_3 = 'mt_compression_on';
    $opt_name_5 = 'mt_compression_plugin_support';
    $hidden_field_name = 'mt_compression_submit_hidden';
	$data_field_name_3 = 'mt_compression_on';
    $data_field_name_5 = 'mt_compression_plugin_support';

    // Read in existing option value from database
	$opt_val_3 = get_option($opt_name_3);
    $opt_val_5 = get_option($opt_name_5);

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
		$opt_val_3 = $_POST[$data_field_name_3];
        $opt_val_5 = $_POST[$data_field_name_5];

        // Save the posted value in the database
		update_option( $opt_name_3, $opt_val_3 );
        update_option( $opt_name_5, $opt_val_5 );

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Compression WP Plugin Options', 'mt_trans_domain' ) . "</h2>";

echo "<br /><strong>How this plugin works</strong><br />This plugin enables GZIP compression on your website which will compress the data on your web server before it is sent to the web browser. By doing this, a smaller amount of data has to be sent which reduces the amount of bandwidth used and should lead to shorter load times<br />";
    // options form
    
    $change3 = get_option("mt_compression_plugin_support");
	$change5 = get_option("mt_compression_on");

if ($change3=="Yes" || $change3=="") {
$change3="checked";
$change31="";
} else {
$change3="";
$change31="checked";
}

if ($change5=="On" || $change5=="") {
$change5="checked";
$change51="";
} else {
$change5="";
$change51="checked";
}
    ?>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Compression is...?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_3; ?>" value="On" <?php echo $change5; ?>>On
<input type="radio" name="<?php echo $data_field_name_3; ?>" value="Off" <?php echo $change51; ?>>Off
</p>

<p><?php _e("Support the Plugin?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="Yes" <?php echo $change3; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="No" <?php echo $change31; ?>>No
</p>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p><hr />

</form>
</div>
<?php } ?>
<?php

function compression() {
$onoff=get_option("mt_compression_on");
if ($onoff=="On" || $onoff=="") {
if(extension_loaded('zlib')){@ob_start('ob_gzhandler');}
}

$supportplugin=get_option("mt_compression_plugin_support");
if ($supportplugin=="" || $supportplugin=="Yes") {
add_action('wp_footer', 'compression_footer_plugin_support');
}
}


function compression_footer_plugin_support() {
  $pshow = "<p style='font-size:x-small'>Compression Plugin made by <a href='http://www.xeromi.net'>Web Hosting</a></p>";
  echo $pshow;
}


add_action("init", "compression");

?>
