<?php
/**
 * @file
 * Main view template.
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
    <?php
    global $base_url;
    $rows = $view->style_plugin->rendered_fields;
    $theme_path = drupal_get_path('theme', 'viamo');
    ?>
    <?php if ($rows): ?>
        <div class="view-content">               
            <?php
                        foreach ($rows as $id => $row) {                    
                  ?>        
            <div class="col m3 s6">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">                        
                        <a href="shop/<?php echo str_replace(' ','-',$row['name_1'])?>"><?php print $row['field_category_image']; ?></a>                        
                        
                        <a href="shop/<?php echo str_replace(' ','-',$row['name_1'])?>"><?php print $row['name']; ?></a>                        
                    </div>                    
                    <?php print $row['view']; ?>                                                                                                            
                    <ul class="collection with-header mt-0">
                        <li class="collection-item">                                                        
                            <a href="shop/<?php echo str_replace(' ','-',$row['name_1'])?>"><?php print t('View All'); ?></a>
                        </li>
                    </ul>
                </div>
            </div>                      
            <?php }//print $rows;  ?>                      
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

