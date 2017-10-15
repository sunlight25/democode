<?php
//Key Information
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
            $rows = $view->style_plugin->rendered_fields;
            ?>
            <div class="table-responsive data-table-center">               
                <table class="table table-striped table-hover" width="100%">     
                    <tbody>
                        <tr>
                            <td></td>                            
                            <?php foreach ($rows as $id => $row){ ?>                            
                            <td>
                                <div class="field-item even"><?php print $row['field_logo'];?></div>
                                <span class="compare-item"><?php print $row['title'];?></span>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php
                        $field = array(
                            'field_boarders' => 'School Type',
                            'field_location' => 'Location',
                            'field_statutory_high_age' => 'Age Range',
                            'field_religiouscharacter' => 'Religious Character',
                            'field_number_of_pupils' => 'Number Of Students',
                            'field_international_student_no' => 'International Student Number',
                            'field_school_website' => 'Website',
			    'field_fees_day'      => 'Fees Day',
                            'field_fees_boarding' => 'Fees Boarding',
                        );
                        foreach ($field as $key => $val) {
                            ?>
                            <tr>
                                <td><?php echo t($val); ?> </td>
                                <?php foreach ($rows as $id => $row) {
                                    ?>
                                    <td>
                                        <?php
                                        if ($key == 'field_statutory_high_age') {
                                            echo ($row[$key]) ? $row['field_statutory_low_age'] . '-' . $row[$key] : '-';
                                        } else {
					   if($key == 'field_fees_day' || $key == 'field_fees_boarding') {                                                                                                
                                                //$fees=str_replace('£', '', $row[$key]);
                                                $fees=$row[$key];
                                                echo ($fees>0) ? '£'.$row[$key] : 'NA';
                                            } else{
                                                echo ($row[$key]) ? t($row[$key]) : '-';
                                            }	                                            
                                        }
                                        ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
