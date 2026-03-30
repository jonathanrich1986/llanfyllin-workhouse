<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class FullWidthContent extends Composer
{
    protected static $views = [
        'partials.flexible.hero',
    ];

    public function with()
    {
        return [
            'title' => get_sub_field('title'),
            'subtitle' => get_sub_field('subtitle'),
            'content' => get_sub_field('content'),
            'buttons' => get_sub_field('buttons') ?: [],
        ];
    }

}