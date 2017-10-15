<?php 
/*
 * Custom theme functions
 *
 */

/**
 * Returns HTML for status and/or error messages, grouped by type.
 */
 /*
4.6.x theme.inc	theme_status_messages()
4.7.x theme.inc	theme_status_messages()
5.x theme.inc	theme_status_messages($display = NULL)
6.x theme.inc	theme_status_messages($display = NULL)
7.x theme.inc	theme_status_messages($variables)
Returns HTML for status and/or error messages, grouped by type.

An invisible heading identifies the messages for assistive technology. Sighted users see a colored box. See http://www.w3.org/TR/WCAG-TECHS/H69.html for info.

Parameters

$variables: An associative array containing:

display: (optional) Set to 'status' or 'error' to display only messages of that type.
Related topics

Default theme implementations
Functions and templates for the user interface to be implemented by themes.
5 theme calls to theme_status_messages()
File

includes/theme.inc, line 1673
The theme system, which controls the output of Drupal.
Code
*/
function viamo_status_messages($variables) {    
  $display = $variables['display'];  
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
  foreach (drupal_get_messages($display) as $type => $messages) {
    $output .= "<div class=\"messages $type\">\n";
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= reset($messages);
    }
    $output .= "</div>\n";
  }
  return $output;
}


/**
 * Implements hook_js_alter().
*/
function viamo_js_alter(&$js) {
    
    $path=drupal_get_path('theme', 'viamo');        
    //unset($js['sites/all/modules/fancybox/fancybox.js']);
    //drupal_add_js('https://code.jquery.com/jquery-3.2.1.min.js',array('type' => 'external', 'scope' => 'footer'));
    //drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js',array('type' => 'external', 'scope' => 'footer'));    
    //$js[drupal_get_path('theme', 'viamo').'/assets/plugins/fancybox3/jquery.fancybox.min.js']=array('preprocess' =>1,'defer' =>'','type'=>'file','group'=>'-50','weight'=>'-10','every_page'=>1,'cache'=>1,'data' => $path.'/assets/plugins/fancybox3/jquery.fancybox.min.js', 'scope' => 'footer');  
    //$js[drupal_get_path('theme', 'viamo').'/assets/js/fancybox.js']=array('preprocess' =>1,'defer' =>'','type'=>'file','group'=>'-50','weight'=>'-9','every_page'=>1,'cache'=>1,'data' => $path.'/assets/js/fancybox.js', 'scope' => 'footer');  
    $js[drupal_get_path('theme', 'viamo').'/assets/plugins/owlcarousel/owl.carousel.min.js']=array('preprocess' =>1,'defer' =>'','type'=>'file','group'=>'-50','weight'=>'-8','every_page'=>1,'cache'=>1,'data' => $path.'/assets/plugins/owlcarousel/owl.carousel.min.js', 'scope' => 'footer');    
    $js[drupal_get_path('theme', 'viamo').'/js/script.js']=array('preprocess' =>1,'defer' =>'','type'=>'file','group'=>'-50','weight'=>'-7','every_page'=>1,'cache'=>1,'data' => $path.'/js/script.js', 'scope' => 'footer');            
    //drupal_add_js('https://maps.googleapis.com/maps/api/js?key=AIzaSyAXsEOZnvvPOmIrY_Ik9qfwQnClHFoqtRk&callback=initMap',array('type' => 'external', 'scope' => 'footer'));
    $js[drupal_get_path('theme', 'viamo').'/assets/js/script.js']=array('preprocess' =>1,'defer' =>'','type'=>'file','group'=>'-50','weight'=>'-6','every_page'=>1,'cache'=>1,'data' => $path.'/assets/js/script.js', 'scope' => 'footer');
    //$js[drupal_get_path('theme', 'viamo').'/assets/js/bootstrap.min.js']=array('preprocess' =>1,'defer' =>'','type'=>'file','group'=>'-50','weight'=>'-7','every_page'=>1,'cache'=>1,'data' => $path.'/assets/js/bootstrap.min.js', 'scope' => 'footer');        
                  
}

