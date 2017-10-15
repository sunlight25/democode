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
          <?php print render($form['name']); ?>
        </div>
        <div class="input-field col s12">
          <?php print render($form['pass']); ?>
        </div>
        <div class="input-field col s12">
          <?php print drupal_render($form['actions']); ?>         
        </div>  
      </div> 
      <!--div class="row-right">
          <p><?php echo t('If you have not registered, then please register first') ;?></p>          
          <div class="input-field col s12">
              <div class="div_title"></div><div class="div_btn"><?php echo l(t('Sign up here'), 'user/register',array ('attributes'=>array('class'=>array('btn','waves-effect','waves-light')))); ?></div>              
          </div>
          
      </div-->   
</div>        
<!--/.First column-->
