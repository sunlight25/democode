<?php
/**
 * Retrieves an element's "attributes" array.
 *
 * @param array $element
 *   The individual renderable array element. It is possible to also pass the
 *   $variables parameter in [pre]process functions and it will logically
 *   determine the correct path to that particular theme hook's attribute array.
 *   Passed by reference.
 * @param string $property
 *   Determines which attributes array to retrieve. By default, this is the
 *   normal attributes, but can be "wrapper_attributes" or
 *   "input_group_attributes".
 *
 * @return array
 *   The attributes array. Passed by reference.
 */
function &_viamo_get_attributes(&$element, $property = 'attributes') {
  // Attempt to retrieve a renderable element attributes first.
  if (
    isset($element['#type']) ||
    isset($element['#theme']) ||
    isset($element['#pre_render']) ||
    isset($element['#markup']) ||
    isset($element['#theme_wrappers']) ||
    isset($element["#$property"])
  ) {
    if (!isset($element["#$property"])) {
      $element["#$property"] = array();
    }
    return $element["#$property"];
  }
  // Treat $element as if it were a [pre]process function $variables parameter
  // and look for a renderable "element".
  elseif (isset($element['element'])) {
    if (!isset($element['element']["#$property"])) {
      $element['element']["#$property"] = array();
    }
    return $element['element']["#$property"];
  }

  // If all else fails, create (if needed) a default "attributes" array. This
  // will, at the very least, either work or cause an error that can be tracked.
  if (!isset($element[$property])) {
    $element[$property] = array();
  }

  return $element[$property];
}

/**
 * Retrieves an element's "class" array.
 *
 * @param array $element
 *   The individual renderable array element. It is possible to also pass the
 *   $variables parameter in [pre]process functions and it will logically
 *   determine the correct path to that particular theme hook's classes array.
 *   Passed by reference.
 * @param string $property
 *   Determines which attributes array to retrieve. By default, this is the
 *   normal attributes, but can be "wrapper_attributes" or
 *   "input_group_attributes".
 *
 * @return array
 *   The classes array. Passed by reference.
 */
function &_viamo_get_classes(&$element, $property = 'attributes') {
  $attributes = &_viamo_get_attributes($element, $property);

  if (!isset($attributes['class'])) {
    $attributes['class'] = array();
  }
  // Contrib modules have a very bad habit of frequently adding classes as
  // strings, convert them to a proper array.
  // @see https://www.drupal.org/node/2269653
  elseif (!is_array($attributes['class'])) {
    $attributes['class'] = explode(' ', $attributes['class']);
  }

  // Ensure classes are not duplicated.
  $attributes['class'] = array_unique($attributes['class']);
  return $attributes['class'];
}

/**
 * Adds a class to an element's render array.
 *
 * @param string|array $class
 *   An individual class or an array of classes to add.
 * @param array $element
 *   The individual renderable array element. It is possible to also pass the
 *   $variables parameter in [pre]process functions and it will logically
 *   determine the correct path to that particular theme hook's classes array.
 *   Passed by reference.
 * @param string $property
 *   Determines which attributes array to retrieve. By default, this is the
 *   normal attributes, but can be "wrapper_attributes" or
 *   "input_group_attributes".
 */
function _viamo_add_class($class, &$element, $property = 'attributes') {
  // Retrieve the element's classes.
  $classes = &_viamo_get_classes($element, $property);

  // Convert the class to an array.
  if (!is_array($class)) {
    $class = array($class);
  }

  // Iterate over all classes to add.
  foreach ($class as $_class) {
    // Ensure the class to add does not yet already exist.
    if (!in_array($_class, $classes)) {
      $classes[] = $_class;
    }
  }
}

/**
 * Removes a class from an element's render array.
 *
 * @param string|array $class
 *   An individual class or an array of classes to remove.
 * @param array $element
 *   The individual renderable array element. It is possible to also pass the
 *   $variables parameter in [pre]process functions and it will logically
 *   determine the correct path to that particular theme hook's classes array.
 *   Passed by reference.
 * @param string $property
 *   Determines which attributes array to retrieve. By default, this is the
 *   normal attributes, but can be "wrapper_attributes" or
 *   "input_group_attributes".
 */
function _viamo_remove_class($class, &$element, $property = 'attributes') {
  // Retrieve the element's classes.
  $classes = &_viamo_get_classes($element, $property);

  // Convert the class to an array.
  if (!is_array($class)) {
    $class = array($class);
  }

  // Iterate over all classes to add.
  foreach ($class as $_class) {
    $key = array_search($_class, $classes);
    if ($key !== FALSE) {
      unset($classes[$key]);
    }
  }
}
