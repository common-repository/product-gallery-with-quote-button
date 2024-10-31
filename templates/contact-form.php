<?php
?>

<div id="gallery-with-quote-contact-form-div">
    <form method="post" id="gallery-with-quote-contact-form" enctype="multipart/form-data">
        <?php wp_nonce_field('pgwq_send_mail', 'gallery_with_quote'); ?>

        <h2><?php esc_html_e('Contact us', 'product-gallery-with-quote-button'); ?></h2>

        <div id="gallery-with-quote-message"></div>
        <input type="hidden" id="gallery-with-quote-form-name-product-id">

        <label for="gwqf-product-name"><?php esc_html_e('Product', 'product-gallery-with-quote-button'); ?>:</label>
        <div id="gwqf-product-name" class="gwqf-prod-info"></div>

        <label for="gwqf-product-desc"><?php esc_html_e('Description', 'product-gallery-with-quote-button'); ?>:</label>
        <div id="gwqf-product-desc" class="gwqf-prod-info"></div>

        <label for="gwqf-product-price"><?php esc_html_e('Price', 'product-gallery-with-quote-button'); ?>:</label>
        <div id="gwqf-product-price" class="gwqf-prod-info"></div>

        <label for="gallery"><?php esc_html_e('Name', 'product-gallery-with-quote-button'); ?></label>
        <input type="text" id="gallery-with-quote-form-name" name="gallery-with-quote-form-name"
               placeholder="<?php esc_html_e('Name', 'product-gallery-with-quote-button'); ?>">

        <label for="gallery-with-quote-form-email"><?php esc_html_e('Email', 'product-gallery-with-quote-button') ?></label>
        <input type="email" name="gallery-with-quote-form-email" id="gallery-with-quote-form-email"
               required class="email">

        <label for="gallery-with-quote-form-tel"><?php esc_html_e('Telephone', 'product-gallery-with-quote-button') ?></label>
        <input type="text" id="gallery-with-quote-form-tel" name="gallery-with-quote-form-tel"
               placeholder="+358401234567">

        <div id="msg"></div>
        <button id="gallery-with-quote-form-button"
                class="submitbtn"><?php esc_html_e('Send', 'product-gallery-with-quote-button') ?></button>
        <a id="gallery-with-quote-form-cancel"
           class="click-link"><?php esc_html_e('Cancel', 'product-gallery-with-quote-button') ?></a>

        <div class="success_msg" style="display: none">
            <?php esc_html_e('Message sent successfully', 'product-gallery-with-quote-button'); ?>
        </div>

        <div class="error_msg" style="display: none">
            <?php esc_html_e('Message not sent. Error occured.', 'product-gallery-with-quote-button'); ?>
        </div>

    </form>
</div>
