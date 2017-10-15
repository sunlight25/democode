<?php       
    print render($form['form_id']);
    print render($form['form_build_id']);     
    $theme_path = drupal_get_path('theme', 'viamo');
    global $base_url;
    if ($_GET['q'] == 'host/register') {
    ?>        
    <div class="row">
            <div class="col s10 offset-s1">
                <p><?php print t('Your address will be used to send orders to if your guests wish to send them directly to you. Your guests will not be able to see your address.'); ?></p>
                <!--form class="mb-5"-->
                    <div class="row">
                        <div class="col s6">
                            <div class="card">
                                <div class="card-content">
                                    <h2 class="h4 v-gold-text mt-0"><?php print t('Your Details'); ?></h2>
                                    <div class="row">
                                        <div class="col s4 input-field">
                                            <?php print render($form['profile_main']['field_suffix_host']); ?>                                            
                                        </div>
                                        <div class="col s4 input-field">
                                            <?php print render($form['profile_main']['field_host_first_name']); ?>                                            
                                        </div>
                                        <div class="col s4 input-field">
                                            <?php print render($form['profile_main']['field_host_last_name']); ?>                                            
                                        </div>
                                        <div class="col s12 input-field">
                                            <?php print render($form['account']['mail']); ?>
                                        </div>
                                        <div class="col s12">
                                            <label><?php print t('You are the'); ?></label>
                                           <?php print render($form['profile_main']['field_partners_type']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="card">
                                <div class="card-content">
                                    <h2 class="h4 v-gold-text mt-0"><?php print t('Partners Details'); ?></h2>
                                    <div class="row">
                                        <div class="col s4 input-field">
                                            <?php print render($form['profile_main']['field_partners_suffix']); ?>
                                        </div>
                                        <div class="col s4 input-field">
                                            <?php print render($form['profile_main']['field_partners_first_name']); ?>
                                        </div>
                                        <div class="col s4 input-field">
                                            <?php print render($form['profile_main']['field_partners_last_name']); ?>
                                        </div>
                                        <div class="col s12 input-field">
                                            <?php print render($form['profile_main']['field_partners_email']); ?>                                            
                                        </div>
                                        <div class="col s12">
                                            <label><?php print t('You are the'); ?></label>
                                            <?php print render($form['profile_main']['field_your_type']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">                                    
                                    <?php print render($form['account']['pass']); ?>                                                                            
                                </div> 
                            </div> 
                        </div> 
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    <h2 class="h4 v-gold-text mt-0"><?php print t('Your Address'); ?></h2>
                                    <p><?php print t('Your address will be used to send orders to if your guests wish to send them directly to you. Your guests will not be able to see your address.'); ?></p>
                                    <div class="row">
                                         <?php print render($form['profile_main']['field_host_address']); ?>                                                                                 
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="col s12 pt-2">
                        <?php
                                          print drupal_render($form['buttons']);
                                          print drupal_render($form['actions']);
                                    ?>                                        
                        </div>                                                                                                
                    </div>
                <!--/form-->
            </div>
        </div>    
    <!--/.First column-->
<?php } else {         
    ?>   
   <div class="row">
            <div class="col s10 offset-s1">
                <p><?php //print t('Your address will be used to send orders to if your guests wish to send them directly to you. Your guests will not be able to see your address.'); ?></p>
                <!--form class="mb-5"-->
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    <h2 class="h4 v-gold-text mt-0"><?php print t('Your Details'); ?></h2>
                                    <div class="row">
                                        <div class="col s4 input-field">
                                            <?php print render($form['field_suffix']); ?>                                            
                                        </div>
                                        <div class="col s4 input-field">
                                            <?php print render($form['field_first_name']); ?>                                            
                                        </div>
                                        <div class="col s4 input-field">
                                            <?php print render($form['field_lastname']); ?>                                            
                                        </div>
                                        <div class="col s12 input-field">
                                            <?php print render($form['account']['mail']); ?>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">                                    
                                    <?php print render($form['account']['pass']); ?>                                                                            
                                </div> 
                            </div> 
                        </div>                         
                        <div class="col s12 pt-2">
                        <?php
                                          print drupal_render($form['buttons']);
                                          print drupal_render($form['actions']);
                                    ?>                                        
                        </div>                                                                                                
                    </div>
                <!--/form-->
            </div>
        </div>     
<?php }  ?>    