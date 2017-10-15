<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <?php print render($title_prefix); ?>
    <?php if ($title): ?>
        <!--h2<?php print $title_attributes; ?>><?php //print $title; ?></h2-->
    <?php endif; ?>
    <?php print render($title_suffix); ?>
    <div<?php //print $content_attributes; ?>>
      <!--a class="element-invisible">Block content</a-->
      <div class="hide-on-med-and-down">
                  <ul class="menu">
                    <li class="first last expanded dropdown" id="user-menu">
                        <a class="collection-item menu-act"><?php //print $title; ?><img src="/sites/all/themes/ukschool/img/globe.png"></a> 
                       <?php       
                            print $content; 
                        ?>
                    </li>
            </ul></div>                       
      <?php       
      //print $content; ?>
    </div>
</div> <!-- /.block -->
