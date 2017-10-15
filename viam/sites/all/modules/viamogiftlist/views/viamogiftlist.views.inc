<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function viamogiftlist_views_data() {
    $data = array();               
    $data['commerce_registry_products']['table']['group'] = t('Commerce Registry Products');

    $data['commerce_registry_products']['table']['base'] = array(
        'field' => 'registry_id', // This is the identifier field for the view.
        'title' => t('Commerce Registry Products'),
        'help' => t('This table is Commerce Registry Products'),
        'weight' => -10,
        'description' => 'This is Commerce Registry Products.',
    );
    $data['commerce_registry_products']['registry_id'] = array(
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
    $data['commerce_registry_products']['product_id'] = array(
        'title' => t('Product id'),
        'help' => t('Product unique id for view'),
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
            'base' => 'commerce_registry_purchased',
            'base field' => 'product_id',
            'relationship field' => 'product_id',
            'title' => t('commerce registry purchased:product ID'),
            'label' => t('commerce registry purchased table relations'),
        ),
    );
     $data['commerce_registry_products']['added_by_uid'] = array(
        'title' => t('Product added_by_uid'),
        'help' => t('Product added by uid for view'),
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
    $data['commerce_registry_products']['quantity'] = array(
        'title' => t('quantity'),
        'help' => t('Registry Products quantity for view'),
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
    $data['commerce_registry_products']['added_time'] = array(
        'title' => t('added_time'),
        'help' => t('Registry Products added time for view'),
        'field' => array(
            'handler' => 'views_handler_field_date',
            'click sortable' => TRUE,
        ),
        'filter' => array(
            'handler' => 'views_handler_filter_date',
        ),
        'sort' => array(
            'handler' => 'views_handler_sort_date',
        ),
        'argument' => array(
            'handler' => 'views_handler_argument',
        ),
    );      
    return $data;
}

/*
 *  Implement hook_views_data_alter(&$data)
 */
function viamogiftlist_views_data_alter(&$data) {
    
    $data['commerce_product']['table']['join']['commerce_registry_products'] = array(        
            'left_field' => 'product_id',
            'field'      => 'product_id',        
    );
    
    $data['commerce_product']['product_id']['relationship'] = 
        array(
            'handler' => 'views_handler_relationship',
            'base' => 'commerce_registry_products',
            'base field' => 'product_id',
            'relationship field' => 'product_id',
            'title' => t('commerce_registry_products product id'),
            'label' => t('commerce_registry_products table relations'),        
        );                    
}
