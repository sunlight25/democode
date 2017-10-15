<?php
/**
 * @file
 * Main view template.
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
            <?php //print $header; ?>
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

            //$view = views_get_view('category_product_list');
            //$view->set_display('page');
            //$view->init_handlers();
            //$exposed_form = $view->display_handler->get_plugin('exposed_form');
            //$ee= $exposed_form->render_exposed_form(true);
            //$form = views_exposed_form(array(), $form_state);
            //drupal_render($exposed_form['sort_by']);
    //echo "<pre>";
    //print_r($ee); exit;
    
//print drupal_render($form);
                    
                  //$block = module_invoke('views', 'block_view', '4f8dc14f9483207f7bd312301796c30d');                  
                  //print_r($block['content']); 
                  
                  //print render($block['content']);
            ?>
    <?php if ($rows): ?>
        <?php
        global $base_url;
        $rows = $view->style_plugin->rendered_fields;
        $theme_path = drupal_get_path('theme', 'viamo');
        ?>        
        <div class="view-content">
            <div class="col s4">
                    <div class="py-1"><?php print $header; ?></div>
	    </div>
            <div class="row mt-5">                 						
                <div class="col">                                                           
                    <div class="row s10">                                                
                    <?php
                                foreach ($rows as $id => $row) {                                
                              ?>    
                        <div class="col m3 s6">
                            <div class="product-item">
                                <?php print $row['field_images']; ?>                                                        
                                <h3 class="item-name h6 upper gold mb-1"><a href="<?php print $row['path']; ?>"><?php print $row['title']; ?></a></h3>
                                <span class="price"><?php print $row['commerce_price']; ?></span>
                                <div class="buttons-block">	
                                    <div class="buttons">
                                        <!-- Modal Trigger -->                                        
                                        <a class="left modal-trigger" href="#add_to_gl">Add to list</a>
                                        <?php print $row['add_to_cart']; ?>
                                        <!--a class="right modal-trigger" href="#add_to_ca">Add to cart</a-->
                                    </div>							
                                </div>
                            </div>
                        </div>                                    
                        <?php } ?>
                    </div>                    
                </div>                                    
            </div>    
        </div>
    <?php elseif ($empty): ?>
        <div class="view-empty">
            <div class="row mt-5">                                                                         
                <div class="col s10">
                    <div class="mb-5">
                        <?php print $empty; ?>
                    </div>
                </div>
            </div>            
        </div>
    <?php endif; ?>

    <?php if ($pager): ?>    
    <div class="py-4 right"><?php print $pager; ?></div>          
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

