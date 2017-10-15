<?php
print render($form['form_id']);
print render($form['form_build_id']);
$theme_path = drupal_get_path('theme', 'ukschool');
global $base_url;
?>
<!--First column-->
<div class="row">    
       <div class="row-left">
        <div class="input-field col s12">
          <?php print render($form['account']['name']); ?>
        </div>
        <div class="input-field col s12">
         <?php print render($form['account']['mail']); ?>
        </div>
        <div class="input-field col s12">
         <?php print render($form['account']['pass']); ?>
       </div>                
       
        <div class="input-field col s12">
           <?php                                            
                    print drupal_render($form['buttons']); 
                    print drupal_render($form['actions']);                                                 
            ?>         
        </div>  
      </div>     
      <div class="row-right">
          <p><?php echo t('If you already have account, then please login first') ;?></p>
          <div class="input-field col s12" style="padding: 40px;">              
              <div class="div_title"><?php echo t('Login here') ;?></div><div class="div_btn"><?php echo l(t('Login here'), 'user/login',array ('attributes'=>array('class'=>array('btn','waves-effect','waves-light')))); ?></div>              
          </div>                    
      </div>   
</div>        
<!--/.First column-->
