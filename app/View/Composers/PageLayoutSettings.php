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
        $default_settings = [
            'disable_layout' => false,
            'boxed_layout' => false,
            'background_colour' => null,
            'background_image' => null,
            'layout_id' => null,
        ];
        $settings = wp_parse_args($row['layout_settings'] ?? [], $default_settings);

        return [
            'fields' => $row,
            'section_settings' => $this->getSectionSettings($settings),
            'disable_layout' => $settings['disable_layout'] ?? false,
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
        return [
            'class' => $this->generateClass($settings),
            'inner_class' => '',
            'style' => $this->generateStyle($settings),
            'id' => sanitize_title($settings['layout_id'] ?? null),
        ];

    }

    /**
     * Generate the CSS class attribute based on the layout settings.
     *
     * @return string
     */
    protected function generateClass(array $settings): string {
        $classes = [];

        if (!empty($settings['boxed_layout'])) {
            $classes[] = 'boxed-layout';
        }

        // Background colour
        if (!empty($settings['background_colour'])) {
            switch ($settings['background_colour']) {
                case 'primary':
                    $classes[] = 'bg-primary';
                    break;
                case 'secondary':
                    $classes[] = 'bg-secondary';
                    break;
                case 'tertiary':
                    $classes[] = 'bg-tertiary';
                    break;
                case 'light_grey':
                    $classes[] = 'bg-light-grey';
                    break;
                default:
                    // For custom colors, we can add a class or handle it via inline styles
                    break;
            }
        }

        // Use standard implode if wr_esc_atts is a custom helper not available
        return implode(' ', $classes);
    }

    /**
     * Build the inline CSS style string.
     */
    protected function generateStyle(array $settings): string 
    {
        $styles = [];

        if ($bg_color = $settings['background_colour'] ?? null) {
            $styles[] = "background-color: {$bg_color}";
        }

        if ($bg_image = $settings['background_image']['url'] ?? null) {
            $styles[] = "background-image: url('{$bg_image}')";
        }

        return !empty($styles) ? implode('; ', $styles) . ';' : '';
    }
}