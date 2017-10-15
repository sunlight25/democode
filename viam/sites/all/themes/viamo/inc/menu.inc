<?php

/**
 * Returns HTML for primary and secondary local tasks.
 */
function viamo_menu_local_tasks(&$variables) {
    $output = '';

    if (!empty($variables['primary'])) {
        $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
        $variables['primary']['#prefix'] = '<div class="primary-tab"><ul class="nav nav-tabs alignright clearfix">';
        $variables['primary']['#suffix'] = '</ul></div>';
        $output .= drupal_render($variables['primary']);
    }

    if (!empty($variables['secondary'])) {
        $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
        $variables['secondary']['#prefix'] = '<ul class="nav nav-pills">';
        $variables['secondary']['#suffix'] = '</ul>';
        $output .= drupal_render($variables['secondary']);
    }

    return $output;
}

/**
 * Returns HTML for primary and secondary local tasks. 
 * @ingroup themeable
 */
function viamo_menu_local_task($variables) {
    $link = $variables['element']['#link'];
    $link_text = $link['title'];
    $classes = array();

    if (!empty($variables['element']['#active'])) {
        // Add text to indicate active tab for non-visual users.
        $active = '<span class="element-invisible">' . t('(active tab)') . '</span>';

        // If the link does not contain HTML already, check_plain() it now.
        // After we set 'html'=TRUE the link will not be sanitized by l().
        if (empty($link['localized_options']['html'])) {
            $link['title'] = check_plain($link['title']);
        }
        $link['localized_options']['html'] = TRUE;
        $link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));

        $classes[] = 'active';
    }
    
    $classes[] = 'btn';
    $classes[] = 'btn-info';          
    
    return '<li class="' . implode(' ', $classes) . '">' . l($link_text, $link['href'], $link['localized_options']) . "</li>\n";
}

/** 
 * Implements theme_menu_tree().
 */

function viamo_menu_tree(&$variables) {        
    return '<ul class="main-menu">' . $variables['tree'] . '</ul>';  
}

function viamo_menu_link(array $variables) {
 $variables['element']['#localized_options']['attributes']['class'][] = 'collection-item'; 
  //start to add <span> to menu item	
 $variables['element']['#title']='<span>'.$variables['element']['#title'].'</span>';
 $variables['element']['#localized_options']['html']=TRUE;
 //end of add <span> to menu item
    $element = $variables['element'];
    $remove_dropdown = 0;
    if (isset($element['#original_link']['menu_name']) && $element['#original_link']['menu_name'] == 'management')
        $remove_dropdown = 1;

    $sub_menu = '';

    if ($element['#below']) {
        // Ad our own wrapper
        unset($element['#below']['#theme_wrappers']);
        if ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] > 1)) {
            $sub_menu = '<ul class="dropdown-content-submenu">' . drupal_render($element['#below']) . '</ul>';
        }else{
            $sub_menu = '<ul class="dropdown-content">' . drupal_render($element['#below']) . '</ul>';
        }        
        if ($remove_dropdown == 0) {
            $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
            $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
        }
        // Check if this element is nested within another
        if ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] > 1)) {
            // Generate as dropdown submenu
            if ($remove_dropdown == 0) {
                $element['#attributes']['class'][] = 'dropdown-submenu';
            }
            $element['#title'] .= '<span class="caret"></span>';
        } else {
            // Generate as standard dropdown
            if ($remove_dropdown == 0) {
                $element['#attributes']['class'][] = 'dropdown';
            }
            $element['#localized_options']['html'] = TRUE;
            $element['#title'] .= '<span class="caret"></span>';
        }

        // Set dropdown trigger element to # to prevent inadvertant page loading with submenu click
        if ($remove_dropdown == 0) {
            $element['#localized_options']['attributes']['data-target'] = '#';
        }        
    }
    
    $element['#attributes']['class'][] ='main-list-item';    
    $output = l(t($element['#title']), $element['#href'], $element['#localized_options']);
    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}


/*
 * overrider the footer Navigation Menu Class
 * Hook_menu_tree__menu_footer_menu();  
 */

function viamo_menu_tree__menu_footer_menu($variables) {
   return '<ul class="">' . $variables['tree'] . '</ul>';  
}

/**
 * Main menu
 * Implements theme__menu_link().
 */

function viamo_menu_link__menu_footer_menu($variables) {    
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  
  unset($element['#attributes']['class']);  
  $element['#localized_options']['html'] = TRUE;
  $output = l(t($element['#title']), $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";  
}


/*
 * overrider the footer Navigation Menu Class
 * Hook_menu_tree__menu_company();  
 */

function viamo_menu_tree__menu_company($variables) {
   return '<ul class="menu-company">' . $variables['tree'] . '</ul>';  
}

/**
 * Main menu
 * Implements theme__menu_link().
 */

function viamo_menu_link__menu_company($variables) {    
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  
  unset($element['#attributes']['class']);  
  $element['#localized_options']['html'] = TRUE;
  $output = l(t($element['#title']), $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";  
}


/**
 * Main menu
 * Implements theme__menu_link().
 */

function viamo_menu_link__menu_top_bar_menu($variables) {    
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  
  unset($element['#attributes']['class']);  
  $element['#localized_options']['html'] = TRUE;
  $output = l(t($element['#title']), $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";  
}

/*
 * overrider the footer Navigation Menu Class
 * Hook_menu_tree__menu_shop();  
 */

function viamo_menu_tree__menu_shop($variables) {
   return '<ul class="menu-company">' . $variables['tree'] . '</ul>';  
}

/**
 * Main menu
 * Implements theme__menu_link().
 */

function viamo_menu_link__menu_shop($variables) {    
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  
  unset($element['#attributes']['class']);  
  $element['#localized_options']['html'] = TRUE;
  $output = l(t($element['#title']), $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";  
}

/**
 * Main menu
 * Implements theme_menu_link__menu_host_navigation().
 */

function viamo_menu_link__menu_host_navigation($variables) {     
  $element = $variables['element'];
  $sub_menu = ''; 
  //echo $element['#href']; exit;
   if($element['#title'] == 'Create Gift List') {
       $url = getGiftListUrl();             
       if(trim($url)!='') {
            //registry/ebe5a859/edit
            $element['#href'] ='registry/'.$url.'/edit';   
            $element['#title']='Edit Gift List Info';
       }
       //echo $element['#href']; exit;
  }
  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }    
  //unset($element['#attributes']['class']);  
  $element['#localized_options']['html'] = TRUE;
  $output = l(t($element['#title']), $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";  
}

/*function viamo_menu_link__menu_host_navigation($variables) {     
  $element = $variables['element'];
  $sub_menu = ''; 
  //echo $element['#href']; exit;
   if($element['#title'] == 'Create Gift List') {
       $url = getGiftListUrl();             
       if(trim($url)!='') {
            //registry/ebe5a859/edit
            $element['#href'] ='registry/'.$url.'/edit';   
            $element['#title']='Edit Gift List Info';
       }
       //echo $element['#href']; exit;
  }
  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }    
  //unset($element['#attributes']['class']);  
  $element['#localized_options']['html'] = TRUE;
  $output = l(t($element['#title']), $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";  
}*/


/**
 * Main menu
 * Implements theme_menu_tree__menu_host_navigation().
 */

function viamo_menu_tree__menu_host_navigation($variables) {
   $giftUrl = getGiftListUrl();
   $viewGiftListlink='';
   if(trim($giftUrl)!='') {
        $viewGiftList = '/registry/'.$giftUrl.'/view';
        $viewGiftListlink = '<li class="last leaf"><a href="'.$viewGiftList.'">'.t('View Your Gift List').'</a></li>'; 
   }
   $viewGiftListlink ='';
   return '<div class="dashboard-menu center-align v-gold"><ul>' . $variables['tree'].$viewGiftListlink.'</ul></div>';  
}
//menu--account-dashboard-mene

/*function viamo_menu_tree__menu_host_navigation($variables) {
   $giftUrl = getGiftListUrl();
   $viewGiftListlink='';
   if(trim($giftUrl)!='') {
        $viewGiftList = '/registry/'.$giftUrl.'/view';
        $viewGiftListlink = '<li class="last leaf"><a href="'.$viewGiftList.'">'.t('View Your Gift List').'</a></li>'; 
   }
   return '<ul class="">' . $variables['tree'].$viewGiftListlink.'</ul>';  
}*/

/**
 * Main menu
 * Implements theme__menu_top_main_menu_mobile_view().
 */

function viamo_menu_link__menu_top_main_menu_mobile_view($variables) {    
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }    
  //unset($element['#attributes']['class']);  
  $element['#localized_options']['html'] = TRUE;
  $output = l(t($element['#title']), $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";  
}


/*
 * overrider the footer Navigation Menu Class
 * Hook_menu_tree__menu_footer_menu();  
 */

function viamo_menu_tree__menu_gift_shop($variables) {        
   return '<ul class="dual-column">' . $variables['tree'] . '</ul>';  
}

/**
 * Main menu
 * Implements theme__menu_link().
 */

function viamo_menu_link__menu_gift_shop($variables) {    
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  
  unset($element['#attributes']['class']);  
  $element['#localized_options']['html'] = TRUE;
  //echo $element['#href']; exit;
  $output = l(t($element['#title']), $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";  
}


/*
 * overrider the footer Navigation Menu Class
 * Hook_menu_tree__menu_wedding_shop();  
 */

function viamo_menu_tree__wedding_shop($variables) {
   return '<ul class="menu-company">' . $variables['tree'] . '</ul>';  
}

/**
 * Main menu
 * Implements theme__menu_link().
 */

function viamo_menu_link__menu_wedding_shop($variables) {      
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  
  unset($element['#attributes']['class']);  
  $element['#localized_options']['html'] = TRUE;
  $output = l(t($element['#title']), $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";  
}

/*
 *  Here we are getting  gift list url key 
 * 
 */
function getGiftListUrl() {
    global $user;
    $query = db_select('commerce_registry', 'cr');
    $query->join('commerce_registry_urls', 'c_url', 'c_url.registry_id = cr.registry_id');
    $query->fields('cr', array('registry_id'))                
             ->condition('cr.owner_uid', $user->uid,'=');
             //->condition('cr.status',1,'=');   
    $query->addField('c_url','url','url');
    $result = $query->execute()->fetchAll();
    $result = (array)$result;                        
    $url = isset($result[0]->url)? $result[0]->url : ' ';                  
       if($url) {
           return $url;
       } else{
           return '';
       }
    
}

/**
 * Main menu
 * Implements theme_menu_link__menu_guest_account_dashboard_men().
 */

function viamo_menu_link__menu_guest_account_dashboard_men($variables) {     
  $element = $variables['element'];
  $sub_menu = ''; 
  
   //echo $element['#href']; exit;   
  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }      
  $element['#localized_options']['html'] = TRUE;
  $output = l(t($element['#title']), $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n"; 
  
}

/**
 * Main menu
 * Implements theme_menu_tree__menu_guest_account_dashboard_men().
 */

function viamo_menu_tree__menu_guest_account_dashboard_men($variables) {   
   return '<div class="dashboard-menu center-align v-blue"><ul>' . $variables['tree'].'</ul></div>';  
}

/**
 * 
 * Implements hook_menu_local_action() 
 * 
 */

function viamo_menu_local_action($variables) {
        
  $link = $variables['element']['#link'];
  $output = '<li>';
  if (isset($link['href'])) {
      
      $link['localized_options']['attributes']['class'][] = 'dropdown-button';  
      $link['localized_options']['attributes']['class'][] = 'btn';  
      $link['localized_options']['attributes']['class'][] = 'text';          
      $output .= l($link['title'], $link['href'], isset($link['localized_options']) ? $link['localized_options'] : array());
      
  }
  elseif (!empty($link['localized_options']['html'])) {
    $output .= $link['title'];
  }
  else {
    $output .= check_plain($link['title']);
  }
  
  $output .= "</li>\n";
  return $output;
  
}

?>