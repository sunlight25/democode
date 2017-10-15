<?php

/**
 * @file
 * Page callbacks for Commerce Simple Address book.
 */

function commerce_simple_addressbook_view($account) {
  $output = array();

  foreach (commerce_customer_profile_types() as $type => $profile_type) {
    $output['content']['address_' . $type] = array(
      '#prefix' => '<div class="commerce-simple-addressbook-view-' . check_plain($type) . '">',
      '#suffix' => '</div>',
      'title' => array(
        '#markup' => '<h2>' . t('Saved @type Addresses', array('@type' => ucwords($type))) . '</h2>',
      ),
      'list' => array(
        '#markup' => views_embed_view('commerce_simple_addressbook_list', 'default', $account->uid, $type),
      ),
      'create' => array(
        '#markup' => l(t('Create a new @type profile', array('@type' => $type)), '/user/' . $account->uid .'/addressbook/create/' . $type),
      ),
    );
  }

  return $output;
}

/*
 * Form callback for editing saved addresses.
 */
function commerce_simple_addressbook_edit($form, &$form_state, $profile, $account, $bundle = 'billing') {
  // Create a new profile if one is not provided.
  if (empty($profile->profile_id)) {
    $profile = commerce_customer_profile_new($bundle);
    $form_state['new_profile'] = TRUE;
  }

  // Use the current logged in user if one is not provided.
  if (empty($account)) {
    global $user;
    $account = $user;
  }

  $form_state['profile'] = $profile;
  $form_state['account'] = $account;

  drupal_set_title(t('@action @type address profile', array('@action' => ucwords(arg(3)), '@type' => $profile->type)));

  field_attach_form('commerce_customer_profile', $form_state['profile'], $form, $form_state);

  // Hide the save option since this address is already saved.
  $form['commerce_simple_addressbook_save']['#access'] = FALSE;

  // If this is a new profile, allow user to clone to other bundles.
  if (empty($profile->profile_id)) {
    $entity_info = entity_get_info('commerce_customer_profile');
    if (!empty($entity_info['bundles'])) {
      foreach ($entity_info['bundles'] as $bundle_name => $bundle_info) {
        if ($bundle_name != $bundle) {
          $options[$bundle_name] = $bundle_info['label'];
        }
      }
    }

    if (!empty($options)) {
      $form['profile_copy'] = array(
        '#type' => 'checkboxes',
        '#title' => t('Also use this address for the following'),
        '#options' => $options,
        '#weight' => 99,
      );
    }
  }

  $form['actions'] = array(
    '#type' => 'container',
    '#weight' => 100,
    'submit' => array(
      '#type' => 'submit',
      '#value' => t('Save address'),
    ),
    'cancel' => array(
      '#markup' => l(t('Cancel'), 'user/' . $account->uid . '/addressbook'),
    ),
  );

  return $form;
}

/**
 * Form validate callback for editing a saved address.
 */
function commerce_simple_addressbook_edit_validate($form, &$form_state) {
  field_attach_validate('commerce_customer_profile', $form_state['profile'], $form, $form_state);
}

/**
 * Form submit callback for editing a saved address.
 */
function commerce_simple_addressbook_edit_submit($form, &$form_state) {
  // Use field api to set the profile values and save the profile.
  field_attach_submit('commerce_customer_profile', $form_state['profile'], $form, $form_state);
  $form_state['profile']->uid = $form_state['account']->uid;
  $profile_wrapper = entity_metadata_wrapper('commerce_customer_profile', $form_state['profile']);
  $profile_wrapper->commerce_simple_addressbook_save->set(TRUE);
  commerce_customer_profile_save($form_state['profile']);

  // Create a profile for each of the other selected bundles.
  if (!empty($form_state['values']['profile_copy'])) {
    foreach ($form_state['values']['profile_copy'] as $bundle) {
      if (!empty($bundle)) {
        $profile = commerce_customer_profile_new($bundle);
        field_attach_submit('commerce_customer_profile', $profile, $form, $form_state);
        $profile->uid = $form_state['account']->uid;
        $profile_wrapper = entity_metadata_wrapper('commerce_customer_profile', $profile);
        $profile_wrapper->commerce_simple_addressbook_save->set(TRUE);
        commerce_customer_profile_save($profile);
      }
    }
  }

  drupal_set_message(t('The @type address profile has been saved.', array('@type' => $form_state['profile']->type)));
  $form_state['redirect'] = 'user/' . $form_state['account']->uid . '/addressbook';
}

/**
 * Profile delete form callback.
 */
function commerce_simple_addressbook_delete($form, &$form_state, $profile) {
  $form_state['profile'] = $profile;

  $output = array(
    'content' => array(
      'address' => array(
        entity_view('commerce_customer_profile', array($profile)),
      ),
    ),
  );

  return confirm_form(
    $form,
    t('Are you sure you want to delete this address?'),
    'user/' . $profile->uid . '/addressbook',
    render($output),
    t('Delete'),
    t('Cancel')
  );
}

/**
 * Profile delete callback.
 */
function commerce_simple_addressbook_delete_submit($form, &$form_state) {
  $profile = $form_state['profile'];
  commerce_customer_profile_delete($profile->profile_id);
  drupal_set_message(t('Address deleted successfully.'));
  $form_state['redirect'] = 'user/' . $profile->uid . '/addressbook';
}
