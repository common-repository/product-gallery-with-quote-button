<div class="wrap">
    <form method="post" action="options.php">
        <?php
        add_settings_section("quote_categories", "Settings for Quote Gallery",
            array($this, "display_quote_gallery_settings"), $this->page);
        settings_fields($this->page);
        do_settings_sections($this->page);
        submit_button();
        ?>
    </form>
</div>