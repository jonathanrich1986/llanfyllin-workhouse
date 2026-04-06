<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Quote extends Composer
{
    protected static $views = [
        'partials.flexible.quote',
    ];

    public function with()
    {
        return [
            'quote' => get_sub_field('quote') ?? '',
            'source' => get_sub_field('source') ?? '',
        ];
    }

}