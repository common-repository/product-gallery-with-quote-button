<?php

namespace ProductGalleryWithQuoteButton\Modules\Product;

/**
 * Product is a class for products and their details
 */
class Product
{
    public $id;
    public $name = '';
    public $desc = '';
    public $price = 0.0;
    public $thumbnail;

    /**
     * @param object $product
     */
    public function __construct($product)
    {
        $this->id = (int)$product->id;
        $this->name = filter_var($product->name, FILTER_SANITIZE_STRING);
        $this->price = (float)$product->price;
        $this->desc = filter_var($product->description, FILTER_SANITIZE_STRING);
        $this->thumbnail = $product->get_image(); // image in img tag
    }

    /**
     * Get product id
     *
     * @return int
     */
    public function get_id(): int
    {
        return $this->id;
    }

    /**
     * Set product's name
     *
     * @param string $name
     *
     * @return void
     */
    public function set_name(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Set product's description
     *
     * @param string $desc Product's description
     *
     * @return void
     */
    public function set_desc(string $desc): void
    {
        $this->desc = $desc;
    }

    /**
     * Set product's price
     *
     * @param float $price Product's price
     *
     * @return void
     */
    public function set_price(float $price): void
    {
        $this->price = $price;
    }
}