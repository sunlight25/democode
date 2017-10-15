<?php
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
?>
<div class="<?php print $classes; ?>">
    <?php print render($title_prefix); ?>
    <?php if ($title): ?>
        <?php print $title; ?>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
    <?php if ($header): ?>
        <div class="view-header">
            <?php print $header; ?>
        </div>
    <?php endif; ?>
    <?php if ($exposed): ?>
        <div class="view-filters">
            <?php print $exposed; ?>
        </div>
    <?php endif; ?>
    <?php if ($attachment_before): ?>
        <div class="attachment attachment-before">
            <?php print $attachment_before; ?>
        </div>
    <?php endif; ?>
    <?php if ($rows): ?>
        <div class="view-content">
            <?php
            $theme_path = drupal_get_path('theme', 'ukschool');
            $rows = $view->style_plugin->rendered_fields;
            ?>
            <div class="no-pad-bot top-banner" id="index-banner">
                <?php print $rows[0]['field_featured_image']; ?>
                <!--img src="http://campus.ukuni.net/sites/default/files/styles/tutor_banner__1290x450_/public/tutor/cover/6.jpg?itok=Vda1fVvE" alt="tutor_banner"-->
                <div class="container relative height100  ">            
                    <div class="user-info" layout="column" layout-align="center center" layout-gt-sm="row" layout-align-gt-sm="start center">      	        
                        <span class="profile-image avatar huge"><?php print $rows[0]['field_logo']; ?></span>
                        <!--img src="http://campus.ukuni.net/sites/default/files/styles/simplecrop/public/tutor/profile/thumb-10.jpg?itok=ERkYQy9e" alt="profile-image" class="profile-image avatar huge"-->
                        <div class="profile-thumb-right">
                            <div class="name"><span class="left mr10"><?php print ucwords($rows[0]['title']); ?></span>
                                <span class="left">                                    
                                </span>
                            </div>                            
                        </div>
                        <div class="banner-bottom-right">
                            <div class="compare-btn btn waves-light">                              
                                <?php
                                    print str_replace('<i class="mdi mdi-compare">', t('Compare'), $rows[0]['node_compare_link']);
                                ?>                              
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner-bottom">
                <div class="container">
                    <div class="banner-bottom-left">                        
                        <div class="banner-bottom-left-span">                                                            
                                    <i class="mdi mdi-map-marker"></i> <span><?php print t($rows[0]['field_location']); ?></span>                                    
                        </div>
                    </div>                        
                    <div class="banner-bottom-right">
                        <div class="jiathis-btn">
                            <?php  
				if(module_exists('jiathis')) { 
				   $block = module_invoke('jiathis', 'block_view','JiaThis'); 
                                   print render($block['content']);                                                                
				}
                            ?>
                        </div>                        
                    </div>
                    </div>                    
                </div>
            </div>
        </div>
    <?php elseif ($empty): ?>
        <div class="view-empty">
            <?php print $empty; ?>
        </div>
    <?php endif; ?>
    <?php if ($pager): ?>
        <?php print $pager; ?>
    <?php endif; ?>
    <?php if ($attachment_after): ?>
        <div class="attachment attachment-after">
            <?php print $attachment_after; ?>
        </div>
    <?php endif; ?>
    <?php if ($more): ?>
        <?php print $more; ?>
    <?php endif; ?>
    <?php if ($footer): ?>
        <div class="view-footer">
            <?php print $footer; ?>
        </div>
    <?php endif; ?>
    <?php if ($feed_icon): ?>
        <div class="feed-icon">
            <?php print $feed_icon; ?>
        </div>
    <?php endif; ?>
</div><?php /* class view */ ?>
