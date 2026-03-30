<?php


if (!function_exists('wr_parse_args')) {

  /**
   * This function will merge the passed-in args with the defaults. Any arrays will be merged with the default arrays, instead of overwriting the whole array
   *
   * @param array $args
   * @param array $defaults
   * @param array $strict
   * @return array
   */
  function wr_parse_args(?array $args = array(), array $defaults = array(), bool $strict = false): array
  {

    if (is_object($args)) {

      $args = get_object_vars($args);
    } elseif (!is_array($args)) {

      $args = array($args);
    }

    // Merge any array elements with defaults instead of overwriting the whole array
    foreach ($defaults as $k => $v) {

      if (isset($args[$k])) {

        // Make into arrays
        if (is_array($v) || is_array($args[$k])) {
          $defaults[$k] = (array) $defaults[$k];
          $args[$k] = (array) $args[$k];
        }

        if (is_array($defaults[$k])) {

          // Check to see if corresponding key is also an array
          if (is_array($args[$k])) {

            $args[$k] = wr_parse_args($args[$k], $defaults[$k]);

            // If not, add the non-array to the default array
          } else {

            $args[$k] = $defaults[$k][] = $args[$k];
          }
        }
      }
    }

    $output = array_merge($defaults, $args);

    return $output;
  }
}

if (!function_exists('wr_is_array')) {

  /**
   * Is the passed in parameter an array and does it contain elements
   *
   * @param mixed $array
   * @return bool
   */
  function wr_is_array($array): bool
  {

    $output = (is_array($array) && !empty($array));

    // If array only has one value and it is empty, return false;
    if ($output && isset($array[0]) && empty($array[0])) {
      $output = false;
    }

    return $output;
  }
}

if (!function_exists('wr_is_url')) {

  /**
   * Check to see if the passed in string is a valid URL
   *
   * @param string $url
   * @return boolean
   */
  function wr_is_url(string $url): bool
  {

    return apply_filters('wr/core/is_url', filter_var($url, FILTER_VALIDATE_URL), $url);
  }
}

if (!function_exists('wr_in_array')) {

  /**
   * This function will return true if needle is in haysack. Also checks if it is an array
   *
   * @param mixed $needle
   * @param mixed $heystack
   * @return bool
   */
  function wr_in_array($needle, $haystack): bool
  {

    $output = false;

    if (is_array($haystack) && in_array($needle, $haystack)) {
      $output = true;
    } else if ($needle == $haystack) {
      $output = true;
    }

    return $output;
  }
}

if (!function_exists('wr_in_arrays')) {

  /**
   * Checks to see if any values in array one are in array 2
   *
   * @param array $array_1
   * @param array $array_2
   * @return bool
   */
  function wr_in_arrays(array $array_1, array $array_2): bool
  {

    return wr_is_array(array_intersect($array_1, $array_2));
  }
}

if (!function_exists('wr_count')) {

  /**
   * This function will count the number of elements in an array, or return 0 if the passed in var is not an array
   *
   * @param mixed $to_count
   * @return integer
   */
  function wr_count($to_count): int
  {

    $output = 0;

    if (is_null($to_count)) {
      return 0;
    }

    if (is_countable($to_count)) {
      $output = count($to_count);
    }

    return $output;
  }
}

if (!function_exists('wr_array_merge')) {

  /**
   * Merges arrays, and also converts non-arrays to arrays
   *
   * @return array
   */
  function wr_array_merge(): array
  {

    $args = func_get_args();
    $output = [];

    foreach ($args as $array) {

      $output = array_merge(wr_array($array), $output);
    }

    return $output;
  }
}

if (!function_exists('wr_array_get_first')) {

  /**
   * Return the first element of an array
   *
   * @param array $array
   * @return mixed
   */
  function wr_array_get_first(array $array)
  {

    return reset($array);
  }
}

if (!function_exists('wr_array_get_last')) {

  /**
   * Return the last element of an array
   *
   * @param array $array
   * @return mixed
   */
  function wr_array_get_last(array $array)
  {

    return end($array);
  }
}

if (!function_exists('wr_is_a')) {

  /**
   * Checks if the passed in parameter is an object and is also an instance of the passed in classname
   *
   * @param mixed $class_name (without the first two parts of the namespace)
   * @param mixed $object
   * @return boolean
   */
  function wr_is_a($class_names, $object): bool
  {

    $output = false;

    if (!wr_is_array($class_names)) {
      $class_names = [$class_names];
    }

    foreach ($class_names as $class_name) {

      if (is_object($object) && is_a($object, $class_name, true)) {
        $output = true;
        break;
      }
    }

    return $output;
  }
}

if (!function_exists('wr_human_filesize')) {

  /**
   * Converts bytes to more human comprehensible sizes
   *
   * @param int $size
   * @return string
   */
  function wr_human_filesize(int $size, int $decimal_places = 0): string
  {

    $mod = 1024;

    $units = explode(' ', 'B KB MB GB TB PB');
    for ($i = 0; $size > $mod; $i++) {
      $size /= $mod;
    }

    return number_format($size, $decimal_places) . ' ' . $units[$i];
  }
}

if (!function_exists('wr_pretty_url')) {

  /**
   * Returns a pretty version of a URL string
   *
   * @param string $url
   * @return void
   */
  function wr_pretty_url(string $url)
  {

    // in case scheme relative URI is passed, e.g., //www.google.com/
    $url = trim($url, '/');

    // If scheme not included, prepend it
    if (!preg_match('#^http(s)?://#', $url)) {
      $url = 'http://' . $url;
    }

    $urlParts = parse_url($url);

    // remove www
    $domain = preg_replace('/^www\./', '', $urlParts['host']);

    return $domain;
  }
}

/**
 * Escape an array of attributes
 *
 * @param array|Core\Atts $atts
 * @return string
 */
if (!function_exists('wr_esc_atts')) {

  function wr_esc_atts($atts = array()): string
  {

    // vars
    $html = '';

    // boolean attributes
    $bool_atts = [
      'required',
      'checked',
      'selected',
      'disabled',
      'autocomplete',
      'multiple',
      'defer',
      'async',
      'autoplay',
      'controls',
      'muted',
      'preload',
      'loop',
      'download',
      'readonly',
    ];

    // implode attributes
    $implode_atts = array('class', 'style');

    // URL atts
    $url_atts = array('href', 'src');

    // loop
    foreach ($atts as $k => $v) {

      if (is_null($v)) {
        continue;
      }

      // Check attribute validity
      if (is_numeric($k)) {
        throw new \Exception("Invalid attribute ($k) passed into wr_esc_atts() with value ($v)");
      }

      // Is false but not a boolean
      if (($v === false || $v === 'false' || $v === '' || $v === null)) {

        if (!in_array($k, $bool_atts)) {
          continue;
        }

        $v = false;
      }

      if ($k == 'data') {

        if (!wr_is_array($v)) {
          $v = [$v];
        }

        $data_array = array();

        if (wr_is_array($v)) {

          foreach ($v as $data => $value) {

            if (!$data) {
              continue;
            }

            if (is_array($value)) {
              $value = json_encode($value);
            }

            $data_array[] = 'data-' . sanitize_title($data) . "='" . esc_attr($value) . "' ";
          }

          $html .= implode(' ', wr_remove_empty($data_array));
        }

        // Is style
      } else if ($k == 'style') {

        if (!wr_is_array($v)) {
          $v = [$v];
        }

        $style_array = array();

        if (wr_is_array($v)) {

          foreach ($v as $style => $value) {

            if (!$style) {
              continue;
            }

            $style_array[] = $style . ":" .  $value . ";";
          }
        }

        if (wr_is_array($style_array)) {
          $html .= 'style="' . esc_attr(implode('', wr_remove_empty($style_array))) . '"';
        }

        // Is url
      } else if (in_array($k, ['href'])) {
        $v = esc_url($v);

        // string
      } elseif (is_string($v)) {

        // don't trim value
        if ($k !== 'value') {
          $v = trim($v);
        }

        // boolean
      } elseif (is_bool($v)) {

        $v = $v ? 1 : 0;

        if (in_array($k, $bool_atts)) {

          if ($v) {

            // append
            $html .= esc_attr($k) . ' ';
          }

          continue;
        }

        // object
      } elseif (is_array($v) || is_object($v)) {

        // If class
        if (in_array($k, $implode_atts)) {

          // Remove empty
          $v = wr_remove_empty(array_unique($v));
          $v = implode(' ', $v);
        } else {

          $v = json_encode($v);
        }
      }

      if ($k !== 'data' && $k !== 'style') {

        if (in_array($k, $url_atts)) {
          $html .= esc_attr($k) . '="' . esc_url($v) . '" ';
        } else {
          // append
          $html .= esc_attr($k) . '="' . esc_attr($v) . '" ';
        }
      }
    }

    // return
    return trim($html);
  }
}

if (!function_exists('wr_icon')) {

  function wr_icon(string $name, array $options = [], array $custom_atts = []): string
  {

    if (wr_font_awesome()) {
      return wr_font_awesome()->get_icon($name, $options, $custom_atts);
    }

    return '';
  }
}

if (!function_exists('wr_el')) {

  /**
   *  * Get a HTML element. Will check tag is valid. Maybe escape attributes while we are at it.
   * 
   * If no content is provided, will just output the opening tag
   *
   * @param string|null $tag
   * @param [type] $atts
   * @param [type] $content
   * @param boolean $esc_html
   * @return string
   */
  function wr_el(?string $tag, $atts, $content = null, bool $esc_html = false): string
  {

    $void = false;

    if ($content && is_callable([$content, 'get_html'])) {
      $content = $content->get_html();
      $esc_html = false;
    }

    // Check we have a value for tag
    if (!$tag) {
      return $esc_html ? esc_html($content) : $content;
    }

    // Check if tag is void
    if (wr_is_valid_tag($tag, true)) {
      $void = true;

      // Check if tag is valid
    } else if (!wr_is_valid_tag($tag, false)) {
      throw new \Exception("Invalid tag passed to v_el ($tag)");
    }

    $output = '<' . $tag;

    $output .= ' ' . wr_esc_atts($atts);

    $output .= '>';

    // The content and closing tag
    if (!$void && !is_null($content)) {
      $output .= ($esc_html ? esc_html($content) : $content) . "</$tag>";
    }

    return $output;
  }
}

if (!function_exists('wr_array_to_list_string')) {

  /**
   * Converts an array of strings to one string, putting commas between values and an 'and' for the last element in the array
   *
   * @param array $array
   * @return string
   */
  function wr_array_to_list_string(array $array): string
  {

    if (!is_array($array)) {
      $array = array($array);
    }

    $output = '';
    $length = count($array);

    $i = 0;
    foreach ($array as $item) {
      $i++;

      $output .= $item;

      if ($i == ($length - 1)) {
        $output .= ' ' . apply_filters('v/core/array_to_list_string_and', 'and') . ' ';
      } elseif ($i != $length) {
        $output .= ', ';
      }
    }

    return $output;
  }
}

if (!function_exists('wr_is_login_page')) {

  /**
   * Checks to see if the current page is the WP login page
   *
   * @return boolean
   */
  function wr_is_login_page(): bool
  {
    $ABSPATH_MY = str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ABSPATH);
    return ((in_array($ABSPATH_MY . 'wp-login.php', get_included_files()) || in_array($ABSPATH_MY . 'wp-register.php', get_included_files())) || $GLOBALS['pagenow'] === 'wp-login.php' || $_SERVER['PHP_SELF'] == '/wp-login.php');
  }
}

if (!function_exists('wr_remove_empty')) {

  /**
   * Remove empty elements from an array, including all false values
   *
   * @param array $args
   * @return array
   */
  function wr_remove_empty(array $array): array
  {

    return array_filter($array);
  }
}

if (! function_exists('wr_post')) {

  /**
   * Helper for instanciating a Post class
   *
   * @param mixed $args
   * @return Webrocket\Theme\Posts\Post|null
   */
  function wr_post($post = null, ?string $post_type = null): ?\Webrocket\Theme\Posts\Post
  {

    return \Webrocket\Theme\Posts\Post::get_object($post, $post_type);
  }
}

if (!function_exists('wr_sanitise_class_name')) {

  /**
   * Make sure the class name contains underscores instead of hyphens and each word begins with an uppercase letter
   *
   * @param string $name
   * @return string
   */
  function wr_sanitise_class_name(string $name): string
  {

    // Split by namespace
    $namespaces = explode('\\', $name);
    $output = [];

    foreach ($namespaces as $namespace) {

      $words = explode('_', str_replace('-', '_', $namespace));
      $words = array_map('ucwords', $words);
      $output[] = implode('_', $words);
    }

    return implode('\\', $output);
  }
}

if (!function_exists('wr_get_short_class_name')) {

  /**
   * Get the unqualified (short) class name i.e. without namespace
   *
   * @param string|object $object
   * @return string
   */
  function wr_get_short_class_name($object): string
  {

    $reflect = new \ReflectionClass($object);
    return $reflect->getShortName();
  }
}

if (!function_exists('wr_get_class_namespace')) {

  /**
   * Get the namespace of a class
   *
   * @param string $object
   * @return string
   */
  function wr_get_class_namespace(string $object): string
  {

    $reflect = new \ReflectionClass($object);
    return $reflect->getNamespaceName();
  }
}

if (!function_exists('wr_array')) {

  /**
   * Makes sure that an array is returned. If value is empty, return an empty array
   *
   * @param mixed $value
   * @return array
   */
  function wr_array($value, ?string $array_map = null): array
  {

    if (is_null($value) || $value === false) {
      return [];
    }

    if (!is_array($value)) {
      $value = [$value];
    }

    // If array map is set, pass each value through the callback
    if ($array_map) {
      $value = array_map($array_map, $value);
    }

    return $value;
  }
}

if (!function_exists('wr_set_type')) {

  /**
   * Set the passed in variable to a type. TODO there may already be a better way to do this
   *
   * @param mixed $value
   * @param string $type
   * @return void
   */
  function wr_set_type($value, string $type)
  {

    // Return format
    switch ($type) {

        // Convert the string 'true' to TRUE and 'false' to FALSE
      case 'bool':
      case 'boolean':

        $value = is_string($value) ? trim(strtolower($value)) : $value;

        if ('true' === $value || true === $value) {
          $value = true;
        } else if ('false' === $value || is_null($value) || false === $value) {
          $value = false;
        }

        $value = (bool) $value;
        break;

        // Convert the value to an array. Will also convert a string which has a pipe (|) character to an array of parts
      case 'array':

        // Convert strings with pipes in to arrays
        if (is_string($value)) {
          $value = explode('|', urldecode($value));
        }

        // Check we still have an array
        if (!is_array($value)) {
          $value = [$value];
        }

        break;

      default:
        settype($value, $type);
        break;
    }

    return $value;
  }
}

if (!function_exists('wr_datetime')) {

  /**
   * Get a DateTime object with the correct timezone set in WP settings
   *
   * @param mixed $time
   * @return \DateTimeImmutable
   */
  function wr_datetime($time = 'now'): \DateTimeImmutable
  {

    // If iso 8601
    if (wr_is_valid_iso_8601($time)) {
      $ob = new \DateTimeImmutable($time, new \DateTimeZone('UTC'));
      $ob = $ob->setTimezone(wp_timezone());

      // If passing in numeric, return from epoch
    } else if (is_numeric($time)) {
      $ob = wr_datetime_from_epoch($time);

      // If passing in DateTime ob
    } else if (wr_is_a('DateTime', $time)) {
      $ob = \DateTimeImmutable::createFromMutable($time);

      // If passing in DateTimeImmutable ob
    } else if (wr_is_a('DateTimeImmutable', $time)) {
      $ob = $time;

      // Create DateTimeImmutable ob
    } else {
      $ob = new \DateTimeImmutable($time, wp_timezone());
    }

    // Return the DateTimeImmutable object
    return $ob;
  }
}

if (!function_exists('wr_is_valid_iso_8601')) {
  function wr_is_valid_iso_8601($date): bool
  {

    if (!is_string($date)) {
      return false;
    }

    $pattern = '/^(\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d+)?(Z|([+-]\d{2}:\d{2})))$/';
    return preg_match($pattern, $date) === 1;
  }
}

if (!function_exists('wr_datetime_from_format')) {

  /**
   * Get a DateTime object with the correct timezone set in WP settings, setting via format
   *
   * @param string $format
   * @param string $time
   * @return \DateTimeImmutable|null
   */
  function wr_datetime_from_format(string $format, string $time): ?\DateTimeImmutable
  {

    $ob = date_create_immutable_from_format($format, $time, wp_timezone()) ?: null;

    // Return the DateTimeImmutable object
    return $ob;
  }
}

if (!function_exists('wr_datetime_from_epoch')) {

  /**
   * Get a DateTime object with the correct timezone set in WP settings, using unix epoch
   *
   * @param int $epoch
   * @return \DateTimeImmutable
   */
  function wr_datetime_from_epoch($epoch): ?\DateTimeImmutable
  {

    // Convert from milliseconds to seconds
    $epoch = substr($epoch, 0, 10);

    // Return the DateTimeImmutable object
    return wr_datetime_from_format('U', (string) $epoch);
  }
}

if (!function_exists('wr_environment')) {

  /**
   * Get the current site environment.
   * @return string|bool
   */
  function wr_environment(): string
  {

    return wp_get_environment_type();
  }
}

if (!function_exists('wr_path_to_url')) {

  /**
   * Convert a path for a file to a URL
   *
   * @param string $path
   * @return string
   */
  function wr_path_to_url(string $path): string
  {

    return trailingslashit(get_site_url()) . str_replace(ABSPATH, '', $path);
  }
}



if (!function_exists('wr_url_to_path')) {

  /**
   * Convert a path for a file to a URL
   *
   * @param string $path
   * @return string
   */
  function wr_url_to_path(string $url): string
  {

    return trailingslashit(ABSPATH) . str_replace(get_site_url(), '', $url);
  }
}


if (!function_exists('wr_get_term_ancestors')) {

  /**
   * Get the term ancestors for either a term_id or post_id.
   *
   * @param array $args
   * @return array
   */
  function wr_get_term_ancestors(array $args): array
  {

    $defaults = [
      'taxonomy' => null, // required
      'post_id' => null, // required or..
      'term_id' => null, // ..required,
      'no_original_term' => null, // Wether or not to add the original term to the output
    ];

    $args = wp_parse_args($args, $defaults);

    $term_id = $args['term_id'] ?: null;

    if (!$taxonomy = $args['taxonomy']) {
      throw new \Exception("Taxonomy is required");
    }

    if (!$term_id) {

      $post_id = $args['post_id'] ?? null;

      if (!$post_id) {
        throw new \Exception("Either a post_id or a term_id is required");
      }

      $terms = wr_get_lowest_terms($post_id, $taxonomy);

      // Check we have terms
      if (!wr_is_array($terms)) {
        return [];
      }

      // Not uncategories
      if ($terms[0]->name == 'Uncategorised' && isset($terms[1])) {
        $term_id = $terms[1]->term_id;
      } else {
        $term_id = $terms[0]->term_id;
      }
    }

    $ancestors = get_ancestors($term_id, $taxonomy);
    $ancestors = array_reverse($ancestors);
    $output = [];

    foreach ($ancestors as $ancestor) {

      $ancestor = get_term($ancestor, $taxonomy);
      if (!is_wp_error($ancestor) && $ancestor) {
        $output[] = $ancestor;
      }
    }

    // Add the original term to the end of the array
    if (!$args['no_original_term']) {
      $output[] = get_term($term_id);
    }

    return $output;
  }
}



if (!function_exists('wr_get_lowest_terms')) {

  /**
   * Get the lowest heirarchical terms for a post
   *
   * @param integer $post_id
   * @param string $taxonomy
   * @return array
   */
  function wr_get_lowest_terms(int $post_id, string $taxonomy): array
  {

    $post_terms = wr_array(get_terms([
      'taxonomy' => $taxonomy,
      'object_ids' => $post_id,
      'hide_empty' => true
    ]));

    $parents = [];
    $ids = [];
    foreach ($post_terms as $post_term) {
      $ids[] = $post_term->term_id;

      if ($post_term->parent) {
        $parents[] = $post_term->parent;
      }
    }

    $lowest_terms = array_diff($ids, $parents);

    $terms = get_terms([
      'object_ids' => $lowest_terms,
      'taxonomy' => $taxonomy,
    ]);

    return $terms;
  }
}

if (!function_exists('wr_get_id')) {

  /**
   * Get the current page ID. Will work for archives by retrieving the queried object ID
   *
   * @return integer|null
   */
  function wr_get_id(): ?int
  {

    if (!did_action('template_redirect')) {
      throw new \Exception('Trying to get ID before post is setup');
    }

    $id = get_the_ID();

    if (is_archive()) {
      $id = get_queried_object_id();
    }

    return $id;
  }
}

if (!function_exists('wr_delete_directory')) {

  /**
   * Remove directory and all files and folders inside
   *
   * @param string $dir
   * @return void
   */
  function wr_delete_directory(string $dir): void
  {

    $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $file) {
      if ($file->isDir()) {
        rmdir($file->getRealPath());
      } else {
        unlink($file->getRealPath());
      }
    }
    rmdir($dir);
  }
}

if (!function_exists('wr_ends_with')) {

  /**
   * Checks to see if the $haystack ends with $needle
   *
   * @param string $haystack
   * @param string $needle
   * @return bool
   */
  function wr_ends_with($haystack, $needle): bool
  {

    $length = strlen($needle);

    if (!$length) {
      return true;
    }

    return substr($haystack, -$length) === $needle;
  }
}

if (!function_exists('wr_find_between')) {

  /**
   * Finds a substring between two strings
   * @param  string $string The string to be searched
   * @param  string $start The start of the desired substring
   * @param  string $end The end of the desired substring
   * @param  bool   $greedy Use last instance of`$end` (default: false)
   * @return string
   */
  function wr_find_between(string $string, string $start, string $end, bool $greedy = false)
  {
    $start = preg_quote($start, '/');
    $end   = preg_quote($end, '/');

    $format = '/(%s)(.*';
    if (!$greedy) $format .= '?';
    $format .= ')(%s)/';

    $pattern = sprintf($format, $start, $end);
    preg_match($pattern, $string, $matches);

    return $matches[2];
  }
}

if (!function_exists('wr_microtime_float')) {

  /**
   * Get microtime
   *
   * @return float
   */
  function wr_microtime_float(): float
  {

    list($usec, $sec) = explode(" ", microtime());
    return ((float) $usec + (float) $sec);
  }
}

if (!function_exists('wr_hash')) {

  /**
   * Create a hash from whatever is passed into it
   *
   * @param mixed $value
   * @return string
   */
  function wr_hash($thing): string
  {

    if (!is_string($thing)) {
      $thing = serialize($thing);
    }

    return md5($thing);
  }
}



if (!function_exists('wr_set_transient')) {

  /**
   * Set a transient, and encode it before saving to the database
   *
   * @param string $transient
   * @param mixed $value
   * @param int $expiration
   * @return bool
   */
  function wr_set_transient(string $transient, $value, int $expiration): bool
  {

    if (strlen($transient) > 172) {
      throw new \Exception("Transient ($transient) is more than 172 characters");
    }

    $value = base64_encode(serialize($value));

    return set_transient($transient, $value, $expiration);
  }
}



if (!function_exists('wr_get_transient')) {

  /**
   * Get a transient, and deencode it before returning
   *
   * @param string $transient
   * @return mixed
   */
  function wr_get_transient(string $transient)
  {

    $value = get_transient($transient);

    return base64_decode(unserialize($value));
  }
}

if (!function_exists('wr_get_current_url')) {

  /**
   * Get the URL for the current page
   */
  function wr_get_current_url(): string
  {

    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  }
}

if (!function_exists('wr_is_rest')) {

  /**
   * Checks wether the current request is from the REST API
   *
   * @return boolean
   */
  function wr_is_rest(): bool
  {

    if (defined('REST_REQUEST') && REST_REQUEST  || isset($_GET['rest_route']) && strpos($_GET['rest_route'], '/', 0) === 0) {
      return true;
    }

    // (#3)
    global $wp_rewrite;
    if ($wp_rewrite === null) {
      $wp_rewrite = new WP_Rewrite();
    }

    // (#4)
    $rest_url = wp_parse_url(trailingslashit(rest_url()));
    $current_url = wp_parse_url(add_query_arg(array()));
    return strpos($current_url['path'], $rest_url['path'], 0) === 0;
  }
}

if (!function_exists('wr_remove_new_lines')) {

  /**
   * Remove new lines from a string and replace with empty one
   *
   * @param string $string
   * @return string
   */
  function wr_remove_new_lines(string $string): string
  {

    return trim(preg_replace('/\s+/', ' ', $string));
  }
}

if (!function_exists('wr_import_image_to_library')) {

  /**
   * Import a file into the media library
   *
   * @param string $file - The path to the file
   * @param \DateTimeInterface|null $time - The time to set to use for the uploads directory
   * @return int|null|\WP_Error If successful, return the ID of the new attachment
   */
  function wr_import_image_to_library(string $file, ?\DateTimeInterface $time = null)
  {

    if (!file_exists($file)) {
      return null;
    }

    if (!$time) {
      $time = wr_datetime();
    }

    // A writable uploads dir will pass this test. Again, there's no point overriding this one.
    $uploads = wp_upload_dir($time->format('Y/m'));
    if (!($uploads && false === $uploads['error'])) {
      return new \WP_Error('upload_error', $uploads['error']);
    }

    $wp_filetype = wp_check_filetype($file, null);
    $type = $wp_filetype['type'];
    $ext  = $wp_filetype['ext'];
    if ((!$type || !$ext) && !current_user_can('unfiltered_upload')) {
      return new \WP_Error('wrong_file_type', __('Sorry, this file type is not permitted for security reasons.', 'add-from-server'));
    }

    // Check if the file already exists
    if (file_exists($uploads['path'] . '/' . basename($file))) {
      return null;
    }

    $filename = wp_unique_filename($uploads['path'], basename($file));

    // copy the file to the uploads dir
    $new_file = $uploads['path'] . '/' . $filename;
    if (false === @copy($file, $new_file)) {
      return new \WP_Error('upload_error', sprintf(__('The selected file could not be copied to %s.', 'add-from-server'), $uploads['path']));
    }

    // Set correct file permissions
    $stat = stat(dirname($new_file));
    $perms = $stat['mode'] & 0000666;
    @chmod($new_file, $perms);
    // Compute the URL
    $url = $uploads['url'] . '/' . $filename;

    // Apply upload filters
    $return = apply_filters('wp_handle_upload', array('file' => $new_file, 'url' => $url, 'type' => $type));
    $new_file = $return['file'];
    $url = $return['url'];
    $type = $return['type'];

    $title = preg_replace('!\.[^.]+$!', '', basename($file));
    $content = $excerpt = '';

    // Make sure it is loaded
    if (!function_exists('wp_read_image_metadata')) {
      require_once ABSPATH . '/wp-admin/includes/image.php';
    }

    if (0 === strpos($type, 'image/') && $image_meta = \wp_read_image_metadata($new_file)) {
      if (trim($image_meta['title']) && !is_numeric(sanitize_title($image_meta['title']))) {
        $title = $image_meta['title'];
      }

      if (trim($image_meta['caption'])) {
        $excerpt = $image_meta['caption'];
      }
    }

    // Construct the attachment array
    $attachment = [
      'post_mime_type' => $type,
      'guid'           => $url,
      'post_parent'    => 0,
      'post_title'     => $title,
      'post_name'      => $title,
      'post_content'   => $content,
      'post_excerpt'   => $excerpt,
      'post_date'      => $time->format('Y-m-d H:i:s'),
      'post_date_gmt'  => $time->format('Y-m-d H:i:s'),
    ];

    $attachment = apply_filters('afs-import_details', $attachment, $file, 0, 'current');

    // Save the data
    $id = wp_insert_attachment($attachment, $new_file, 0);
    if (!is_wp_error($id)) {
      $data = wp_generate_attachment_metadata($id, $new_file);
      wp_update_attachment_metadata($id, $data);
    }

    return $id;
  }
}

if (!function_exists('wr_is_valid_tag')) {

  /**
   * Is the passed in tag valid
   *
   * @param string $tag
   * @param boolean $void - Check to see if the passed in tag is a void tag
   * @return boolean
   */
  function wr_is_valid_tag($tag, $void = null)
  {

    $valid_tags = array(
      'a',
      'abbr',
      'address',
      'area',
      'article',
      'aside',
      'audio',
      'b',
      'base',
      'bdi',
      'bdo',
      'blockquote',
      'body',
      'br',
      'button',
      'canvas',
      'caption',
      'cite',
      'code',
      'col',
      'colgroup',
      'command',
      'datalist',
      'dd',
      'del',
      'details',
      'dfn',
      'div',
      'dl',
      'dt',
      'em',
      'embed',
      'fieldset',
      'figcaption',
      'figure',
      'footer',
      'form',
      'h1',
      'h2',
      'h3',
      'h4',
      'h5',
      'h6',
      'head',
      'header',
      'hgroup',
      'hr',
      'html',
      'i',
      'iframe',
      'img',
      'input',
      'ins',
      'kbd',
      'keygen',
      'label',
      'legend',
      'li',
      'link',
      'map',
      'mark',
      'menu',
      'meta',
      'meter',
      'nav',
      'noscript',
      'object',
      'ol',
      'optgroup',
      'option',
      'output',
      'p',
      'param',
      'pre',
      'progress',
      'q',
      'rp',
      'rt',
      'ruby',
      's',
      'samp',
      'script',
      'section',
      'select',
      'small',
      'source',
      'span',
      'strong',
      'style',
      'sub',
      'summary',
      'sup',
      'table',
      'tbody',
      'td',
      'textarea',
      'tfoot',
      'th',
      'thead',
      'time',
      'title',
      'tr',
      'track',
      'u',
      'ul',
      'var',
      'video',
      'wbr',
    );

    $void_tags = array(
      'area',
      'base',
      'basefont',
      'bgsound',
      'br',
      'col',
      'command',
      'embed',
      'frame',
      'hr',
      'image',
      'img',
      'input',
      'isindex',
      'keygen',
      'link',
      'menuitem',
      'meta',
      'nextid',
      'param',
      'source',
      'track',
      'wbr',
    );

    if ($void === null) {

      return in_array($tag, $valid_tags);
    } elseif ($void === true) {

      return in_array($tag, $void_tags);
    } elseif ($void === false) {

      return (in_array($tag, $valid_tags) && !in_array($tag, $void_tags));
    }
  }
}

if (!function_exists('wr_array_unset_recursive')) {

  /**
   * Unset an element in an array, recursively
   *
   * @param array $array
   * @param string $remove
   * @return void
   */
  function wr_array_unset_recursive(array &$array, string $remove): void
  {

    foreach ($array as $key => &$value) {

      if ($key === $remove) {
        unset($array[$key]);
      } else if (is_array($value)) {
        wr_array_unset_recursive($value, $remove);
      }
    }
  }
}

if (!function_exists('wr_seconds_to_text')) {

  /**
   * Convert seconds to a human readable format
   *
   * @param int $post_id
   * @return string
   */
  function wr_seconds_to_text(int $seconds, bool $ex_singular = false): string
  {

    // Define time periods in seconds
    $periods = array(
      'year' => 31536000,
      'month' => 2592000,
      'week' => 604800,
      'day' => 86400,
      'hour' => 3600,
      'minute' => 60,
      'second' => 1,
    );

    // Initialize the output string
    $output = array();

    // Loop through each period and calculate the number of each
    foreach ($periods as $name => $duration) {
      if ($seconds >= $duration) {
        $value = floor($seconds / $duration);
        $seconds %= $duration;
        // Handle singular cases
        if ($value == 1) {
          $output[] = (!$ex_singular ? $value . ' ' : '') . $name;
        } else {
          $output[] = $value . ' ' . $name . 's';
        }
      }
    }

    // Format the output string
    if (count($output) > 1) {
      $last = array_pop($output);
      return implode(', ', $output) . ' and ' . $last;
    } else {
      return implode(', ', $output);
    }
  }
}

if (!function_exists('wr_get_acronym')) {
  /**
   * Get an acronym from a string
   *
   * @param string $string
   * @return string
   */
  function wr_get_acronym($string)
  {
    $words = explode(' ', $string);
    $acronym = '';

    foreach ($words as $word) {
      $acronym .= mb_substr($word, 0, 1);
    }

    return $acronym;
  }
}

if (!function_exists('wr_make_url_absolute')) {
  /**
   * Ensure a URL is absolute. 
   * If relative, prepend with site URL.
   *
   * @param string $url The URL to check.
   * @return string Absolute URL.
   */
  function wr_make_url_absolute($url)
  {
    // Trim whitespace
    $url = trim($url);

    // Empty check
    if (empty($url)) {
      return $url;
    }

    // If already absolute (http, https, mailto, tel, etc.), return as is
    if (preg_match('#^(https?:)?//#i', $url) || preg_match('#^(mailto:|tel:)#i', $url)) {
      return $url;
    }

    // Make absolute using site_url (or home_url if you prefer front-end URL)
    return home_url($url);
  }
}

if (!function_exists('wr_add_admin_notice')) {

  /**
   * Store an admin notice as a transient to be displayed at the next possible opportunity
   *
   * @param string $message
   * @param string $type - 'error', 'warning', 'success', 'info'
   * @param boolean $is_dismissable
   * @return void
   */
  function wr_add_admin_notice(string $message, string $type = 'info', bool $is_dismissible = true)
  {

    $key = 'wr_add_admin_notice_' . get_current_user_id();
    $existing_notices = wr_array(get_transient($key) ?: []);

    $existing_notices[] = [
      'message' => $message,
      'type' => $type,
      'is_dismissible' => $is_dismissible
    ];

    // Store a temporary flag in the database for 60 seconds
    set_transient($key, $existing_notices, DAY_IN_SECONDS);
  }
}
