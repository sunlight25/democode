<?php
    $form = $variables['form'];
    $theme_path = drupal_get_path('theme', 'viamo');
        print render($form['form_id']);
        print render($form['form_build_id']);
        print render($form['form_token']);
        //dpm($form); 
?>
<!--div class = "container pt-5"-->
<div class = "row">
    <div class = "col s10 offset-s1">
<div class="row mb-5">
    <div class="col s12 pt-5">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h2 class="h4 v-gold-text mt-0">Your Event</h2>
                    <p>Your address will be used to send orders to if your guests wish to send them directly to you. Your guests will not be able to see your address.</p>
                    <br /><br />
                    <div class="row">                        
                        <div class="col s5 input-field">
                            <?php print drupal_render($form['title']); ?>                            
                            <?php print drupal_render($form['event_calendar_date']); ?>                            
                        </div>                        
                        <div class="col s7 input-field">                            
                            <label class="tp-of-cer"><?php print t('Type of Ceremeny'); ?></label>
                            <?php print drupal_render($form['field_type_of_ceremeny']); ?>                            
                        </div>                        
                        <div class="col s8 input-field">
                            <?php //print drupal_render($form['field_other_ceremony_venue_on_of']); ?>
                            <?php //print drupal_render($form['field_ceremony_venue']); ?>                                                       
                            <?php print drupal_render($form['field_other_ceremony_venue']); ?>
                        </div>
                        <div class="input-field col s4">
                            <?php print drupal_render($form['field_ceremony_time']); ?>                                                        
                        </div>
                        <div class="col s8 input-field">
                            <?php print drupal_render($form['field_other_reception_venue_on_o']); ?>                            
                            <?php print drupal_render($form['field_other_reception_venue']); ?>                            
                            <?php print drupal_render($form['field_venues']); ?>                                                                                            
                        </div>
                        <div class="input-field col s4">
                            
                            <?php print drupal_render($form['field_reception_time']); ?>                                                                                                                                            
                            <?php print drupal_render($form['add_button']); ?>                            
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php print drupal_render($form['actions']); ?>                                        
            <!--button class="btn waves-effect">Go to your account</button-->
        </div>        
    </div>
</div>
</div>
</div>

