<?php
namespace App;

use Illuminate\Support\Facades\Blade;

$shortcodes = [
  'button' => [
    'description' => 'Button',
    'has_content' => true,
    'atts' => [
      'url' => [
        'description' => 'Button URL',
        'type' => 'url',
        'default' => '#',
      ],
      'colour' => [
        'description' => 'Button colour',
        'type' => 'enum',
        'options' => wr_get_button_colours(),
      ],
      'style' => [
        'description' => 'Button style',
        'type' => 'enum',
        'options' => wr_get_button_styles(),
      ],
      'size' => [
        'description' => 'Button size',
        'type' => 'enum',
        'options' => [
          'small' => 'Small',
          'medium' => 'Medium',
          'large' => 'Large',
        ],
      ],
      'with_arrow' => [
        'description' => 'Show an arrow on the button',
        'type' => 'bool',
      ],
    ],
  ],
  'em' => [
    'description' => 'Highlight text',
    'has_content' => true,
    'atts' => [
      'size' => [
        'description' => 'Text size',
        'type' => 'enum',
        'options' => [
          'small' => 'Small',
          'medium' => 'Medium',
          'large' => 'Large',
        ],
        'default' => 'medium',
      ],
      'weight' => [
        'description' => 'Text weight',
        'type' => 'enum',
        'options' => [
          'thin' => 'Thin',
          'normal' => 'Normal',
          'bold' => 'Bold',
        ],
        'default' => 'normal',
      ],
    ],
  ],
  'heading' => [
    'description' => 'Heading',
    'has_content' => true,
    'atts' => [
      'size' => [
        'description' => 'Heading size',
        'type' => 'enum',
        'options' => [
          'small' => 'small',
          'medium' => 'medium',
          'large' => 'large',
          'xl' => 'xl',
          '2xl' => '2xl',
        ],
      ],
      'tag' => [
        'description' => 'Heading tag',
        'type' => 'enum',
        'options' => [
          'h1' => 'H1',
          'h2' => 'H2',
          'h3' => 'H3',
          'h4' => 'H4',
          'h5' => 'H5',
          'h6' => 'H6',
        ],
      ],
      'divider' => [
        'description' => 'Show a divider under the heading',
        'type' => 'bool',
      ],
      'align' => [
        'description' => 'Heading alignment',
        'type' => 'enum',
        'options' => [
          'left' => 'Left',
          'centre' => 'Centre',
          'right' => 'Right',
        ],
      ],
    ],
  ],
  'list' => [
    'description' => 'List',
    'has_content' => true,
    'atts' => [
      'icon' => [
        'description' => 'Icon',
        'type' => 'string',
        'default' => 'check',
      ],
      'columns' => [
        'description' => 'Columns',
        'type' => 'int',
        'default' => 1,
      ],
      'column_width' => [
        'description' => 'Column width',
        'type' => 'enum',
        'options' => [
          'small' => 'small',
          'medium' => 'medium',
          'large' => 'large',
        ],
        'default' => 'auto',
      ]
    ],
  ],
  'phone' => [
    'description' => 'Phone number',
    'has_content' => false,
    'atts' => [],
  ],
  'email' => [
    'description' => 'Email address',
    'has_content' => false,
    'atts' => [],
  ],
  'social_pages' => [
    'description' => 'Social pages',
    'has_content' => false,
    'atts' => [
      'prefix' => [
        'description' => 'Prefix',
        'type' => 'string',
        'default' => '',
      ],
      'align' => [
        'description' => 'Align',
        'type' => 'enum',
        'options' => [
          'none' => 'none',
          'left' => 'left',
          'centre' => 'centre',
          'right' => 'right'
        ]
      ]
    ],
  ],
  'lead_paragraph' => [
    'description' => 'Lead paragraph',
    'has_content' => true,
    'atts' => [],
  ],
  'size' => [
    'description' => 'Size',
    'has_content' => true,
    'atts' => [
      'size' => [
        'description' => 'Size',
        'type' => 'enum',
        'options' => [
          'small' => 'small',
          'medium' => 'medium',
          'large' => 'large',
          'xl' => 'xl',
        ],
        'default' => 'small',
      ],
    ],
  ],
  'logo' => [
    'description' => 'Company logo',
    'has_content' => false,
    'atts' => [
      'size' => [
        'description' => 'Logo size',
        'type' => 'enum',
        'options' => [
          'small' => 'small',
          'medium' => 'medium',
          'large' => 'large',
          'xl' => 'xl',
        ],
      ],
      'type' => [
        'description' => 'Logo type',
        'type' => 'enum',
        'options' => [
          'default' => 'default'
        ],
      ],
      'align' => [
        'description' => 'Image alignment',
        'type' => 'enum',
        'options' => [
          'left' => 'left',
          'centre' => 'centre',
          'right' => 'right'
        ],
      ],
    ]
  ],
  'membership_form' => [
    'description' => 'Membership form',
    'has_content' => false,
    'atts' => []
  ],
];

/**
 * Register Shortcodes from the config array
 */
collect($shortcodes)->each(function ($config, $name) {
    add_shortcode($name, function ($atts, $content = null) use ($name, $config) {
        
        $defaults = collect($config['atts'])->mapWithKeys(function ($att, $key) {
            return [$key => $att['default'] ?? ''];
        })->toArray();

        $merged_atts = shortcode_atts($defaults, $atts);

        // Define the slot content
        $slot = $config['has_content'] ? do_shortcode($content) : '';

        $kebabName = str_replace('_', '-', $name);
        $componentPath = "shortcodes.{$kebabName}";

        if (!view()->exists("components.{$componentPath}")) {
            return "<!-- Component components.{$componentPath} not found -->";
        }

        /**
         * We pass the attributes as the second argument to Blade::render.
         * In the string, we use $attributes->merge() or bind them directly.
         */
        return Blade::render(
          "<x-{$componentPath} :attributes='\$attributes'>{!! \$slot !!}</x-{$componentPath}>", 
          [
              'attributes' => new \Illuminate\View\ComponentAttributeBag($merged_atts),
              'slot' => $slot
          ]
      );
    });
});