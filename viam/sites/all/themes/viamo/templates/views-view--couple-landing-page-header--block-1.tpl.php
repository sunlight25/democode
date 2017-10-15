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
    <div class="view-content">
        <?php
            $rows=$view->style_plugin->rendered_fields;                       			                      
            //echo "<pre>";                                
            //print_r($rows); exit;            
        ?> 
        <div class="row confir-block">
            <div class="col-sm-20 pt-5 pr-10 pb-10">
            <h3 class="h4 upper gold mt-0"><?php echo t('Confirmation');?></h3>            
            <dl class="row">
                <dt class="col-sm-3"><?php echo t('Bride &amp; Groom'); ?></dt>
                <dd class="col-sm-9"><?php echo isset($rows[0]['field_suffix_host'])?$rows[0]['field_suffix_host']:'--' ?>  <?php echo isset($rows[0]['field_host_first_name'])?$rows[0]['field_host_first_name']:'--' ?> <?php echo isset($rows[0]['field_host_last_name'])?$rows[0]['field_host_last_name']:'--' ?> 
                    &amp; <?php echo isset($rows[0]['field_partners_suffix'])?$rows[0]['field_partners_suffix']:'--' ?>  <?php echo isset($rows[0]['field_partners_first_name'])?$rows[0]['field_partners_first_name']:'--' ?> <?php echo isset($rows[0]['field_partners_last_name'])?$rows[0]['field_partners_last_name']:'--' ?></dd>
                <dt class="col-sm-3"><?php echo t('Event Date'); ?></dt>
                <dd class="col-sm-9"><?php echo isset($rows[0]['event_calendar_date'])?$rows[0]['event_calendar_date']:'--' ?></dd>
                <dt class="col-sm-3">Ceremony</dt>
                <dd class="col-sm-9">St. Chads Poulton at 1pm</dd>
                <dt class="col-sm-3"><?php echo t('Reception'); ?></dt>
                <dd class="col-sm-9"><?php echo t('The').' '; ?><?php echo isset($rows[0]['title_1'])?$rows[0]['title_1']:'--' ?></dd>
                <h3 class="h4 upper gold mt-5">Choose your stationary</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi suscipit blandit ex, nec molestie sapien fermentum a. Cras non pretium nulla, eu egestas leo. Nunc faucibus lorem nec neque vestibulum placerat.</p>            
            </dl>                        
        </div>         
        </div>
      <?php //print $rows; ?>
        
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


