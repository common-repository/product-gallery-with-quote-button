jQuery(document).ready(function () {
    jQuery("#gallery-with-quote-form-button").click(function (event) {
        event.preventDefault();
        let product_id = parseInt(jQuery("#gallery-with-quote-form-name-product-id").val());
        let elem_name = jQuery("#gallery-with-quote-form-name").val();
        let elem_tel = jQuery("#gallery-with-quote-form-tel").val();
        let elem_email = jQuery("#gallery-with-quote-form-email").val();
        let elem_nonce = jQuery("#gallery_with_quote").val();

        if (isNaN(product_id) === true) {
            console.log("Cannot find product id from form.")
            return;
        }

        let name = (typeof elem_name === 'undefined') ? "" : elem_name;
        let tel = (typeof elem_tel === 'undefined') ? "" : elem_tel;
        let email = (typeof elem_email === 'undefined') ? "" : elem_email;
        let nonce = (typeof elem_nonce === 'undefined') ? "" : elem_nonce;

        let data = {
            action: 'pgwq_mail',
            product_id: product_id,
            name: name,
            tel: tel,
            email: email,
            gallery_quote_nonce: nonce,
        };

        jQuery.post(GalleryWithButton.ajax_url, data, function (response) {
            console.log(response);
        });

        let form = jQuery("#gallery-with-quote-contact-form-div");
        form.hide();
    });

    jQuery("#gallery-with-quote-form-cancel").click(function (event) {
        event.preventDefault();
        let form = jQuery("#gallery-with-quote-contact-form-div");
        form.hide();
    })
});

function GalleryButtonRequestQuote(id) {
    jQuery('#gallery-with-quote-form-name-product-id').val(id);
    let product = GalleryWithButton.Products.filter(p => p.id === Number(id))[0];
    let product_name = document.getElementById('gwqf-product-name');
    let product_desc = document.getElementById('gwqf-product-desc');
    let product_price = document.getElementById('gwqf-product-price');
    let form = jQuery("#gallery-with-quote-contact-form-div");
    product_name.textContent = product.name.replace('&#34;', '"');
    product_desc.textContent = product.desc.replace('&#34;', '"');
    product_price.textContent = product.price;
    form.show();
}