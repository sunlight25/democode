<?php
require_once dirname(__FILE__) . '/inc/theme.inc';
require_once dirname(__FILE__) . '/inc/form.inc';
require_once dirname(__FILE__) . '/inc/menu.inc';


/**
 * Implements hook_theme().
 */
function ukschool_theme(&$existing, $type, $theme, $path) {    
	
    return array(  
         
        'user_login' => array(
            'render element' => 'form',
            'path' => drupal_get_path('theme', 'ukschool'),
            'template' => 'templates/user-login',
        ),
      
        'user_register_form' => array(
            'render element' => 'form',
            'path' => drupal_get_path('theme', 'ukschool'),
            'template' => 'templates/user-register',
        ),   
        /*
         'user_profile_form' => array(
            'render element' => 'form',
            'path' => drupal_get_path('theme', 'ukschool'),
            'template' => 'templates/change-password',
        ),
         * 
         */
    );
}

function getTremFlagPath($id) {
    $query = db_select('file_usage','f');
    $query->condition('f.id',$id,'=');
    $query->condition('f.type','taxonomy_term','=');    
    $query->join('file_managed','fm','f.fid = fm.fid');
    $query->fields('fm',array('uri'));
    $query->range(0, 1);
    $result = $query->execute(); 
    $url = '';
    foreach($result as $record) {
        $url = $record->uri;
    }
    return $url;    
}

/**
 * ukschool theme wrapper function for the  main menu mobile view links added
 */
function ukschool_menu_tree__menu_top_main_menu_mobile_view($variables) {
    global $base_url,$user;
    $array = array();
    $theme_path_base = base_path() . path_to_theme();
    $account = user_load($user->uid);
    if (!empty($account->picture)) {
        if (is_numeric($account->picture)) {
          $account->picture = file_load($account->picture);

        }
        if (!empty($account->picture->uri)) {
          $filepath = $account->picture->uri;
        }
        $array = array('path' => $filepath,'alt' => 'Picture');
    }
    $extrLinks = '';
    if (user_is_logged_in()) {
        $extrLinks .= '<li class="leaf main-li-login">';
        if($array){
	 $extrLinks .= '<span  class="mob_nav_pic_img"><a class="m_link" href="/user">' .theme_image($array) . '</a></span>';
        }else{
                $extrLinks .= '<span  class="login-icon"><img alt="login" src="' . $theme_path_base . '/img/login.png"></span>';
        }
        $extrLinks .= '<span class="login-name-span" > ' . getTrimmedUserName() . ' </span><span class="login-icon1"><img alt="login" src="' . $theme_path_base . '/img/log-out.png"></span><a class="level1 sign-out-mobile"  href="' . get_baseurl_with_language() . '/user/logout"><span>' . t('Sign Out') . '</span></a>';
        $extrLinks .= '</li>';
    } else {
        $extrLinks .= '<li class="leaf">
         <a class="collection-item" href="' . get_baseurl_with_language() . '/user/login"><span>' . t('Login') . '</span></a>        
        </li>';
        
       // $extrLinks .= '<li class="leaf">'
           //     . '<a class="collection-item" href="' . get_baseurl_with_language() . '/user/register"><span id="create-account-mobile">' . t('Create Account') . '</span></a></li>';
        
    }    
    $var = $extrLinks . $variables['tree'];
   // return '<ul id="nav-mobile" class="nav navbar-nav main-navigation">' . $var . '</ul>';    
    $output='';
    $output.='<ul id="nav-mobile" class="nav navbar-nav main-navigation">';            
    if(module_exists('locale')) {        
        $block = module_invoke('locale', 'block_view', 'language');        
        $output.='<li class="last leaf expanded apply-mobile-view dropdown">
                  <a data-target="#" data-toggle="dropdown" class="collection-item" href="/"><span>'.t('Languages').'</span><span class="caret"></span></a>';
       $block['content'] = str_replace('dropdown dropdown-content','dropdown', $block['content']);
       $block['content'] = str_replace('zh-hans first','zh-hans first leaf', $block['content']);               
       $output.=render($block['content']);
       $output.='</li>';
    }            
    $output.=$var.'</ul>';    
    return $output;
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
 * function getDefaultImage.
 */

function getDefaultImage($char,$gender){
	
	 $theme_path = drupal_get_path('theme', 'ukschool');
	 global $base_url;
	
	$arr1  = array('A','G','M','W');
        $arr2  = array('B','H','N','T');
	$arr3  = array('C','I','O','U');
	$arr4  = array('D','J','P','Y');
	$arr5  = array('E','K','Q','Z');
	$arr6  = array('F','L','R','X','V','S');
    
    
    if(in_array($char,$arr1)){
		
	    return ($gender == 'Male') ? "<img src='".$base_url."/".$theme_path."/img/user1.png'>" : "<img src='".$base_url."/".$theme_path."/img/female1.png'>"; 	
		
		
	}
	if(in_array($char,$arr2)){
		return ($gender == 'Male') ? "<img src='".$base_url."/".$theme_path."/img/user2.png'>" : "<img src='".$base_url."/".$theme_path."/img/female2.png'>"; 	
	}
	if(in_array($char,$arr3)){
		return ($gender == 'Male') ? "<img src='".$base_url."/".$theme_path."/img/user3.png'>" : "<img src='".$base_url."/".$theme_path."/img/female3.png'>"; 	
	}
	if(in_array($char,$arr4)){
		return ($gender == 'Male') ? "<img src='".$base_url."/".$theme_path."/img/user4.png'>" : "<img src='".$base_url."/".$theme_path."/img/female4.png'>"; 	
	}
	if(in_array($char,$arr5)){
		return ($gender == 'Male') ? "<img src='".$base_url."/".$theme_path."/img/user5.png'>" : "<img src='".$base_url."/".$theme_path."/img/female5.png'>"; 	
	}
	if(in_array($char,$arr6)){
		return ($gender == 'Male') ? "<img src='".$base_url."/".$theme_path."/img/user6.png'>" : "<img src='".$base_url."/".$theme_path."/img/female6.png'>"; 	
	}                        
	
	
}

function ukschool_js_alter(&$javascript) {
    //echo "<pre>";
    //print_r($javascript); exit;
    /*$javascript['misc/jquery.form.js']['data'] = drupal_get_path('theme', 'ukschool') . '/js/jquery.form.js';
    
    $javascript['misc/jquery.form.js']['scope'] = 'header';
    $javascript['misc/jquery.form.js']['group'] = 'JS_LIBRARY';
    $javascript['misc/jquery.form.js']['weight'] = '100';
    $javascript['misc/jquery.form.js']['every_page'] = TRUE;
    $javascript['misc/jquery.form.js']['type'] = 'file';
    $javascript['misc/jquery.form.js']['preprocess'] = 'TRUE';
    $javascript['misc/jquery.form.js']['cache'] = 'TRUE';
    $javascript['misc/jquery.form.js']['defer'] = 'TRUE';*/
}


/**
 * Implements hook_preprocess_image().
 *  
 */      
function ukschool_preprocess_image(&$variables) {        
    /*
     * Below If conditions Use for Location taxonomy "region_image" unset default image style 
     */
    if(isset($variables['style_name'])){
        if ($variables['style_name'] == 'region_image') {           
            foreach (array('width', 'height','typeof') as $key) {
               // unset($variables[$key]);
            }                           
            $variables['attributes']['class'][] = 'img-responsive';       
        }

        if ($variables['style_name'] == 'school_other_image') {           
            foreach (array('width', 'height','typeof') as $key) {
              //  unset($variables[$key]);
            }                           
            $variables['attributes']['class'][] = 'img-fluid';               
	}            
        
        if ($variables['style_name'] == 'school_card_image') {           
            foreach (array('width', 'height','typeof') as $key) {
               // unset($variables[$key]);
            }                           
            $variables['attributes']['class'][] = 'img-fluid';       
        }   
        // Remove query string for image.
        $variables['path'] = preg_replace('/\?.*/', '', $variables['path']);        
    }    
}


/**
 * Implements hook__preprocess_block().
 *  
 */ 

function ukschool_preprocess_block(&$vars) {           
    if(arg(1)==70) {
        $vars['content_attributes_array']['class'][] = 'container';  
    }   
    
    if(arg(1)!=70 && $vars['block_html_id'] == 'block-newsletter-newsletter-subscribe') {        
        $vars['content_attributes_array']['class'][] = 'container'; 
    }         
}



/**
 * function getschoolGender.
 * this function use return schools gender type icon schools listing page
 */

function getschoolGender($gender) {    
   // Co-ed ,Boys ,Girls
    $return='';   
    if(module_exists('views')) {      
        if($gender!=''){
            switch ($gender) {
                 case 'Co-ed':
                   // $return ='<span class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="'.t('Co-Education').'"><span class="school-title icon-color"><i class="mdi mdi-human-male-female"></i></span></span>';                                                
                    $return ='<div class="tooltip"><span class="school-title icon-color"><i class="mdi mdi-human-male-female"></i></span><span class="tooltiptext">'.t('Co-Education').'</span></div>';
                    break;
                 case 'Boys':
                    //$return ='<span class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="'.t('Boys').'"><span class="school-title icon-color"><i class="mdi mdi-gender-male"></i></span></span>';                                                
                     $return ='<div class="tooltip"><span class="school-title icon-color"><i class="mdi mdi-gender-male"></i></span><span class="tooltiptext">'.t('Boys').'</span></div>';
                    break;
                 case 'Girls':
                    //$return ='<span class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="'.t('Girls').'"><span class="school-title icon-color"><i class="mdi mdi-gender-female"></i></span></span>';                                                
                     $return ='<div class="tooltip"><span class="school-title icon-color"><i class="mdi mdi-gender-female"></i></span><span class="tooltiptext">'.t('Girls').'</span></div>';
                    break;
                default:
                    $return='';
                    break;
            }
        }
    }
    return $return;
}



/**
 * function getSchoolBoardersType.
 * this function use return schools Boarders type icon schools listing page
 */

function getSchoolBoardersType($Boarderstype) {    
   // Boarding School,Boarding School    
    $return='';   
    if(module_exists('views')) {   
        if($Boarderstype!='') {
            switch ($Boarderstype) {
                 case 'Day School':
                    //$return ='<span class="school-title icon-color tooltipped" data-position="bottom" data-delay="50" data-tooltip="'.t('Day School').'"><i class="mdi mdi-white-balance-sunny"></i></span>';
                    $return ='<div class="school-title icon-color tooltip"><i class="mdi mdi-white-balance-sunny"></i><span class="tooltiptext">'.t('Day School').'</span></div>';	  
                    break;
                 case 'Boarding School':
                    //$return ='<span class="school-title icon-color tooltipped" data-position="bottom" data-delay="50" data-tooltip="'.t('Boarding School').'"><i class="fa fa-hotel"></i></span>';
                     $return ='<div class="school-title icon-color tooltip"><i class="fa fa-hotel"></i><span class="tooltiptext">'.t('Boarding School').'</span></div>';	  
                    break;            
                default:
                    $return='';
                    break;
            }
        }
    }
    return $return;
}




/**
 * function getInternationalStudentFees()
 * this function use return schools International Student Fees Range icon schools listing page
 */

function getInternationalStudentFees($fees) {       
/*  @$fees   Range 0 to  15999 and NA one icon highlighted
 *  @$fees   Range 15999 to  25999 and NA two icon highlighted
 *  @$fees   Range 25999+ and NA three icon highlighted
 */
    $return='';   
    if(module_exists('views')) {           
       if(intval($fees)>0){
            switch ($fees) {                                                            
                case (((intval($fees)>=0) && (intval($fees)<=15999))):                                       
                    //$return ='<span class="school-title icon-color tooltipped gbpicon" data-position="bottom" data-delay="50" data-tooltip="'.t('Tuition Fees').'"><i class="mdi mdi-currency-gbp"></i><i class="mdi mdi-currency-gbp opacity40"></i><i class="mdi mdi-currency-gbp opacity40"></i></span>';
                    $return ='<span class="school-title icon-color tooltip gbpicon"><i class="mdi mdi-currency-gbp"></i><i class="mdi mdi-currency-gbp opacity40"></i><i class="mdi mdi-currency-gbp opacity40"></i><span class="tooltiptext">'.t('Tuition Fees').'</span></span>';
                    break;                
                case (intval($fees)>=16000 && intval($fees)<=25999):                     
                    //$return ='<span class="school-title icon-color tooltipped gbpicon" data-position="bottom" data-delay="50" data-tooltip="'.t('Tuition Fees').'"><i class="mdi mdi-currency-gbp"></i><i class="mdi mdi-currency-gbp"></i><i class="mdi mdi-currency-gbp opacity40"></i></span>';                
                    $return ='<span class="school-title icon-color tooltip gbpicon"><i class="mdi mdi-currency-gbp"></i><i class="mdi mdi-currency-gbp"></i><i class="mdi mdi-currency-gbp opacity40"></i><span class="tooltiptext">'.t('Tuition Fees').'</span></span>';
                    break;            
                case (intval($fees)>=25999):
                    //$return ='<span class="school-title icon-color tooltipped gbpicon" data-position="bottom" data-delay="50" data-tooltip="'.t('Tuition Fees').'"><i class="mdi mdi-currency-gbp"></i><i class="mdi mdi-currency-gbp"></i><i class="mdi mdi-currency-gbp"></i></span>';
                    $return ='<span class="school-title icon-color tooltip gbpicon"><i class="mdi mdi-currency-gbp"></i><i class="mdi mdi-currency-gbp"></i><i class="mdi mdi-currency-gbp"></i><span class="tooltiptext">'.t('Tuition Fees').'</span></span>';
                    break;
            }    
        } else {
            //$return ='<span class="school-title icon-color tooltipped gbpicon" data-position="bottom" data-delay="50" data-tooltip="Tuition Fees"><i class="mdi mdi-currency-gbp"></i><i class="mdi mdi-currency-gbp opacity40"></i><i class="mdi mdi-currency-gbp opacity40"></i></span>';
            $return ='<span class="school-title icon-color tooltip gbpicon"><i class="mdi mdi-currency-gbp"></i><i class="mdi mdi-currency-gbp opacity40"></i><i class="mdi mdi-currency-gbp opacity40"></i><span class="tooltiptext">'.t('Tuition Fees').'</span></span>';
        }
    }
    return $return;
}

/**
 * Preprocess for the comparison page.
 */
function ukschool_preprocess_node_compare_comparison_page(&$vars) {
    if(module_exists('quicktabs')) {
        $block = module_invoke('quicktabs', 'block_view', 'schools_compare');
        $vars['comparison_tab'] =array(                
            '#markup'=> render($block),
        );   
    }    
}


/*
 * Implement hook_preprocess_page();
 */
 
function ukschool_preprocess_page(&$variables) {
    global $language;
    global $base_url;
    $current_lang = $language->language;
    drupal_add_js(array('current_lang' => $current_lang), 'setting');
    drupal_add_js(array('base_url'=> $base_url), 'setting');
}

/*
 * Implement hook__links__locale_block();
 */

 function ukschool_links__locale_block($variables) {
           
     $variables['attributes']['class'][]='dropdown-content';      
     $variables['attributes']['class'][]=' last-menu';      
     foreach($variables['links'] as $language => $langInfo) {      
        $variables['links'][$language]['attributes']['class'][] = 'expanded';
        $variables['links'][$language]['attributes']['class'][] = 'dropdown';
        $variables['links'][$language]['attributes']['class'][] = 'dropdown-content';                         
    }
  
    return theme_links($variables);
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





