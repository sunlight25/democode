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
        ?>    
        <div id="hero_title-bg-img" class="mb-0 text-center white t-bg">
            <h1 class="display-5 text-uppercase "><?php echo t('The').' '; ?><?php echo isset($rows[0]['title_1'])?$rows[0]['title_1']:'--' ?></h1>
            <h2 class="upper white h6"><?php echo isset($rows[0]['field_locations'])?$rows[0]['field_locations']:'--' ?></h2>
            <h3 class="upper">
                <small class="bold text-muted"><?php echo t('is hosting the wedding of');?>:</small><br />
                <span class="xbold">
                    <?php echo isset($rows[0]['field_suffix_host'])?$rows[0]['field_suffix_host']:'--' ?>  <?php echo isset($rows[0]['field_host_first_name'])?$rows[0]['field_host_first_name']:'--' ?> <?php echo isset($rows[0]['field_host_last_name'])?$rows[0]['field_host_last_name']:'--' ?> 
                    &amp; <?php echo isset($rows[0]['field_partners_suffix'])?$rows[0]['field_partners_suffix']:'--' ?>  <?php echo isset($rows[0]['field_partners_first_name'])?$rows[0]['field_partners_first_name']:'--' ?> <?php echo isset($rows[0]['field_partners_last_name'])?$rows[0]['field_partners_last_name']:'--' ?>
                        </span><br />
                <small class="bold text-muted"><?php echo t('on the day of');?></small><br />
                <span class="xbold"><?php echo isset($rows[0]['event_calendar_date'])?$rows[0]['event_calendar_date']:'--' ?></span>
            </h3>
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


