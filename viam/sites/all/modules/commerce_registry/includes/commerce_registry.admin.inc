<?php
/**
 * @file
 * Administrative functions for Commerce Registry.
 */

function commerce_registry_type_form($form, $form_state, $registry_type, $op = 'edit') {
  if ($op == 'clone') {
    $registry_type->label .= ' (cloned)';
    $registry_type->name = '';
  }
  $form_state['registry_type'] = $registry_type;
  $form['label'] = array(
    '#title' => t('Label'),
    '#type' => 'textfield',
    '#default_value' => $registry_type->label,
    '#description' => t('The human-readable name of this registry type.'),
    '#required' => TRUE,
    '#size' => 30,
  );
  // Machine-readable type name.
  $form['type'] = array(
    '#type' => 'machine_name',
    '#default_value' => isset($registry_type->type) ? $registry_type->type : '',
    '#maxlength' => 32,
    '#disabled' => $registry_type->locked && $op != 'clone',
    '#machine_name' => array(
      'exists' => 'commerce_registry_type_exists',
      'source' => array('label'),
    ),
    '#description' => t('A unique machine-readable name for this registry type. It must only contain lowercase letters, numbers, and underscores.'),
  );
  $form['description'] = array(
    '#type' => 'textarea',
    '#default_value' => isset($registry_type->description) ? $registry_type->description : '',
    '#title' => t('Description'),
  );
  $form['actions'] = array('#type' => 'actions');
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save registry type'),
    '#weight' => 40,
  );

  if (!$registry_type->locked && $op != 'add') {
    $form['actions']['delete'] = array(
      '#type' => 'submit',
      '#value' => t('Delete registry type'),
      '#weight' => 45,
      '#limit_validation_errors' => array(),
      '#submit' => array('commerce_registry_type_form_submit_delete')
    );
  }

  return $form;
}

/**
 * Form API submit callback for the type form.
 */
function commerce_registry_type_form_submit($form, $form_state) {
  $registry_type = $form_state['registry_type'];
  $registry_type->type = check_plain($form_state['values']['type']);
  $registry_type->label = check_plain($form_state['values']['label']);
  $registry_type->description = check_plain($form_state['values']['description']);
  $registry_type->save();
  $form_state['redirect'] = 'admin/commerce/config/registry_types';
}

/**
 * Form API submit callback for the delete button.
 */
function commerce_registry_type_form_submit_delete($form, $form_state) {
  $form_state['redirect'] = 'admin/commerce/config/registry_types/manage/' . $form_state['registry_type']->type . '/delete';
}
