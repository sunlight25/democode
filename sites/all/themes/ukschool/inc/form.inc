<?php
/**
 * Implements theme_select().
 */
function ukschool_select($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id', 'name', 'size'));
  _form_set_class($element, array('form-select'));

  return '<select' . drupal_attributes($element['#attributes']) . '>' . form_select_options($element) . '</select>';
}


function ukschool_form_alter(&$form, $form_state, $form_id) {
    
  if ($form_id == 'user_register_form') {
      
    drupal_set_title(t('Create new account'));
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
}

/**
 * Implements theme_form_element().
 */
function ukschool_form_element($variables) {
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

function tutor_form_submit_handler(&$form, &$form_state){
    global $base_url,$user;           
   
    if (in_array('Tutor', array_values($user->roles), TRUE)){
        $insert = db_insert('profile')
        ->fields(array(            
            'type' => 'tutor_profile',
            'uid' => $user->uid,
            'label' => 'Tutor Profile',
            'created' => strtotime(format_date(time(), 'custom', 'Y-m-d H:i:s')),
            'changed' => strtotime(format_date(time(), 'custom', 'Y-m-d H:i:s')),            
        ))
        ->execute();
        $form_state['redirect'] = 'profile-tutor_profile'; 
    }else{
        $form_state['redirect'] = 'user/'.$user->uid; 
    }       
}



