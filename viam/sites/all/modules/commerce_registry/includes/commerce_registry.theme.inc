<?php
/**
 * @file
 * Commerce Registry theme functions.
 */

/**
 * Theme a registry.
 * @TODO: Show registry product purchases reflected in the quantity.
 */
function theme_commerce_registry_view($variables) {    
  //echo "<pre>";
  //print_r($variables); exit;
  global $user;
  $registry = $variables['registry'];
  drupal_add_css(drupal_get_path('module', 'commerce_registry') . '/css/commerce_registry.css');
  $crumbs = array();
  $crumbs[] = l(t('Home'), '/');
  if ($user->uid != 0) {
    $crumbs[] = l($user->name, 'user/' . $user->uid);
    $crumbs[] = l(t('My Registries'), 'user/' . $user->uid . '/registry');
  }
  drupal_set_breadcrumb($crumbs);
  $theme = '<div class="commerce-registry">';
  $theme .= "<div class='registry-owner'>";
  $ownerlink = $registry->owner->name;
  if (user_access('access user profiles')) {
    $ownerlink = l($registry->owner->name, 'user/' . $registry->owner->uid);
  }
  $ownervars = array(
    '!link' => $ownerlink,
    '!time' => format_date($registry->created),
  );
  $theme .= t("Created by !link on !time", $ownervars);
  $theme .= "</div>";
  if (isset($registry->description) && !empty($registry->description)) {
    $theme .= "<div class='registry-description'>";
    $theme .= check_plain($registry->description);
    $theme .= "</div>";
  }
  foreach ($registry->products as $product_id => $info) {
    $product = commerce_product_load($product_id);        
    $values = $info + array(
      'product' => $product,
      'registry' => $registry,
    );
    $theme .= theme('commerce_registry_product_view', $values);
  }
  if (empty($registry->products)) {
    $theme .= t('There are no products on this registry yet. Continue searching and feel free to add them later.');
  }
  
  $theme .= "</div>";
  
 /// echo "<pre>";
 // print_r($theme); exit;
  
  return $theme;
}

/**
 * Theme a product on a registry.
 */
function theme_commerce_registry_product_view($variables) {   
  $product = $variables['product'];
  $themed = "<div class='field field-registry-product registry-product commerce-product commerce-product-" . $product->product_id . "'>";
  $themed .= "<div class='product-title'><div class='field-label field-title-label label'>"
    . t('Title') . ": </div>";
  $themed .= "<div class='field-items value'>";
  $themed .= l($product->title, $variables['settings']['page']);
  $themed .= "</div>";
  $themed .= "</div>";
  $themed .= "<div class='product-quantity'><div class='field-label field-quantity-label label'>"
    . t('Quantity') . ": </div>";
  $themed .= "<div class='field-items value'>" . check_plain($variables['quantity']) . "</div>";
  $themed .= "</div>";
  $themed .= "<div class='product-message'><div class='field-label field-message-label label'>"
    . t('Message') . ": </div>";
  $themed .= "<div class='field-items value'>" . check_plain($variables['message']) . "</div>";
  $themed .= "</div>";
  $themed .= render(field_attach_view('commerce_product', $product, 'commerce_registry_product'));
  module_load_include('inc', 'commerce_registry', '/includes/commerce_registry.forms');
  $add_form_id = 'commerce_registry_product_add_to_cart_form_' . $product->product_id;
  $delete_form_id = 'commerce_registry_remove_product_' . $product->product_id;
  $themed .= theme('commerce_registry_product_in_cart', array('product' => $product, 'registry' => $variables['registry']));
  $themed .= render(drupal_get_form($add_form_id, $product, $variables['registry'], $variables['settings']['page']));
  if (commerce_registry_has_access('delete', $variables['registry'])) {
    $themed .= render(drupal_get_form($delete_form_id, $product, $variables['registry']));
  }
  $themed .= "</div>";
  return $themed;
}

/**
 * Theme function to show whether a product is in the cart or not.
 */
function theme_commerce_registry_product_in_cart($variables) {
  $theme = "<div class='product-in-cart'>";
  $registry = $variables['registry'];
  $product = $variables['product'];
  $order_id = commerce_registry_get_user_order();
  $product_ids = array();
  if ($order_id != 0) {
    $order = commerce_order_load($order_id);
    $order_wrapper = entity_metadata_wrapper('commerce_order', $order);
    foreach ($order_wrapper->commerce_line_items as $delta => $line_item_wrapper) {
      $line_item = $line_item_wrapper->value();
      if (isset($line_item->data) && isset($line_item->data['commerce_registry'])
        && $line_item->data['commerce_registry']->registry_id == $registry->registry_id) {
        // This line item is for this particular registry.
        $product_id = (int) $line_item_wrapper->commerce_product->product_id->value();
        if (isset($product_ids[$product_id])) {
          $product_ids[$product_id] += (int) $line_item_wrapper->quantity->value();
        }
        else {
          $product_ids[$product_id] = (int) $line_item_wrapper->quantity->value();
        }
      }
    }
  }
  if (array_key_exists($product->product_id, $product_ids)) {
    // Product is in the user's cart already.
    $vars = array(
      '@count' => $product_ids[$product->product_id],
      '!product' => '<em>' . $product->title . '</em>',
      '!cart' => l(t('your cart'), 'cart'),
    );
    $theme .= t('You have @count of !product in !cart already.', $vars);
  }
  else {
  }
  $theme .= "</div>";
  return $theme;
}

/**
 * Theme the registry list for the user's registry list block.
 */
function theme_commerce_registry_user_registry_list($variables) {
  drupal_add_css(drupal_get_path('module', 'commerce_registry') . '/css/commerce_registry.css');
  $user = $variables['account'];
  $theme = '';
  foreach ($variables['registries'] as $registry) {
    $theme .= "<div class='field commerce-registry registry-" . $registry->registry_id
      . " user-" . $user->uid . "-registry user-" . $user->uid
      . "-registry-" . $registry->registry_id . "'>";
    $theme .= "<div class='registry-info'>";
    $theme .= "<div class='registry-name'>" . l($registry->name, 'registry/' . $registry->url) . "</div>";
    $theme .= "<div class='registry-description'>" . check_plain($registry->description) . "</div>";
    $theme .= "</div>";
    $theme .= "<div class='registry-product-info'>";
    $theme .= "<div class='registry-product-count'>";
    $theme .= "<div class='field-label label'>" . t('Products: ') . "</div>";
    $total = 0;
    $currency = '';
    $products = 0;
    foreach ($registry->products as $product_id => $product_info) {
      $product = commerce_product_load($product_id);
      if (empty($currency)) {
        $currency = $product->commerce_price[LANGUAGE_NONE][0]['currency_code'];
      }
      $total += ((int) $product->commerce_price[LANGUAGE_NONE][0]['amount'] * (int) $product_info['quantity']);
      $products += (int) $product_info['quantity'];
    }
    $theme .= "<div class='field-items value'>" . $products . "</div>";
    $theme .= "</div>";
    $theme .= "<div class='registry-product-amount'>";
    $theme .= "<div class='field-label label'>" . t('Total: ') . "</div>";
    $theme .= "<div class='field-items value'>" . commerce_currency_format($total, $currency) . "</div>";
    $theme .= "</div>";
    $theme .= "</div>";
    $theme .= "</div>";
  }
  return $theme;
}

/**
 * Show access checkboxes in a grid.
 */
function theme_commerce_registry_access_checkboxes($element) {
  $element = $element['form'];
  if (!isset($element['view'])) {
    return;
  }
  $item = '';
  $rows[] = array();
  if (is_string($element['#itemname'])) {
    $item = $element['#itemname'];
    $rows[] = array(
      $item,
      drupal_render($element['view']),
      drupal_render($element['add']),
      drupal_render($element['remove'])
    );
  }
  else {
    $rows[] = array(
      drupal_render($element['view']),
      drupal_render($element['add']),
      drupal_render($element['remove'])
    );
  }
  $variable = array(
    'rows' => $rows,
    'attributes' => array('class' => 'checkbox_columns'),
  );
  return theme('table', $variable);
}
