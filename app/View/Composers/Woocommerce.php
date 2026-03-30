<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Woocommerce extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'woocommerce.single-product.price',
    ];

    /**
    * Retrieve the product price.
    */
    public function price(): string
    {
        global $product;

        return $product->get_price_html();
    }
}
