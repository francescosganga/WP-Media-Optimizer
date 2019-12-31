# WP Media Optimizer

Automatically optimize images in your Wordpress site by converting them to .webp extension

## Getting Started

Simply install and activate it, and your images will be optimized.
You can see full readme from (wordpress official website)[https://it.wordpress.org/plugins/wp-media-optimizer-webp/]

### How it works

When anyone access to a Wordpress page, plugin check for images already converted to .webp.
If one or more images have not been already converted, the plugin converts them immediately.
Converted images are stored in a subfolder of wp-content folder: wp-content/wpmowebp

### TROUBLESHOOTING

If Wordpress go out of memory try to add
define('WP_MEMORY_LIMIT', '256M');
to your wp-config.php

### Installing

1. Upload folder inside zip 'wp-media-optimizer-webp.zip' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress

## Thanks To

* **[Francesco Sganga](http://www.francescosganga.it)** - *Initial work*

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

Under Construction