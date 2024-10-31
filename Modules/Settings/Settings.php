<?php

namespace ProductGalleryWithQuoteButton\Modules\Settings;

/**
 * Class for settings page shown in admin panel
 */
class Settings
{
    private $page = WPGWQB_PLUGIN_NAME . '-settings-group';

    function __construct()
    {
        // Add menu page to the sidebar
        add_menu_page(__('Gallery with Quote settings', 'product-gallery-with-quote-button'),
            __('Gallery with Quote', 'product-gallery-with-quote-button'),
            'administrator',
            WPGWQB_PLUGIN_NAME,
            array($this, 'render_page'),
            'dashicons-format-gallery', 81);
        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Set options which can be edited in the settings view
     *
     * @return void
     */
    function register_settings(): void
    {
        register_setting($this->page, 'wpgwqb_show_category');
        register_setting($this->page, 'wpgwqb_email_to');
    }

    /**
     * Render Product categories
     *
     * @return void
     */
    function display_categories_form_element(): void
    {
        $cat_args = ['orderby' => 'name', 'order' => 'asc', 'hide_empty' => false];
        $product_categories = get_terms('product_cat', $cat_args);
        $options = get_option('wpgwqb_show_category');
        $show_category = isset($options['show_category_field']) ? (array)$options['show_category_field'] : [];
        if (empty($product_categories) === false) {
            echo '';
            foreach ($product_categories as $key => $category) {
                $checked = checked(in_array($category->term_id, $show_category), true, false);
                $id = esc_attr($category->term_id);

                $allowed_html = [
                    'label' => [],
                    'input' => ['type' => [], 'name' => [], 'value' => [], 'checked' => [], 'br' => []],
                    'br' => []
                ];
                $html = "<label>";
                $html .= "<input type='checkbox' name='wpgwqb_show_category[show_category_field][]' value='$id' $checked>";
                $html .= esc_html($category->name);
                $html .= "</label>";
                $html .= "<br>";
                echo wp_kses($html, $allowed_html);
            }
        }
    }

    /**
     * Add fields for settings section
     *
     * @return void
     */
    function display_quote_gallery_settings(): void
    {
        add_settings_field("quote_categories",
            "Show quote in category",
            array($this, "display_categories_form_element"),
            $this->page,
            "quote_categories");

        add_settings_field("wpgwqb_email_to",
            "Contact email",
            array($this, "display_email_form_element"),
            $this->page,
            "quote_categories");
    }

    /**
     * Generate input field for email address
     *
     * @return void
     */
    function display_email_form_element(): void
    {
        $wpgwqb_email_to = filter_var(get_option('wpgwqb_email_to'), FILTER_VALIDATE_EMAIL) ? get_option('wpgwqb_email_to') : "";
        $allowed_html = ['input' => ['type' => [], 'name' => [], 'value' => []]];
        $html = "<input type='email' name='wpgwqb_email_to' value='$wpgwqb_email_to' />";
        echo wp_kses($html, $allowed_html);
    }

    /**
     * Render html content for Settings page in admin panel
     *
     * @return void
     */
    function render_page(): void
    {
        if (method_exists('ProductGalleryWithQuoteButton\Modules\Settings\Settings', 'display_quote_gallery_settings') === true) {
            // Include settings page's content template with dynamic content
            include WPGWQB_PLUGIN_DIR . '/templates/settings-admin.php';
        }
    }
}