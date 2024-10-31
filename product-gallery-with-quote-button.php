<?php
/**
 * Plugin Name: Product Gallery with Quote Button
 * Plugin URI: http://www.wizardcow.fi/product-gallery-with-quote-button/
 * Text Domain: product-gallery-with-quote-button
 * Domain Path: /languages/
 * Description: Create a frontend product gallery and add quote button to each product
 * License: GPL3
 * Version: 1.0
 * Author: Juha Sarkkinen
 * Author URI: http://www.wizardcow.fi/
 */

namespace ProductGalleryWithQuoteButton;

define('WPGWQB_PLUGIN', __FILE__);
define('WPGWQB_PLUGIN_BASENAME', plugin_basename(WPGWQB_PLUGIN));
define('WPGWQB_PLUGIN_NAME', trim(dirname(WPGWQB_PLUGIN_BASENAME), '/'));
define('WPGWQB_PLUGIN_DIR', untrailingslashit(dirname(WPGWQB_PLUGIN)));
define('WPGWQB_TEXT_DOMAIN', 'product-gallery-with-quote-button');

/**
 * This plugin is used to create a gallery with quote button from woocommerce products
 */
class Plugin
{
    public $settings_page = null;

    public function __construct()
    {
        if (!function_exists('is_plugin_active')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        if (is_plugin_active('woocommerce/woocommerce.php') === false) {
            return;
        }

        $this->load_css();
        add_action('plugins_loaded', array($this, 'wpgwqb_load_textdomain'));
        add_action('wp_enqueue_scripts', array($this, 'ajax_contact_form'));
        add_action('wp_ajax_pgwq_mail', array($this, 'pgwq_send_mail'));
        add_action('wp_ajax_nopriv_pgwq_mail', array($this, 'pgwq_send_mail'));
        add_action('wp_mail_failed', array($this, 'onMailError'), 10, 1);
        add_action('admin_menu', array($this, 'add_settings_page'));
    }

    /**
     * Load stylesheets
     *
     * @return void
     */
    public function load_css(): void
    {
        add_shortcode('gallery_with_quote', array($this, 'render_gallery'));
        wp_register_style('wpg_style', plugins_url('css/style.css', __FILE__));
        wp_enqueue_style('wpg_style');
    }

    /**
     * Add settings page for wordpress side bar
     *
     * @return void
     */
    public function add_settings_page(): void
    {
        require_once WPGWQB_PLUGIN_DIR . '/Modules/Settings/Settings.php';
        $this->settings_page = new Modules\Settings\Settings();
    }

    /**
     * Load i18 translations
     *
     * @return void
     */
    public function wpgwqb_load_textdomain(): void
    {
        load_plugin_textdomain('product-gallery-with-quote-button',
            false, WPGWQB_PLUGIN_DIR . '/languages/');
    }

    /**
     * Show mail error
     *
     * @param $wp_error
     *
     * @return void
     */
    public function onMailError($wp_error): void
    {
        echo "<pre>";
        print_r($wp_error);
        echo "</pre>";
    }

    /**
     * Generate Quote email when contact request has been sent
     *
     * @return void
     */
    public function pgwq_send_mail(): void
    {
        if (wp_verify_nonce($_POST['gallery_quote_nonce'], 'pgwq_send_mail') === false) {
            wp_send_json_error(__('Nonce failed.', 'product-gallery-with-quote-button'));
        }

        $product_id = (int)$_POST['product_id'];
        $product = wc_get_product($product_id);
        $product_name = $product->get_name();
        $name = sanitize_text_field($_POST['name']);
        $tel = filter_var($_POST['tel'], FILTER_SANITIZE_NUMBER_INT);
        $contact_email = sanitize_email($_POST['email']);

        $message = __('Product id', 'product-gallery-with-quote-button') . ": $product_id\r\n";
        $message .= __('Product name', 'product-gallery-with-quote-button') . ": $product_name\r\n\r\n";
        $message .= __('Contact details', 'product-gallery-with-quote-button') . "\r\n";
        $message .= __('Name', 'product-gallery-with-quote-button') . ": $name\r\n";
        $message .= __('Telephone', 'product-gallery-with-quote-button') . ":  $tel\r\n";
        $message .= __('Email', 'product-gallery-with-quote-button') . ": $contact_email\r\n";

        $email = sanitize_email(get_option('wpgwqb_email_to'));

        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            if (wp_mail($email, "Quote request received: $product_name($product_id)", $message)) {
                wp_send_json_success(__('Message has been sent successfully', 'product-gallery-with-quote-button'));
            }
        } else {
            wp_send_json_error(__('Sending message failed', 'product-gallery-with-quote-button'));
        }
    }

    /**
     * Load contact form JS codes
     *
     * @return void
     */
    public function ajax_contact_form(): void
    {
        wp_enqueue_script('ajax_pgwq_contact_form', plugins_url('js/contact_form.js', __FILE__), array('jquery'));
        wp_localize_script('ajax_pgwq_contact_form', 'GalleryWithButton',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
            )
        );
    }

    /**
     * Render gallery to the frontend
     *
     * @return void
     */
    public function render_gallery(): void
    {
        include('templates/contact-form.php');
        include('templates/gallery.php');
    }
}

$woocommerce_product_gallery_with_quote_button = new Plugin();


