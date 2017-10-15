<?php
/**
 * @file views-view.tpl.php
 * Main view template
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
            $rows = $view->style_plugin->rendered_fields;
            ?>
            <div class="standard-box">
                <h5 class="center"><p class="title-top-border"></p><?php global $language;$subspace = (isset($language->language) && $language->language=='en')? ' ':''; print t(ucwords($rows[0]['field_school_ranking'])).$subspace.t('Ranking Information'); ?></h5>
                <!--div class="standard-box-inner-box-title mt10">Education</div-->
                <div class="background-grey-box">
                    <div class="background-grey-box-inner">
                        <div class="background-grey-box-inner-left">
                            <div class="background-grey-box-inner-left-inner">
                                <div class="background-grey-box-inner-left-inner">
                                    <div class="uni-sub"><?php print t('Times Overall Ranking'); ?> - <span><?php echo (isset($rows[0]['field_times_overall_ranking']) && !empty($rows[0]['field_times_overall_ranking']) ? $rows[0]['field_times_overall_ranking'] : 'NA'); ?></span></div>
                                <div class="uni-sub"><?php print t('GCSE Ranking'); ?> - <span><?php echo (isset($rows[0]['field_times_gcse_rank']) && !empty($rows[0]['field_times_gcse_rank']) ? $rows[0]['field_times_gcse_rank'] : 'NA'); ?></span></div>                                    
				<div class="uni-sub"><?php print t('A-Level Ranking'); ?> - <span><?php echo (isset($rows[0]['field_times_a_level_rank']) && !empty($rows[0]['field_times_a_level_rank']) ? $rows[0]['field_times_a_level_rank'] : 'NA'); ?></span></div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php
            if (arg(0) == 'node' && is_numeric(arg(1))) {
                $nid = arg(1);
                if ($nid) {
                    $node = node_load($nid);

                    ini_set('display_errors', TRUE);
                    ini_set('display_startup_errors', TRUE);
                    ini_set("display_errors", "1");
                    error_reporting(E_ALL);

                    global $language;

                    $query = db_select('comment', 'c')
                            //->innerjoin('users', 'u', 'u.uid = c.uid')
                            ->fields('c', array('nid', 'cid', 'uid', 'name', 'subject', 'created', 'language', 'created'))
                            ->condition('c.nid', $node->nid, '=')
                            ->condition('c.language', $language->language, '=')
                            ->condition('fdcb.entity_type', 'comment')
                            ->fields('fdcb', array("entity_type", "bundle", "deleted", "entity_id", "revision_id", "language", "delta", "comment_body_value", "comment_body_format"))
                            ->orderBy('c.cid', 'DESC');
                    $query->innerjoin('field_data_comment_body', 'fdcb', 'fdcb.entity_id = c.cid');
                    $result = $query->execute();
                    
                    $num_comments = db_query("SELECT COUNT(cid) AS count FROM {comment} WHERE nid =:nid",array(":nid"=>$node->nid))->fetchField();                  
                    if((isset($num_comments) && $num_comments >0) || (isset($user->roles[5]) && $user->roles[5] === 'Expert')){ 
                    
                    ?>

                    <div class="standard-box">
                        <h5 class="center"><p class="title-top-border"></p><?php $subspace = (isset($language->language) && $language->language=='en')? ' ':''; print t(ucwords($rows[0]['field_school_ranking'])).$subspace.t('Expert Advice'); ?></h5>
                        <?php
                        global $user;
                        if (isset($user->roles[5]) && $user->roles[5] === 'Expert') {
                            ?>
                            <a href="#comment_form_add" class="edit_comment btn btn-lg btn-primary"> Add </a>
                            <!--comment add form start -->
                            <div id="comment_form_add" class="modal">

                                <div class="modal-content">
                                    <?php
                                    $comment->nid = $nid;
                                    $form = drupal_get_form('comment_node_schools_form', $comment);
                                    $form['actions']['submit']['#attributes']['class'][] = 'checkcomment';
                                    unset($form['actions']['preview']);
                                    hide($form['subject']);
                                    $form['custom-form'] = array(
                                        '#prefix' => '<a class="btn btn-lg btn-primary mr15 modal-action modal-close">',
                                        '#suffix' => '</a>',
                                        '#markup' => t('Close'),
                                        '#weight' => 15,
                                    );
                                    print render($form);
                                    ?>
                                </div>


                            </div>
                            <!-- comment add form end -->
                        <?php } ?>
                        <div class="background-grey-box">
                            <div class="background-grey-box-inner">
                                <div class="background-grey-box-inner-left">
                                    <div class="background-grey-box-inner-left-inner">


                                        <?php
                                        $i = 0;
                                        while ($comment_detail = $result->fetchAssoc()) {
                                            if ($comment_detail['uid'] !== NULL) {

                                                $user_id = $comment_detail['uid'];
                                                $comment_user = user_load($user_id);
                                                $default_thumbnail = image_style_url('thumbnail', $comment_user->picture->uri);
                                                $comment_name = $comment_user->name;
                                                $comment_subject = $comment_detail['subject'];

                                                $comment_body = $comment_detail['comment_body_value'];
                                                $comment_body_trim = (strlen($comment_body) < 250) ? $comment_body : (substr($comment_body, 0, 250)) . '<a data-toggle="collapse" class="showmore" alt="' . $comment_detail['cid'] . '">... Read more</a>';
                                                $comment_body_full = $comment_body . '<a data-toggle="collapse" class="showless" alt="' . $comment_detail['cid'] . '"> Show less</a>';

                                                echo '<div class="uni-detail-mid-arti-innbg-row-midbg">
                                <div class="uni-detail-mid-arti-innbg-row-mid-left-inn-thumb1"><img src="' . $default_thumbnail . '"></div>
                                <div class="uni-detail-mid-arti-innbg-row-mid-left-inn-thumb-right1">
                                    <div class="uni-detail-mid-arti-innbg-row-mid-left-inn-thumb-right-title1">' . $comment_name . '</div>
                                        <div class="uni-detail-mid-arti-innbg-row-mid-left-inn-thumb-right-con uni-detail-alumni-deskview hidden-comment">
                                            <span id="showless' . $comment_detail['cid'] . '" class="body_trim">
                                            ' . $comment_body_trim . '
                                            </span>
                                            <span id="showmore' . $comment_detail['cid'] . '" class="body_full">
                                            ' . $comment_body_full . '
                                            </span>
                                        </div>
                                        <div class="uni-detail-mid-arti-innbg-row-mid-left-inn-thumb-right-con-mobile">

                                        </div>';
                                                if (isset($user->roles[5]) && $user->roles[5] === 'Expert' && $user_id == $user->uid) {
                                                    echo '<a href="#comment_form_update' . $comment_detail['cid'] . '" class="edit_comment btn btn-lg btn-primary"> Edit </a>
                           <input type="hidden" name="edit_commentV" id="edit_commentV" value="">
                            </div>
                            </div>';

                                                    echo '<div id="comment_form_update' . $comment_detail['cid'] . '" class="modal update-comment">
                        <div class="modal-content">' .
                                                    $comment->pid = '';
                                                    $comment->cid = $comment_detail['cid'];
                                                    $comment->name = $comment_detail['name'];


                                                    $comment->uid = $user->uid;
                                                    $comment->mail = $user->mail;

                                                    $comment->date = $comment_detail['created'];
                                                    $comment->subject = $comment_body;
                                                    $comment->comment_body['und'][0]['value'] = $comment_body;
                                                    $comment->comment = $comment_body;

                                                    $form = drupal_get_form("comment_node_schools_form", $comment);

                                                    $form['#action'] = url('comment/' . $comment_detail['cid'] . '/edit');
                                                    $form['actions']['submit']['#attributes']['class'][] = 'checkcomment';

                                                    unset($form['actions']['preview']);
                                                    hide($form['subject']);

                                                    $form['custom-form'] = array(
                                                        '#prefix' => '<a class="btn btn-lg btn-primary mr15 modal-action modal-close">',
                                                        '#suffix' => '</a>',
                                                        '#markup' => t('Close'),
                                                        '#weight' => 15,
                                                    );
                                                    print render($form);
                                                }
                                                echo '</div></div>';
                                            }
                                            $i++;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                }
            }
            ?>

            <div class="standard-box">
                <h5 class="center"><p class="title-top-border"></p><?php $subspace = (isset($language->language) && $language->language=='en')? ' ':''; print t(ucwords($rows[0]['field_school_ranking'])).$subspace.t('Exam Results'); ?></h5>
                <!--div class="standard-box-inner-box-title mt10">Education</div-->
                <div class="background-grey-box">
                    <div class="background-grey-box-inner">
                        <div class="background-grey-box-inner-left">
                            <div class="background-grey-box-inner-left-inner">
                                <div class="background-grey-box-inner-left-inner">
                                    <div class="uni-sub"><?php print t('A Level (% A*)'); ?> - <span><?php echo (isset($rows[0]['field_a_level_a']) && !empty($rows[0]['field_a_level_a']) ? $rows[0]['field_a_level_a'] : 'NA'); ?></span></div>
                                    <div class="uni-sub"><?php print t('A Level (% A*/A)'); ?> - <span><?php echo (isset($rows[0]['field_a_level_aa']) && !empty($rows[0]['field_a_level_aa']) ? $rows[0]['field_a_level_aa'] : 'NA'); ?></span></div>
                                    <div class="uni-sub"><?php print t('A Level (% A*/B)'); ?> - <span><?php echo (isset($rows[0]['field_a_level_ab']) && !empty($rows[0]['field_a_level_ab']) ? $rows[0]['field_a_level_ab'] : 'NA'); ?></span></div>
                                    <div class="uni-sub"><?php print t('GCSE (% A*/A)'); ?> - <span><?php echo (isset($rows[0]['field_gcse_aa']) && !empty($rows[0]['field_gcse_aa']) ? $rows[0]['field_gcse_aa'] : 'NA'); ?></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
