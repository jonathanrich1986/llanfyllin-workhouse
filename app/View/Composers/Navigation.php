<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Navi;

class Navigation extends Composer
{
    protected static $views = [
        'partials.menu.*',
        'partials.menu-mobile.*',
        'partials.menu-footer.*',
    ];

    /**
     * The data to be passed to the view.
     *
     * @return void
     */
    public function with()
    {
        return [
            'navigation' => $this->getMenu(),
            'mobileMenu' => $this->getMenu('mobile_navigation'),
            'footerMenu' => $this->getMenu('footer_navigation'),
        ];
    }

    /**
     * Retrieve the menu items for the specified navigation location.
     *
     * @param string $location The navigation location (default: 'primary_navigation').
     * @return array
     */
    public function getMenu($location = 'primary_navigation')
    {
        if (has_nav_menu($location)) {
            return (new Navi())->build($location)->toArray();
        }
        return [];
    }
}