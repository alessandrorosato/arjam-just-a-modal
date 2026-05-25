<?php
/**
 * Plugin Name: ARJAM - Just a Modal
 * Description: Render a simple modal with a title, some text and an image. No frills, no pro version.
 * Author: Alessandro Rosato
 * Author URI: https://www.alessandrorosato.com/
 * Version: 1.0.1
 * License: GPLv2 or later
 */

if(!defined('ABSPATH')) {
    exit;
}

define('ARJAM_VERSION', '1.0.1' );

// Admin menu
function arjam_plugin_menu() {
    add_menu_page(
        'ARJAM - Just a Modal',         // Page title
        'ARJAM - Just a Modal',         // Menu title
        'manage_options',       // Capability required to access
        'arjam-just-a-modal-plugin',  // Menu slug
        'arjam_plugin_page',      // Function to display the page
        'dashicons-sticky',     // Icon
        100                     // Position
    );
}
add_action('admin_menu', 'arjam_plugin_menu');

// Settings link in plugins list
function arjam_plugin_add_settings_link($links) {
    $settings_url = admin_url('admin.php?page=arjam-just-a-modal-plugin');
    $settings_link = '<a href="' . esc_url($settings_url) . '">Settings</a>';
    array_unshift($links, $settings_link);
    
    return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'arjam_plugin_add_settings_link' );

// Admin settings
function arjam_plugin_settings_init() {
    register_setting('arjam_plugin_settings', 'arjam_plugin_text_field', ['type' => 'string', 'sanitize_callback' => 'sanitize_text_field']);
    register_setting('arjam_plugin_settings', 'arjam_plugin_richtext_field', ['type' => 'string', 'sanitize_callback' => 'sanitize_textarea_field']);
    register_setting('arjam_plugin_settings', 'arjam_plugin_image_field', ['type' => 'string', 'sanitize_callback' => 'sanitize_text_field']);
    register_setting('arjam_plugin_settings', 'arjam_plugin_enable_modal', ['type' => 'boolean', 'sanitize_callback' => 'wp_validate_boolean']);
    register_setting('arjam_plugin_settings', 'arjam_plugin_hash', ['type' => 'string', 'sanitize_callback' => 'sanitize_text_field']);
    register_setting('arjam_plugin_settings', 'arjam_plugin_delay', ['type' => 'string', 'sanitize_callback' => 'sanitize_text_field']);

    add_settings_section(
        'arjam_plugin_section',
        'Settings',
        'arjam_plugin_section_callback',
        'arjam-just-a-modal-plugin'
    );

    add_settings_field(
        'arjam_plugin_enable_modal',
        'Enable Modal',
        'arjam_plugin_enable_modal_render',
        'arjam-just-a-modal-plugin',
        'arjam_plugin_section'
    );

    add_settings_field(
        'arjam_plugin_text_field',
        'Modal Title',
        'arjam_plugin_text_field_render',
        'arjam-just-a-modal-plugin',
        'arjam_plugin_section'
    );

    add_settings_field(
        'arjam_plugin_image_field',
        'Modal Image',
        'arjam_plugin_image_field_render',
        'arjam-just-a-modal-plugin',
        'arjam_plugin_section'
    );

    add_settings_field(
        'arjam_plugin_richtext_field',
        'Modal Content',
        'arjam_plugin_richtext_field_render',
        'arjam-just-a-modal-plugin',
        'arjam_plugin_section'
    );

    add_settings_field(
        'arjam_plugin_delay',
        'Modal Delay',
        'arjam_plugin_delay_render',
        'arjam-just-a-modal-plugin',
        'arjam_plugin_section'
    );

    add_settings_field(
        'arjam_plugin_hash',
        'Modal Hash',
        'arjam_plugin_hash_render',
        'arjam-just-a-modal-plugin',
        'arjam_plugin_section'
    );
}
add_action('admin_init', 'arjam_plugin_settings_init');

// Admin fields rendering
function arjam_plugin_text_field_render() {
    $value = get_option('arjam_plugin_text_field');
    echo '<input type="text" name="arjam_plugin_text_field" value="' . esc_attr($value) . '" class="regular-text">';
}

function arjam_plugin_richtext_field_render() {
    $value = get_option('arjam_plugin_richtext_field');
    wp_editor(
        $value,
        'arjam_plugin_richtext_field',
        array(
            'textarea_name' => 'arjam_plugin_richtext_field',
            'media_buttons' => true,
            'teeny' => false,
            'textarea_rows' => 10
        )
    );
}

function arjam_plugin_image_field_render() {
    $value = get_option('arjam_plugin_image_field');
    ?>
    <input type="text" name="arjam_plugin_image_field" id="arjam_plugin_image_field" value="<?php echo esc_url($value); ?>" class="regular-text">
    <input type="button" class="button" value="Upload Image" id="arjam_plugin_upload_image_button">
    <p class="description">Image should be maximum 600 pixels in width.</p>
    <script>
    jQuery(document).ready(function($) {
        $('#arjam_plugin_upload_image_button').click(function(e) {
            e.preventDefault();
            var image = wp.media({
                title: 'Upload Image',
                multiple: false
            }).open()
            .on('select', function(e) {
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                $('#arjam_plugin_image_field').val(image_url);
            });
        });
    });
    </script>
    <?php
}

function arjam_plugin_enable_modal_render() {
    $value = get_option('arjam_plugin_enable_modal', true);
    echo '<input type="checkbox" name="arjam_plugin_enable_modal" ' . checked(true, $value, false) . '>';
}

function arjam_plugin_hash_render() {
    $value = get_option('arjam_plugin_hash', '1');
    echo '<input type="text" name="arjam_plugin_hash" value="' . esc_attr($value) . '" size="16"> <button type="button" id="my-custom-admin-btn" class="button button-secondary">Generate!</button>';
}

function arjam_plugin_delay_render() {
    $value = get_option('arjam_plugin_delay', '0');
    echo '<input type="number" name="arjam_plugin_delay" value="' . esc_attr($value) . '">';
    echo '<p class="description">Delay to trigger the modal window, in seconds. Default value is 0, meaning the modal will be rendered on page load.</p>';
}

// Admin page
function arjam_plugin_page() {
    ?>
    <div class="wrap">
        <h1>ARJAM - Just a Modal</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('arjam_plugin_settings');
            do_settings_sections('arjam-just-a-modal-plugin');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function arjam_plugin_section_callback() {
    echo '<p>A very basic modal popup. It will render above a dark background with a title, an image and some text.</p>';
    echo '<p>The modal can be toggled via the <b>"Enable Modal"</b> checkbox. Generating a new hash will make the modal reapper on browsers that already visited the site (useful for when changes have been done to its content).</p>';
}

// Admin JS
function arjam_plugin_admin_js() {
    wp_enqueue_script('arjam-just-a-modal-admin-script', plugins_url('admin/js/arjam-just-a-modal-admin.js', __FILE__), array(), ARJAM_VERSION, true);
}
add_action('admin_enqueue_scripts', 'arjam_plugin_admin_js');

// Load assets
function arjam_plugin_assets() {
    wp_enqueue_style('arjam-just-a-modal-style', plugins_url('public/css/arjam-just-a-modal.css', __FILE__), array(), ARJAM_VERSION, 'all');
    wp_enqueue_script('arjam-just-a-modal-script', plugins_url('public/js/arjam-just-a-modal.js', __FILE__), array(), ARJAM_VERSION, true);
    wp_localize_script('arjam-just-a-modal-script', 'arjam_plugin_data', array(
        'text'          => get_option('arjam_plugin_text_field'),
        'richtext'      => get_option('arjam_plugin_richtext_field'),
        'image'         => get_option('arjam_plugin_image_field'),
        'enable_modal'  => get_option('arjam_plugin_enable_modal'),
        'modal_hash'    => get_option('arjam_plugin_hash', '1'),
        'modal_delay'   => get_option('arjam_plugin_delay', 0)
    ));
}
add_action('wp_enqueue_scripts', 'arjam_plugin_assets');