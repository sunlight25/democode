<?php
/**
 * @file
 * Commerce Registry forms.
 */

/**
 * Show a login form to view a registry.
 */
function commerce_registry_registry_login_form($form, &$form_state, $registry) {
  $form_state['commerce_registry'] = $registry;
  $form = array();
  $form['registry'] = array(
    '#type' => 'markup',
    //'#markup' => 'Log in to view the <em>' . $registry->name . '</em> registry',
    '#markup' => 'Log in to view the <em>' . $registry->name,
  );
  $form['password'] = array(
    '#type' => 'password',
    '#title' => 'Registry Password',
  );
  $form['login'] = array(
    '#type' => 'submit',
    '#value' => t('Submit'),
  );

  return $form;
}

/**
 * Login form validate handler.
 */
function commerce_registry_registry_login_form_validate($form, &$form_state) {
  global $user;  
  $registry = $form_state['commerce_registry'];
  $password = $form_state['values']['password'];
  if ($registry->loginLimit($user)) {
    form_set_error('password', t('You have reached the login limit for this registry. Try again in 15 minutes. All further login attempts will be logged.'));
    return FALSE;
  }
  elseif (!$registry->login($user, $password)) {
     
    form_set_error('password', t('You either have no permission to view this registry, or entered an invalid password.'));
    return FALSE;
  }
  return TRUE;
}

/**
 * Login form submit handler: Redirect to the registry.
 */
function commerce_registry_registry_login_form_submit($form, &$form_state) {   
  $registry = $form_state['commerce_registry'];
  drupal_set_message(t('Successfully logged in to view the registry !name.', array('!name' => $registry->name))); 
  $uri = $registry->defaultUri();
  drupal_goto($uri['path']);
}

/**
 * Form to create a new registry.
 */
function commerce_registry_registry_new_form($form, &$form_state, $type = 'registry') {    
  global $user;
  $values['type'] = $type;
  $values['owner_uid'] = $user->uid;  
  
  $registry = entity_create('commerce_registry', $values);
  
  $form_state['commerce_registry'] = $registry;  
  $form = array();
  $form['registry'] = array(
    '#type' => 'fieldset',
    '#title' => t('Create a Gift List'),
    '#tree' => TRUE,
  );
  $type_object = commerce_registry_type_load($type);
  $form['registry']['type'] = array(
    '#type' => 'item',
    '#markup' => $type_object->label,
    '#title' => t('Gift List Type'),
    '#attributes' => array('class'=>array('0'=>'gift-list-type-hidden')),  
  );
  $form['registry']['name'] = array(
    '#type' => 'textfield',
    '#title' => t('Gift List Name'),
    '#required' => TRUE,
    '#weight' => 0,
    '#default_value' =>'Gift List',
    '#attributes' => array('readonly' => 'readonly'),  
  );
  $form['registry']['public'] = array(
    '#type' => 'radios',
    '#title' => t('Type'),
    '#options' => array(
      1 => t('Public'),
      0 => t('Private'),
    ),
    '#default_value' => 1,
    '#required' => TRUE,
    '#weight' => 1,
  );
  $form['registry']['password'] = array(
    '#type' => 'password',
    '#title' => t('Password'),
    '#states' => array(
      'visible' => array(
        ':input[name="registry[public]"]' => array('value' => 0),
      ),
    ),
    '#weight' => 2,
  );
  $form['registry']['description'] = array(
    '#type' => 'textarea',
    '#title' => t('Description'),
    '#weight' => 3,
  );
  $form['registry']['status'] = array(
    '#type' => 'radios',
    '#title' => t('Status'),
    '#options' => array(
      0 => t('Disabled'),
      1 => t('Enabled'),
    ),
    '#required' => TRUE,
    '#default_value' => 1,
    '#weight' => 4,
  );
  $form['registry']['fields'] = array(
    '#type' => 'container',
    '#weight' => 5,
    '#parents' => array('registry', 'fields'),
  );
  field_attach_form('commerce_registry', $registry, $form['registry']['fields'], $form_state);
  $path = 'user/' . $user->uid . '/registry/new';
  $form['registry']['actions'] = array(
    '#type' => 'actions',
    'submit' => array(
      '#type' => 'submit',
      '#value' => t('Create Gift List'),
    ),
    'cancel' => array(
      '#type' => 'markup',
      '#markup' => l(t('Cancel'), $path),
    ),
  );           
  return $form;
}

/**
 * New registry form validate handler.
 */
function commerce_registry_registry_new_form_validate($form, &$form_state) {
  field_attach_form_validate('commerce_registry', $form_state['commerce_registry'], $form['registry']['fields'], $form_state);
  if ($form_state['values']['registry']['public'] == 0) {
    $pass = $form_state['values']['registry']['password'];
    if (strlen($pass) == 0) {
      form_set_error('registry][password', t('You must enter a password for a private registry.'));
      return FALSE;
    }
    elseif (strlen($pass) < 6) {
      form_set_error('registry][password', t('The password must be at least 6 characters long.'));
      return FALSE;
    }
  }
  return TRUE;
}

/**
 * New registry form submit handler.
 * 
 */
function commerce_registry_registry_new_form_submit($form, &$form_state) {
  global $user;
  $values = $form_state['values']['registry'];
  $registry = $form_state['commerce_registry'];
  foreach($values as $key => $value) {
    if ($key != 'fields') {
      $registry->{$key} = $value;
    }
  }
  if ($form_state['values']['registry']['public'] == 0) {
    if (function_exists('user_hash_password')) {
      $registry->password = user_hash_password($registry->password);
    }
  }
  entity_save('commerce_registry', $registry);
  field_attach_submit('commerce_registry', $registry, $form['registry']['fields'], $form_state);
  drupal_set_message(t('Registry !registry created successfully.', array('!registry' => '<em>' . $registry->name . '</em>')));
  drupal_goto('registry/' . $registry->url);
}

/**
 * Add to cart form for a registry product.
 * Adds context to the product/line item upon adding so we know it was for a
 * particular registry.
 */
function commerce_registry_product_add_to_cart_form($form, &$form_state, $product, $registry, $context) {
  $form_state['commerce_product'] = $product;
  $form_state['commerce_registry'] = $registry;
  $form_state['page_context'] = $context;
  $form['submit'] = array(
    '#type' => 'submit',
    //'#value' => t('Add !name to Cart', array('!name' => $product->title)),
    '#value' => t('Add to Cart'),
  );
  return $form;
}

/**
 * Remove a product from a registry.
 */
function commerce_registry_remove_product_form($form, &$form_state, $product, $registry) {
  $form_state['commerce_product'] = $product;
  $form_state['commerce_registry'] = $registry;
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Remove'),
  );
  return $form;
}

/**
 * Submit handler to remove product from registry.
 */
function commerce_registry_remove_product_form_submit($form, &$form_state) {
  db_delete('commerce_registry_products')
    ->condition('registry_id', $form_state['commerce_registry']->registry_id)
    ->condition('product_id', $form_state['commerce_product']->product_id)
    ->execute();
  $vars = array(
    '!name' => '<em>' . $form_state['commerce_product']->title . '</em>',
  );
  drupal_set_message(t('!name was removed from the registry.', $vars));
  drupal_goto('registry/' . $form_state['commerce_registry']->url);
}

/**
 * Adds product to cart with registry context.
 */
function commerce_registry_product_add_to_cart_form_submit($form, &$form_state) { 
  //echo 454545; exit;
  $data = array(
    'context' => array(
      'display_path' => $form_state['page_context'],
    ),
    'commerce_registry' => $form_state['commerce_registry'],
  );     
  $line_item = commerce_product_line_item_new($form_state['commerce_product'], 1, 0, $data);    
  commerce_line_item_save($line_item);
  
   // below function is comment for multistore        
   //commerce_cart_product_add($user->uid, $line_item);    
  global $user;
  commerce_marketplace_cart_product_add($user->uid,$line_item,                
        isset($line_item->data['context']['add_to_cart_combine']) ? $line_item->data['context']['add_to_cart_combine'] : TRUE
      );      
}

/**
 * Registry edit page callback.
 */
function commerce_registry_edit_form($form, &$form_state, $registry) {
  global $user;
  $crumbs = array();
  $crumbs[] = l(t('Home'), '/');
  $crumbs[] = l($user->name, 'user/' . $user->uid);
  $crumbs[] = l(t('My Registries'), 'user/' . $user->uid . '/registry');
  drupal_set_breadcrumb($crumbs);
  $form_state['commerce_registry'] = $registry;
  $registry_type = commerce_registry_type_load($registry->type);
  $form = array();
  $form['tabs'] = array(
    '#type' => 'vertical_tabs',
    '#default_tab' => 'registry',
  );
  $form['tabs']['registry'] = array(
    '#type' => 'fieldset',
    '#title' => t('Edit Gift List'),
    '#tree' => TRUE,
  );
  $form['tabs']['registry']['type'] = array(
    '#type' => 'item',
    '#markup' => $registry_type->label,
    '#title' => t('Gift List Type'),
    '#weight' => -6,
  );
  $form['tabs']['registry']['name'] = array(
    '#type' => 'textfield',
    '#title' => t('Gift List Name'),
    '#default_value' => $registry->name,
    '#attributes' => array('readonly' => 'readonly'),  
    '#required' => TRUE,
    '#weight' => -5,
  );
  $form['tabs']['registry']['public'] = array(
    '#type' => 'radios',
    '#title' => t('Type'),
    '#options' => array(
      1 => t('Public'),
      0 => t('Private'),
    ),
    '#default_value' => $registry->public,
    '#required' => TRUE,
    '#weight' => -4,
  );
  $form['tabs']['registry']['password'] = array(
    '#type' => 'password',
    '#title' => t('Password'),
    '#states' => array(
      'visible' => array(
        ':input[name="registry[public]"]' => array('value' => 0),
      ),
    ),
    '#weight' => -3,
  );
  $form['tabs']['registry']['description'] = array(
    '#type' => 'textarea',
    '#title' => t('Description'),
    '#weight' => -2,
    '#default_value' => $registry->description,
  );
  $form['tabs']['registry']['status'] = array(
    '#type' => 'radios',
    '#title' => t('Status'),
    '#options' => array(
      0 => t('Disabled'),
      1 => t('Enabled'),
    ),
    '#required' => TRUE,
    '#default_value' => $registry->status,
    '#weight' => -1,
  );
  $form['tabs']['registry']['fields'] = array(
    '#type' => 'container',
    '#weight' => 0,
    '#parents' => array('fields'),
  );
  field_attach_form('commerce_registry', $registry, $form['tabs']['registry']['fields'], $form_state);
  $form['tabs']['registry_access'] = array(
    '#type' => 'fieldset',
    '#title' => t('Access Permissions'),
    '#tree' => TRUE,
  );
  $users = array();
  $roles = array();
  $as = commerce_registry_registry_get_access_settings($registry->registry_id, TRUE);
  foreach ($as as $access_type => $access) {
    foreach ($access as $op => $entities) {
      foreach ($entities as $entity) {
        switch ($access_type) {
          case "user":
            $users[$entity][] = $op;
            break;
          case "role":
            $roles[$entity][] = $op;
            break;
        }
      }
    }
  }
  $form_state['roles'] = count($roles);
  $form_state['users'] = count($users);
  $form['tabs']['registry_access']['roles'] = array(
    '#type' => 'fieldset',
    '#title' => t('Roles'),
  );
  $boxes = array(
    'add' => t('Add'),
    'remove' => t('Remove'),
    'view' => t('View'),
  );
  foreach ($roles as $roleid => $ops) {
    $role = user_role_load($roleid);
    $form['tabs']['registry_access']['roles'][$roleid] = array(
      '#type' => 'checkboxes',
      '#theme' => 'commerce_registry_access_checkboxes',
      '#options' => $boxes,
      '#default_value' => $ops,
      '#itemname' => $role->name,
    );
    if ($role->name == 'administrator') {
      // Admin access cannot be changed.
      $form['tabs']['registry_access']['roles'][$roleid]['#disabled'] = TRUE;
    }
  }
  $role_button = t('Add a Role');
  $not_all_roles = FALSE;
  $avail_roles = user_roles();
  foreach ($avail_roles as $role_id => $name) {
    if (!in_array($role_id, array_keys($roles))) {
      $not_all_roles = TRUE;
    }
    else {
      unset($avail_roles[$role_id]);
    }
  }
  // Add a blank role row only if there is a role left to add.
  if (isset($form_state['role_box_count']) && $not_all_roles
    && count($roles) < $form_state['role_box_count']) {
    for ($i=count($roles); $i<$form_state['role_box_count']; $i++) {
      $form['tabs']['registry_access']['roles']['new_' . $i] = array(
        '#type' => 'container',
      );
      $form['tabs']['registry_access']['roles']['new_' . $i]['new_role_id'] = array(
        '#type' => 'select',
        '#options' => $avail_roles,
      );
      $form['tabs']['registry_access']['roles']['new_' . $i]['new_role_ops'] = array(
        '#type' => 'checkboxes',
        '#theme' => 'commerce_registry_access_checkboxes',
        '#options' => $boxes,
        '#itemname' => 0,
      );
    }
    $role_button = t('Save Role');
  }
  if ($not_all_roles) {
    $form['tabs']['registry_access']['roles']['new_role'] = array(
      '#type' => 'submit',
      '#value' => $role_button,
      '#submit' => array('commerce_registry_edit_form_add_role'),
    );
  }
  $form['tabs']['registry_access']['users'] = array(
    '#type' => 'fieldset',
    '#title' => t('Users'),
  );
  foreach ($users as $userid => $ops) {
    $account = user_load($userid);
    $form['tabs']['registry_access']['users'][$userid] = array(
      '#type' => 'checkboxes',
      '#theme' => 'commerce_registry_access_checkboxes',
      '#options' => $boxes,
      '#default_value' => $ops,
      '#itemname' => $account->name,
    );
    if ($userid == 1) {
      // Admin access cannot be changed.
      $form['tabs']['registry_access']['users'][$userid]['#disabled'] = TRUE;
    }
  }
  $user_button = t('Add a User');
  // Add a blank user row.
  if (isset($form_state['user_box_count'])
    && count($users) < $form_state['user_box_count']) {
    for ($i=count($users); $i<$form_state['user_box_count']; $i++) {
      $form['tabs']['registry_access']['users']['new_' . $i] = array(
        '#type' => 'container',
      );
      $form['tabs']['registry_access']['users']['new_' . $i]['new_user_name'] = array(
        '#type' => 'textfield',
        '#autocomplete_path' => 'user/autocomplete',
        '#size' => 30,
        '#maxlength' => 60,
      );
      $form['tabs']['registry_access']['users']['new_' . $i]['new_user_ops'] = array(
        '#type' => 'checkboxes',
        '#theme' => 'commerce_registry_access_checkboxes',
        '#options' => $boxes,
        '#itemname' => 0,
      );
    }
    $user_button = t('Save User');
  }
  $form['tabs']['registry_access']['users']['new_user'] = array(
    '#type' => 'submit',
    '#value' => $user_button,
    '#submit' => array('commerce_registry_edit_form_add_user'),
  );
  $form['tabs']['actions'] = array(
    '#type' => 'actions',
    'submit' => array(
      '#type' => 'submit',
      '#value' => t('Save Gift List'),
    ),
    'cancel' => array(
      '#markup' => l(t('Cancel'), 'registry/' . $registry->url),
    ),
  );
  return $form;
}

/**
 * Callback to add a blank user access box.
 */
function commerce_registry_edit_form_add_user($form, $form_state) {
  unset($form_state['submit_handlers']);
  $count = $form_state['users'];
  $form_state['user_box_count'] = $count + 1;
  $form_state['rebuild'] = TRUE;
  commerce_registry_edit_form_save_access_settings($form, $form_state);
}

/**
 * Callback to add a blank role access box.
 */
function commerce_registry_edit_form_add_role($form, $form_state) {
  unset($form_state['submit_handlers']);
  $count = $form_state['roles'];
  $form_state['role_box_count'] = $count + 1;
  $form_state['rebuild'] = TRUE;
  commerce_registry_edit_form_save_access_settings($form, $form_state);
}

/**
 * Edit registry form validate handler.
 */
function commerce_registry_edit_form_validate($form, $form_state) {
  field_attach_form_validate('commerce_registry', $form_state['commerce_registry'], $form['tabs']['registry']['fields'], $form_state);
  if ($form_state['values']['registry']['public'] == 0) {
    $pass = $form_state['values']['registry']['password'];
    if (empty($pass)
     && empty($form_state['commerce_registry']->password)) {
      form_set_error('registry][password', t('You must enter a password for a private registry.'));
      return FALSE;
    }
    elseif (strlen($pass) < 6 && strlen($pass) > 0) {
      form_set_error('registry][password', t('The password must be at least 6 characters long.'));
      return FALSE;
    }
  }
  return TRUE;
}

/**
 * Callback to save the access settings between adding new settings and
 * actually saving the form.
 */
function commerce_registry_edit_form_save_access_settings($form, $form_state) {
  $registry = $form_state['commerce_registry'];
  if (isset($form_state['values']['registry_access'])) {
    foreach ($form_state['values']['registry_access'] as $type => $access) {
      $type = substr($type, 0, -1);
      foreach ($access as $access_id => $ops) {
        if (substr($access_id, 0, 4) == 'new_' && is_array($ops)) {
          if ($type == 'user') {
            if (isset($ops['new_user_name'])) {
              $name = $ops['new_user_name'];
              $user = user_load_by_name($name);
              if (isset($name) && $name != "" && $user !== FALSE) {
                $ops = $ops['new_user_ops'];
                $ops = array_flip($ops);
                unset($ops[0]);
                $ops = array_keys($ops);
                $registry->setAccess($user->uid, $type, $ops);
              }
            }
          }
          else if ($type == 'role') {
            $role_id = $ops['new_role_id'];
            $ops = $ops['new_role_ops'];
            $ops = array_flip($ops);
            unset($ops[0]);
            $ops = array_keys($ops);
            $registry->setAccess($role_id, $type, $ops);
          }
        }
        elseif (is_array($ops)) {
          // Any op that is not checked, remove it from the list and save.
          $ops = array_flip($ops);
          unset($ops[0]);
          $ops = array_keys($ops);
          $registry->setAccess($access_id, $type, $ops);
        }
      }
    }
    $registry->save();
  }
}

/**
 * Edit registry form submit handler.
 */
function commerce_registry_edit_form_submit($form, $form_state) {
  $registry = $form_state['commerce_registry'];
  $registry->name = $form_state['values']['registry']['name'];
  $registry->description = $form_state['values']['registry']['description'];
  $registry->public = (int) $form_state['values']['registry']['public'];
  if ($registry->public == 0) {
    $registry->password = user_hash_password($form_state['values']['registry']['password']);
  }
  $registry->status = (int) $form_state['values']['registry']['status'];
  commerce_registry_edit_form_save_access_settings($form, $form_state);
  $registry->save();
  field_attach_submit('commerce_registry', $form_state['commerce_registry'], $form['tabs']['registry']['fields'], $form_state);
  drupal_set_message(t('Registry updated.'));
  drupal_goto('registry/' . $registry->url);
}



/**
 * Form to edit a product on a registry.
 * @TODO Possibly do inline quantity editing instead of a new form.
 */
function commerce_registry_product_edit_form($form, $form_state, $product, $registry) {
  $form_state['commerce_product'] = $product;
  $form_state['commerce_registry'] = $registry;
  return $form;
}

/**
 * Registry product form validation.
 */
function commerce_registry_product_edit_form_validate($form, $form_state) {
  // @TODO Make sure quantity is legit.
}

/**
 * Registry product form submission.
 */
function commerce_registry_product_edit_form_submit($form, $form_state) {
  
}
