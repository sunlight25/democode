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
            <?php $rows = $view->style_plugin->rendered_fields; ?>                            
            <div>            
                <?php
                    global $base_url;
                    foreach ($rows as $id => $row) {                                                                    
                    ?>                                                     
                    <div class="col-md-4 col-sm-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <div class="card ovf-hidden">                            
                            <div class="view overlay hm-white-slight">                        
                                <?php print $row['field_card_image']; ?>
                                <a><div class="mask"></div></a>                                                                   
                            </div>                            
                            <div class="card-block">                                                                
                                <a class="activator tooltip"><?php print $row['field_times_overall_ranking']; ?><span class="tooltiptext"><?php print t('Times Ranking'); ?></span></a>
                                <h4 class="card-title tooltip"><?php print $row['title']; ?><span class="tooltiptext"><?php print $row['title_1']; ?></span></h4>                               
                                <!--a class="activator tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php print t('Times Ranking'); ?>"><?php print $row['field_times_overall_ranking']; ?></a>                                
                                <h4 class="card-title tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php print $row['title_1']; ?>"><?php print $row['title']; ?></h4-->                                                                                                
                                <p class="card-text"><i class="material-icons map">room</i><?php print t($row['field_location']); ?></p>
                                 
                                <div class="card-reveal-upper">
                                    <div class="card-reveal-gender">                                                      
                                        <?php     
                                                if($row['field_fees_day']>0) {
                                                    print getInternationalStudentFees($row['field_fees_day']);
                                                } else {
                                                    print getInternationalStudentFees($row['field_fees_boarding']);
                                                }                                              
                                                //print getInternationalStudentFees($row['field_fees_day']);
                                                print getschoolGender($row['field_gender']);
                                                print getSchoolBoardersType($row['field_boarders']);                                            
                                        ?>
                                    </div>   
                                </div>
                                <div class="card-reveal-bottom">
                                    <span class="mt10 left full-width">
                                        <span class="right a2a_kit a2a_default_style" data-a2a-url="<?php print $base_url; ?>/<?php print $row['path']; ?>" data-a2a-title="<?php print strip_tags($row['title']); ?>"> 
                                            <span class="left"><?php print $row['node_compare_link']; ?></span>
                                            <!--a href="#" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Compare"><img alt="Home" src="/sites/all/themes/ukschool/img/compair-icon.png"></a-->
                                            <a class="a2a_dd" href="https://www.addtoany.com/share" href="#"><i class="mdi mdi-share"></i></a>
                                        </span>                                                    
                                        <!--a class="link-text right" href="<?php print $row['path']; ?>"><h5>More<i class="fa fa-chevron-right"></i></h5></a-->
                                    </span>
                                </div>
                            </div>                           
                        </div>
                    </div>
                <?php } ?>                           
                <div class="featured-schools-view-btn"><a class="btn btn-lg btn-primary wow fadeInUp" href="<?php echo get_baseurl_with_language(); ?>/schools"><?php  print t('View All Schools'); ?></a></div>
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
<script async src="https://static.addtoany.com/menu/page.js"></script>
