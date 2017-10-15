<?php
/**
 * @file
 * Commerce Registry page callbacks.
 */

/**
 * Shows the user's registries.
 */
function commerce_registry_user_registry_page() {
  global $user;
  $registries = array(
    'registries' => commerce_registry_load_user_registries(),
    'account' => $user,
  );
  return theme('commerce_registry_user_registry_list', $registries);
}

/**
 * Callback to list the available registry types the user can create.
 */
function commerce_registry_new_registry_page() {
  $page = '';
  $options = array('html' => TRUE);
  foreach (commerce_registry_types() as $type => $info) {
    $page .= "<p>";
    $page .= l(
      t('Create a new <em>!type</em> registry', array('!type' => $info->label)),
      'user/1/registry/new/' . $type,
      $options);
    $page .= "</p>";
  }
  return $page;
}
