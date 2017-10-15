<?php
$form = $variables['form'];
$theme_path = drupal_get_path('theme', 'viamo');
print render($form['form_id']);
print render($form['form_build_id']);
print render($form['form_token']);
//echo "<pre>";
//print_r($form); exit;
//dpm($form); 
?>
<!--div class = "container pt-5"-->
<div class = "row  pt-5">    
    <div class="row mb-0">
        <div class="col s12">        
            <div class="card">
                <div class="card-content">
                    <h2 class="h4 v-gold-text mt-0"><?php print t('Edit Account Details'); ?></h2>                                        
                    <div class="row">                                                
                        <div class="col s12 input-field">                            
                            <div class="center"><?php print drupal_render($form['picture']); ?></div>
                        </div>                        
                        <div class="col s6 input-field">                            
                            <?php print drupal_render($form['account']['name']); ?>                            
                        </div>                        
                        <div class="col s6 input-field">                                                        
                            <?php print drupal_render($form['account']['mail']); ?>                            
                        </div>                        
                        <div class="col s4 input-field">                            
                            <?php print drupal_render($form['field_suffix']); ?>                            
                        </div>
                        <div class="col s4 input-field">                            
                            <?php print drupal_render($form['field_first_name']); ?>                            
                        </div>                        
                        <div class="col s4 input-field">                                                        
                            <?php print drupal_render($form['field_lastname']); ?>                            
                        </div>
                        <div class="col s12 input-field">                                                                                                               
                            <?php print drupal_render($form['account']['current_pass']); ?>                                                        
                            <?php print drupal_render($form['account']['pass']); ?>                            
                        </div>
                        <div class="input-field col s12">
                            <?php print drupal_render($form['overlay_control']); ?>                                                        
                        </div>
                        <div class="col s8 input-field">
                            <?php //print drupal_render($form['field_first_name']);  ?>                                                        
                        </div>
                        <div class="input-field col s4">

                            <?php //print drupal_render($form['field_reception_time']);  ?>                                                                                                                                            
                            <?php //print drupal_render($form['add_button']); ?>                            

                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12">                                
                    <div class="col s6 input-field">
                        <?php print drupal_render($form['actions']); ?>
                    </div>
                    <div class="col s6 input-field">
                        <div id="overlay-close-wrapper">
                             <a id="overlay-close-user" href="#" class="overlay-close btn v-blue right"><?php print t('Close me'); ?></a>                    
                        </div>
                    </div>                
            </div>           
            <!--div id="overlay-close-wrapper">
                    <a id="overlay-close" href="#" class="overlay-close"><?php print t('Close overlay'); ?></a>
            </div-->
            <!--button class="btn waves-effect">Go to your account</button-->        
        </div>
    </div>    
</div>


