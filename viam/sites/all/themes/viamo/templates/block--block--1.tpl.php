<?php
/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user
 *     module is responsible for handling the default user navigation block. In
 *     that case the class would be 'block-user'.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>
<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>    
    <?php print render($title_prefix); ?>
    <?php if ($block->subject): ?>
        <h2<?php print $title_attributes; ?>><?php print $block->subject ?></h2>
    <?php endif; ?>
    <?php print render($title_suffix); ?>

    <div class="content"<?php print $content_attributes; ?>>
        <?php //print $content  ?>
        <div class="carousel carousel-slider bh w-100" data-indicators="true">
            <div class="carousel-fixed-item center">
                <a class="btn-floating btn-large waves-effect waves-light white center-align tooltipped" data-position="bottom" data-delay="50" data-tooltip="Scroll Down"><i class="grey-text fa fa-chevron-down" aria-hidden="true"></i></a>
            </div>
            <div class="carousel-item white-text center slide-2" href="#one!">
                <div class="content-bottom">
                    <h1 class="light"><?php print t('Expert wedding planning...'); ?></h1>
                    <p class="mb-4"><?php print t('We provide a full end to end wedding planning and gift list service!<br/>We make sure you cover all bases!'); ?></p>
                    <a class="waves-effect waves-light btn btn-large btn-viamo"><i class="material-icons left"><?php print t('shopping_basket'); ?></i><?php print t('Shop Gifts Now'); ?></a>
                    <?php global $base_url,$user; ?>                 
                    <?php if($user->uid>0){ ?>
                    <a class="waves-effect waves-light btn btn-large btn-viamo ml-2"><i class="material-icons left"><?php print t('playlist_add'); ?></i><?php print t('Create a List'); ?></a>
                    <?php } else { ?>
                    <a class="waves-effect waves-light btn btn-large btn-viamo ml-2" href="<?php print $base_url; ?>/host/register"><i class="material-icons left"><?php print t('playlist_add'); ?></i><?php print t('Create a List'); ?></a>
                    <?php } ?>
                </div>
            </div>
            <div class="carousel-item white-text center slide-1" href="#two!">
                <div class="content-bottom center-align">
                    <h1 class="light"><?php print t('Thousands of Gifts...'); ?></h1>
                    <p class="mb-4"><?php print t('We provide a full end to end wedding planning and gift list service!<br/>We make sure you cover all bases!'); ?></p>
                    <a class="waves-effect waves-light btn btn-large btn-viamo"><i class="material-icons left"><?php print t('cloud'); ?></i><?php print t('Shop Gifts Now'); ?></a>                    
                    <?php if($user->uid>0){ ?>
                        <a class="waves-effect waves-light btn btn-large btn-viamo ml-2"><i class="material-icons left"><?php print t('cloud'); ?></i><?php print t('Create a List'); ?></a>
                    <?php } else {?>
                        <a class="waves-effect waves-light btn btn-large btn-viamo ml-2" href="<?php print $base_url; ?>/host/register"><i class="material-icons left"><?php print t('cloud'); ?></i><?php print t('Create a List'); ?></a>
                    <?php } ?>
                </div>
            </div>
            <div class="carousel-item white-text center slide-3" href="#three!">
                <div class="content-bottom center-align">
                    <h1 class="light"><?php print t('Cherish the moments...'); ?></h1>
                    <p class="mb-4"><?php print t('We provide a full end to end wedding planning and gift list service!<br/>We make sure you cover all bases!'); ?></p>
                    <a class="waves-effect waves-light btn btn-large btn-viamo"><i class="material-icons left"><?php print t('cloud'); ?></i><?php print t('Shop Gifts Now'); ?></a>
                    <?php if($user->uid>0) { ?>
                    <a class="waves-effect waves-light btn btn-large btn-viamo ml-2"><i class="material-icons left"><?php print t('cloud'); ?></i><?php print t('Create a List'); ?></a>
                    <?php } else{ ?>
                    <a class="waves-effect waves-light btn btn-large btn-viamo ml-2" href="<?php print $base_url; ?>/host/register"><i class="material-icons left"><?php print t('cloud'); ?></i><?php print t('Create a List'); ?></a>
                    <?php }  ?>
                </div>
            </div>
        </div> 
    </div>
</div>
