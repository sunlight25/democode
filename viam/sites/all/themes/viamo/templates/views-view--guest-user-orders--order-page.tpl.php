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

  <?php if ($rows): ?>
    <?php
         global $base_url;
         $rows = $view->style_plugin->rendered_fields;
         $theme_path = drupal_get_path('theme', 'viamo');                                
      ?>    
    <div class="view-content">
        <h3><span class="v-gold-text mb-5 p-3"><?php// print t('Recent Orders'); ?></span></h3>
        <div class="p-3 white z-depth-2">			 
            <table class="highlight">
                <thead class="">
                    <tr>
                        <th><?php print t('Order Number'); ?></th>
                        <th><?php print t('Order Date'); ?></th>
                        <th><?php print t('Total'); ?></th>
                        <th><?php print t('Status'); ?></th>
                        <th><?php print t('View'); ?></th>
                        <th><?php print t('Comments'); ?></th>
                    </tr>
                </thead>													
                <tbody>
                    <?php foreach ($rows  as $id => $row) { ?> 
                    <?php //print_r($row); exit; ?>
                    <tr>									
                        <td>
                            <span class="bold"><?php print $row['order_number']; ?></span>
                            <br><span><?php print $row['mail']; ?></span>
                        </td>
                        <td><?php print $row['created']; ?></td>
                        <td><?php print $row['commerce_order_total']; ?></td>
                        <td>                         
                        <?php if($row['status'] == 'Completed'):?>
                            <i class="material-icons green-text">done</i>
                        <?php else:?>
                           <i class="material-icons red-text tooltipped" data-position="left" data-delay="50" data-tooltip="<?php print $row['status']; ?>">info_outline</i>                            
                        <?php endif;?>                                                
                        </td>
                        <td><?php print $row['order_id']; ?></td>
                        <td><i class="material-icons grey-text">question_answer</i></td>
                    </tr>                                                       
                    <?php } ?> 
                </tbody>
            </table>
        </div>                         
    <?php //print $rows; ?>
    </div>
  <?php elseif ($empty): ?>    
    <div class="view-empty p-3 white z-depth-2">
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
