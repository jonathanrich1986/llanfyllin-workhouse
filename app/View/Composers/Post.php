<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Post extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.page-header',
        'partials.content',
        'partials.content-*',
    ];

    /**
     * Retrieve the page layout settings for the current flexible content row.
     *
     * @return array
     */
    public function with()
    {

        $page_settings = [
            'hide_header' => get_field('hide_header') ?: false,
            'header_text_position' => get_field('header_text_position') ?: 'left',
            'header_image' => get_field('header_image') ?: null,
            'header_image_mobile' => get_field('header_image_mobile') ?: null,
            'header_text' => get_field('header_text') ?: null,
        ];

        $page_settings['header_image_classes'] = $this->generateHeaderImageClasses($page_settings);

        return [
            'title' => $this->title(),
            'pagination' => $this->pagination(),
            'page_settings' => $page_settings,
        ];

    }

    /**
     * Generate the CSS classes for the header image based on the presence of desktop and mobile images.
     *
     * @param array $page_settings The page settings containing header image information.
     * @return string A string of CSS classes to apply to the header image element.
     */
    public function generateHeaderImageClasses(array $page_settings): string
    {
        
        $classes = [];

        if ($page_settings['header_image'] || $page_settings['header_image_mobile']) {

            if ($page_settings['header_image']) {
                $classes[] = 'lg:block lg:absolute lg:inset-0 lg:aspect-auto lg:h-full';
            } else {
                $classes[] = 'lg:hidden';
            }

            if ($page_settings['header_image_mobile']) {
                $classes[] = 'aspect-square md:aspect-video';
            } else {
                $classes[] = 'hidden';
            }
        }

        return implode(' ', $classes);

    }

    /**
     * Retrieve the post title.
     */
    public function title(): string
    {
        if ($this->view->name() !== 'partials.page-header') {
            return get_the_title();
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(
                /* translators: %s is replaced with the search query */
                __('Search Results for %s', 'sage'),
                get_search_query()
            );
        }

        if (is_404()) {
            return __('Not Found', 'sage');
        }

        return get_the_title();
    }

    /**
     * Retrieve the pagination links.
     */
    public function pagination(): string
    {
        return wp_link_pages([
            'echo' => 0,
            'before' => '<p>'.__('Pages:', 'sage'),
            'after' => '</p>',
        ]);
    }
}
