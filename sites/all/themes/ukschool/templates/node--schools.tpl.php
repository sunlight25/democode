<?php
$links = render($content['links']);
?>
<div class="row page container">
    <div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <div class="content card-content">
        <?php print render($title_prefix); ?>
        <h4 class="card-title" <?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h4>
        <?php print render($title_suffix); ?>
        <?php if ($display_submitted): ?>
            <p class="submitted">
                <span class="label">
                    <?php print $submitted; ?>
                </span>
            </p>
        <?php endif; ?>
        <?php if (!empty($user_picture)): ?>
            <div class="user image">
                <?php print $user_picture; ?>
            </div>
        <?php endif; ?>                    
        <div <?php print $content_attributes;  ?>>            
            <?php
            // We hide the comments and links now so that we can render
            // them later.
            //hide($content['comments']);
            // print render($content);
            ?>
        </div>
    </div>    
    <div class="col s12 m3">
            <div class="icon-block summurybox">
                <h5><p class="title-top-border"></p><?php global $language; $subspace = (isset($language->language) && $language->language=='en')? ' ':''; print t($title).$subspace.t('Entry Test'); ?></h5>
                <p class="light">
                  <?php                                          
                    global $base_url;
                    $block = module_invoke('block', 'block_view', '2');                            
                    if(module_exists('i18n_string')) {
                        $block['content'] = i18n_string(array('blocks', 'block', 2, 'body'), $block['content']);
                    }
                    print render($block['content']);                                                                                    
                  ?>
                </p>
                <?php                     
                    global $language;                    
                    $translations = translation_path_get_translations("node/83");
                    $takeTestUrl = drupal_get_path_alias(($translations[$language->language]));                                                                                
                ?>    
                <a href="<?php echo get_baseurl_with_language().'/'.$takeTestUrl; ?>"><button class="btn waves-effect waves-light right"><?php echo t('TAKE TEST');?></button></a>
            </div>
            <div class="icon-block summurybox">
                <h5><p class="title-top-border"></p><?php print t($title).$subspace.t('Simlar Schools'); ?></h5>
                <span class="available-chart">
                        <?php                                
                            if(module_exists('views')) {
                                $block = module_invoke('views', 'block_view', 'similar_schools-block_1');
                                print render($block['content']);                                                                 
                            }                        
                        ?>                                           
                </span>
            </div>
        </div>
        <div class="col s12 m9">                                  
            <div class="standard-box">
                <h5 class="center"><p class="title-top-border"></p><?php print t($title).$subspace.t('Key Information');?></h5>
                <!--div class="standard-box-inner-box-title mt10">Education</div-->
                <div class="background-grey-box">
                    <div class="background-grey-box-inner">
                        <div class="background-grey-box-inner-left">
                            <div class="background-grey-box-inner-left-inner">
	                           <?php if(!empty($field_boarders[0]['value']) && $field_boarders[0]['value']!='NA') { ?>
                                <div class="uni-name"><?php print t('School Type'); ?> - <span><?php print t($field_boarders[0]['value']); ?></span></div>
                                <?php } ?>
                                <?php if(!empty($field_statutory_low_age[0]['value'])) { ?>
                                <div class="uni-sub"><?php print t('Age Range'); ?> - <span><?php print $field_statutory_low_age[0]['value'].'-'.$field_statutory_high_age[0]['value']; ?></span></div>
                                <?php } ?>
                                <?php if(!empty($field_religiouscharacter[0]['taxonomy_term'])) { ?>
                                <div class="uni-sub"><?php print t('Religious Character'); ?> - <span><?php print (isset($field_religiouscharacter[0]['taxonomy_term']) && $field_religiouscharacter[0]['taxonomy_term']!='' )?$field_religiouscharacter[0]['taxonomy_term']->name:''; ?></span></div>
                                <?php } ?>
                                <?php if(!empty($field_number_of_pupils[0]['value'])) { ?>
                                <div class="uni-sub"><?php print t('Number Of Students'); ?> - <span><?php print $field_number_of_pupils[0]['value']; ?></span></div>
                                <?php } ?>
                                <?php if(!empty($field_international_student_no[0]['value']) && $field_international_student_no[0]['value']!='NA') { ?>
                                <div class="uni-sub"><?php print t('International Student Number'); ?> - <span><?php echo (isset($field_international_student_no[0]['value']) && !empty($field_international_student_no[0]['value']) ? $field_international_student_no[0]['value'] : 'NA'); ?></span></div>
                                <?php } ?>
                                <?php if(isset($field_fees_day[0]['value']) && !empty($field_fees_day[0]['value'])) { ?>
                                <div class="uni-sub"><?php print t('Fees Day'); ?> - <span><?php echo (isset($field_fees_day[0]['value']) && !empty($field_fees_day[0]['value']) ? '£'.number_format($field_fees_day[0]['value'], '2', '.', ',') : 'NA'); ?></span></div>
                                <?php } ?>
                                <?php  if (isset($field_fees_boarding[0]['value']) && !empty($field_fees_boarding[0]['value'])) {                                     
                                    ?>                                                                
                                <div class="uni-sub"><?php print t('Fees Boarding'); ?> - <span><?php echo (isset($field_fees_boarding[0]['value']) && !empty($field_fees_boarding[0]['value']) ? '£'.number_format($field_fees_boarding[0]['value'], '2', '.', ',') : 'NA'); ?></span></div>
                                <?php } ?>
                                <?php $fieldschoolwebsite =(isset($field_school_website[0]['value']) && !empty($field_school_website[0]['value']) ? $field_school_website[0]['value'] : ''); ?>
                                <?php if(!empty($fieldschoolwebsite)) { ?>
                                    <div class="uni-sub"><?php print t('Website'); ?> - <span><a href="<?php echo $fieldschoolwebsite;?>"><?php print $fieldschoolwebsite; ?></a></span></div>	
                                <?php } ?>    
                                <?php  if (isset($field_oxbirdge_[0]['value']) && !empty($field_oxbirdge_[0]['value'])) {                                     
                                    ?>                                                                
                                <div class="uni-sub"><?php print t('Oxbirdge %'); ?> - <span><?php echo (isset($field_oxbirdge_[0]['value']) && !empty($field_oxbirdge_[0]['value']) ? $field_oxbirdge_[0]['value'] : 'NA'); ?></span></div>
                                <?php } ?>
                                <?php  if (isset($field_registration[0]['value']) && !empty($field_registration[0]['value'])) {                                     
                                    ?>                                                                
                                <div class="uni-sub"><?php print t('Registration'); ?> - <span><?php echo (isset($field_registration[0]['value']) && !empty($field_registration[0]['value']) ? $field_registration[0]['value'] : 'NA'); ?></span></div>
                                <?php } ?>
                                <?php  if (isset($field_admission[0]['value']) && !empty($field_admission[0]['value'])) {                                     
                                    ?>                                                                
                                <div class="uni-sub"><?php print t('Admission'); ?> - <span><?php echo (isset($field_admission[0]['value']) && !empty($field_admission[0]['value']) ? $field_admission[0]['value'] : 'NA'); ?></span></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>                                
           </div>
            <?php
                /* Get School Ranking View Block  */
                if(module_exists('views')){
                  $block = module_invoke('views', 'block_view', 'individual_school_ranking-block');
                  print render($block['content']);                                                                 
                }
            ?>                     
        </div>    
    <?php if ($links): ?>
        <?php print $links; ?>
    <?php endif; ?>
    <?php
//    hide($content['comments']);
//    print render($content['comments']);
    ?>
</div>
</div>

