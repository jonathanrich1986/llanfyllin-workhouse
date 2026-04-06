<?php

/**
 * Theme filters.
 */

namespace App;

// Remove global styles to prevent conflicts with Tailwind CSS.
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('global-styles');
}, 100);