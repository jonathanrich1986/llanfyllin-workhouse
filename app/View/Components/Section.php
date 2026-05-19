<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Section extends Component
{

    /**
     * Additional CSS classes for the outer section element.
     *
     * @var string|null
     */
    public ?string $class;

    /**
     * Additional CSS classes for the inner container element.
     *
     * @var string|null
     */
    public ?string $innerClass;

    /**
     * Inline styles for the outer section element.
     *
     * @var string|null
     */
    public ?string $style;

    /**
     * Whether to apply prose typography styles to the inner container.
     *
     * @var bool|null
     */
    public ?bool $useProse;

    public ?string $backgroundColour;
    public ?string $textColour;
    public ?string $contentPosition;
    public ?string $contentWidth;
    public ?bool $boxedLayout;
    public ?string $height;
    public ?string $customCss;
    public ?string $customClasses;
    public ?string $layoutId;
    public ?string $paddingTop;
    public ?string $paddingBottom;
    public ?string $marginTop;
    public ?string $marginBottom;

    public $backgroundImage;
    public $backgroundImageMobile;
    public ?bool $keepBgBehindContentOnMobile;

    /**
     * Create the component instance.
     *
     * @param string      $class                 Additional classes for the outer <section> element.
     * @param string      $innerClass           Additional classes for the inner container element.
     * @param string      $style                 Inline styles for the outer <section> element.
     * @param bool        $useProse             Whether to enable prose typography on the inner container.
     * @param bool|null   $boxedLayout          Wrap content in a padded, rounded box.
     * @param string|null $contentWidth         Content width: 'narrow', 'thin', 'default', or null for full width.
     * @param string|null $height               Section height: 'default', 'hero', 'full'
     * @param string|null $backgroundColour     Background colour: 'primary', 'secondary', 'tertiary', 'light_grey', 'dark_grey', 'black', or 'white'.
     * @param string|null $textColour           Text colour: 'automatic', 'light', 'dark', or null for automatic based on background.
     * @param string|null $contentPosition      Content alignment: 'top', 'centre', 'bottom', 'left', 'right', 'top_left', 'top_right', 'bottom_left', or 'bottom_right'.
     * @param int|null    $backgroundImage      
     * @param int|null    $backgroundImageMobile
     * @param string|null $customCss            Custom CSS scoped to this section.
     * @param string|null $customClasses        Additional custom classes for the section.
     * @param string|null $layoutId             HTML id attribute for the section.
     * @param string|null $paddingTop           Custom top padding: 'default', 'small', 'large', 'none', or null for default.
     * @param string|null $paddingBottom        Custom bottom padding: 'default', 'small', 'large', 'none', or null for default.
     * @param string|null $marginTop            Custom top margin: 'default', 'small', 'large', 'none', or null for default.
     * @param string|null $marginBottom         Custom bottom margin: 'default', 'small', 'large', 'none', or null for default.
     * @param bool|null   $keepBgBehindContentOnMobile Whether to keep the background image behind content on mobile when a mobile-specific image is set.
     */
    public function __construct(
        ?string $class = null,
        ?string $innerClass = null,
        ?string $style = null,
        ?bool $useProse = null,
        ?bool $boxedLayout = null,
        ?string $contentWidth = null,
        ?string $height = null,
        ?string $backgroundColour = null,
        ?string $textColour = null,
        ?string $contentPosition = null,
        ?int $backgroundImage = null,
        ?int $backgroundImageMobile = null,
        ?string $customCss = null,
        ?string $customClasses = null,
        ?string $layoutId = null,
        ?string $paddingTop = null,
        ?string $paddingBottom = null,
        ?string $marginTop = null,
        ?string $marginBottom = null,
        ?bool $keepBgBehindContentOnMobile = null,
    ) {
        $this->class = $class;
        $this->innerClass = $innerClass;
        $this->style = $style;
        $this->useProse = $useProse;
        $this->boxedLayout = $boxedLayout;
        $this->contentWidth = $contentWidth;
        $this->backgroundColour = $backgroundColour;
        $this->contentPosition = $contentPosition;
        $this->height = $height;
        $this->backgroundImage = $backgroundImage;
        $this->backgroundImageMobile = $backgroundImageMobile;
        $this->customCss = $customCss;
        $this->customClasses = $customClasses;
        $this->textColour = $textColour;
        $this->layoutId = $layoutId;
        $this->paddingTop = $paddingTop;
        $this->paddingBottom = $paddingBottom;
        $this->marginTop = $marginTop;
        $this->marginBottom = $marginBottom;
        $this->keepBgBehindContentOnMobile = $keepBgBehindContentOnMobile;
    
        $this->setAcfSectionSettings();
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
     * Maybe populate from ACF fields
     *
     * @return void
     */
    protected function setAcfSectionSettings(): void
    {
        $row = get_row(true);

        if (! $row) {
            return;
        }

        foreach ($row as $key => $value) {
            if (strpos($key, 'layout_settings_') === 0) {
                $setting_key = str_replace('layout_settings_', '', $key);
                $setting_key = wr_camel_case($setting_key);
                $this->$setting_key = $this->$setting_key ?? $value;
            }
        }

    }

    /**
     * Map the background_colour setting to a Tailwind CSS class.
     *
     * @return string
     */
    public function getBackgroundColourClass(): string
    {

        $bg_colour = $this->backgroundColour ?? null;
        $is_boxed  = $this->boxedLayout ?? false;
        $has_image = $this->backgroundImage;

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
     * Get the CSS classes for the background gradient overlay if a background image is set.
     *
     * @return string
     */
    public function getBackgroundGradientClass(): string {

        $classes = array();
        $has_image = $this->backgroundImage;
        $has_bg_colour = $this->backgroundColour;
        $is_boxed = $this->boxedLayout;

        if ($has_image && (!$is_boxed || !$has_bg_colour && $is_boxed)) {
            $classes[] = 'text-shadow-lg/20 before:absolute before:inset-0 before:z-10 before:from-30% before:to-70%';

            if (!$this->hasDarkBackground()) {
                $classes[] = 'text-shadow-white/20';
            }

            // Gradient direction based on content position
            $classes[] = match ($this->contentPosition) {
                'top' => 'before:bg-gradient-to-b',
                'centre' => 'before:bg-gradient-to-b',
                'bottom' => 'before:bg-gradient-to-t',
                'left' => 'before:bg-gradient-to-r',
                'right' => 'before:bg-gradient-to-l',
                'top_left' => 'before:bg-gradient-to-br',
                'top_right' => 'before:bg-gradient-to-bl',
                'bottom_left' => 'before:bg-gradient-to-tr',
                'bottom_right' => 'before:bg-gradient-to-tl',
                default => 'before:bg-gradient-to-t',
            };

            // Gradient colour based on background colour
            $classes[] = match ($this->backgroundColour) {
                'primary' => 'before:from-primary/80 before:to-primary/0',
                'secondary' => 'before:from-secondary/80 before:to-secondary/0',
                'tertiary' => 'before:from-tertiary/80 before:to-tertiary/0',
                'light_grey' => 'before:from-light-grey/80 before:to-light-grey/0',
                'dark_grey' => 'before:from-dark-grey/80 before:to-dark-grey/0',
                'black' => 'before:from-black/80 before:to-black/0',
                'white' => 'before:from-white/80 before:to-white/0',
                default => 'before:from-black/80 before:to-black/0',
            };
        }

        return implode(' ', $classes);

    }

    /**
     * Determine whether the background colour is a dark variant.
     *
     * @return bool
     */
    public function hasDarkBackground(): bool
    {
        $bg_colour = $this->backgroundColour ?? null;
        $text_colour = $this->textColour ?? null;
        $output = in_array($bg_colour, ['primary', 'secondary', 'tertiary', 'dark_grey', 'black']);

        if (strpos($this->customClasses, 'is-dark') !== false) {
            $output = true;
        }

        if ($text_colour === 'dark') {
            $output = false;
        } else if ($text_colour === 'light') {
            $output = true;
        }

        return $output;
    }

    /**
     * Process and optionally scope the custom CSS to the section's ID.
     *
     * @return string
     */
    public function getCustomCss(): string
    {
        if (!$this->customCss) {
            return '';
        }

        // Strip any malicious tags
        $css = wp_strip_all_tags($this->customCss);

        // If an ID is set, wrap the CSS to scope it
        if ($this->layoutId) {
            $id = sanitize_title($this->layoutId);
            return "#$id { $css }";
        }

        return $css;
    }
}
