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
        $rows=$view->style_plugin->rendered_fields;                    
    ?>                
    <div class="view-content">
        <div class="row confir-block">
            <div class="col-sm-20 pt-0 pr-10 pb-10">
                <h3 class="h4 upper gold mt-0"><?php echo t('Create gift list');?></h3>             
                <div class="bg-white--">                    
                    <div class="row pb-2">
                        <?php
                            //Below function is write in menu.inc file
                            $giftUrl = getGiftListUrl();
                            $viewGiftListlink='';
                            $viewGiftList='';
                            if(trim($giftUrl)!='') {
                                 $viewGiftList = '/registry/'.$giftUrl.'/view';
                            }
                        ?>
                        <div class="col-sm-6">
                        <a href="/shop"><button type="button" class="btn btn-info"><?php print t('Add Product'); ?></button></a>	
                        <?php if($viewGiftList!='') { ?>
                            <a href="<?php print $viewGiftList; ?>"><button type="button" class="btn btn-info"><?php print t('View All Product'); ?></button></a>	
                        <?php } ?>
                        </div>
                    </div>                    
                </div>
                <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php print t('Product Name'); ?></th>
                                <th><?php print t('Images'); ?></th>
                                <th><?php print t('Quantity'); ?></th>
                                <th><?php print t('Price'); ?></th>
                                <th><?php print t('Gift List added Date'); ?></th>                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php                                                         
                            foreach($rows as $id => $row) {                                                               
                         ?>                                    
                            <tr>
                                <th scope="row"><?php print $row['counter']; ?></th>
                                <td><?php print ucfirst($row['title']); ?></td>
                                <td><?php print $row['field_images']; ?></td>
                                <td><?php print $row['quantity']; ?></td>
                                <td><?php print isset($row['commerce_price'])?$row['commerce_price']:'---'; ?></td>
                                <td><?php print $row['added_time']; ?></td>                                
                            </tr>                                                        
                            <?php } ?>                                                       
                        </tbody>
                    </table>                    
                <?php  //print $rows; ?>                
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
    <div class="row confir-block">
        <div class="col-sm-20 pt-0 pr-10 pb-10">
            <h3 class="h4 upper gold mt-5">Find suppliers</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi suscipit blandit ex, nec molestie sapien fermentum a. Cras non pretium nulla, eu egestas leo. Nunc faucibus lorem nec neque vestibulum placerat  
        </div>
    </div>
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