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
                    $block = module_invoke('views', 'block_view', '-exp-teacher-page_1');
                    print render($block['content']);
                    ?>
                    <div class="change-view">
                        <ul class="top-right-icon">               
                            <?php
                            /* Gird and list toggle btn generating Block */
                            if (module_exists('teacherlistgridview')) {
                                $block = module_invoke('teacherlistgridview', 'block_view', 'teach_list_and_grid');
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
        <!--<div class="view-content cd-main-content">-->
        <?php
        global $base_url;
        $rows = $view->style_plugin->rendered_fields;
        $theme_path = drupal_get_path('theme', 'ukschool');
        ?>
        <?php if ($rows): ?>
            <ul class="<?php echo $_SESSION['teacher-class-gird-list']; ?>">
                <?php
                foreach ($rows as $id => $row) {

                    $teacher_name = substr($row['field_teacher_first_name'], 0, 1) . ' ' . $row['field_teacher_last_name'];

                    $node = node_load($row['nid']);
                    $node_wrapper = entity_metadata_wrapper('node', $node);
                    $filevalue = $node_wrapper->field_teacher_gallery->value();
                    $image_url = file_create_url($filevalue[0]['uri']);

                    $badgesfield = $node->field_teacher_badges['und'];
                    $offeringfield = $node->field_teacher_offering['und'];

                   // $teacherurl = $base_url.$row['path'];
                    $teacherurl = '';
                            
                    echo '<li class="mix color-1 check1 option1" data-wow-duration="1000ms" data-wow-delay="300ms" style="display: inline-block;">
                                <div class="card">
                                    <div class="card-image waves-effect waves-block waves-light">
                                        <div class="profile-img-round">' . $row['field_teacher_profile_photo'] . '</div>
                                        <div class="offering-icons">';
                                            if ($row['field_teacher_dbs_check'] == 'Yes') {

                        foreach ($badgesfield as $key => $value) {
//                            echo "<pre>";
//                            print_r($badgesfield);
                            $term = taxonomy_term_load($value['tid']);
                            if ($value['tid'] == '74') { //No Smoking
                                
                                echo '<span class="school-title icon-color tooltip"><span class="tooltiptext">'.t($term->name).'</span><i class="mdi mdi-smoking-off"></i></span>';
                            }else if ($value['tid'] == '75') { //No pets
                                echo '<span class="school-title icon-color tooltip"><span class="tooltiptext">'.t($term->name).'</span><i class="mdi mdi-pig"></i></span>';
                            }else if ($value['tid'] == '76') {//Children at home
                                echo '<span class="school-title icon-color tooltip"><span class="tooltiptext">'.t($term->name).'</span><i class="mdi mdi-voice"></i></span>';
                            }else if ($value['tid'] == '77') {//Privat bathroom
                                echo '<span class="school-title icon-color tooltip"><span class="tooltiptext">'.t($term->name).'</span><i class="mdi-water-pump"></i></span>';
                            }else if ($value['tid'] == '78') {//Wifi Available
                                echo '<span class="school-title icon-color tooltip"><span class="tooltiptext">'.t($term->name).'</span><i class="mdi mdi-wifi"></i></span>';
                            }
                        }
                    }
                                       echo' </div>
                                        <div class="card-black-shadow"></div><img src="' . $image_url . '" alt="Smiley face" height="42" width="42">                                                                  
                                            <a><div class="mask"></div></a>                    
                                    </div>
                                    <div class="card-block">';



                    echo '<div class="card-reveal-upper">  
                                    <h4 class="card-title tooltip ' . $_SESSION['teacher-girdView'] . '"><a href="'.$teacherurl.'">' . $teacher_name . '</a>
                                          <span class="tooltiptext">' . $teacher_name . '</span>
                                    </h4>   
                                    <h4 class="card-title tooltip ' . $_SESSION['teacher-listView'] . '"><a href="'.$teacherurl.'">' . $teacher_name . '</a>
                                          <span class="tooltiptext">' . $teacher_name . '</span>
                                    </h4>';

                    

                    echo '<div class="card-reveal-location">
                                        <i class="mdi mdi-map-marker"></i> <span class="school-title">' . t($row['field_major_locations']) . '</span>                                                
                                    </div>';
                    echo '<div class="card-reveal-gender">';

                    
                     foreach ($offeringfield as $key => $value) {
                         
                        $term = taxonomy_term_load($value['tid']);
                        if ($value['tid'] == '68') {//Guardianship (boarding school)
                            echo '<span class="school-title icon-color tooltip"><span class="tooltiptext">'.t($term->name).'</span><i class="mdi mdi-hospital-building"></span></i>';
                        }else if ($value['tid'] == '70') {//Guardianship (day school)
                            echo '<span class="school-title icon-color tooltip"><span class="tooltiptext">'.t($term->name).'</span><i class="mdi mdi-home"></i></span>';
                        }else if ($value['tid'] == '71') {//HomeStay (Christmas holiday)
                            echo '<span class="school-title icon-color tooltip"><span class="tooltiptext">'.t($term->name).'</span><i class="mdi mdi-cake-variant"></i></span>';
                        }else if ($value['tid'] == '72') {//HomeStay (Easter holiday)
                            echo '<span class="school-title icon-color tooltip"><span class="tooltiptext">'.t($term->name).'</span><i class="mdi mdi-cake"></i></span>';
                        }else if ($value['tid'] == '73') {//HomeStay (term time)
                            echo '<span class="school-title icon-color tooltip"><span class="tooltiptext">'.t($term->name).'</span><i class="mdi mdi-quicktime"></i></span>';
                        }
                    }
                    
                    echo '</div>';
                    echo '</div>   
                                    </div></div>                                
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
