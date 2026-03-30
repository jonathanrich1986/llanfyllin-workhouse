<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class FullWidthContent extends Composer
{
    protected static $views = [
        'partials.flexible.full-width-content',
    ];

    public function with()
    {
        return [
            'title' => get_sub_field('title'),
            'subtitle' => get_sub_field('subtitle'),
            'content' => get_sub_field('content'),
        ];
    }

}