<?php
/**
 * @file
 * Commerce Registry rules integration.
 */

/**
 * Implements hook_rules_event_info().
 */
function commerce_registry_rules_event_info() {
  $events['commerce_registry_new'] = array(
    'label' => t('A registry is created'),
    'group' => t('Commerce Registry'),
    'variables' => array(
      'commerce_registry' => array(
        'label' => t('Commerce Registry'),
        'type' => 'commerce_registry',
      ),
      'owner' => array(
        'label' => t('The new registry owner'),
        'type' => 'user',
      ),
    ),
  );
  $events['commerce_registry_update'] = array(
    'label' => t('A registry is updated'),
    'group' => t('Commerce Registry'),
    'variables' => array(
      'commerce_registry' => array(
        'label' => t('Commerce Registry'),
        'type' => 'commerce_registry',
      ),
    ),
  );
  $events['commerce_registry_product_add'] = array(
    'label' => t('Product is added to a registry'),
    'group' => t('Commerce Registry'),
    'variables' => array(
      'commerce_registry' => array(
        'label' => t('Commerce Registry'),
        'type' => 'commerce_registry',
      ),
      'commerce_product' => array(
        'label' => t('Commerce Product'),
        'type' => 'commerce_product',
      ),
      'added_by_user' => array(
        'label' => t('User that added this product'),
        'type' => 'user',
      ),
    ),
  );
  $events['commerce_registry_product_remove'] = array(
    'label' => t('Product is removed from a registry'),
    'group' => t('Commerce Registry'),
    'variables' => array(
      'commerce_registry' => array(
        'label' => t('Commerce Registry'),
        'type' => 'commerce_registry',
      ),
      'commerce_product' => array(
        'label' => t('Commerce Product'),
        'type' => 'commerce_product',
      ),
    ),
  );
  $events['commerce_registry_product_purchased'] = array(
    'label' => t('A registry product is purchased'),
    'group' => t('Commerce Registry'),
    'variables' => array(
      'commerce_registry' => array(
        'label' => t('The Commerce Registry for the purchase'),
        'type' => 'commerce_registry',
      ),
      'commerce_product' => array(
        'label' => t('Commerce Product that was purchased'),
        'type' => 'commerce_product',
      ),
      'quantity' => array(
        'label' => t('Quantity of product purchased'),
        'type' => 'integer',
      ),
      'purchaser' => array(
        'label' => t('User that purchased this product'),
        'type' => 'user',
      ),
      'commerce_order' => array(
        'label' => t('Commerce Order of the purchase'),
        'type' => 'commerce_order',
      ),
    ),
  );

  return $events;
}

/**
 * Implements hook_rules_condition_info().
 */
function commerce_registry_rules_condition_info() {
  $conditions['commerce_registry_order_has_registry_product'] = array(
    'label' => t('Order has a line item with a product for a registry'),
    'group' => t('Commerce Registry'),
    'parameter' => array(
      'commerce_order' => array(
        'type' => 'commerce_order',
        'label' => t('Order to check for registry line items'),
      ),
    ),
    'callbacks' => array(
      'execute' => 'commerce_registry_order_has_registry_product',
    ),
  );
  return $conditions;
}

/**
 * Implements hook_rules_action_info().
 */
function commerce_registry_rules_action_info() {
  $actions['commerce_registry_mark_product_purchased'] = array(
    'label' => t('Mark a registry product as purchased'),
    'group' => t('Commerce Registry'),
    'parameter' => array(
      'commerce_line_item' => array(
        'label' => t('Commerce Line Item containing the product that was purchased'),
        'type' => 'commerce_line_item',
      ),
    ),
  );

  return $actions;
}

/**
 * Condition callback: Checks if the line item is for a registry.
 */
function commerce_registry_order_has_registry_product($order) { 
    //echo 45444; exit;
  $order_wrapper = entity_metadata_wrapper('commerce_order', $order);
  foreach ($order_wrapper->commerce_line_items as $delta => $line_item_wrapper) {
    if (_commerce_registry_line_item_for_registry($line_item_wrapper->value())) {
      return TRUE;
    }
  }
  return FALSE;
}

/**
 * Helper function to see if a line item product is for a registry.
 */
function _commerce_registry_line_item_for_registry($line_item) {
  if (isset($line_item->data) && isset($line_item->data['commerce_registry'])) {
    return TRUE;
  }
  return FALSE;
}

/**
 * Action callback: Adds a purchased product to the registry.
 */
function commerce_registry_mark_product_purchased($lineitem) {
    
  if (!_commerce_registry_line_item_for_registry($lineitem)) {
    return;
  }  
  global $user;
  $line_item_wrapper = entity_metadata_wrapper('commerce_line_item', $lineitem);
  $registry = $lineitem->data['commerce_registry'];
  $product = $line_item_wrapper->commerce_product->value();
  $quantity = $line_item_wrapper->quantity->value();
  $record = (object) array(
    'registry_id' => $registry->registry_id,
    'product_id' => $product->product_id,
    'order_id' => $lineitem->order_id,
    'quantity' => $quantity,
    'purchaser_uid' => $user->uid,
  );
  drupal_write_record('commerce_registry_purchased', $record);
  // Trigger all rules and hooks.
  $order = commerce_order_load($lineitem->order_id);
  rules_invoke_all('commerce_registry_product_purchased', $registry, $product, $quantity, $user, $order);
}
