<?php
if(!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$options = [
    'arjam_plugin_text_field',
    'arjam_plugin_richtext_field',
    'arjam_plugin_image_field',
    'arjam_plugin_enable_modal',
    'arjam_plugin_hash',
    'arjam_plugin_delay'
];

foreach ($options as $option) {
    delete_option($option);

    // Multisite
    delete_site_option($option);
}