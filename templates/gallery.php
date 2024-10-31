<?php
require_once WPGWQB_PLUGIN_DIR . '/Modules/Gallery/Gallery.php';

use ProductGalleryWithQuoteButton\Modules\Gallery\Gallery;

// Get from Settings which categories should be shown in Gallery
$options = (array)get_option('wpgwqb_show_category');
$categories = isset(array_values($options)[0]) === true ? array_values($options)[0] : [];
// Find matching names for categories
$categories = array_map('get_the_category_by_ID', $categories);

// Create a gallery instance and fill gallery with products in previously defined category
$gallery = new Gallery();
$gallery->set_products(['category' => $categories]);

// Set product in variable
$products = $gallery->get_products();

// Allow image tag html
$allow_html_img = ['img' => ['width' => [], 'height' => [], 'src' => [], 'alt' => [], 'loading' => []]];
?>

<script>
    if (typeof GalleryWithButton === 'undefined') {
        var GalleryWithButton = {};
    }
    GalleryWithButton.Products = <?php
    echo htmlspecialchars_decode(json_encode($products, JSON_HEX_QUOT), ENT_SUBSTITUTE | ENT_NOQUOTES);
    ?>;

</script>

<div class="wpg-gallery">
    <?php foreach ($products as $product) { ?>
        <div class='wpg-gallery-item' key=" <?php esc_attr_e($product->get_id()); ?>">
            <div class='wpg-wrap-image'> <?php echo wp_kses($product->thumbnail, $allow_html_img); ?> </div>
            <div class='gallery-item-text-content'>
                <button class="wpg-gallery-item-button"
                        onclick="GalleryButtonRequestQuote(<?php esc_attr_e($product->get_id()); ?>)"><?php esc_html_e('Request quote', 'product-gallery-with-quote-button'); ?></button>
                <div class='price'><?php echo esc_html(number_format($product->price, 2)); ?><?php echo esc_html(get_woocommerce_currency_symbol()); ?></div>
                <h2 class='title'><?php echo esc_html($product->name); ?></h2>
                <p> <?php echo esc_html($product->desc); ?> </p>
            </div>
        </div>
    <?php } ?>
</div>