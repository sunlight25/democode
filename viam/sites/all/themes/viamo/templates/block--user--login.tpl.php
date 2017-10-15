<?php
    $elements = drupal_get_form('user_login_block');
    global $base_url;
?>
<ul id="slide_out_login" class="side-nav">
    <li><a class="subheader"><?php print t('Sign in'); ?></a></li>
    <li class="px-3">
        <div class="row">                            
                <?php 
                    $output  = '<form class="col s12" action="' . $elements['#action'] .'" method="' . $elements['#method'] .'" id="' . $elements['#id'] .'" accept-charset="UTF-8"><div>';                                                                                                                                              
                    $output .= "<div class='row'>";
                    $output .= "<div class='input-field col s12'><i class='material-icons prefix'>account_circle</i>".drupal_render($elements['name'])."</div>";
                    $output .= "<div class='input-field col s12'><i class='material-icons prefix'>code</i>".drupal_render($elements['pass'])."</div>";
                    $output .= "<div class='input-field col s12'>".drupal_render($elements['remember_me'])."</div>";                                                                                
                    $output .= drupal_render($elements['form_build_id']);
                    $output .= drupal_render($elements['form_id']);
                    $output .= drupal_render($elements['actions']);                     
                    //$output .= drupal_render($elements['links']);
                    $output .= '</div></div></form>';
                    print $output;                             
                ?>                          
        </div>	
        <?php print '<a href="'.$base_url.'/user/register" class="btn btn-block btn v-blue mr-3">'.t('SIGN UP').'</a>'; ?>
    </li>
    <li>
        <div class="divider"></div>
    </li>
    <li><a class="subheader"><?php print t('Social Login'); ?></a></li>
    <?php                                 
        $content= drupal_render($elements['hybridauth']);                                 
        $find_array= array('Sign Up using Facebook','Sign Up using Twitter','Sign Up using Google Plus');
        $replace_array=array('Login with Facebook','Login with Twitter','Login with Google Plus');                                                
        //$content = drupal_render($element);
        $replaceContent = str_ireplace($find_array, $replace_array, $content);
        print $replaceContent; //$replaceContent;                         
    ?>                                               
    <li class="px-3">
        <a class="waves-effect waves-light btn-large social pinterest">
            <i class="fa fa-pinterest"></i>
            Sign in with pinterest
        </a>
    </li>
    <!--
    <li class="px-3">
        <a class="waves-effect waves-light btn-large social facebook">
            <i class="fa fa-facebook"></i>Sign in with facebook            
        </a>
    </li>
    <li class="px-3">
        <a class="waves-effect waves-light btn-large social twitter">
            <i class="fa fa-twitter"></i>
            Sign in with twitter
        </a>
    </li>
    <li class="px-3">
        <a class="waves-effect waves-light btn-large social google">
            <i class="fa fa-google"></i>
            Sign in with google
        </a>
    </li>
    <li class="px-3">
        <a class="waves-effect waves-light btn-large social pinterest">
            <i class="fa fa-pinterest"></i>
            Sign in with pinterest
        </a>
    </li>-->
</ul>
