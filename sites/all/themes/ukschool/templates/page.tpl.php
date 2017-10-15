<?php
/**
 * @file
 * Materialize theme implementation to display a single Drupal page.
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
 * @ingroup themeable
 */
?>
<div id="page">
  <div class="navbar navbar-invers menu-wrap">
        <?php $imgpath = base_path() . path_to_theme(); ?>
        <div class="navbar-header text-center">
            <?php if ($logo): ?>
                <a class="brand-logo navbar-brand logo-right" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
                  <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
                </a>
            <?php endif; ?>              
        </div>
        <?php if (!empty($page['top_bottom'])): ?>        
          <?php print render($page['top_bottom']); ?>        
        <?php endif; ?><!-- /.top bottom  -->
        <button class="close-button" id="close-button">Close Menu</button>
    </div>
  <nav class="dark-red" id="nav" role="navigation">
      <!-- teal lighten-1 -->
    <div class="nav-wrapper container-fluid">      
    <div class="navbar-left">
        <?php if ($logo): ?>
        <a class="brand-logo" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
        </a>
      <?php endif; ?>  
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      <?php if (!empty($primary_nav)): ?>
        <div class="hide-on-med-and-down main-menu">
          <?php print render($primary_nav); ?>
        </div>
      <?php endif; ?>               
    </div>
    <?php if (!empty($page['top'])): ?>
        <div class="navbar-right">
          <?php print render($page['top']); ?>
        </div>
    <?php endif; ?><!-- /.top  --> 
    <?php $imgpath = base_path() . path_to_theme(); ?>
    <button class="menu-icon" id="open-button" style="color:#ffffff !important;">
        <i class="mdi-navigation-menu"><img src="<?php print $imgpath; ?>/img/menu-icon.png" /></i>
    </button>             
    <!--a id="open-button" href="#" data-activates="nav-mobile" class="menu-icon button-collapse" style="color:#ffffff !important;"><img src="<?php print $imgpath; ?>/img/menu-icon.png" /></a-->
    <!--a id="buttin-collapse-mobile-view" href="#" data-activates="nav-mobile" class="button-collapse" style="color:#ffffff !important;"><img src="<?php print $imgpath; ?>/img/menu-icon.png" /></a-->
    <?php //if (!empty($page['top_bottom'])): ?>        
          <?php //print render($page['top_bottom']); ?>        
    <?php //endif; ?><!-- /.top bottom  -->
    </div>
  </nav>
    
    <div id="school-list" class="content-wrap">
  <?php if (!empty($page['header'])): ?>
    <div class="top">
      <?php print render($page['header']); ?>
    </div>
  <?php endif; ?>
  <?php if (!empty($page['homepagebanner'])): ?>    
      <?php print render($page['homepagebanner']); ?>   
  <?php endif; ?>  
  <!-- /.header  -->
  <div>
    <?php if (!empty($page['sidebar_first'])): ?>
      <aside class="<?php print $sidebar_left; ?> sidebar-first" role="complementary">
        <?php print render($page['sidebar_first']); ?>
      </aside>  <!-- /#sidebar-first -->
    <?php endif; ?>

    <section class="<?php print $main_grid; ?> main" role="main">
      <?php if (!empty($page['highlighted'])): ?>
        <div class="highlighted"><?php print render($page['highlight']); ?></div>
      <?php endif; ?>

      <?php print render($secondary_navigation); ?>

      <?php if (!empty($breadcrumb)): 
         // print $breadcrumb; 
           endif; 
      ?>
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php print render($title_suffix); ?>
      <?php if (!empty($title)): ?>
        <h1 class="page-header"><?php print $title; ?></h1>
      <?php endif; ?>
      <?php              
        if(!empty($messages)) {              
           drupal_add_js($messages,array('type' => 'inline', 'scope' => 'header', 'weight' =>-1));                        
        }                
      ?>
      <?php if (!empty($tabs['#primary'])): ?>
        <?php //print render($tabs_primary); ?>
      <?php endif; ?>

      <?php if (!empty($page['help'])): ?>
        <?php print render($page['help']); ?>
      <?php endif; ?>
      <?php if (!empty($action_links)): ?>
        <div class="action-links"><i class="mdi-action-note-add small"></i><?php print render($action_links); ?></div>
      <?php endif; ?>
      <?php print render($tabs_secondary); ?>
      <?php print render($page['content']); ?>
    </section>

    <?php if (!empty($page['sidebar_second'])): ?>
      <aside class="<?php print $sidebar_right; ?> sidebar-last" role="complementary">
        <?php print render($page['sidebar_second']); ?>
      </aside>  <!-- /#sidebar-second -->
    <?php endif; ?>
  </div> <!-- /main  -->
   <?php if (!empty($page['content_bottom1'])): ?>
    <?php print render($page['content_bottom1']); ?>
    <?php endif; ?>
  <?php if (!empty($page['content_bottom2'])): ?>
    <?php print render($page['content_bottom2']); ?>
    <?php endif; ?>
   <?php if (!empty($page['content_bottom3'])): ?>
      <?php print render($page['content_bottom3']); ?>
    <?php endif; ?>
  
  <?php if (!empty($page['content_bottom'])): ?>  
    <?php print render($page['content_bottom']); ?>  
  <?php endif; ?> 
  <section id="footer">
  <?php if (!empty($page['footer'])): ?>    
    <div class="container">
      <div class="row">            
        <div class="col-md-5 col-sm-12 col-xs-12 bor-right footer-minheight">
            <?php if (!empty($page['footer_first'])): ?>               
                  <?php print render($page['footer_first']); ?>                
            <?php endif; ?>
        </div>        
        <!--div class="col-md-2 col-sm-12 col-xs-12 bor-right footer-minheight">
            <?php if (!empty($page['footer_second'])): ?>               
                  <?php print render($page['footer_second']); ?>                
            <?php endif; ?>
        </div-->        
        <div class="col-md-2 col-sm-12 col-xs-12 bor-right footer-minheight">
            <?php if (!empty($page['footer_third'])): ?>               
                  <?php print render($page['footer_third']); ?>                
            <?php endif; ?>
        </div>        
        <div class="col-md-2 col-sm-12 col-xs-12 bor-right footer-minheight">
            <?php if (!empty($page['footer_forth'])): ?>               
                  <?php print render($page['footer_forth']); ?>                
            <?php endif; ?>
        </div>        
        <div class="col-md-3 col-sm-12 col-xs-12 footer-minheight">
          <?php if (!empty($page['footer_fifth'])): ?>               
                  <?php print render($page['footer_fifth']); ?>                
            <?php endif; ?>
        </div>                
      </div>
  </div>    
  <?php endif; ?>    
    <!-- Go to Top Link -->
    <div id="back-to-top-block">
        <a href="#home" class="btn-primary back-to-top">
         <i class="fa fa-chevron-up"></i>
       </a>
   <div>
  </section>
  <section id="copyright">    
      <div class="container footer-copyright">
      <div class="container row">            	
      	<div class="col-md-12"> 
            <?php if (!empty($page['footer'])): ?>                           
                <?php print render($page['footer']); ?>                
            <?php endif; ?>
        </div>
      </div>
    </div>
 </section>     
    <?php if (!empty($page['model_popup'])): ?> 
    <a href="#modal2" id="open-model-compare" class="compare-school"><?php print t('Compare'); ?></a>
    <div id="modal2" class="modal">                   
        <div class="modal-content">    		                                                                            
            <?php 
                print render($page['model_popup']);                
            ?>
          <div class="modal-footer border-none">		                                        
            <a class="btn btn-lg btn-primary mr15 modal-action modal-close"><?php echo t('Close'); ?></a>            
        </div> 
        </div>	 	
        
    </div>             
    <?php endif; ?>  
</div> <!-- /#page -->
</div>
