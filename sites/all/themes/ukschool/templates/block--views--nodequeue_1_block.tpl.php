<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <div class="container">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <div class="section-header text-center">          
          <h1 class="section-title wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="100ms"><?php print $title; ?></h1>
    </div>    
  <?php endif;?>
  <?php print render($title_suffix); ?>
  <div class="block-content row feature-card">
  <?php print $content ?>
  </div>
        </div>
</div> <!-- /.block -->