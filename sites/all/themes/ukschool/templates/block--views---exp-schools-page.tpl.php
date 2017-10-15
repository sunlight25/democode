<?php
    global $base_url;
    $theme_path = drupal_get_path('theme', 'ukschool'); 
?>
<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <div class="block-content">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <h2<?php print $title_attributes; ?>><?php print $title; ?></h2>
  <?php endif;?>
  <?php print render($title_suffix); ?>
     <div class="cd-filter">
        <div class="mainleftbox">
            <div class="whiteinnboxbg">
                <?php
                   print $content; 
                ?>
            </div>
        </div>
        <a href="#0" class="cd-close"><img src="<?php echo $base_url . '/' . $theme_path; ?>/img/close-icon.png"></a>
    </div> <!-- cd-filter -->
    <a href="#0" class="cd-filter-trigger"><?php print t('Filters'); ?></a>         
  </div>
</div> <!-- /.block -->
