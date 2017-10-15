<?php
/**
 * Implements hook_views_data_alter().
 *
 * @param $data
 *   Information about Views' tables and fields.
 */
function commerce_add_to_cart_confirmation_extras_views_data_alter(&$data) {
  // Add the Title form field to 
  $data['commerce_product']['add_to_cart'] = array(
    'field' => array(
      'title' => t('Add To cart Popup'),
      'help' => t('Add To cart Popup'),
      'handler' => 'commerce_add_to_cart_confirmation_extras_field_handler_add_to_cart_btn',
    ),
  );  
}