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
    <div class="view-content">    
    <div class="bg-white">
        <div class="container">
            <div class="row pb-5">
                <div class="col-sm-12">
                    <h3 class="h4 upper gold mt-5"><?php print t('Your guests'); ?></h3>
                    <?php if ($rows): ?>
                    <?php
                        $rows=$view->style_plugin->rendered_fields;                    
                    ?>                
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php print t('First Name'); ?></th>
                                <th><?php print t('Last Name'); ?></th>
                                <th><?php print t('Email'); ?></th>
                                <th><?php print t('Mobile'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php                             
                            $i=1;                            
                            foreach($rows as $id => $row) {                                
                         ?>                                    
                            <tr>
                                <th scope="row"><?php print $i; ?></th>
                                <td><?php print ucfirst($row['title']); ?></td>
                                <td><?php print ucfirst($row['field_last_name']); ?></td>
                                <td><?php print $row['field_email']; ?></td>
                                <td><?php print isset($row['field_mobile'])?$row['field_mobile']:'---'; ?></td>
                                <td><?php print $row['edit_node'].'/'.$row['delete_node']; ?></td>                                
                            </tr>                                                        
                            <?php $i++; } ?>                                                       
                        </tbody>
                    </table>                                       
                </div>
            </div>	
        </div>
    </div>         
    <?php //print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>
    <div class="bg-white">
        <div class="container">
            <div class="row pb-5">
                <div class="col-sm-12">
                <a href="/node/add/user-guest-list?destination=<?php print $_GET['q']; ?>"><button type="button" class="btn btn-info"><?php print t('Manage Guests'); ?></button></a>	
                <a href="/send-invitations?destination=<?php print $_GET['q']; ?>"><button type="button" class="btn btn-info"><?php print t('Send Invitations'); ?></button></a>	
                </div>
            </div>
        </div>
    </div>
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
