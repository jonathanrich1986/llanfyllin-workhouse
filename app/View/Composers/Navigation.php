<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Navi;

class Navigation extends Composer
{
    protected static $views = ['partials.menu.*'];

    /**
     * The data to be passed to the view.
     *
     * @return void
     */
    public function with()
    {
        return [
            'navigation' => $this->getMenu(),
        ];
    }

    /**
     * Retrieve the menu items for the primary navigation.
     *
     * @return array
     */
    public function getMenu()
    {
        if (has_nav_menu('primary_navigation')) {
            return (new Navi())->build('primary_navigation')->toArray();
        }
        return [];
    }
}