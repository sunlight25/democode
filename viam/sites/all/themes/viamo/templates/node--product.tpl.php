<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php if ((!$page && !empty($title)) || !empty($title_prefix) || !empty($title_suffix) || $display_submitted): ?>
  <header>
    <?php print render($title_prefix); ?>
    <?php if (!$page && !empty($title)): ?>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
    <?php if ($display_submitted): ?>
    <span class="submitted">
      <?php print $user_picture; ?>
      <?php print $submitted; ?>
    </span>
    <?php endif; ?>
  </header>
  <?php endif; ?>
  <?php  
     //dpm($content); 
    //echo "<pre>" ;
    //print_r($content); exit;  
    // Hide comments, tags, and links now so that we can render them later. 
            hide($content['comments']);
            hide($content['links']);
            hide($content['field_tags']);   
  ?>              
        <div class="product-title-area center-align">
            <h1 class="item-name"><?php print render($content['product:title']);?></h1>
            <h2 class="vendor v-gold-text"><?php print render($content['product:commerce_store']);?></h2>
            <p><span class="gold"><?php print render($content['product:commerce_price']);?></span></p>
        </div>
        <div class="row">
            <div class="col offset-s1 s5">
                <div class="owl-carousel owl-theme">
                <?php 
                              if(is_array($content['product:field_product_gallery']['#object']->field_product_gallery['und'])) {
                                    foreach($content['product:field_product_gallery']['#object']->field_product_gallery['und'] as $key => $val){
                                       $uri= $val['uri'];
                                       $path= file_create_url($uri);
                                       print '<div class="item"><img src="'.$path.'" /></div>';                                       
                                    }                                                
                              }                                
                        ?>
                    <?php //echo "<pre>"; print_r($content['product:field_product_gallery']['#object']->field_product_gallery['und']); exit; ?> 
                    <?php //print render($content['product:field_product_gallery']);?>                                        
                </div>
            </div>
            <div class="col s5">
                <p><?php print render($content['body']); ?></p>                                                
                <?php print render($content['field_product_variations']); ?>                 
                <!--div class="input-field">
                    <label>Quantity</label>
                    <input width="200" type="number" />
                </div>
                <button class="btn waves add-to-cart v-blue">Add to Gift List</button>
                <button class="btn waves add-to-cart v-blue">Buy Now</button-->
                <p><strong><?php echo render($content['product:sku']);?></strong></p>
                    <button class="btn waves add-to-cart v-blue" disabled>Add to Gift List</button>
            </div>
        </div>       
  <?php
    //print render($content);
    // Only display the wrapper div if there are tags or links.
    $field_tags = render($content['field_tags']);
    $links = render($content['links']);
    if ($field_tags || $links):
  ?>
   <footer>
     <?php print $field_tags; ?>
     <?php print $links; ?>
  </footer>
  <?php endif; ?>
  <?php print render($content['comments']); ?>
</article>




