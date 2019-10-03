<?php
/**
* Plugin Name: WP Media Optimizer (.webp)
* Plugin URI: http://www.francescosganga.it/wordpress/plugin/wp-media-optimizer-webp/
* Description: Convert your media images to .webp for increase performances
* Version: 1.0
* Author: Francesco Sganga
* Author URI: http://www.francescosganga.it/
**/

function wpmowebp_init() {
	register_setting('wpmowebp-options', 'wpmowebp-images-dir', array(
		'type' => 'string', 
		'sanitize_callback' => 'sanitize_text_field',
		'default' =>  WP_CONTENT_DIR . "/wpmowebp"
	));

}
add_action('admin_init', 'wpmowebp_init');

function wpmowebp_options_panel(){
	add_menu_page('WP Media Optimizer', 'WP Media Optimizer', 'manage_options', 'wpmowebp-options', 'wpmowebp_options_settings');
	add_submenu_page('wpmowebp-options', 'About', 'About', 'manage_options', 'wpmowebp-option-about', 'wpmowebp_options_about');
}
add_action('admin_menu', 'wpmowebp_options_panel');

function wpmowebp_options_settings(){
	wp_enqueue_script("wpmowebp-admin", plugin_dir_url(__FILE__) . "assets/admin-main.js", array(), "1.0.0", true);
	?>
	<div class="wrap">
		<h1>WP Media Optimizer (.webp)</h1>
		<h2>Settings Section</h2>
		<form method="post" action="options.php">
		<?php settings_fields('wpmowebp-options'); ?>
		<?php do_settings_sections('wpmowebp-options'); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Test</th>
				<td>
					<input type="text" name="wpmowebp-images-dir" value="<?php print get_option('wpmowebp-images-dir'); ?>" />
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
		</form>
		<hr />
		<h2>How to use</h2>
	</div>
	<?php
}

function wpmowebp_options_about(){
	?>
	<h1>About</h1>
	<h2>Under Construction</h2>
	<?php
}

function wpmowebp_imagetowebp($realImage) {
    $realImage = WP_CONTENT_DIR . str_replace("wp-content", "", $realImage);
    if(file_exists($realImage)) {
        if(!is_dir(get_option('wpmowebp-images-dir')))
            mkdir(get_option('wpmowebp-images-dir'), 0755, true);
        
        $image = get_option('wpmowebp-images-dir') . "/" . str_replace(WP_CONTENT_DIR, "wp-content/", $realImage);
        $path = dirname($image);
        $filename = pathinfo($image, PATHINFO_FILENAME);
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        
        write_log($log);
        
        if(!is_dir($path))
            mkdir($path, 0755, true);
        
        if(!file_exists("{$path}/{$filename}.webp")) {
            switch($extension) {
                case "jpg":
                    if(!imagewebp(imagecreatefromjpeg($realImage), "{$path}/{$filename}.webp"))
                        return false;
                    break;
                    
                case "png":
                    print "yooo";
                    if(!imagewebp(imagecreatefrompng($realImage), "{$path}/{$filename}.webp"))
                        return false;
                    break;
            }
        } else {
            return true;
        }
            
        return true;
    }
}


function filter_content($content) {
    $content = preg_replace_callback("/https:\/\/{$_SERVER['HTTP_HOST']}\/([^\/]+\/)?([^\/]+)\/([^\/]+)\/([^\/]+)\/([^\/]+)\/([\w-]+).(png|jpg)/", function($matches) {
        if(!file_exists(WP_CONTENT_DIR . "/wpmowebp/{$matches[6]}.webp")) {
            if(!wpmowebp_imagetowebp("{$matches[1]}/{$matches[2]}/{$matches[3]}/{$matches[4]}/{$matches[5]}/{$matches[6]}.{$matches[7]}")) {
                return $matches[0];   
            }
        }
        
        return home_url() . "/wp-content/wpmowebp/{$matches[1]}/{$matches[2]}/{$matches[3]}/{$matches[4]}/{$matches[5]}/{$matches[6]}.webp";
    }, $content);
    
    return $content;
}
ob_start("filter_content");