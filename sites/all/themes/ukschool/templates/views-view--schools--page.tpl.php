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
<div class="views-courses-page <?php print $classes; ?>">
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

    <div class="cd-tab-filter-wrapper">
        <div class="cd-tab-filter">
            <ul class="cd-filters">
                <div class="cd-select cd-filters top-right-select">
                    <?php
                    $block = module_invoke('views', 'block_view', '-exp-schools-page_1');
                     print render($block['content']);
                    ?>
                     <div class="change-view">
                        <ul class="top-right-icon">               
                            <?php
                            /* Gird and list toggle btn generating Block */
                            if (module_exists('ukschoollistgridview')) {
                                $block = module_invoke('ukschoollistgridview', 'block_view', 'list_and_grid');
                                print render($block['content']);
                            }
                            ?>      
                        </ul>
                    </div>
                </div>
            </ul>
        </div>
    </div>
    <div class="view-content cd-gallery cd-main-content">
        <?php
        global $base_url;
        $rows = $view->style_plugin->rendered_fields;
        $theme_path = drupal_get_path('theme', 'ukschool');
        ?>
        <?php if ($rows): ?>
            <ul class="<?php echo $_SESSION['class-gird-list']; ?>">
                <?php
                foreach ($rows as $id => $row) {
                    //echo "<pre>";
                    //print_r($row); exit;
                    echo    '<li class="mix color-1 check1 option1" data-wow-duration="1000ms" data-wow-delay="300ms">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">                                                                                
                                        <div class="card-black-shadow"></div>' . $row['field_card_image'] . '                                                                  
                                            <a><div class="mask"></div></a>                    
                                    </div>                                                                        
                                    <div class="card-block">
                                    <div class="activator tooltip">' . $row['field_times_overall_ranking'] . '
                                          <span class="tooltiptext">'.t('Times Ranking').'</span>
                                     </div>   
                                    <div class="card-reveal-upper"> 
                                    
                                    <h4 class="card-title tooltip ' .$_SESSION['girdView']. '">' . $row['title'] . '
                                          <span class="tooltiptext">'.$row['title_1'].'</span>
                                    </h4>   
                                    <h4 class="card-title tooltip ' .$_SESSION['listView']. '">' . $row['title_2'] . '
                                          <span class="tooltiptext">' . $row['title_1'] .'</span>
                                    </h4>                                                                                                                                                 
                                    <div class="card-reveal-location">
                                        <i class="mdi mdi-map-marker"></i> <span class="school-title">'.t($row['field_location']).'</span>                                                
                                    </div>
                                            <div class="card-reveal-gender">';
                                            if($row['field_fees_day']>0) {
                                                print getInternationalStudentFees($row['field_fees_day']);
                                            } else {
                                                print getInternationalStudentFees($row['field_fees_boarding']);
                                            }
                                            //print getInternationalStudentFees($row['field_fees_day']);    
                                            print getschoolGender($row['field_gender']);
                                            print getSchoolBoardersType($row['field_boarders']);                                            
                                    echo '</div>                                            
                                         </div>                                      
                                            <div class="card-reveal-bottom">
                                                <span class="right mt5">
                                                    <div class="a2a_kit a2a_default_style" data-a2a-url="'.$base_url.'/'.strip_tags($row['path_1']).'" data-a2a-title="'.strip_tags($row['title']).'">
                                                         <span class="left">'.$row['node_compare_link'] .'</span>
                                                        <a class="a2a_dd" href="https://www.addtoany.com/share"><i class="mdi mdi-share"></i></a>                                                        
                                                    </div>                                                    
                                                </span>
                                            </div>
                                    </div>
                                    
                                </div>                                
                            </li>';
                }
                ?>
            </ul>        
    </div>
    <?php elseif ($empty): ?>
            <div class="cd-fail-message"><?php print $empty; ?></div>
    <?php endif; ?>       
    <?php if ($pager): ?>
        <div class="bottomloader">
            <?php print $pager; ?>
        </div>
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
