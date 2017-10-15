<?php 
/*
 * Custom theme functions
 *
 */

/**
 * Returns HTML for status and/or error messages, grouped by type.
 */
function ukschool_status_messages($variables) {
   
    $display = $variables['display'];
    $output = '';

    $status_heading = array(
        'status' => t('Status message'),
        'error' => t('Error message'),
        'warning' => t('Warning message'),
    );

    // Map Drupal message types to their corresponding Bootstrap classes.
    // @see http://twitter.github.com/bootstrap/components.html#alerts
    $status_class = array(
        'status' => 'success',
        'error' => 'error',
        'warning' => 'info',
    );
    //print_r(drupal_get_path_alias($_GET['q']));exit;
    foreach (drupal_get_messages($display) as $type => $messages) {
        $class = (isset($status_class[$type])) ? 'toast alert-' . $status_class[$type] : '';
        if (drupal_get_path_alias($_GET['q']) == 'student/pack') {
            
        } else {
            $output .= "<div class=\"alert alert-block$class\">\n";
            $output .= "  <a class=\"close\" data-dismiss=\"alert\" href=\"#\">&times;</a>\n";
        }
        if (!empty($status_heading[$type])) {
            $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
        }
        if (count($messages) > 1) {
            
            if ($_GET['q'] == 'user/register' || $_GET['q'] == 'user/login' || $_GET['q'] == 'newsletter/subscribe') {
                $out = ' ';
                $out .= '<ul>\n';
                foreach ($messages as $message) {
                    if ($type == "status" && strpos($message, 'instructions have been sent to your e-mail address.')) {
                        $message = 'Account successfully created -- fill in your basic information to start your application!';
                    }
                    if ($type == "error" && strpos($message, 'Have you forgotten your password?')) {
                        $message = strip_tags($message, ' ');
                    }
                    $out .= '<li>' . $message . '</li>\n';
                }
                $out .= '</ul>\n';
                //jQuery(document).ready(function () { Materialize.toast("<ul><li>Username field is required.</li><li>Password field is required.</li></ul>", 5000, "toast alert-error"); });
               // $output .= '<script> Materialize.toast(\'' . $out . '\', 5000, "' . $class . '"); </script>';                                                                
                $return_message_output .= 'jQuery(document).ready(function () { Materialize.toast("'.$out.'", 5000, "' . $class . '"); });';
            } else {               
                $output .= " <ul>\n";
                foreach ($messages as $message) {
                    $output .= '<li>' . $message . "</li>\n";
                }
               $output .= " </ul>\n";                               
            }
        } else {
            if ($_GET['q'] == 'user/register' || $_GET['q'] == 'user/login' || $_GET['q'] == 'newsletter/subscribe') {
                if($type == 'my-warning'){             
                     $output .= $messages[0];
                }   
                if ($type == "status" && strpos($messages[0], 'instructions have been sent to your e-mail address')) {                            
                    if (!user_is_logged_in() && $_GET['q'] == 'user/login') {
                            $me = 'Further instructions have been sent to your e-mail address!';                            
                    } else {
                            $me = 'Account successfully created -- fill in your basic information to start your application!';
                    }
                    $output .=  '<script> jQuery(".not-logged-in.page-user-login").find(".alert-success").css("display","none");</script>';                    
                    $return_message_output .= 'jQuery(document).ready(function () { Materialize.toast("<ul><li>' . $me . '</li></ul>", 5000, "' . $class . '"); });';
                } else if ($type == "error" && strpos($messages[0], 'Have you forgotten your password?')) {
                    $me = strip_tags($messages[0], ' ');                    
                    $return_message_output .= 'jQuery(document).ready(function () { Materialize.toast("<ul><li>' . $me . '</li></ul>", 5000, "' . $class . '"); });';
                } else {
                    $output .=  '<script> jQuery(".not-logged-in.page-user-login").find(".alert-success").css("display","none");</script>';                   
                    $return_message_output .= 'jQuery(document).ready(function () { Materialize.toast("<ul><li>' . $messages[0] . '</li></ul>", 5000, "' . $class . '"); });';
                }
            } else {
                if($type == 'my-warning'){             
                     $output .= $messages[0];
                } else{                    
                    $return_message_output .= '<script> Materialize.toast(\'<ul><li>' . $messages[0] . '</li></ul>\', 5000, "' . $class . '"); </script>';                    
                }
            }
        }
        $output .= "</div>\n";
    }
    return $return_message_output;
}


