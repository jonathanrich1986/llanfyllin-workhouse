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
            'title' => get_sub_field('title') ?? '',
            'titleSize' => get_sub_field('title_size') ?? 'medium',
            'subtitle' => get_sub_field('subtitle') ?? '',
            'content' => get_sub_field('content') ?? '',
            'buttons' => $this->getButtons(),
        ];
    }

    /**
     * Retrieves and normalizes button data from ACF repeater field.
     *
     * @return array
     */
    public function getButtons()
    {
        $buttons = get_sub_field('buttons') ?: [];
        return array_map(function ($button) {
            return [
                'content' => $button['text'] ?? '',
                'url' => $button['link'] ?? '#',
                'colour' => $button['colour'] ?? 'primary',
                'style' => $button['style'] ?? 'solid',
                'size' => $button['size'] ?? 'medium',
            ];
        }, $buttons);
    }

}