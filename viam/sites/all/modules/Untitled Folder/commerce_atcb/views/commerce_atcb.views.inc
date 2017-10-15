<?php
/**
 * Implements hook_views_data_alter().
 *
 * @param $data
 *   Information about Views' tables and fields.
 */
function commerce_atcb_views_data_alter(&$data) {
  // Add the Title form field to 
  $data['commerce_product']['add_to_cart'] = array(
    'field' => array(
      'title' => t('Add To cart Button'),
      'help' => t('Add To cart Button'),
      'handler' => 'commerce_atcb_field_handler_add_to_cart_btn',
    ),
  );
  $data['commerce_product']['add_to_list'] = array(
    'field' => array(
      'title' => t('Add To Gift List'),
      'help' => t('Add To Gift List'),
      'handler' => 'commerce_atcb_field_handler_add_to_list_btn',
    ),
  );
}