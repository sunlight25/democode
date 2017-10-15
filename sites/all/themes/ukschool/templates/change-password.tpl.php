<?php
    print render($form['form_id']);
    print render($form['form_build_id']);
    print render($form['form_token']);
    global $user;
?>

<!--First column-->
<div class="row card-panel">    
      <div class="row-left">
        <div class="input-field col s12">
          <?php print render($form['account']['mail']); ?>
        </div>
        <div class="input-field col s12">
          <?php print render($form['account']['pass']); ?>
        </div>
        <div class="input-field col s12">
          <?php print render($form['actions']); ?>
        </div>  
      </div> 
      <div class="row-right">          
          <div class="input-field col s12" style="padding: 40px;">         
              <?php if (in_array('Tutor', array_values($user->roles), TRUE)){ ?>
                <div class="div_title"><?php echo t('User Profile') ;?></div><div class="div_btn"><?php echo l(t('Click'), 'profile-tutor_profile',array ('attributes'=>array('class'=>array('btn','waves-effect','waves-light')))); ?></div>                            
              <?php } else { ?>
                <div class="div_title"><?php echo t('User Profile') ;?></div><div class="div_btn"><?php echo l(t('Click'), 'user',array ('attributes'=>array('class'=>array('btn','waves-effect','waves-light')))); ?></div>                              
              <?php } ?>              
          </div>                    
      </div>   
</div>        
<!--/.First column-->