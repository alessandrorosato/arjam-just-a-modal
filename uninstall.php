<?php
if(!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$arjam_options = [
    'arjam_plugin_text_field',
    'arjam_plugin_richtext_field',
    'arjam_plugin_image_field',
    'arjam_plugin_enable_modal',
    'arjam_plugin_hash',
    'arjam_plugin_delay'
];

foreach ($arjam_options as $arjam_option) {
    delete_option($arjam_option);

    // Multisite
    delete_site_option($arjam_option);
}