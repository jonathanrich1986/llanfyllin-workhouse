<?php

namespace App\View\Components\Shortcodes;

use Illuminate\View\Component;

class MembershipForm extends Component
{
    /** @var \WC_Product[] */
    public array $products = [];
    
    public function __construct() {
        $this->products = $this->getMembershipProducts();
        $test = 1;
    }

    public function render()
    {
        return view('components.shortcodes.membership-form');
    }

    public function getMembershipProducts() {

      // Check if WooCommerce is active to prevent fatal errors
      if (!function_exists('wc_get_products')) {
        return [];
      }

      return wc_get_products( [
        'status' => 'publish',
        'tag' => ['membership'], // Using array is safer for tags
        'limit' => -1,
        'order' => 'ASC',
        'orderby' => 'post_date',
      ] );
    }
}