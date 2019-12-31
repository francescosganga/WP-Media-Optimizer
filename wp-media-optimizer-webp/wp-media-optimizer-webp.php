<?php
/**
* Plugin Name: WP Media Optimizer (.webp)
* Plugin URI: http://www.francescosganga.it/wordpress/plugin/wp-media-optimizer-webp/
* Description: Convert your media images to .webp for increase performances
* Text Domain: wp-media-optimizer-webp
* Version: 1.2.0
* Author: Francesco Sganga
* Author URI: http://www.francescosganga.it/
**/

function wpmowebp_init() {
	register_setting('wpmowebp-options', 'wpmowebp-images-dir');
	register_setting('wpmowebp-options', 'wpmowebp-reviewnotice');
	if(get_option('wpmowebp-images-dir') == false or get_option('wpmowebp-images-dir') == '') {
		update_option('wpmowebp-images-dir', WP_CONTENT_DIR . "/wpmowebp");
	}
	if(get_option('wpmowebp-reviewnotice') == false or get_option('wpmowebp-reviewnotice') == '') {
		update_option('wpmowebp-reviewnotice', false);
	}
}
add_action('admin_init', 'wpmowebp_init');

function wpmowebp_options_panel(){
	add_menu_page('WP Media Optimizer', 'WP Media Optimizer', 'manage_options', 'wpmowebp-options', 'wpmowebp_options_settings');
	add_submenu_page('wpmowebp-options', 'About', 'About', 'manage_options', 'wpmowebp-option-about', 'wpmowebp_options_about');
}
add_action('admin_menu', 'wpmowebp_options_panel');

function wpmowebp_detect_browser() {
	if(stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false)
		return "Chrome";
	elseif(stripos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
		return "Firefox";
	elseif(stripos($_SERVER['HTTP_USER_AGENT'], 'Safari'))
		return "Safari";
	elseif(stripos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
		return "Opera";
	else
		return false;
}

function wpmowebp_options_settings(){
	if(isset($_GET['dismissreviewnotice'])) {
		update_option('wpmowebp-reviewnotice', true);
		wp_redirect(home_url() . "/wp-admin/");
	}
	wp_enqueue_script("wpmowebp-admin", plugin_dir_url(__FILE__) . "assets/admin-main.js", array(), "1.0.0", true);
	?>
	<div class="wrap">
		<strong><?php _e("Debug", "wp-media-optimizer-webp") ?></strong>
		<p>
			<?php print $_SERVER['HTTP_USER_AGENT'] ?><br />
			<?php printf(__("Your browser is: %s", "wp-media-optimizer-webp"), wpmowebp_detect_browser()) ?>
		</p>
		<h1><?php _e("WP Media Optimizer (.webp)", "wp-media-optimizer-webp") ?></h1>
		<h2><?php _e("Settings", "wp-media-optimizer-webp") ?></h2>
		<form method="post" action="options.php">
		<?php settings_fields('wpmowebp-options'); ?>
		<?php do_settings_sections('wpmowebp-options'); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e(".webp images path (often automatically generated)", "wp-media-optimizer-webp") ?></th>
				<td>
					<input type="text" name="wpmowebp-images-dir" value="<?php print get_option('wpmowebp-images-dir'); ?>" />
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
		</form>
		<hr />
		<h2><?php _e("How it works", "wp-media-optimizer-webp") ?></h2>
		<p><?php _e("When anyone access to a Wordpress page, plugin check for images already converted to .webp.", "wp-media-optimizer-webp") ?></p>
		<p><?php _e("If one or more images have not been already converted, the plugin converts them immediately.", "wp-media-optimizer-webp") ?></p>
		<p><?php _e("Converted images are stored in a subfolder of wp-content folder: wp-content/wpmowebp", "wp-media-optimizer-webp") ?></p>
		<hr />
		<h2><?php _e("Feature Request", "wp-media-optimizer-webp") ?></h2>
		<p><?php _e("Using this form you can send me a feature request so I can insert it in the next releases.", "wp-media-optimizer-webp") ?></p>
		<form action="http://www.francescosganga.it/plugins/featurerequest.php?plugin=wpmowebp&url=<?php print (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" method="POST">
			<input type="text" name="title" placeholder="<?php _e("Feature Request Title", "wp-media-optimizer-webp") ?>" /><br /><br />
			<textarea name="message" placeholder="<?php _e("Describe here what feature do you like to see in WPMOWEBP", "wp-media-optimizer-webp") ?>"></textarea><br /><br />
			<input type="submit" class="button button-primary" value="<?php _e("Send Feature Request", "wp-media-optimizer-webp") ?>" />
		</form>
	</div>
	<?php
}

function wpmowebp_options_about(){
	?>
	<h1><?php _e("About", "wp-media-optimizer-webp") ?></h1>
	<?php
	$response = wp_remote_get("http://www.francescosganga.it/dev/about.html");
	$body = wp_remote_retrieve_body($response);

	print $body;
}

function wpmowebp_imagetowebp($wpcontentdir, $realImage) {
	$realImage = WP_CONTENT_DIR . str_replace($wpcontentdir, "", $realImage);
	if(file_exists($realImage)) {
		if(!is_dir(get_option('wpmowebp-images-dir')))
			mkdir(get_option('wpmowebp-images-dir'), 0755, true);
		
		$image = get_option('wpmowebp-images-dir') . "/" . str_replace(WP_CONTENT_DIR, "{$wpcontentdir}/", $realImage);
		$path = dirname($image);
		$filename = pathinfo($image, PATHINFO_FILENAME);
		$extension = pathinfo($image, PATHINFO_EXTENSION);
		
		if(!is_dir($path))
			mkdir($path, 0755, true);
		
		if(!file_exists("{$path}/{$filename}.webp")) {
			switch($extension) {
				case "jpg":
					$img = imagecreatefromjpeg($realImage);
					imagepalettetotruecolor($img);
					if(!imagewebp($img, "{$path}/{$filename}.webp"))
						return false;
					break;
				
				case "jpeg":
					$img = imagecreatefromjpeg($realImage);
					imagepalettetotruecolor($img);
					if(!imagewebp($img, "{$path}/{$filename}.webp"))
						return false;
					break;

				case "png":
					$img = imagecreatefrompng($realImage);
					imagepalettetotruecolor($img);
					if(!imagewebp($img, "{$path}/{$filename}.webp"))
						return false;
					break;
			}
		}
			
		return true;
	} else {
		return false;
	}
}

function wpmowebp_reviewnotice() {
	$reviewnotice = get_option('wpmowebp-reviewnotice');
	if($reviewnotice == false) {
		?>
		<div class="notice notice-warning">
			<p><?php _e("I hope you like <strong>WP Media Optimizer (.webp)</strong>.", 'wp-media-optimizer-webp'); ?></p>
			<p><?php _e("I would like to ask you if you can <a href=\"https://wordpress.org/support/plugin/wp-media-optimizer-webp/reviews/\" target=\"_BLANK\">review my plugin</a>.", 'wp-media-optimizer-webp'); ?></p>
			<p><?php printf(__("<a href=\"%s\">I already reviewed WPMOWEBP</a>", 'wp-media-optimizer-webp'), home_url() . "/wp-admin/admin.php?page=wpmowebp-options&dismissreviewnotice"); ?></p>
		</div>
		<?php
	}
}
add_action("admin_notices", "wpmowebp_reviewnotice");

function wpmowebp_check_activation_notice(){
     if(get_transient('wpmowebp-activation-notice')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php printf(__("Welcome to WP Media Optimizer (.webp). You don't need to do anything. Go to your <a href=\"%s\">homepage</a> and you will see your converted webp images.", "wp-media-optimizer-webp"), home_url()) ?></p>
        </div>
        <?php
        delete_transient('wpmowebp-activation-notice' );
    }
}
add_action("admin_notices", "wpmowebp_check_activation_notice");

register_activation_hook(__FILE__, 'wpmowebp_check_activation_notice_hook');
function wpmowebp_check_activation_notice_hook() {
    set_transient('wpmowebp-activation-notice', true, 5);
}

function wpmowebp_filter_content($content) {
	$currentBrowser = wpmowebp_detect_browser();
	if(wpmowebp_detect_browser() != "Safari" and wpmowebp_detect_browser() != false) {
		isset($_SERVER["HTTPS"]) ? $prot = 'https' : $prot = 'http';
		$content = preg_replace_callback("/{$prot}:\/\/{$_SERVER['HTTP_HOST']}\/([^\/]+)\/uploads\/([^\/]+)\/([^\/]+)\/([\w-]+).(png|jpg|jpeg)/", function($matches) {
			if(!file_exists(WP_CONTENT_DIR . "/wpmowebp/{$matches[1]}/uploads/{$matches[2]}/{$matches[3]}/{$matches[4]}.webp")) {
				if(!wpmowebp_imagetowebp($matches[1], "/uploads/{$matches[2]}/{$matches[3]}/{$matches[4]}.{$matches[5]}")) {
					return $matches[0];   
				}
			}
			
			return WP_CONTENT_URL . "/wpmowebp/{$matches[1]}/uploads/{$matches[2]}/{$matches[3]}/{$matches[4]}.webp";
		}, $content);
	}
	
	return $content;
}
ob_start('wpmowebp_filter_content');
