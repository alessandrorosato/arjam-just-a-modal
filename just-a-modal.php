<?php
/**
 * Plugin Name: Just a Modal
 * Description: Render a simple modal with a title, some text and an image. No frills, no pro version.
 * Author: Alessandro Rosato
 * Author URI: https://www.alessandrorosato.com/
 * Version: 0.1.0
 */

if(!defined('ABSPATH')) {
    exit;
}

define('JAM_VERSION', '0.1.0' );

// Admin menu
function jam_plugin_menu() {
    add_menu_page(
        'Just a Modal',         // Page title
        'Just a Modal',         // Menu title
        'manage_options',       // Capability required to access
        'just-a-modal-plugin',  // Menu slug
        'jam_plugin_page',      // Function to display the page
        'dashicons-sticky',     // Icon
        100                     // Position
    );
}
add_action('admin_menu', 'jam_plugin_menu');

// Settings link in plugins list
function jam_plugin_add_settings_link($links) {
    $settings_url = admin_url('admin.php?page=just-a-modal-plugin');
    $settings_link = '<a href="' . esc_url($settings_url) . '">Settings</a>';
    array_unshift($links, $settings_link);
    
    return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'jam_plugin_add_settings_link' );


// Admin settings
function jam_plugin_settings_init() {
    register_setting('jam_plugin_settings', 'jam_plugin_text_field');
    register_setting('jam_plugin_settings', 'jam_plugin_richtext_field');
    register_setting('jam_plugin_settings', 'jam_plugin_image_field');
    register_setting('jam_plugin_settings', 'jam_plugin_enable_modal');
    register_setting('jam_plugin_settings', 'jam_plugin_hash');
    register_setting('jam_plugin_settings', 'jam_plugin_delay');

    add_settings_section(
        'jam_plugin_section',
        'Settings',
        'jam_plugin_section_callback',
        'just-a-modal-plugin'
    );

    add_settings_field(
        'jam_plugin_enable_modal',
        'Enable Modal',
        'jam_plugin_enable_modal_render',
        'just-a-modal-plugin',
        'jam_plugin_section'
    );

    add_settings_field(
        'jam_plugin_text_field',
        'Modal Title',
        'jam_plugin_text_field_render',
        'just-a-modal-plugin',
        'jam_plugin_section'
    );

    add_settings_field(
        'jam_plugin_image_field',
        'Modal Image',
        'jam_plugin_image_field_render',
        'just-a-modal-plugin',
        'jam_plugin_section'
    );

    add_settings_field(
        'jam_plugin_richtext_field',
        'Modal Content',
        'jam_plugin_richtext_field_render',
        'just-a-modal-plugin',
        'jam_plugin_section'
    );

    add_settings_field(
        'jam_plugin_delay',
        'Modal Delay',
        'jam_plugin_delay_render',
        'just-a-modal-plugin',
        'jam_plugin_section'
    );

    add_settings_field(
        'jam_plugin_hash',
        'Modal Hash',
        'jam_plugin_hash_render',
        'just-a-modal-plugin',
        'jam_plugin_section'
    );
}
add_action('admin_init', 'jam_plugin_settings_init');

// Admin fields rendering
function jam_plugin_text_field_render() {
    $value = get_option('jam_plugin_text_field');
    echo '<input type="text" name="jam_plugin_text_field" value="' . esc_attr($value) . '" class="regular-text">';
}

function jam_plugin_richtext_field_render() {
    $value = get_option('jam_plugin_richtext_field');
    wp_editor(
        $value,
        'jam_plugin_richtext_field',
        array(
            'textarea_name' => 'jam_plugin_richtext_field',
            'media_buttons' => true,
            'teeny' => false,
            'textarea_rows' => 10
        )
    );
}

function jam_plugin_image_field_render() {
    $value = get_option('jam_plugin_image_field');
    ?>
    <input type="text" name="jam_plugin_image_field" id="jam_plugin_image_field" value="<?php echo esc_url($value); ?>" class="regular-text">
    <input type="button" class="button" value="Upload Image" id="jam_plugin_upload_image_button">
    <script>
    jQuery(document).ready(function($) {
        $('#jam_plugin_upload_image_button').click(function(e) {
            e.preventDefault();
            var image = wp.media({
                title: 'Upload Image',
                multiple: false
            }).open()
            .on('select', function(e) {
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                $('#jam_plugin_image_field').val(image_url);
            });
        });
    });
    </script>
    <?php
}

function jam_plugin_enable_modal_render() {
    $value = get_option('jam_plugin_enable_modal', 'on');
    echo '<input type="checkbox" name="jam_plugin_enable_modal" ' . checked('on', $value, false) . '>';
}

function jam_plugin_hash_render() {
    $value = get_option('jam_plugin_hash', '1');
    echo '<input type="text" name="jam_plugin_hash" value="' . esc_attr($value) . '" size="16"> <button type="button" id="my-custom-admin-btn" class="button button-secondary">Generate!</button>';
}

function jam_plugin_delay_render() {
    $value = get_option('jam_plugin_delay', '0');
    echo '<input type="number" name="jam_plugin_delay" value="' . esc_attr($value) . '"> (seconds)';
}

// Admin page
function jam_plugin_page() {
    ?>
    <div class="wrap">
        <h1>Just a Modal</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('jam_plugin_settings');
            do_settings_sections('just-a-modal-plugin');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function jam_plugin_section_callback() {
    echo '<p>A very basic modal popup. It will render above a dark background with a title, an image and some text.</p>';
    echo '<p>The modal can be toggled via the <b>"Enable Modal"</b> checkbox. Generating a new hash will make the modal reapper on browsers that already visited the site (useful for when changes have been done to its content).</p>';
    echo '<p>A delay (in seconds) can be added before the modal shows up with the <b>"Modal Delay"</b> field. Default value is 0, meaning the modal will be rendered on page load.</p>';
}

// Admin JS
function jam_plugin_admin_js() {
    wp_enqueue_script('just-a-modal-admin-script', plugins_url('assets/just-a-modal-admin.js', __FILE__), array(), JAM_VERSION, true);
}
add_action('admin_enqueue_scripts', 'jam_plugin_admin_js');

// Load assets
function jam_plugin_assets() {
    wp_enqueue_style('just-a-modal-style', plugins_url('assets/just-a-modal.css', __FILE__), array(), JAM_VERSION, 'all');
    wp_enqueue_script('just-a-modal-script', plugins_url('assets/just-a-modal.js', __FILE__), array(), JAM_VERSION, true);
    wp_localize_script('just-a-modal-script', 'jam_plugin_data', array(
        'text'          => get_option('jam_plugin_text_field'),
        'richtext'      => get_option('jam_plugin_richtext_field'),
        'image'         => get_option('jam_plugin_image_field'),
        'enable_modal'  => get_option('jam_plugin_enable_modal', 'on') === 'on',
        'modal_hash'    => get_option('jam_plugin_hash', '1'),
        'modal_delay'    => get_option('jam_plugin_delay', 0)
    ));

}
add_action('wp_enqueue_scripts', 'jam_plugin_assets');