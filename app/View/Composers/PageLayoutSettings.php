<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PageLayoutSettings extends Composer
{
    /**
     * List of views served by this composer.
     */
    protected static $views = [
        'partials.flexible.*',
    ];

    /**
     * Retrieve the page layout settings for the current flexible content row.
     *
     * @return array
     */
    public function with()
    {
        $row = get_row(true) ?: [];
        $layout_settings = [];
        $layout_index = get_row_index();

        foreach($row as $key => $value) {
            if (strpos($key, 'layout_settings_') === 0) {
                $setting_key = str_replace('layout_settings_', '', $key);
                $layout_settings[$setting_key] = $value;
            }
        }

        $default_settings = [
            'background_colour' => null,
            'background_image' => null,
            'background_image_mobile' => null,
            'boxed_layout' => false,
            'content_width' => null, // full_width, default, thin, narrow
            'content_position' => null, // top, center, bottom
            'custom_css' => null,
            'disable_layout' => false,
            'layout_id' => null,
            'layout_index' => $layout_index,
        ];
        $settings = wp_parse_args($layout_settings, $default_settings);

        return [
            'fields' => $row,
            'section_settings' => $this->getSectionSettings($settings),
            'disable_layout' => $settings['disable_layout'] ?? false,
            'layout_index' => $settings['layout_index'] ?? null,
        ];
    }

    /**
     * Normalize the layout settings into a consistent format for use in views.
     *
     * @param array $settings
     * @return array
     */
    protected function getSectionSettings(array $settings): array
    {
        $background_image = $settings['background_image'] ?? null;
        if (is_array($background_image) && !empty($background_image['url'])) {
            $settings['background_image'] = wp_get_attachment_image($background_image['id'], 'full', false, ['class' => 'w-full h-full object-cover']);
        }

        return [
            'class' => $this->generateClasses($settings)['wrapper_classes'],
            'inner_class' => $this->generateClasses($settings)['inner_classes'],
            'style' => $this->generateStyle($settings),
            'id' => sanitize_title($settings['layout_id'] ?? null),
            'background_image' => $settings['background_image'] ?? null,
            'background_image_mobile' => $settings['background_image_mobile'] ?? null,
            'custom_css' => $this->getCustomCss($settings),
        ];

    }

    /**
     * Generate the CSS class attribute based on the layout settings.
     *
     * @return array
     */
    protected function generateClasses(array $settings): array {
        $wrapper_classes = ['flex', 'group/layout'];
        $inner_classes = [
            $this->getContentWidthClass($settings),
            'mx-0!',
        ];

        if ($settings['boxed_layout']) {
            $inner_classes[] = 'boxed-layout mx-auto relative p-12! rounded-2xl';
            $wrapper_classes[] = 'py-20';

            // Background colour
            if ($settings['background_colour']) {
                $inner_classes[] = $this->getBackgroundClass($settings);
            }

        } else if ($settings['background_colour']) {
            $wrapper_classes[] = $this->getBackgroundClass($settings);
        }

        if ($this->hasDarkBackground($settings)) {
            $wrapper_classes[] = 'is-dark';
            $inner_classes[] = 'prose-invert';
        }

        // Add content position classes
        if (isset($settings['content_position'])) {
            switch ($settings['content_position']) {
                case 'top':
                    $wrapper_classes[] = 'items-start justify-center';
                    break;
                case 'centre':
                    $wrapper_classes[] = 'items-center justify-center';
                    break;
                case 'bottom':
                    $wrapper_classes[] = 'items-end justify-center';
                    break;
                case 'left':
                    $wrapper_classes[] = 'justify-start';
                    break;
                case 'right':
                    $wrapper_classes[] = 'justify-end';
                    break;
                case 'top_left':
                    $wrapper_classes[] = 'items-start justify-start';
                    break;
                case 'top_right':
                    $wrapper_classes[] = 'items-start justify-end';
                    break;
                case 'bottom_left':
                    $wrapper_classes[] = 'items-end justify-start';
                    break;
                case 'bottom_right':
                    $wrapper_classes[] = 'items-end justify-end';
                    break;
                default:
                    $wrapper_classes[] = 'items-center';
            }
        }

        // Use standard implode if wr_esc_atts is a custom helper not available
        return [
            'wrapper_classes' => implode(' ', $wrapper_classes),
            'inner_classes' => implode(' ', $inner_classes),
        ];
    }

    /**
     * Map the background_colour setting to a Tailwind CSS class.
     *
     * @param array $settings
     * @return string
     */
    protected function getBackgroundClass(array $settings): string
    {
        $bg_colour = $settings['background_colour'] ?? null;
        $is_boxed = $settings['boxed_layout'] ?? false;
        $has_image = isset($settings['background_image']) && $settings['background_image'];
        if ($bg_colour) {
            switch ($bg_colour) {
                case 'primary':
                    return $is_boxed && $has_image ? 'bg-primary/70 backdrop-blur-sm' : 'bg-primary';
                case 'secondary':
                    return $is_boxed && $has_image ? 'bg-secondary/70 backdrop-blur-sm' : 'bg-secondary';
                case 'tertiary':
                    return $is_boxed && $has_image ? 'bg-tertiary/70 backdrop-blur-sm' : 'bg-tertiary';
                case 'light_grey':
                    return $is_boxed && $has_image ? 'bg-light-grey/70 backdrop-blur-sm' : 'bg-light-grey';
                case 'dark_grey':
                    return $is_boxed && $has_image ? 'bg-dark-grey/70 backdrop-blur-sm' : 'bg-dark-grey';
                case 'black':
                    return $is_boxed && $has_image ? 'bg-black/70 backdrop-blur-sm' : 'bg-black';
                case 'white':
                    return $is_boxed && $has_image ? 'bg-white/70 backdrop-blur-sm' : 'bg-white';
                default:
                    // For custom colors, we can add a class or handle it via inline styles
                    return '';
            }
        }
        return '';
    }

    /**
     * Determine if the background colour is one of the darker options.
     *
     * @param array $settings
     * @return bool
     */
    protected function hasDarkBackground(array $settings): bool
    {
        $bg_colour = $settings['background_colour'] ?? null;
        return in_array($bg_colour, ['primary', 'secondary', 'tertiary', 'dark_grey', 'black']);
    }

    /**
     * Build the inline CSS style string.
     */
    protected function generateStyle(array $settings): string 
    {
        return '';
    }

    /**
     * Map the content_width setting to a Tailwind CSS class.
     *
     * @param array $settings
     * @return string
     */
    protected function getContentWidthClass(array $settings): string
    {
        $content_width = $settings['content_width'] ?? null;
        if ($content_width) {
            switch ($content_width) {
                case 'narrow':
                    return 'max-w-2xl';
                case 'thin':
                    return 'max-w-4xl';
                case 'default':
                    return 'max-w-6xl';
                default:
                    return 'max-w-none';
            }
        }
        return '';
    }

    /**
     * Get the custom css
     *
     * @param array $settings
     * @return string
     */
    protected function getCustomCss(array $settings): string
    {
        $custom_css = $settings['custom_css'] ?? null;
        $output = '';

        if ($custom_css) {

            $output = wp_strip_all_tags($custom_css);

            // If the layout has an ID, scope the custom CSS to that ID to prevent it affecting other sections
            if (isset($settings['layout_id']) && $settings['layout_id']) {
                $id = sanitize_title($settings['layout_id']);
                $output = "#$id { $output }";
            }

        }
        
        return $output;
    }
}