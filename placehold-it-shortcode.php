<?php
/*
Plugin Name: placehold-it-shortcode
Plugin URI: http://github.com/dsawardekar/placehold-it-shortcode
Description: Shortcodes for the placehold.it image placeholder service.
Version: 0.2
Author: Darshan Sawardekar
Author URI: http://pressing-matters.io
License: GPL2
*/

function get_defaults() {
  return array(
    'width' => '300',
    'height' => '200',
    'textcolor' => null,
    'bgcolor' => null,
    'text' => null
  );
}

function build_segments(&$attrs) {
  $short_attrs = shortcode_atts(get_defaults(), $attrs);
  $segments = array();

  add_segment($segments, get_sizes($short_attrs));
  add_segment($segments, get_colors($short_attrs));
  add_segment($segments, get_text($short_attrs));

  return $segments;
}

function add_segment(&$segments, $value) {
  if ($value) {
    array_push($segments, $value);
  }
}

function get_sizes(&$attrs) {
  return $attrs['width'] . 'x' . $attrs['height'];
}

function get_colors(&$attrs) {
  $bgcolor = $attrs['bgcolor'];
  $textcolor = $attrs['textcolor'];

  if ($bgcolor && $textcolor) {
    return $bgcolor . '/' . $textcolor;
  } else {
    return null;
  }
}

function get_text(&$attrs) {
  $text = $attrs['text'];
  if (is_null($text)) {
    $text = get_sizes($attrs);
  }

  return '&text=' . $text;
}

function placeholder_it_shortcode($attrs) {
  $segments = build_segments($attrs);
  return '<img src="http://placehold.it/' . implode('/', $segments) . '">';
}

add_shortcode('placehold-it', 'placeholder_it_shortcode');

?>
