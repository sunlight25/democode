<?php

/**
 * Returns HTML for primary and secondary local tasks.
 */
function ukschool_menu_local_tasks(&$variables) {
    $output = '';

    if (!empty($variables['primary'])) {
        $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
        $variables['primary']['#prefix'] = '<ul class="nav nav-tabs">';
        $variables['primary']['#suffix'] = '</ul>';
        $output .= drupal_render($variables['primary']);
    }

    if (!empty($variables['secondary'])) {
        $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
        $variables['secondary']['#prefix'] = '<ul class="nav nav-pills">';
        $variables['secondary']['#suffix'] = '</ul>';
        $output .= drupal_render($variables['secondary']);
    }

    return $output;
}

/**
 * Returns HTML for primary and secondary local tasks.
 *
 * @ingroup themeable
 */
function ukschool_menu_local_task($variables) {
    $link = $variables['element']['#link'];
    $link_text = $link['title'];
    $classes = array();

    if (!empty($variables['element']['#active'])) {
        // Add text to indicate active tab for non-visual users.
        $active = '<span class="element-invisible">' . t('(active tab)') . '</span>';

        // If the link does not contain HTML already, check_plain() it now.
        // After we set 'html'=TRUE the link will not be sanitized by l().
        if (empty($link['localized_options']['html'])) {
            $link['title'] = check_plain($link['title']);
        }
        $link['localized_options']['html'] = TRUE;
        $link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));

        $classes[] = 'active';
    }

    return '<li class="' . implode(' ', $classes) . '">' . l($link_text, $link['href'], $link['localized_options']) . "</li>\n";
}

function ukschool_menu_tree(&$variables) {
    return '<ul class="menu">' . $variables['tree'] . '</ul>';
}

function ukschool_menu_link(array $variables) {

//add class for li
 //$variables['element']['#attributes']['class'][] = 'expanded dropdown';
//add class for a
 $variables['element']['#localized_options']['attributes']['class'][] = 'collection-item'; 
  //start to add <span> to menu item	
 $variables['element']['#title']='<span>'.$variables['element']['#title'].'</span>';
 $variables['element']['#localized_options']['html']=TRUE;
 //end of add <span> to menu item
    $element = $variables['element'];
    $remove_dropdown = 0;
    if (isset($element['#original_link']['menu_name']) && $element['#original_link']['menu_name'] == 'management')
        $remove_dropdown = 1;

    $sub_menu = '';

    if ($element['#below']) {
        // Ad our own wrapper
        unset($element['#below']['#theme_wrappers']);
        if ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] > 1)) {
            $sub_menu = '<ul class="dropdown-content-submenu">' . drupal_render($element['#below']) . '</ul>';
        }else{
            $sub_menu = '<ul class="dropdown-content">' . drupal_render($element['#below']) . '</ul>';
        }        
        if ($remove_dropdown == 0) {
            $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
            $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
        }
        // Check if this element is nested within another
        if ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] > 1)) {
            // Generate as dropdown submenu
            if ($remove_dropdown == 0) {
                $element['#attributes']['class'][] = 'dropdown-submenu';
            }
            $element['#title'] .= '<span class="caret"></span>';
        } else {
            // Generate as standard dropdown
            if ($remove_dropdown == 0) {
                $element['#attributes']['class'][] = 'dropdown';
            }
            $element['#localized_options']['html'] = TRUE;
            $element['#title'] .= '<span class="caret"></span>';
        }

        // Set dropdown trigger element to # to prevent inadvertant page loading with submenu click
        if ($remove_dropdown == 0) {
            $element['#localized_options']['attributes']['data-target'] = '#';
        }
    }

    $output = l(t($element['#title']), $element['#href'], $element['#localized_options']);
    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
