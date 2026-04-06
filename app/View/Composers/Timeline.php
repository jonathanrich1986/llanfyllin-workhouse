<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Timeline extends Composer
{
    protected static $views = [
        'partials.flexible.timeline',
    ];

    /**
     * The data to be passed to the view. Retrieves timeline fields from ACF.
     *
     * @return array
     */
    public function with()
    {
        $items = $this->getItems();

        
        return [
            'title' => get_sub_field('title'),
            'title_size' => get_sub_field('title_size') ?: 'medium',
            'subtitle' => get_sub_field('subtitle'),
            'content' => get_sub_field('content'),
            'items' => $items,
        ];
    }

    /**
     * Retrieves and normalizes timeline item data from ACF repeater field.
     *
     * @return array
     */
    public function getItems()
    {
        $items = get_sub_field('items') ?: [];
        return array_map(function ($item) use (&$i) {
            return [
                'title' => $item['title'] ?? '',
                'date' => $item['date'] ?? '',
                'content' => $item['content'] ?? '',
            ];
        }, $items);
    }

}