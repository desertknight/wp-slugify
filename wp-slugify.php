<?php

/**
 * Plugin Name: WP Slugify
 * Plugin URI: http://wordpress.org/extend/plugins/wp-slugify/
 * Description: Change default wordpress automatic generation slug
 * Author: Zlatko Hristov <zlatko.2create@gmail.com>
 * Version: 1.0.1
 * License: The MIT License (MIT)
 */
if (is_admin()) {
    include_once plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR . 'WPSlugifyAdmin.php';
    $WPSlugifyAdmin = new WPSlugifyAdmin();
}

include_once plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR . 'WPSlugifyGenerator.php';
$WPSlugifyGenerator = new WPSlugifyGenerator();