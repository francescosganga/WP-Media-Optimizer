=== WP Media Optimizer (.webp) ===
Contributors: francescosganga
Donate link: http://www.francescosganga.it/
Tags: media, optimizer, reduce, image, size, webp
Requires at least: 5.1
Tested up to: 5.3
Requires PHP: 5.6
Stable tag: 1.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Automatically optimize images in your Wordpress site by converting them to .webp extension

== Description ==
 
Optimize images (jpg, png) in your Wordpress site by converting them to .webp extension (it uses PHP GD library)

*UASGE*

Simply install and activate it, and your images will be optimized.

*HOW IT WORKS*

When anyone access to a Wordpress page, plugin check for images already converted to .webp.
If one or more images have not been already converted, the plugin converts them immediately.
Converted images are stored in a subfolder of wp-content folder: wp-content/wpmowebp

*TROUBLESHOOTING*

If Wordpress go out of memory try to add
define('WP_MEMORY_LIMIT', '256M');
to your wp-config.php

Enjoy your new Wordpress Plugin.

== Installation ==

1. Upload folder inside zip 'wp-media-optimizer-webp.zip' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==
 
== Screenshots ==
 
== Changelog ==
 
= 1.0.0 =
* First plugin release
= 1.0.1 =
* Added .jpeg support
* Removed some debug lines
= 1.0.2 =
* Added "how it works" to page plugin
* Fixed about section
= 1.0.3 =
* Some fixes for WP Plugins Directory