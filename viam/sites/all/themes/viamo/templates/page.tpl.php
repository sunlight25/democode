<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup templates
 */
?>
<?php global $base_url; ?>
<div id="page" class="wrapper">
    <?php if (!$in_overlay): ?>        
        <header id="site_header">
            <div id="top_bar">        
                <?php print render($page['header']); ?>                    
            </div>    
            <div id="page_loader" class="progress">
                <div class="indeterminate"></div>
            </div>
            <div id="main_header" class="masthead">
                <div>
                    <ul class="shopping-menu">
                        <li>
                            <button data-activates="slide_out_main_menu" class="hide-on-med-and-up button-collapse hamburger hamburger--collapse so-main-menu" type="button">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                                <span class="hamburger-label">Menu</span>
                            </button>				
                        </li>
                        <?php if (user_is_logged_in()): ?>
                        <?php global $user;  ?>                                     
                        <?php if (in_array('Guest', $user->roles)): ?>                                            
                        <?php                
                                          if(module_exists('views')) {
                                                         $block = module_invoke('views', 'block_view', 'user_profile_block-block_1');
                                                         print render($block['content']);                                                                 
                                           } 
                                     ?>                                        
                        <?php endif; ?>                                        
                        <?php if (in_array('Standard Account(Host or Guest)', $user->roles)):                            
                                        if(module_exists('views')) {
                                             $block = module_invoke('views', 'block_view', 'user_profile_block-block');
                                             print render($block['content']);                                                                 
                                        }                                          
                                        ?>                           
                        <?php endif; ?>
                        <?php else: ?>                                            
                            <li id="login_button" class="hide-on-med-and-down">						
                                <a data-activates="slide_out_login" class="so-login" href="#customer_menu">							
                                <i class="flaticon-user-1"></i>							
                                        <span class="login-button-text v-blue-text">Login / SignUp</span>
                                        <span class="login-button-text small">Go to your account</span>							
                                </a>							
			    </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="right">
                    <ul class="shopping-menu">
                        
                        <li class=""><?php
                                    /* Showing Shopping Cart added product */
                                    if (module_exists('viamocommerce')) {
                                        $block = module_invoke('viamocommerce', 'block_view', 'shopping_cart_count');
                                        print render($block['content']);
                                    }
                                    ?></li>						                
                        <?php if (user_is_logged_in()): ?>  
                        <?php global $user;                        
                                    if (in_array('Venue User', $user->roles)):
                                    ?>   
                                <li class="hide-on-med-and-down"><a href="<?php echo get_baseurl_with_language() . '/venue-dashboard'; ?>"><i class="flaticon-user-1"></i><span><?php print t('My Profile'); ?></span></a></li>                
                            <?php endif; ?>                                             
                            <?php if (in_array('Standard Account(Host or Guest)', $user->roles)): ?>                                   
                                <!--li class="hide-on-med-and-down"><a href="<?php echo get_baseurl_with_language() . '/standard-dash'; ?>"><i class="flaticon-user-1"></i><span><?php print t('My Profile'); ?></span></a></li-->                
                            <?php endif; ?>                                                                                                         
                            <?php if (in_array('merchant', $user->roles)): ?>   
                                <li class="hide-on-med-and-down"><a href="<?php echo get_baseurl_with_language() . '/vendor-dashboard'; ?>"><i class="flaticon-user-1"></i><span><?php print t('My Profile'); ?></span></a></li>                
                            <?php endif; ?>                                               
                            <!--li class="hidden-md-downhide-on-med-and-down"><a href="<?php echo get_baseurl_with_language() . '/user/logout'; ?>"><i class="flaticon-user-1"></i><span><?php print t('Sign Out'); ?></span></a></li-->                                  
                        <?php else: ?>                                            
                            <!--li class="hidden-md-down"><a href="#customer_menu"><i class="flaticon-user-1"></i><span>Login/Signup (0)</span></a></li-->                
                        <?php endif; ?>
                        <li class=""><a id="header_search_btn" href="#"><i class="flaticon-magnification-lens"></i></a></li>						
                    </ul>
                    <?php if ($logo): ?>
                        <a class="logo navbar-btn pull-left" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
                            <h3 class="site_logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></h3>
                        </a>            
                    <?php endif; ?>            
                </div>
                <!--   Main Menu -->
                <?php if (!empty($primary_nav)): ?>
                    <div class="main_nav hide-on-med-and-down">
                        <?php print render($primary_nav); ?>
                    </div>
                <?php endif; ?>                    
                <!--   Main Menu -->
                <div class="clearfix"></div>
                <form id="header_search">
                    <div class="input-field">
                        <input id="search" class="mb-0" type="search" placeholder="What are you looking for?" required>
                        <label class="label-icon" for="search"><i class="material-icons grey-text">search</i></label>
                        <i class="material-icons">close</i>
                    </div>
                </form>
            </div>                
            <div id="main_header_on_scroll" class="masthead reversed">
                <div class="left">
                    <ul class="shopping-menu">
                        <li>
                            <button data-activates="slide_out_main_menu" class="button-collapse hamburger hamburger--collapse so-main-menu" type="button">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                                <span class="hamburger-label">Menu</span>
                            </button>
                        </li>
                    </ul>
                </div>
                <h3 class="site_logo">Viamo</h3>
                <div class="right">
                    <ul class="shopping-menu">
                        <li class=""><a href="#"><i class="flaticon-paper-bag"></i><span>Basket (0)</span></a></li>                   
                        <li class=""><a id="header_search_btn" href="#"><i class="flaticon-magnification-lens"></i></a></li>                   
                    </ul>
                    <a href="../index.php"><h3 class="site_logo">Viamo</h3></a>
                </div>
            </div>        
        </header>    
        <ul id="slide_out_main_menu" class="side-nav">
        <li>
            <div class="user-view pb-4">
                <div class="background">
                    <img width="300" src="<?php print $base_url;?>/sites/all/themes/viamo/assets/img/profile_pic-bg.jpg">
                </div>
                <a href="#!user"><img class="circle" src="<?php print $base_url;?>/sites/all/themes/viamo/assets/img/profile_pic-viamo.jpg"></a>
                <a href="#!name"><span class="white-text name">Sign In Now</span></a>

            </div>
        </li>
        <li class="active"><a href="../index.php"><span>Homepage</span></a></li>    
        <li class=""><a href="../shop.php">Shop</a></li>    
        <li class=""><a href="../venues.php">Venues</a></li>    
        <li class=""><a href="../app.php">Wedding Planner</a></li>    
        <li class=""><a href="../brands.php">Brands</a></li>    
        <li class=""><a href="../inspirations.php">Inspirations</a></li>    
        <li class=""><a href="../faq.php">FAQ</a></li>    
    </ul>
    <?php endif; ?>       
        <?php if (!empty($page['user_login']) && !$in_overlay): ?>    
            <?php print render($page['user_login']); ?>    
        <?php endif; ?>      
        <?php if(drupal_is_front_page()):?>
        <?php print $messages; ?>
        <?php endif;?>
        <?php if (!empty($page['homepagebanner']) && !$in_overlay): ?>    
            <section>
                <?php print render($page['homepagebanner']); ?>   
            </section>      
        <?php endif; ?>    
        <?php //print_r($_GET['q']); exit; ?>
        <?php if (!drupal_is_front_page()): ?>    
            <section id="page_content">                 
                <!--  Start Hide Below section for Standard Account Dashboard and Front Page-->            
                <?php if (!drupal_is_front_page()  && $_GET['q']!='standard-dash' && !$in_overlay && $_GET['q']!='dash-guest'): ?>
                    <div id="hero_title" class="mb-0 center-align upper white-text t-bg">
                        <a id="main-content"></a>
                        <?php print render($title_prefix); ?>
                        <?php if (!empty($title)): ?>
                            <h1 class="page-header"><?php print $title; ?></h1>
                        <?php endif; ?>
                        <!--code use for showing view edit link -->
                        <?php //print render($title_suffix);  ?>
                    </div>    
                <?php endif; ?>
                <!-- End Hide Below section for Standard Account Dashboard and Front Page-->            

                <?php if ($page['featured']!='' && !$in_overlay): ?>
                    <div id="featured">
                        <div class="mt-0 clearfix">
                                <?php print render($page['featured']); ?>
                        </div>
                    </div> <!-- /.section, /#featured -->
                <?php endif; ?>                 
                <div class="main-container <?php print $container_class; ?>">                             
                    <div class="row">
                        <?php //if (!empty($breadcrumb)): print $breadcrumb; endif; ?>                              
                        <?php print $messages; ?>
                        <?php if (!empty($tabs)): ?>
                            <?php print render($tabs); ?>
                        <?php endif; ?>  
                        <?php if (!empty($page['sidebar_first']) && !$in_overlay): ?>
                            <aside class="col s2 mt-5" role="complementary">
                                <?php print render($page['sidebar_first']); ?>
                            </aside>  <!-- /#sidebar-first -->
                        <?php endif; ?>    
                        <section<?php print $content_column_class; ?>>                
                            <?php if (!empty($page['highlighted'])): ?>
                                <div class="highlighted jumbotron"><?php print render($page['highlighted']); ?></div>
                            <?php endif; ?>      
                            <?php if (!empty($page['help'])): ?>
                                <?php print render($page['help']); ?>
                            <?php endif; ?>
                            <?php if (!empty($action_links)): ?>
                                <ul class="action-links"><?php print render($action_links); ?></ul>
                            <?php endif; ?>
                            <?php print render($page['content']); ?>
                        </section>
                        <?php if (!empty($page['sidebar_second']) && !$in_overlay): ?>
                            <aside class="col s3" role="complementary">
                                <?php print render($page['sidebar_second']); ?>
                            </aside>  <!-- /#sidebar-second -->
                        <?php endif; ?>
                    </div>
                </div>        
            </section>                      
        <?php endif; ?> 
     <?php if (!$in_overlay): ?>      
    <footer id="site_footer" class="p-3 p-md-5 white">    
        <?php if ($page['footer_firstcolumn'] || $page['footer_secondcolumn'] || $page['footer_thirdcolumn'] || $page['footer_fourthcolumn']): ?>   
            <h3 class="v-gold-text"><?php print t('Get to know Viamo'); ?></h3>
            <div class="row no-gutters">
                <?php if (!empty($page['footer_firstcolumn'])): ?>
                    <div class="col s12 m2 mb-4">
                        <?php print render($page['footer_firstcolumn']); ?>        
                    </div>
                <?php endif; ?>
                <?php if (!empty($page['footer_secondcolumn'])): ?>
                    <div class="col s12 m4 mb-4">
                        <?php print render($page['footer_secondcolumn']); ?>
                    </div>
                <?php endif; ?>        
                <?php if (!empty($page['footer_thirdcolumn'])): ?>
                    <div class="col s12 m2 mb-4">
                        <?php print render($page['footer_thirdcolumn']); ?>
                    </div>
                <?php endif; ?>                
                <?php if (!empty($page['footer_fourthcolumn'])): ?>
                    <div class="col s12 m2 mb-4">
                        <?php print render($page['footer_fourthcolumn']); ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($page['footer_fivthcolumn'])): ?>
                    <div class="col s12 m2 mb-4">
                        <?php print render($page['footer_fivthcolumn']); ?>
                    </div>
                <?php endif; ?>                                    
            </div>
        <?php endif; ?>    
    </footer>           
    <footer class="page-footer v-blue">
        <div class="p-3 p-md-5">
            <div class="row">
                <?php if (!empty($page['bottom_footer_firstcolumn'])): ?>
                    <div class="col l2 s12">
                        <?php print render($page['bottom_footer_firstcolumn']); ?>
                    </div>
                <?php endif; ?>                  
                <?php if (!empty($page['bottom_footer_secondcolumn'])): ?>
                    <div class="col l2 s12">
                        <?php print render($page['bottom_footer_secondcolumn']); ?>
                    </div>
                <?php endif; ?>                                                                          
                <?php if (!empty($page['bottom_footer_thirdcolumn'])): ?>
                    <div class="col l2 s12">
                        <?php print render($page['bottom_footer_thirdcolumn']); ?>
                    </div>
                <?php endif; ?>                                                                          
                <?php if (!empty($page['bottom_footer_fourthcolumn'])): ?>
                    <div class="col l2 s12">
                        <?php print render($page['bottom_footer_fourthcolumn']); ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($page['bottom_footer_fivthcolumn'])): ?>
                    <div class="col l2 s12">
                        <?php print render($page['bottom_footer_fivthcolumn']); ?>
                    </div>
                <?php endif; ?> 
                <?php if (!empty($page['bottom_footer_sixcolumn'])): ?>
                    <div class="col l2 s12">
                        <?php print render($page['bottom_footer_sixcolumn']); ?>
                    </div>
                <?php endif; ?>                        
            </div>
        </div>
        <div class="footer-copyright pl-3 pl-md-5">
            <?php if (!empty($page['footer'])): ?>
                <?php print render($page['footer']); ?>        
            <?php endif; ?>
        </div>    
    <?php endif; ?>
</div>
