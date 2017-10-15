<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function viamogift_purchased_views_data() {
    $data = array();               
    $data['commerce_registry_purchased']['table']['group'] = t('Commerce Registry Purchased Products');
    
    $data['commerce_registry_purchased']['table']['join']['commerce_product'] = array(        
            'left_field' => 'product_id',
            'field'      => 'product_id',        
    );
    
    $data['commerce_registry_purchased']['table']['base'] = array(
        'field' => 'registry_id', // This is the identifier field for the view.
        'title' => t('Commerce Registry Purchased Products'),
        'help' => t('This table is Commerce Registry Purchased Products'),
        'weight' => -10,
        'description' => 'This is Commerce Registry Purchased Products.',
    );
    $data['commerce_registry_purchased']['registry_id'] = array(
        'title' => t('Registry Id'),
        'help' => t('Registry Unique Id'),
        'filter' => array(
            'handler' => 'views_handler_filter_string',
        ),
        'field' => array(
            'handler' => 'views_handler_field',
            'click sortable' => TRUE,
        ),
        'sort' => array(
            'handler' => 'views_handler_sort',
        ),
        'argument' => array(
            'handler' => 'views_handler_argument',
        ),
        'relationship' => array(
            'handler' => 'views_handler_relationship',
            'base' => 'commerce_registry',
            'base field' => 'registry_id',
            'title' => t('Registry Id'),
            'label' => t('commerce_registry table registry_id'),
        ),      
        
    );
    $data['commerce_registry_purchased']['product_id'] = array(
        'title' => t('Product id'),
        'help' => t('Registry Purchased Product unique id for view'),
        'filter' => array(
            'handler' => 'views_handler_filter_string',
        ),
        'field' => array(
            'handler' => 'views_handler_field',
            'click sortable' => TRUE,
        ),
        'sort' => array(
            'handler' => 'views_handler_sort',
        ),        
        'argument' => array(
            'handler' => 'commerce_product_handler_argument_product_id',
        ),        
        'relationship' => array(
            'handler' => 'views_handler_relationship',
            'base' => 'commerce_product',
            'base field' => 'product_id',
            'relationship field' => 'product_id',
            'title' => t('commerce_product:product ID'),
            'label' => t('commerce_product table relations'),
        ),        
    );
     $data['commerce_registry_purchased']['purchaser_uid'] = array(
        'title' => t('Product Purchased purchaser_uid'),
        'help' => t('Product Purchased user uid for view'),
        'filter' => array(
            'handler' => 'views_handler_filter_string',
        ),
        'field' => array(
            'handler' => 'views_handler_field',
            'click sortable' => TRUE,
        ),
        'sort' => array(
            'handler' => 'views_handler_sort',
        ),
        'argument' => array(
            'handler' => 'views_handler_argument',
        ),
        'relationship' => array(
            'handler' => 'views_handler_relationship',
            'base' => 'users',
            'base field' => 'uid',
            'title' => t('Product add to Gift list user'),
            'label' => t('Product add to Gift list user'),
        ),
    );     
    $data['commerce_registry_purchased']['quantity'] = array(
        'title' => t('quantity'),
        'help' => t('Registry Purchased Products quantity for view'),
        'filter' => array(
            'handler' => 'views_handler_filter_string',
        ),
        'field' => array(
            'handler' => 'views_handler_field',
            'click sortable' => TRUE,
        ),
        'sort' => array(
            'handler' => 'views_handler_sort',
        ),
        'argument' => array(
            'handler' => 'views_handler_argument',
        ),
    );  
    $data['commerce_registry_purchased']['order_id'] = array(
        'title' => t('order_id'),
        'help' => t('Registry Purchased Products Order Id for view'),
        'filter' => array(
            'handler' => 'views_handler_filter_string',
        ),
        'field' => array(
            'handler' => 'views_handler_field',
            'click sortable' => TRUE,
        ),
        'sort' => array(
            'handler' => 'views_handler_sort',
        ),
        'argument' => array(
            'handler' => 'commerce_order_handler_argument_order_order_id',
            'name field' => 'order_number',
            'numeric' => TRUE,
            'validate type' => 'order_id',
        ),
    );      
    return $data;
}

/*
 *  Implement hook_views_data_alter(&$data)
 */

function viamogift_purchased_views_data_alter(&$data) {    
    $data['commerce_product']['table']['join']['commerce_registry_purchased']
            = array(		                
                'left_field' => 'product_id',
                'field'      => 'product_id'
            );                       
   // commerce_order View Data Table Alter        
    $data['commerce_order']['table']['join']['commerce_registry_purchased'] = array(        
            'left_field' => 'order_id',
            'field'      => 'order_id',        
    );
    
    $data['commerce_order']['order_id']['relationship'] = array(                                 
        'handler' => 'views_handler_relationship',
        'base' => 'commerce_registry_purchased',
        'base field' => 'order_id',
        'relationship field' => 'order_id',
        'title' => t('commerce_registry_purchased  product id'),
        'label' => t('commerce_registry_purchased  table relations'),        
    );   
}