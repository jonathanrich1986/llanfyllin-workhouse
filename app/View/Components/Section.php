<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Section extends Component
{
    /**
     * The computed section settings used by the template.
     *
     * @var array
     */
    public array $section_settings;

    /**
     * Additional CSS classes for the outer section element.
     *
     * @var string
     */
    public string $class;

    /**
     * Additional CSS classes for the inner container element.
     *
     * @var string
     */
    public string $inner_class;

    /**
     * Inline styles for the outer section element.
     *
     * @var string
     */
    public string $style;

    /**
     * Whether to apply prose typography styles to the inner container.
     *
     * @var bool
     */
    public bool $use_prose;

    /**
     * Create the component instance.
     *
     * Individual setting parameters (boxed_layout, content_width, etc.) take
     * precedence over the equivalent computed values in section_settings,
     * allowing the component to be used both within the ACF flexible content
     * loop (via section_settings) and manually (via direct parameters).
     *
     * @param array       $section_settings      Pre-computed settings from the ACF flexible content composer.
     * @param string      $class                 Additional classes for the outer <section> element.
     * @param string      $inner_class           Additional classes for the inner container element.
     * @param string      $style                 Inline styles for the outer <section> element.
     * @param bool        $use_prose             Whether to enable prose typography on the inner container.
     * @param bool|null   $boxed_layout          Wrap content in a padded, rounded box.
     * @param string|null $content_width         Content width: 'narrow', 'thin', 'default', or null for full width.
     * @param string|null $background_colour     Background colour: 'primary', 'secondary', 'tertiary', 'light_grey', 'dark_grey', 'black', or 'white'.
     * @param string|null $content_position      Content alignment: 'top', 'centre', 'bottom', 'left', 'right', 'top_left', 'top_right', 'bottom_left', or 'bottom_right'.
     * @param mixed       $background_image      Desktop background image: ACF image array, attachment ID, or pre-rendered HTML string.
     * @param mixed       $background_image_mobile Mobile background image: ACF image array, attachment ID, or pre-rendered HTML string.
     * @param string|null $custom_css            Custom CSS scoped to this section.
     * @param string|null $layout_id             HTML id attribute for the section.
     */
    public function __construct(
        array $section_settings = [],
        string $class = '',
        string $inner_class = '',
        string $style = '',
        bool $use_prose = false,
        ?bool $boxed_layout = null,
        ?string $content_width = null,
        ?string $background_colour = null,
        ?string $content_position = null,
        $background_image = null,
        $background_image_mobile = null,
        ?string $custom_css = null,
        ?string $layout_id = null,
    ) {
        $this->class = $class;
        $this->inner_class = $inner_class;
        $this->style = $style;
        $this->use_prose = $use_prose;

        // Collect individual params that were explicitly provided (non-null).
        $overrides = array_filter([
            'boxed_layout'            => $boxed_layout,
            'content_width'           => $content_width,
            'background_colour'       => $background_colour,
            'content_position'        => $content_position,
            'background_image'        => $background_image,
            'background_image_mobile' => $background_image_mobile,
            'custom_css'              => $custom_css,
            'layout_id'               => $layout_id,
        ], fn ($v) => !is_null($v));

        if (!empty($overrides)) {
            $defaults = [
                'background_colour'       => null,
                'background_image'        => null,
                'background_image_mobile' => null,
                'boxed_layout'            => false,
                'content_width'           => null,
                'content_position'        => null,
                'custom_css'              => null,
                'disable_layout'          => false,
                'layout_id'               => null,
                'layout_index'            => null,
            ];

            $raw_settings = array_merge($defaults, $overrides);
            $computed = $this->getSectionSettings($raw_settings);

            // Individual params take precedence over anything in section_settings.
            $this->section_settings = array_merge($section_settings, $computed);
        } else {
            $this->section_settings = $section_settings;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return $this->view('components.section');
    }

    /**
     * Normalise raw layout settings into the format consumed by the template.
     *
     * @param array $settings
     * @return array
     */
    protected function getSectionSettings(array $settings): array
    {
        $background_image = $settings['background_image'] ?? null;
        if (is_array($background_image) && !empty($background_image['url'])) {
            $settings['background_image'] = wp_get_attachment_image(
                $background_image['id'],
                'full',
                false,
                ['class' => 'w-full h-full object-cover']
            );
        } elseif (is_int($background_image)) {
            $settings['background_image'] = wp_get_attachment_image(
                $background_image,
                'full',
                false,
                ['class' => 'w-full h-full object-cover']
            );
        }

        $classes = $this->generateClasses($settings);

        return [
            'class'                   => $classes['wrapper_classes'],
            'inner_class'             => $classes['inner_classes'],
            'style'                   => $this->generateStyle($settings),
            'id'                      => sanitize_title($settings['layout_id'] ?? null),
            'background_image'        => $settings['background_image'] ?? null,
            'background_image_mobile' => $settings['background_image_mobile'] ?? null,
            'custom_css'              => $this->getCustomCss($settings),
        ];
    }

    /**
     * Generate wrapper and inner CSS classes from the raw settings array.
     *
     * @param array $settings
     * @return array{wrapper_classes: string, inner_classes: string}
     */
    protected function generateClasses(array $settings): array
    {
        $wrapper_classes = ['flex', 'group/layout'];
        $inner_classes = [
            $this->getContentWidthClass($settings),
            'mx-0!',
        ];

        if ($settings['boxed_layout']) {
            $inner_classes[] = 'boxed-layout mx-auto relative p-12! rounded-2xl';
            $wrapper_classes[] = 'py-20';

            if ($settings['background_colour']) {
                $inner_classes[] = $this->getBackgroundClass($settings);
            }
        } elseif ($settings['background_colour']) {
            $wrapper_classes[] = $this->getBackgroundClass($settings);
        }

        if ($this->hasDarkBackground($settings)) {
            $wrapper_classes[] = 'is-dark';
            $inner_classes[] = 'prose-invert';
        }

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

        return [
            'wrapper_classes' => implode(' ', $wrapper_classes),
            'inner_classes'   => implode(' ', $inner_classes),
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
        $is_boxed  = $settings['boxed_layout'] ?? false;
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
                    return '';
            }
        }

        return '';
    }

    /**
     * Determine whether the background colour is a dark variant.
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
     *
     * @param array $settings
     * @return string
     */
    protected function generateStyle(array $settings): string
    {
        return '';
    }

    /**
     * Map the content_width setting to a Tailwind max-width class.
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
     * Process and optionally scope the custom CSS to the section's ID.
     *
     * @param array $settings
     * @return string
     */
    protected function getCustomCss(array $settings): string
    {
        $custom_css = $settings['custom_css'] ?? null;
        $output     = '';

        if ($custom_css) {
            $output = wp_strip_all_tags($custom_css);

            if (isset($settings['layout_id']) && $settings['layout_id']) {
                $id     = sanitize_title($settings['layout_id']);
                $output = "#$id { $output }";
            }
        }

        return $output;
    }
}
