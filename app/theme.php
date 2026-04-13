<?php

/**
 * Get the available button colours
 *
 * @return array
 */
function wr_get_button_colours(): array {

  return [
    'primary' => 'Primary',
    'secondary' => 'Secondary',
    'tertiary' => 'Tertiary',
    'grey' => 'Grey',
    'black' => 'Black',
    'white' => 'White',
  ];
}

/**
 * Get the available button styles
 *
 * @return array
 */
function wr_get_button_styles(): array
  {

    return [
      'solid' => 'Solid',
      'outline' => 'Outline',
    ];
  }