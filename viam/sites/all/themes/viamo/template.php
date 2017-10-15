<?php
include_once dirname(__FILE__) . '/inc/common.inc';
require_once dirname(__FILE__) . '/inc/form.inc';
require_once dirname(__FILE__) . '/inc/menu.inc';
require_once dirname(__FILE__) . '/inc/theme.inc';
    
/**
 * @file
 * The primary PHP file for this theme.
 */    
function commerce_kickstart_rebuild_feature($module) {
  $feature = features_load_feature($module, TRUE);
  $items[$module] = array_keys($feature->info['features']);
  // Need to include any new files.
  features_include_defaults(NULL, TRUE);
  _features_restore('enable', $items);
  // Rebuild the list of features includes.
  features_include(TRUE);
  // Reorders components to match hook order and removes non-existant.
  $all_components = array_keys(features_get_components());
  foreach ($items as $module => $components) {
    $items[$module] = array_intersect($all_components, $components);
  }
  _features_restore('rebuild', $items);
}

/**
 * Add body classes if certain regions have content.
*/

function viamo_preprocess_html(&$variables) {       
  if (!empty($variables['page']['featured'])) {
    $variables['classes_array'][] = 'featured';
  }

  if (!empty($variables['page']['triptych_first'])
    || !empty($variables['page']['triptych_middle'])
    || !empty($variables['page']['triptych_last'])) {
     $variables['classes_array'][] = 'triptych';
  }

  if (!empty($variables['page']['footer_firstcolumn'])
    || !empty($variables['page']['footer_secondcolumn'])
    || !empty($variables['page']['footer_thirdcolumn'])
    || !empty($variables['page']['footer_fourthcolumn'])) {
    $variables['classes_array'][] = 'footer-columns';
  } 
    
    $variables['html_attributes_array'] = array(        
            'lang' => $variables['language']->language,
            'dir' => $variables['language']->dir,        
    );
  
    // Create a dedicated attributes array for the BODY element.
    if (!isset($variables['body_attributes_array'])) {
        $variables['body_attributes_array'] = array();
    }
    
    // Ensure there is at least a class array.
    if (!isset($variables['body_attributes_array']['class'])) {
        $variables['body_attributes_array']['class'] = array();
    }  
}


/**
 * Processes variables for the "html" theme hook.
 *
 * See template for list of available variables.
 *
 * **WARNING**: It is not recommended that this function be copied to a
 * sub-theme. There is rarely any need to process the same variables twice.
 *
 * If you need to add something to the "html_attributes_array" or
 * "body_attributes_array" arrays, you should do so in a hook_preprocess_html()
 * function since process functions will always run after all preprocess
 * functions have been executed.
 *
 * If there is a need to implement a hook_process_html() function in your
 * sub-theme (to process your own custom variables), ensure that it doesn't
 * add this base theme's logic and risk introducing breakage and performance
 * issues.
 *
 * @see html.tpl.php
 *
 * @ingroup theme_process
 */

function viamo_process_html(&$variables) {
  // Merge in (not reference!) core's ambiguous and separate "attribute" and
  // "class" arrays. These arrays are meant for the BODY element, but it must
  // be done at the process level in case sub-themes wish to add classes to
  // core's non-standard arrays (which are for the BODY element only).
  // @see https://www.drupal.org/node/2868426
  
  $variables['body_attributes_array'] = drupal_array_merge_deep($variables['body_attributes_array'], $variables['attributes_array']);

  // Use this project's class helper (to eliminate any duplicate classes).
 _viamo_add_class($variables['classes_array'], $variables, 'body_attributes_array');

  // Finally, convert the arrays into proper attribute strings.
  $variables['html_attributes'] = drupal_attributes($variables['html_attributes_array']);
  $variables['body_attributes'] = drupal_attributes($variables['body_attributes_array']);
}

/**
 * Pre-processes variables for the "page" theme hook.
 *
 * See template for list of available variables.
 *
 * @see page.tpl.php
 *
 * @ingroup theme_preprocess
 */
function viamo_preprocess_page(&$variables) {              
      global $user;      
      
      if(arg(0)=='user' && arg(1)==$user->uid && arg(2) == 'addressbook') {          
            $userdata = user_load($user->uid);                        
	$variables['title'] = $userdata->field_first_name['und']['0']['value'].' '.$userdata->field_lastname['und']['0']['value'];				                    
      }    
      //Add information about the number of sidebars.
     
        if (!empty($variables['page']['sidebar_first']) && !empty($variables['page']['sidebar_second'])) {
          $variables['content_column_class'] = ' class="col s6"';
        }
        elseif (!empty($variables['page']['sidebar_first']) || !empty($variables['page']['sidebar_second'])) {
          $variables['content_column_class'] = ' class="col s10"';
        }
        else {
          $variables['content_column_class'] = ' class="col s12"';
        }


        if(preg_match("/^standard-dash$/", $_GET['q'])) {      
             $variables['container_class'] = '';  
        } else {
             $variables['container_class'] = 'container';  
        }

        if(preg_match("/^event-detail\/[0-9]{0,5}$/", $_GET['q'])) {
             $variables['container_class'] = '';  
        } else {
          $variables['container_class'] = 'container';  
        }

        // Primary nav.
        $variables['primary_nav'] = FALSE;
        if ($variables['main_menu']) {
          // Build links.
          $variables['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
          // Provide default theme wrapper function.
          //$variables['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
        }

        // Secondary nav.
        $variables['secondary_nav'] = FALSE;
        if ($variables['secondary_menu']) {
          // Build links.
         // $variables['secondary_nav'] = menu_tree(variable_get('menu_secondary_links_source', 'user-menu'));
          // Provide default theme wrapper function.
          $variables['secondary_nav']['#theme_wrappers'] = array('menu_tree__secondary');
        }

        $variables['navbar_classes_array'] = array('navbar');

        //drupal_add_js('https://code.jquery.com/jquery-3.2.1.min.js', array('type' => 'external','group'=>'-55','weight'=>'-12', 'scope' => 'footer'));
        //drupal_add_js('https://code.jquery.com/jquery-2.2.4.min.js', array('type' => 'external','group'=>'-55','weight'=>'-12', 'scope' => 'footer'));
        drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js', array('type' => 'external', 'group'=>'-55','weight'=>'-11','scope' => 'footer'));    
        //drupal_add_js('https://maps.googleapis.com/maps/api/js?key=AIzaSyAXsEOZnvvPOmIrY_Ik9qfwQnClHFoqtRk&callback=initMap',array('type' => 'external', 'group'=>'-55','weight'=>'-7', 'scope' => 'footer'));
        $variables['scripts'] = drupal_get_js();      

         if (isset($variables['node']->type) && arg(2) == 'edit') {                            
             if($variables['node']->type=='event_calendar') {
                 $variables['theme_hook_suggestions'][] = 'page__node__' . $variables['node']->type.'__edit';
             } else{
                 $variables['theme_hook_suggestions'][] = 'page__node__edit';
             }        
         }            

         // Removes a tab called 'Reviews, change with your own tab title   
         if(!in_array('administrator', $user->roles)) {
              $removetab = array('Order history','My Registries','Address Book','Edit');       
              foreach($removetab as $key => $val) {
                   viamo_removetab($val, $variables);
              }
         }
}

/*
 *  Implement hook_preprocess_region();
 */

function viamo_preprocess_region(&$variables, $hook) {
    if($variables['region'] == "homepagebanner") {
        $variables['classes_array'][] = 'bh';
        $variables['classes_array'][] = 'hero-area';        
    }
}


/**
 * Processes variables for the "block" theme hook.
 *
 * See template for list of available variables.
 *
 * @see block.tpl.php
 *
 * @ingroup theme_process
 */
function viamo_process_block(&$variables) {    
  // Drupal 7 should use a $title variable instead of $block->subject.
  // Don't override an existing "title" variable, some modules may already it.
  if (!isset($variables['title'])) {
    $variables['title'] = $variables['block']->subject;
  }
  $variables['title'] = filter_xss_admin($variables['title']);
}


/**
 * viamo theme wrapper function for the  main menu mobile view links added
 */

function viamo_menu_tree__menu_top_main_menu_mobile_view($variables) {    
    global $base_url,$user; 
    $array = array();   
    $theme_path_base = base_path() . path_to_theme();
    $extrLinks = '';
    $extrLinks.='<li class="active"><a href="/"><span>Homepage</span></a></li>';    
    if (user_is_logged_in()) {
        $extrLinks .= '<li class="leaf main-li-login">';
        if($array) {
	 $extrLinks .= '<span  class="mob_nav_pic_img"><a class="m_link" href="/user">' .theme_image($array) . '</a></span>';
        } else {
                $extrLinks .= '<span  class="login-icon"><img alt="login" src="' . $theme_path_base . '/img/login.png"></span>';
        }
        $extrLinks .= '<span class="login-name-span" > ' . getTrimmedUserName() . ' </span><span class="login-icon1"><img alt="login" src="' . $theme_path_base . '/img/log-out.png"></span><a class="level1 sign-out-mobile"  href="' . get_baseurl_with_language() . '/user/logout"><span>' . t('Sign Out') . '</span></a>';
        $extrLinks .= '</li>';
    } else {
        //$extrLinks .= '<li class="leaf">
         //<a class="collection-item" href="' . get_baseurl_with_language() . '/user/login"><span>' . t('Login') . '</span></a>        
       //</li>';                       
    }    
    $var = $extrLinks . $variables['tree'];
    //echo "<pre>";
    //print_r($variables); exit;
    return '<ul>'.$variables['tree'].'</ul>';            
    //return '<nav id="main_menu"><ul>' . $var . '</ul></nav>';            
}

function getTrimmedUserName() {
    global $user;
    if (strlen($user->name) > 10) {
        return ucfirst(substr($user->name, 0, 7) . '...');
    } else {
        return ucfirst($user->name);
    }
}

/**
 * return url with language prefix
 */

function get_baseurl_with_language() {
    global $base_url, $language;
    if ($language->language != 'en') {
        return $base_url.'/'.$language->language;
    } else {
        return $base_url;
    }
}

/**
 * return url with language prefix
 */

function viamo_preprocess_block(&$vars) {
  /* Set shortcut variables. Hooray for less typing! */
  $block_id = $vars['block']->module . '-' . $vars['block']->delta;
  $classes = &$vars['classes_array'];
  $title_classes = &$vars['title_attributes_array']['class'];
  $content_classes = &$vars['content_attributes_array']['class'];   
  
  /* Add classes based on the block delta. */
  switch ($block_id) {
    /* System Navigation block */
    case 'block-views-exp-viamo-venues-page':
     // $classes[] = 'container';      
    //  $content_classes[] = 'container';
      break;    
  }
}



/**
 * Implements hook_preprocess_image().
 *  
 */      
function viamo_preprocess_image(&$variables) {        
    /*
     * Below If conditions Use for Location taxonomy "venue_category_350_350" unset default image style 
     */        
    if(isset($variables['style_name'])){
        if ($variables['style_name'] == 'venue_category_350_350' || $variables['style_name'] == 'product-350_350' || $variables['style_name'] == 'related-product-250_203'  || $variables['style_name'] ==  'product-img-800_800') {           
            foreach (array('width', 'height','typeof') as $key) {
               unset($variables[$key]);
            }                           
            $variables['attributes']['class'][] = 'img-responsive';       
            if($variables['style_name'] == 'product-img-800_800'){
                unset($variables['attributes']['class']);
                $variables['attributes']['class'][] = 'responsive-img';                       
                //$variables['attributes']['class'][] = 'materialboxed';       
            }
        } 
       
        // Remove query string for image.
       //$variables['path'] = preg_replace('/\?.*/', '', $variables['path']);        
    }    
}


/**
 * Template preprocess function for hybridauth_widget.
 */
function viamo_preprocess_hybridauth_widget(&$vars, $hook) {
    
  $element = $vars['element'];  
  $element['providers']['Facebook']['text'] ='<i class="fa fa-facebook"></i>Sign in with facebook';                                           
  $element['providers']['Twitter']['text'] ='<i class="fa fa-twitter"></i>Sign Up using Twitter';
  $element['providers']['Google']['text'] ='<i class="fa fa-google-plus"></i>Sign Up using Google Plus';  
  $element['providers']['Facebook']['options']['attributes']['class'][]='waves-effect waves-light btn-large social facebook';
  $element['providers']['Twitter']['options']['attributes']['class'][]='waves-effect waves-light btn-large social twitter';
  $element['providers']['Google']['options']['attributes']['class'][]='waves-effect waves-light btn-large social google';      
  //echo "<pre>";
  //print_r($element['providers']['Facebook']['options']['attributes']); exit;
  $vars['providers'] = array();
  foreach ($element['providers'] as $provider) {
    $vars['providers'][] = l(render($provider['text']), $provider['path'], $provider['options']);
  }
  
  
  
}


/**
 * @file
 * Commerce Registry theme functions.
 */

/**
 * Theme a registry.
 * @TODO: Show registry product purchases reflected in the quantity.
 */
function viamo_commerce_registry_view($variables) { 
  global $user;
  $registry = $variables['registry'];
  
  //echo "<pre>";
  //print_r(count($registry->products)); exit;
  
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
  if (isset($registry->description) && !empty($registry->description)) {
    $theme .= "<div class='registry-description'>";
    $theme .= check_plain($registry->description);
    $theme .= "</div>";
  }
  if(count($registry->products)>0) {
    $theme.= "<div class='registry-product-count'>";
    $theme.= 'Gift List Total Product:'.count($registry->products);
    $theme.= "</div>";
  }
  //count($registry->products)
  $theme .= t("Created by !link on !time", $ownervars);
  $theme .= "</div>";
  $theme.= '<div class="view-content container">';
  $theme.= '<div class="row">';
  foreach ($registry->products as $product_id => $info) {
    $product = commerce_product_load($product_id);                
    $values = $info + array(
      'product' => $product,
      'registry' => $registry,
    );    
    $theme.= theme('commerce_registry_product_view', $values);
  
    
  }
  $theme.='</div></div>';
  if (empty($registry->products)) {
    $theme .= t('There are no products on this registry yet. Continue searching and feel free to add them later.');
  }  
  $theme .= "</div>";   
  return $theme;
}

/**
 * Theme a product on a registry.
 * 
 */
function viamo_commerce_registry_product_view($variables) {    
  $product = $variables['product'];   
  $productPath = viamogiftlist_product_display_node_path($product);  
  
  // get below function(getPurchaseproductCount) we are using for purchase product count
  // abilable in viamogiftlist.module file
  $Purchaseproduct= getPurchaseproductCount($variables['registry']->registry_id,$product->product_id);    
  $purchaseProductCount =0;
  if(count($Purchaseproduct)>0) {
      $purchaseProductCount = $Purchaseproduct[0]->product_count;
            
  }
 // $themed = "<div class='field field-registry-product registry-product commerce-product commerce-product-" . $product->product_id . "'>";
 // $themed.= '<div class="view-content container">;
  //$themed = '<div class="row">';  
  $field_images = field_view_field('commerce_product', $product, 'field_images',array('label'=>'hidden','settings' => array('image_style' => 'product-350_350')));
  $themed = '<div class="col-sm-3">
            <div class="product-item">'.render($field_images); 
  $themed.= '<h3 class="item-name h6 upper gold mb-1">'.l($product->title, $productPath).'</h3>';  
  $themed.= '<span class="pr-quanity">Quantity:'.check_plain($variables['quantity']).'</span>';
  if($purchaseProductCount>0) {
    $themed.= '<span class="pr-quanity">&nbsp;&nbsp;Purchase Quantity:'.check_plain($purchaseProductCount).'</span>';
  }
  $commerce_price = field_view_field('commerce_product', $product, 'commerce_price',array('label'=>'hidden'));
  $themed.= '<span class="price">'.render($commerce_price).'</span>';
  $themed.= '<div class="buttons-block">';
   module_load_include('inc', 'commerce_registry', '/includes/commerce_registry.forms');
   $add_form_id = 'commerce_registry_product_add_to_cart_form_' . $product->product_id;
   $delete_form_id = 'commerce_registry_remove_product_' . $product->product_id; 
  if($variables['quantity']>$purchaseProductCount) {    
    
    $themed .= theme('commerce_registry_product_in_cart', array('product' => $product, 'registry' => $variables['registry']));        
    $registry_Image = drupal_get_form($add_form_id, $product, $variables['registry'], $variables['settings']);    
    $themed .= render($registry_Image);    
    
  } else{
    $themed .=  '<p>Product Quantity is  zero remaining.</p>';
  } 
  if(count($Purchaseproduct)<=0) {
    if (commerce_registry_has_access('delete', $variables['registry'])) {
      if (commerce_registry_has_access_custom_function('delete', $variables['registry'])) {
        $deleteFormId = drupal_get_form($delete_form_id, $product, $variables['registry']);
        $themed .= render($deleteFormId);
      }
    }
  }
  $themed.= '</div>';
  $themed.= "</div>";	
  $themed.= "</div>";
  //$themed.= "</div>";
  return $themed;
}

/**
 *  hook_preprocess_overlay();
 *  @param type $variables;
 */

function viamo_preprocess_overlay(&$variables) { 
    
 //drupal_add_js('https://code.jquery.com/jquery-2.2.4.min.js', array('type' => 'external','group'=>'-55','weight'=>'-12', 'scope' => 'footer'));  
// drupal_add_js(drupal_get_path('theme', 'viamo') .'/js/script.js', array('preprocess' =>1,'defer' =>'','type'=>'file','group'=>'-50','weight'=>'-7','every_page'=>1,'cache'=>1,'scope' => 'footer')); 
 
 // drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js', array('type' => 'external', 'group'=>'-55','weight'=>'-11','scope' => 'footer'));    
  //drupal_add_js('https://maps.googleapis.com/maps/api/js?key=AIzaSyAXsEOZnvvPOmIrY_Ik9qfwQnClHFoqtRk&callback=initMap',array('type' => 'external', 'group'=>'-55','weight'=>'-7', 'scope' => 'footer'));
  //$variables['scripts'] = drupal_get_js();      
  //$variables['tabs'] = menu_primary_local_tasks();
  //unset($variables['tabs']);
 // $variables['title'] = drupal_get_title();
 // $variables['disable_overlay'] = overlay_disable_message();
 // $variables['content_attributes_array']['class'][] = 'clearfix';
    /*if (overlay_get_mode() == 'child') {                
        $variables['template_files'][] = 'page-overlay';
   }*/
}


// Remove undesired local task tabs.
// Related to yourthemename_removetab() in yourthemename_preprocess_page().
function viamo_removetab($label, &$vars) {

  // Remove from primary tabs
  $i = 0;
  if(isset($vars['tabs']['#primary'])) {
    if (is_array($vars['tabs']['#primary'])) {
      foreach ($vars['tabs']['#primary'] as $primary_tab) {
        if ($primary_tab['#link']['title'] == $label) {
          unset($vars['tabs']['#primary'][$i]);
        }
        ++$i;
      }
    }
  }

  // Remove from secundary tabs
  $i = 0;
  if(isset($vars['tabs']['#secundary'])) {
    if (is_array($vars['tabs']['#secundary'])) {
      foreach ($vars['tabs']['#secundary'] as $secundary_tab) {
        if ($secundary_tab['#link']['title'] == $label) {
          unset($vars['tabs']['#secundary'][$i]);
        }
        ++$i;
      }
    }
  }
}

/*
 * @see theme_pager()
 *
 * @ingroup themeable
 */
function viamo_pager_link($variables) {   
  $text = $variables['text'];
  $page_new = $variables['page_new'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $attributes = $variables['attributes'];

  $page = isset($_GET['page']) ? $_GET['page'] : '';
  if ($new_page = implode(',', pager_load_array($page_new[$element], $element, explode(',', $page)))) {
    $parameters['page'] = $new_page;
  }

  $query = array();
  if (count($parameters)) {
    $query = drupal_get_query_parameters($parameters, array());
  }
  if ($query_pager = pager_get_query_parameters()) {
    $query = array_merge($query, $query_pager);
  }

  // Set each pager link title
  if (!isset($attributes['title'])) {
    static $titles = NULL;
    if (!isset($titles)) {
      $titles = array(
        t('« first') => t('Go to first page'),
        t('‹ previous') => t('Go to previous page'),
        t('next ›') => t('Go to next page'),
        t('last »') => t('Go to last page'),
      );
    }
    if (isset($titles[$text])) {
        //echo "<pre>";
        //print_r($attributes); exit;
      $attributes['title'] = $titles[$text];
    }
    elseif (is_numeric($text)) {
      $attributes['title'] = t('Go to page @number', array('@number' => $text));
    }
  }

  // @todo l() cannot be used here, since it adds an 'active' class based on the
  //   path only (which is always the current path for pager links). Apparently,
  //   none of the pager links is active at any time - but it should still be
  //   possible to use l() here.
  // @see http://drupal.org/node/1410574
  $attributes['href'] = url($_GET['q'], array('query' => $query));
  return '<a' . drupal_attributes($attributes) . '>' . check_plain($text) . '</a>';
}

function viamo_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« first')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('last »')), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('pager-first'),
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous'),
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('waves-effect'),
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-current active'),
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('waves-effect'),
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next'),
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => array('pager-last'),
        'data' => $li_last,
      );
    }
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('pager pagination')),
    ));
  }
}

/**
 * Implements template_preprocess_node()
 */
/*function viamo_preprocess_node(&$variables) {
  $node = $variables['node'];
  $view_mode = $variables['view_mode'];
  echo $view_mode; exit;
  // Set up template suggestions for non-standard view modes
  if ($view_mode !== 'full') {
    $variables['theme_hook_suggestions'][] = 'node__' . $node->type . '__' . $view_mode;
  }
}*/

/*
function viamo_entity_view_alter(&$build, $type) {
  if('commerce_product' == $type) {
      echo "<pre>";
      print_r($build);
      echo "<pre>";
      print_r($type);
      
       exit;
    $build['#theme'] = 'commerce-product-line-item';
  }
}*/

/**
 * Adds our theme specifications to the Theme Registry.
 */
/*function viamo_theme($existing, $type, $theme, $path) {
  return array(
    'commerce_product' => array(
      'variables' => array('element' => null),
      'template' => 'commerce-product-line-item'
    ),
  );
}*/

/**
 * Allows modules to alter the path to calculate the breadcrumb.
 *
 * @param string $path
 *   The current drupal path returned by drupal_get_path_alias().
 */


/**
 * Function for making custom Changes in easy breadcrumb module
 */
 //function viamo_easy_breadcrumb($variables) {
     
     //echo "<pre>";
     //print_r($variables); exit;
     
 //}
 
 
/**
 * Allows modules to alter the breadcrumb displayed in the block.
 *
 * @param array $breadcrumb
 *   The breadcrumb array returned to render in the block.
 */
function viamo_easy_breadcrumb_breadcrumb_alter(&$breadcrumb) {      
     $requrl = request_uri();
     $reqArr = explode('/', $requrl);   
      if(is_array($reqArr) && count($reqArr)>0){
        if(isset($reqArr[1])) {
            if($reqArr[1]=='category') {
                    $breadcrumb[1]['content'] = t('Shop');
                    $breadcrumb[1]['url'] = 'shop';                        
            }
        }      
        
      if($requrl=='/shop'){
          $breadcrumb[1]['content'] = t('Shop');                
      }        
    }                    
}
