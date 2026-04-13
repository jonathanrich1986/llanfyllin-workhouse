<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Grid extends Composer
{
    protected static $views = [
        'partials.flexible.grid',
    ];

    public function with()
    {

        $type = get_sub_field('type') ?? 'custom';

        return [
            'title' => get_sub_field('title') ?? '',
            'titleSize' => get_sub_field('title_size') ?? 'medium',
            'subtitle' => get_sub_field('subtitle') ?? '',
            'content' => get_sub_field('content') ?? '',
            'type' => $type,
            'box_template' => get_sub_field('box_template') ?? 'default',
            'boxes' => $this->getBoxes($type),
        ];
    }

    /**
     * Retrieves and normalizes box data based on the selected type (custom or posts).
     *
     * @param string $type The type of boxes to retrieve (custom or posts).
     * @return array An array of boxes with normalized data for rendering.
     */
    protected function getBoxes(string $type): array
    {
        $boxes = [];
        
        switch ($type) {
            case 'custom':
                while (have_rows('custom_boxes')) {
                    the_row();
                    $boxes[] = [
                        'icon' => get_sub_field('icon') ? wr_icon(get_sub_field('icon')) : null,
                        'title' => get_sub_field('title') ?: '',
                        'content' => get_sub_field('content') ?: '',
                        'url' => get_sub_field('url') ?: '#',
                        'image' => get_sub_field('image') ?: null,
                    ];
                }
                break;
            case 'posts':
                $posts = get_sub_field('posts') ?: [];
                foreach ($posts as $post) {
                    $boxes[] = [
                        'icon' => null,
                        'title' => get_the_title($post),
                        'content' => get_the_excerpt($post),
                        'url' => get_permalink($post),
                        'image' => get_the_post_thumbnail_url($post, 'medium_large') ?: null,
                    ];
                }
                break;
        }

        return $boxes;
    }

}