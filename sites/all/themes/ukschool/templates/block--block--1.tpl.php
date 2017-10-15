<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <?php print render($title_prefix); ?>
    <?php if ($title): ?>
        <h2<?php print $title_attributes; ?>><?php print $title; ?></h2>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
    <div class="block-content">
        <?php
        if (user_is_logged_in()) {
            global $base_url, $user;
            $array = array();
            $account = user_load($user->uid);
            $theme_path = drupal_get_path('theme', 'ukschool');          
            $dashurl='';
            $dashurl=''.get_baseurl_with_language().'/user/'.$user->uid;
            echo '<div class="hide-on-med-and-down">
                  <ul class="menu right-menu">
                    <li class="first last expanded dropdown" id="user-menu">
                        <a class="collection-item menu-act" href="'.$dashurl.'">'.t('Account').'</a>                                                                                                  
                        <ul class="dropdown-content last-menu">                                    
                                <li class="first leaf">
                                    <a class="level1" href="'.get_baseurl_with_language().'/user/'.$user->uid.'"><span>' . t('Profile') . '</span></a>
                                </li>                                    
                            <li class="leaf">
                                <a class="level1"  href="'.get_baseurl_with_language().'/user/logout"><span>' . t('Sign Out') . '</span></a>
                            </li>
                        </ul>
                    </li>
            </ul></div>';
        } else {
            $paths_disable = array('user', 'user/login');
            $paths_alter = array('user/register', 'user/password');
            echo '<ul class="menu">
                                <li class="first">' . l(t('Login'), 'user/login') . '</li>
                            </ul>';
            /*if (in_array(current_path(), $paths_disable)) {             
                echo '<ul class="menu">
                                <li class="first">' . l(t('Sign Up'), 'user/register') . '</li>
                            </ul>';
            } else {
                echo '<ul class="menu">
                                <li class="first">' . l(t('Login'), 'user/login') . '</li>
                            </ul>';
            }*/
        }
        ?>
    </div>
</div> <!-- /.block -->
