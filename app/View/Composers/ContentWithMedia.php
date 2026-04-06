<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ContentWithMedia extends Composer
{
    protected static $views = [
        'partials.flexible.content-with-media',
    ];

    /**
     * The data to be passed to the view. Retrieves content with media fields and buttons from ACF.
     *
     * @return array
     */
    public function with()
    {
        $buttons = $this->getButtons();

        return [
            'title' => get_sub_field('title'),
            'title_size' => get_sub_field('title_size') ?: 'medium',
            'subtitle' => get_sub_field('subtitle'),
            'content' => get_sub_field('content'),
            'buttons' => $buttons,
            'layout' => get_sub_field('layout') ?: 'text-left',
            'image' => get_sub_field('image') ?: null,
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