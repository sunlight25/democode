<?php
/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
?>
<div class="<?php print $classes; ?>">
    <?php print render($title_prefix); ?>
    <?php if ($title): ?>
        <?php print $title; ?>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
    <?php if ($header): ?>
        <div class="view-header">
            <?php print $header; ?>
        </div>
    <?php endif; ?>

    <?php if ($exposed): ?>
        <div class="view-filters">
            <?php print $exposed; ?>
        </div>
    <?php endif; ?>

    <?php if ($attachment_before): ?>
        <div class="attachment attachment-before">
            <?php print $attachment_before; ?>
        </div>
    <?php endif; ?>
    <?php if ($rows): ?>
        <div class="view-content py-5">
            <?php $rows = $view->style_plugin->rendered_fields; ?>                                      
            <?php //echo "<pre>";  print_r($rows); exit; ?>
            <div id="hidden-content-1">                
                <ul class="collapsible mb-0" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header active"><i>1</i><?php print t('Account'); ?></div>
                        <div class="collapsible-body">                                                        
                            <div class="p-2">
                                <dl class="row">
                                    <dt class="col s12 m3 bold"><?php print t('Profile Image'); ?></dt>
                                    <dd class="col s12 m9 v-gold-text"><?php print $rows[0]['picture']; ?></dd>
                                    <dt class="col s12 m3 bold"><?php print t('Last Access'); ?></dt>
                                    <dd class="col s12 m9 v-gold-text"><?php print $rows[0]['access']; ?></dd>
                                    <dt class="col s12 m3 bold"><?php print t('User Name'); ?></dt>
                                    <dd class="col s12 m9 v-gold-text"><?php print $rows[0]['name']; ?></dd>                                    
                                </dl>                                
                                <div class="dropdown-button btn text"><?php print $rows[0]['edit_node']; ?></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i>2</i><?php print t('Basic'); ?></div>
                        <div class="collapsible-body">
                            <div class="p-2">
                                <dl class="row">
                                    <dt class="col s12 m3 bold"><?php print t('First Name'); ?></dt>
                                    <dd class="col s12 m9 v-gold-text"><?php print $rows[0]['field_first_name']; ?></dd>
                                    <dt class="col s12 m3 bold"><?php print t('Last Name'); ?></dt>
                                    <dd class="col s12 m9 v-gold-text"><?php print $rows[0]['field_lastname']; ?></dd>
                                    <dt class="col s12 m3 bold"><?php print t('Email Address'); ?></dt>
                                    <dd class="col s12 m9 v-gold-text"><?php print $rows[0]['mail']; ?></dd>
                                </dl>
                                <!--a class="dropdown-button btn text" href="#" data-activates="dropdown1">Tick this off</a-->
                            </div>
                        </div>
                    </li>
                    <!--li>
                        <div class="collapsible-header"><i>3</i>Personal gifts &amp; favours</div>
                        <div class="collapsible-body">
                            <p>Lorem ipsum dolor sit amet.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i>4</i>Our gift list</div>
                        <div class="collapsible-body">
                            <p>Lorem ipsum dolor sit amet.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i>5</i>The day - Countdown</div>
                        <div class="collapsible-body">
                            <p>Lorem ipsum dolor sit amet.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i>6</i>Honeymoon</div>
                        <div class="collapsible-body">
                            <p>Lorem ipsum dolor sit amet.</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i>7</i>Future Planning</div>
                        <div class="collapsible-body">
                            <p>Lorem ipsum dolor sit amet.</p>
                        </div>
                    </li-->
                </ul>
            </div>
        </div>
    <?php elseif ($empty): ?>
        <div class="view-empty">
            <?php print $empty; ?>
        </div>
    <?php endif; ?>

    <?php if ($pager): ?>
        <?php print $pager; ?>
    <?php endif; ?>

    <?php if ($attachment_after): ?>
        <div class="attachment attachment-after">
            <?php print $attachment_after; ?>
        </div>
    <?php endif; ?>

    <?php if ($more): ?>
        <?php print $more; ?>
    <?php endif; ?>

    <?php if ($footer): ?>
        <div class="view-footer">
            <?php print $footer; ?>
        </div>
    <?php endif; ?>

    <?php if ($feed_icon): ?>
        <div class="feed-icon">
            <?php print $feed_icon; ?>
        </div>
    <?php endif; ?>
</div><?php /* class view */ ?>


