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
    // Hide comments, tags, and links now so that we can render them later.
  
    hide($content['comments']);
    hide($content['links']);
    hide($content['field_tags']);
    //echo 
    //print render($content);        exit;
    //echo "<pre>";
    //print_r($content['contact_form']); exit;
    // echo print_r($field_venue_gallery_image); 
     //print_r($field_venue_gallery_image[0]['filename']); 
     //echo file_create_url($field_venue_gallery_image[0]['filename']);
     
     //exit;
     
    //print render($content['field_venue_gallery_image']);
    
  ?>  
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div id="carouselExampleIndicators" class="carousel slide mb-2" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li>
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <?php 
                                    $SlideNumber=array('0'=>'First slide','1'=>'Second slide','2'=>'Third slide','3'=>'fourth slide');
                                    foreach ($field_venue_gallery_image as $key=>$val){
                                        if($key==3){ break; }                         
                                        $filePath=file_create_url($val['uri']);
                                        ?>
                                    <div class="carousel-item <?php if($key==1){ echo "active"; }?>">
                                        <img class="d-block img-fluid" src="<?php print $filePath; ?>" alt="<?php echo $SlideNumber[$key]; ?>">                         
                                    </div>
                                    <?php 
                                    } ?>                                    
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>  
                <div class="venue-gallery clearfix mb-5">
                    <div>
                        <a class="fancybox" rel="gallery" href="">
                            <img src="" alt="" />
                        </a>
                    </div>
                </div>
                <div class="panel mb-5">
                    <?php print $body[0]['value']; ?>                    
                </div>
                <div class="panel mb-5">
                    <h2><?php print t('Find West Tower on the Map');?></h2>                    
                    <div id="map"><?php print render($content['field_venue_map']); //print render($field_venue_map[0]['value']);?></div>                    
                </div>
                <div class="panel mb-5">
                    <h2 class="mb-4"><?php print t('Make an enquiry with West Tower');?></h2>                   
                        <div class="row">
                            <?php print render($content['contact_form']); ?>
                            <!--div class="col-2">
                                <input type="suffix" class="form-control form-control-lg" placeholder="Suffix" />
                            </div>
                            <div class="col-5">
                                <input type="text" class="form-control form-control-lg" placeholder="First Name" />
                            </div>
                            <div class="col-5">
                                <input type="text" class="form-control form-control-lg" placeholder="Last Name" />
                            </div>
                            <div class="col-12 mt-4 mb-4">
                                <input type="text" class="form-control form-control-lg" placeholder="Email Address" />
                            </div>
                            <div class="col-12">
                                <textarea type="suffix" class="form-control form-control-lg" placeholder="Your Message"></textarea>
                            </div-->
                        </div>                    
                </div>
            </div>                        
            <div class="col-sm-4">
                <div class="panel-title">
                    <h3 class="h6 upper white m-0"><?php print t('Contact Us'); ?></h3>
                </div>
                <div class="panel boxed">
                    <p><?php print t('Phone'); ?>: <strong><?php print $field_phone_number[0]['value']; ?></strong></p>
                    <p class="mb-0"><?php print t('View the'); ?><strong><a href="<?php print $field_website_url[0]['value']; ?>" target="_blank">&nbsp;<?php print t('Website'); ?></a></strong></p>
                </div>
                <div class="panel-title">
                    <h3 class="h6 upper white m-0"><?php print t('Facilities at West Tower'); ?></h3>
                </div>
                <div class="panel boxed">
                    <?php if(is_array($field_venue_type) && count($field_venue_type)>0) { ?>                    
                        <h3 class="h6 bold gold upper"><?php print t('Venue Type'); ?>:</h3>                        
                        <ul class="list-ticks mb-5">
                            <?php foreach ($field_venue_type as $key => $val) { ?>
                            <li><?php print $val['taxonomy_term']->name;?></li>                                                                                                                                                                        
                            <?php } ?>
                        </ul>                                                                                            
                    <?php } ?>
                    <?php if(is_array($field_evening_entertainment) && count($field_evening_entertainment)>0) { ?>                    
                        <h3 class="h6 bold gold upper"><?php print t('Evening Entertainment'); ?>:</h3>                        
                        <ul class="list-ticks mb-5">
                            <?php foreach ($field_evening_entertainment as $key => $val) { ?>
                            <li><?php print $val['taxonomy_term']->name;?></li>                                                                                                                                                                        
                            <?php } ?>
                        </ul>                                                                                            
                    <?php } ?>                        
                    <?php if(is_array($field_overnight_accommodation) && count($field_overnight_accommodation)>0) { ?>                    
                        <h3 class="h6 bold gold upper"><?php print t('Overnight Accommodation'); ?>:</h3>                        
                        <ul class="list-ticks mb-5">
                            <?php foreach ($field_overnight_accommodation as $key => $val) { ?>
                            <li><?php print $val['taxonomy_term']->name;?></li>                                                                                                                                                                        
                            <?php } ?>
                        </ul>                                                                                            
                    <?php } ?>
                    <?php if(is_array($field_other_features) && count($field_other_features)>0) { ?>                    
                        <h3 class="h6 bold gold upper"><?php print t('Other Features'); ?>:</h3>                        
                        <ul class="list-ticks mb-5">
                            <?php foreach ($field_other_features as $key => $val) { ?>
                            <li><?php print $val['taxonomy_term']->name;?></li>                                                                                                                                                                        
                            <?php } ?>
                        </ul>                                                                                            
                    <?php } ?>                                                                       
                    <?php if(is_array($field_dining_options) && count($field_dining_options)>0) { ?>                    
                        <h3 class="h6 bold gold upper"><?php print t('Dining Options'); ?>:</h3>                        
                        <ul class="list-ticks mb-5">
                            <?php foreach ($field_dining_options as $key => $val) { ?>
                            <li><?php print $val['taxonomy_term']->name;?></li>                                                                                                                                                                        
                            <?php } ?>
                        </ul>                                                                                            
                    <?php } ?>                        
                    <?php if(is_array($field_capacity) && count($field_capacity)>0) { ?>                    
                        <h3 class="h6 bold gold upper"><?php print t('Capacity'); ?>:</h3>                        
                        <ul class="list-ticks mb-5">
                            <?php foreach ($field_capacity as $key => $val) { ?>
                            <li><?php print $val['taxonomy_term']->name;?></li>                                                                                                                                                                        
                            <?php } ?>
                        </ul>                                                                                            
                    <?php } ?>                        
                    <?php if(is_array($field_venue_staff_assistance) && count($field_venue_staff_assistance)>0) { ?>                    
                        <h3 class="h6 bold gold upper"><?php print t('Venue Staff Assistance'); ?>:</h3>                        
                        <ul class="list-ticks mb-5">
                            <?php foreach ($field_venue_staff_assistance as $key => $val) { ?>
                            <li><?php print $val['taxonomy_term']->name;?></li>                                                                                                                                                                        
                            <?php } ?>
                        </ul>                                                                                            
                    <?php } ?>                        
                </div>
            </div>
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




