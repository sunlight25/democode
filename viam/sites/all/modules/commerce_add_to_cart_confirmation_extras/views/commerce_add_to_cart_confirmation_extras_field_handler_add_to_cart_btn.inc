<?php

/**
   * @file
   *
   * A Views' field handler for editing a node title.
   *
   */
class commerce_add_to_cart_confirmation_extras_field_handler_add_to_cart_btn  extends views_handler_field {
  function construct() {
    parent::construct();
    $this->additional_fields['product_id'] = 'product_id';    
  }

  function query() {
    $this->ensure_my_table();
    $this->add_additional_fields();
  }
  
   /**
   * Render the field.
   *
   * @param $values
   *   The values retrieved from the database.
   */
  function render($values) {
     // Add Ctool modal and configuration.
    ctools_include('ajax');
    ctools_include('modal');
    drupal_add_js(array(
      'cart-button-popup' => array(
        'modalSize' => array(
          'type' => 'fixed',
          'width' => 550,
          'height' => 300,
           'top'   => 50,
        ),
        'modalOptions' => array(
          'opacity' => .5,
          'background-color' => '#000',
        ),
        'animation' => 'fadeIn',
        'animationSpeed'=> 'fast',
        'modalTheme' => 'CToolsULModal',
        'throbber' => '',//theme('image', array('path' => ctools_image_path('loading_animation.gif', 'modal_forms'), 'alt' => t('Loading...'), 'title' => t('Loading'))),
        'closeText' => '',//t('Close'),
      ),
    ), 'setting');
    
    ctools_modal_add_js();    
    ctools_add_js('commerce_add_to_cart_confirmation_extras', 'commerce_add_to_cart_confirmation_extras');
    ctools_add_css('commerce_add_to_cart_confirmation_extras', 'commerce_add_to_cart_confirmation_extras');
    $product_id = $this->get_value($values, 'product_id');    
    $button_text = t('Add to cart button');
    $button_url = 'add_to_cart/nojs/' . $product_id;
    $result[] = l($button_text, $button_url, array(
      'attributes' => array('class' => array('right','ctools-use-modal', 'ctools-modal-cart-button-popup'), 'title' => $button_text),
      'query' => array('destination' => $_GET['q']),
    ));
    
    $element[0]['#markup'] = $result[0]; // Assign it to the #markup of the element    
    return $element;
  }

}
