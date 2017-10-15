<?php
/**
 * Implements theme_select().
 */
function viamo_select($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id', 'name', 'size'));
  _form_set_class($element, array('form-control form-select custom-select mb-2 mr-4 mb-sm-0'));

  return '<select' . drupal_attributes($element['#attributes']) . '>' . form_select_options($element) . '</select>';
}

/*
function viamo_form_alter(&$form, $form_state, $form_id) {
    
  if ($form_id == 'user_register_form') {
      
    //drupal_set_title(t('Create new account'));
    if(isset($form_state['profiles']) && $form_state['profiles']){
      
        $form['#submit'][] = 'tutor_form_submit_handler';
    }    
  }
  elseif ($form_id == 'user_pass') {
    drupal_set_title(t('Request new password'));
  }
  elseif ($form_id == 'user_login') {
  drupal_set_title(t('User Login'));
  }
}*/

/**
 * Implements theme_form_element().
 */
function viamo_form_element($variables) {
   
  $element = &$variables['element'];

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes['class'] = array('form-item input-field');
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'],
      array(
        ' ' => '-',
        '_' => '-',
        '[' => '-',
        ']' => '',
      )
    );
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }
  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";
      
  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      if ($element['#type'] != 'select') {
          $output .= ' ' . theme('form_element_label', $variables);
      }        
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }
  
    if (!empty($element['#description'])) {
      $output .= '<div class="description">' . $element['#description'] . "</div>\n";
    }
    $output .= "</div>\n";
  
  return $output;
}

/*
 * 
 * hook_textfield(); 
 * 
 */

function viamo_textfield($variables) {              
  $element = $variables['element'];  
  $element['#attributes']['type'] = 'text';
  $requ='';
  if($element['#required']) {
      $required='*';
  } else{
      $required ='';
  }
  if(isset($element['#title'])) {
    //$element['#attributes']['placeholder'] = $element['#title'].$required;  
    //$element['#title_display'] = 'invisible';
  }
  //echo "<pre>";
  //print_r($element); 
  
  element_set_attributes($element, array('id', 'name', 'value', 'size', 'maxlength'));
  _form_set_class($element, array('form-control form-text'));

  $extra = '';
  if ($element['#autocomplete_path'] && !empty($element['#autocomplete_input'])) {
    drupal_add_library('system', 'drupal.autocomplete');
    $element['#attributes']['class'][] = 'form-autocomplete';

    $attributes = array();
    $attributes['type'] = 'hidden';
    $attributes['id'] = $element['#autocomplete_input']['#id'];
    $attributes['value'] = $element['#autocomplete_input']['#url_value'];
    $attributes['disabled'] = 'disabled';
    $attributes['class'][] = 'autocomplete';
    $extra = '<input' . drupal_attributes($attributes) . ' />';
  }

  $output = '<input' . drupal_attributes($element['#attributes']) . ' />';
  return $output . $extra;      
}



/**
 * 
 *  Implemente hook_button();
 * Returns HTML for a button form element.
 * Properties used: #attributes, #button_type, #name, #value.
 *
 * 
 */
function viamo_button($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'submit';
  element_set_attributes($element, array('id', 'name', 'value'));

  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  $element['#attributes']['class'][] = 'form-control-lg btn v-blue mr-3';
  
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}


/**
 * Returns HTML for a form element label and required marker.
 *
 * Form element labels include the #title and a #required marker. The label is
 * associated with the element itself by the element #id. Labels may appear
 * before or after elements, depending on theme_form_element() and
 * #title_display.
 *
 * This function will not be called for elements with no labels, depending on
 * #title_display. For elements that have an empty #title and are not required,
 * this function will output no label (''). For required elements that have an
 * empty #title, this will output the required marker alone within the label.
 * The label will use the #id to associate the marker with the field that is
 * required. That is especially important for screenreader users to know
 * which field is required.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: An associative array containing the properties of the element.
 *     Properties used: #required, #title, #id, #value, #description.
 *
 * @ingroup themeable
 */

function viamo_form_element_label($variables) {
  
  //echo "<pre>";
  //print_r($variables); exit;
  
    
  $element = $variables['element'];
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  // If title and required marker are both empty, output no label.
  if ((!isset($element['#title']) || $element['#title'] === '') && empty($element['#required'])) {
    return '';
  }

  // If the element is required, a required marker is appended to the label.
  $required = !empty($element['#required']) ? theme('form_required_marker', array('element' => $element)) : '';

  $title = filter_xss_admin($element['#title']);

  $attributes = array();
  // Style the label as class option to display inline with the element.
  if ($element['#title_display'] == 'after') {
    $attributes['class'] = 'option';
  }
  // Show label only to screen readers to avoid disruption in visual flows.
  elseif ($element['#title_display'] == 'invisible') {
    $attributes['class'] = 'element-invisible';
  }

  if (!empty($element['#id'])) {
    $attributes['for'] = $element['#id'];
  }

  // The leading whitespace helps visually separate fields from inline labels.
  return ' <label' . drupal_attributes($attributes) . '>' . $t('!title !required', array('!title' => $title, '!required' => $required)) . "</label>\n";
}


/**
 * Implements theme_textarea().
 */
function viamo_textarea($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id', 'name', 'cols', 'rows'));
  _form_set_class($element, array('form-textarea materialize-textarea'));

  /*$wrapper_attributes = array(
    'class' => array('form-textarea-wrapper'),
  );*/

  // Add resizable behavior.
  /*if (!empty($element['#resizable'])) {
    drupal_add_library('system', 'drupal.textarea');
    $wrapper_attributes['class'][] = 'resizable';
  }*/

  /*$output = '<div' . drupal_attributes($wrapper_attributes) . '>';*/
  $output = '<textarea' . drupal_attributes($element['#attributes']) . '>' . check_plain($element['#value']) . '</textarea>';
  /*$output .= '</div>';*/
  return $output;
}


/**
 * Returns HTML for a fieldset form element and its children.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: An associative array containing the properties of the element.
 *     Properties used: #attributes, #children, #collapsed, #collapsible,
 *     #description, #id, #title, #value.
 *
 * @ingroup themeable
 * 
 */
function viamo_fieldset($variables) {
  $element = $variables['element'];
  //echo "<pre>";
  //print_r($element['#entity_type']); exit;
    
  element_set_attributes($element, array('id'));
  _form_set_class($element, array('form-wrapper'));
  
  if(isset($element['#entity_type'])) {
      $entity_type = $element['#entity_type'];
  } else {
      $entity_type ='';
  }  
  $output = '';
  $output = '<fieldset' . drupal_attributes($element['#attributes']) . '>';
  if (!empty($element['#title']) && $entity_type != 'profile2') {
    // Always wrap fieldset legends in a SPAN for CSS positioning.
    $output .= '<legend><span class="fieldset-legend">' . $element['#title'] . '</span></legend>';
  }
  $output .= '<div class="fieldset-wrapper">';
  if (!empty($element['#description'])) {
    //$output .= '<div class="fieldset-description">' . $element['#description'] . '</div>';
  }
  $output .= $element['#children'];
  if (isset($element['#value'])) {
    $output .= $element['#value'];
  }
  $output .= '</div>';
  $output .= "</fieldset>\n";
  return $output;
}

