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
    <div class="view-content">
        <?php
            $rows=$view->style_plugin->rendered_fields;                       			                      
            //echo "<pre>";                                
            //print_r($rows); exit;            
        ?>
        <div id="dash_welcome" class="card white mb-5">
            <div class="card-content">
                <span class="card-title v-gold-text"><?php print t('Manage your Wedding Day'); ?></span></span>
                <p class="mb-3"><?php print t('Viamo create luxurious wedding stationary and stock an extensive range of on the day products. View our wedding shop here wedding stationary and stock an extensive range of on the day products. View our wedding shop here.'); ?></p>
                <dl class="row">
                    <dt class="col s12 m3 bold"><?php print t('Bride &amp; Groom'); ?></dt>
                    <dd class="col s12 m9 v-gold-text"><?php echo isset($rows[0]['field_suffix_host'])?$rows[0]['field_suffix_host']:'--' ?>  <?php echo isset($rows[0]['field_host_first_name'])?$rows[0]['field_host_first_name']:'--' ?> <?php echo isset($rows[0]['field_host_last_name'])?$rows[0]['field_host_last_name']:'--' ?> 
                    &amp; <?php echo isset($rows[0]['field_partners_suffix'])?$rows[0]['field_partners_suffix']:'--' ?>  <?php echo isset($rows[0]['field_partners_first_name'])?$rows[0]['field_partners_first_name']:'--' ?> <?php echo isset($rows[0]['field_partners_last_name'])?$rows[0]['field_partners_last_name']:'--' ?></dd>
                    <dt class="col s12 m3 bold"><?php print t('Event Date'); ?></dt>
                    <dd class="col s12 m9 v-gold-text">                        
                    <p><a class="v-gold-text bold" href="node/add/event-calendar"><?php print t('Add Event'); ?></a></p>    
                    <?php echo isset($rows[0]['event_calendar_date'])?$rows[0]['event_calendar_date']:'--' ?>                    
                    </dd>
                    <dt class="col s12 m3 bold"><?php print t('Ceremony'); ?></dt>
                    <dd class="col s12 m9 v-gold-text">St. Chads Poulton at 1pm</dd>
                    <dt class="col s12 m3 bold"><?php print t('Reception'); ?></dt>
                    <dd class="col s12 m9 v-gold-text"><?php echo t('The').' '; ?><?php echo isset($rows[0]['title_1'])?$rows[0]['title_1']:'--' ?></dd>
                    <dt class="col s12 m3 bold"><?php print t('Package'); ?></dt>
                    <dd class="col s12 m9 v-gold-text">Fairytail Package</dd>
                </dl>
                <p>View <a class="v-gold-text bold" href="confirmation.php"><?php print t('Full Confirmation &amp; Package Details'); ?></a>.</p>
            </div>
            <div class="card-action">
                <a href="#" class="grey-text"><b><?php print t('Next steps'); ?>:</b></a>
                <a data-fancybox data-options='{"src": "#hidden-content-1", "touch": false, "smallBtn" : true}' href="javascript:;">Set Up Account</a>
                <a href="confirmation.php"><?php print t('View Package'); ?></a>
                <a href="upgrade.php"><?php print t('Upgrade'); ?></a>
            </div>
        </div>        
      <?php //print $rows; ?>
       <div style="display: none; width: 600px" id="hidden-content-1">
       <h3 class="h4 upper v-gold-text mt-0">Get started with the wizard</h3>
      <ul class="collapsible mb-0" data-collapsible="accordion">
        <li>
            <div class="collapsible-header active"><i>1</i>Guest list &amp; invites</div>
            <div class="collapsible-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi suscipit blandit ex, nec molestie sapien fermentum a. Cras non pretium nulla, eu egestas leo.</p>
                <a class="dropdown-button btn text" href="#" data-activates="dropdown1">Tick this off</a>

                <ul id="dropdown1" class="dropdown-content">
                    <li><a href="#!">Confirm Details</a>
                    </li>
                    <li><a href="#!">Hide</a>
                    </li>
                    <li><a href="#!"><i class="material-icons">edit</i>Edit</a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i>2</i>Add wedding stationary</div>
            <div class="collapsible-body">
                <p>Click the button below to create your list and start adding products!</p>
                <a class="btn text wave" href="#">Create Gift List</a>

            </div>
        </li>
        <li>
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
        </li>


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


