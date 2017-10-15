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
<div class="section-header text-center">
 <h1 class="section-title wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="100ms"><?php echo t('Featured UK Locations')?></h1>
</div>
        <div class="view-content">            
            <?php $rows = $view->style_plugin->rendered_fields; ?>                            
            <div>   
                
                <div class="row">                                           
                <?php 
                    $i=0;
                    foreach ($rows as $id => $row) {
                        if($i>3) { 
                            echo '</div><div class="row">';                                                                                
                            $i=1;                                                   
                        } else {
                           $i++; 
                        }
                    ?>                                                                                                                                                                                                                             
                       <div class="col-md-3 col-sm-12 wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <div class="feature-imbinn">
                            <div class="feature-imbinn-titlebg">
                                <div class="feature-imbinn-title"><?php print t($row['field_location']); ?></div>
                                <div class="feature-imbinn-subtitle"><?php print t($row['title']); ?></div>
                            </div>                            
                            <?php print $row['field_region_image']; ?>                                                                                  
                        </div>                      
                    </div>
                <?php } ?>    
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
