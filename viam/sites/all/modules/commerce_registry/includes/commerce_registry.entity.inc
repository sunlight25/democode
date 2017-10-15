<?php
/**
 * @file
 * Registry entity functions and class.
 */

require_once DRUPAL_ROOT . '/' . variable_get('password_inc', 'includes/password.inc');

/**
 * Implements hook_entity_info().
 */
function commerce_registry_entity_info() {
  $info = array();

  $info['commerce_registry'] = array(
    'label' => t('Commerce Registry'),
    'entity class' => 'CommerceRegistry',
    'controller class' => 'EntityAPIController',
    'base table' => 'commerce_registry',
    'fieldable' => TRUE,
    'entity keys' => array(
      'id' => 'registry_id',
      'bundle' => 'type',
      'label' => 'name',
    ),
    'bundle keys' => array(
      'bundle' => 'type',
    ),
    'view modes' => array(
      'full' => array(
        'label' => t('Full registry'),
        'custom settings' => FALSE,
      ),
      'teaser' => array(
        'label' => t('Registry teaser'),
        'custom settings' => FALSE,
      ),
    ),
    'bundles' => array(),
    'load hook' => 'commerce_registry_load',
    'label callback' => 'entity_class_label',
    'uri callback' => 'entity_class_uri',
    'module' => 'commerce_registry',
    'access callback' => 'commerce_registry_registry_access',
  );

  $info['commerce_registry_type'] = array(
    'label' => t('Commerce Registry Type'),
    'entity class' => 'CommerceRegistryType',
    'controller class' => 'EntityAPIControllerExportable',
    'base table' => 'commerce_registry_type',
    'fieldable' => FALSE,
    'bundle of' => 'commerce_registry',
    'exportable' => FALSE,
    'entity keys' => array(
      'id' => 'registry_type_id',
      'bundle' => 'type',
      'label' => 'label',
      'name' => 'type',
    ),
    'module' => 'commerce_registry',
    // Enable the entity API's admin UI.
    'admin ui' => array(
      'path' => 'admin/commerce/config/registry_types',
      'file' => 'includes/commerce_registry.admin.inc',
      'controller class' => 'CommerceRegistryTypeUIController',
    ),
    'access callback' => 'commerce_registry_type_access',
  );

  return $info;
}

/**
 * Implements hook_entity_info_alter().
 */
function commerce_registry_entity_info_alter(&$entity_info) {
  foreach (commerce_registry_types() as $type => $info) {
    $entity_info['commerce_registry']['bundles'][$type] = array(
      'label' => $info->label,
      'admin' => array(
        'path' => 'admin/commerce/config/registry_types/manage/%commerce_registry_type',
        'real path' => 'admin/commerce/config/registry_types/manage/' . $type,
        'bundle argument' => 5,
        'access arguments' => array('administer commerce_registry types'),
      ),
    );
  }
  // Add a view mode to Commerce Products for displaying on a registry page.
  $entity_info['commerce_product']['view modes']['commerce_registry_product'] = array(
    'label' => t('Commerce Registry: Product'),
    'custom settings' => FALSE,
  );
}

/**
 * Implements hook_entity_property_info_alter().
 */
function commerce_registry_entity_property_info_alter(&$info) {
  $properties = &$info['commerce_registry']['properties'];
  $properties['created'] = array(
    'label' => t('Date created'),
    'type' => 'date',
    'description' => t('The date the registry was created.'),
    'setter callback' => 'entity_property_verbatim_set',
    'setter permission' => 'administer commerce_registry',
    'schema field' => 'created',
  );
  $properties['owner_uid'] = array(
    'label' => t('Registry Owner'),
    'type' => 'user',
    'description' => t('The owner of this registry.'),
    'setter callback' => 'entity_property_verbatim_set',
    'setter permission' => 'administer commerce_registry entities',
    'required' => TRUE,
    'schema field' => 'owner_uid',
  );
}

/**
 * Registry class.
 * @TODO Allow multiple URLs to be saved against a registry.
 */
class CommerceRegistry extends Entity {
  public $products = array(),
    $owner,
    $name,
    $description,
    $created,
    $public,
    $status,
    $url,
    $urls,
    $settings,
    $password;

  public function __construct(array $values = array(), $rtype = NULL) {
    parent::__construct($values, $rtype);
    $this->owner = $this->owner();
    $this->loadProducts();
    $this->loadUrls();
    if (empty($this->urls)) {
      $this->urls = commerce_registry_generate_registry_url($this);
      $this->url = $this->urls[0];
    }
    if (is_string($this->settings)) {
      $this->settings = unserialize($this->settings);
    }
  }

  /**
   * Returns the user object of the owner, or FALSE if not set.
   */
  protected function owner() {
    return (isset($this->owner_uid) ? user_load($this->owner_uid) : FALSE);
  }

  /**
   * Build the URL listing on load.
   */
  private function loadUrls() {
    $this->urls = array();
    if (!isset($this->registry_id)) {
      return;
    }
    $q = db_select('commerce_registry_urls', 'cru')
      ->fields('cru')
      ->condition('registry_id', $this->registry_id)
      ->execute();
    foreach ($q as $url) {
      $this->urls[] = $url->url;
    }
  }

  /**
   * Build the product listing on load.
   */
  protected function loadProducts() {
    if (!isset($this->registry_id)) {
      return;
    }
    $q = db_select('commerce_registry_products', 'crp')
      ->fields('crp')
      ->condition('registry_id', $this->registry_id)
      ->execute();
    foreach ($q as $product) {
      $newProduct = array(
        'product_id' => $product->product_id,
        'message' => $product->message,
        'quantity' => $product->quantity,
        'added_by_uid' => $product->added_by_uid,
        'added_time' => $product->added_time,
        'settings' => unserialize($product->settings),
      );
      $this->products[$product->product_id] = $newProduct;
    }
  }

  /**
   * Registry default label.
   */
  protected function defaultLabel() {
    return $this->label;
  }

  /**
   * Set the registry's access password.
   */
  public function setPassword($newPassword = NULL, $account = NULL) {
    if (empty($account)) {
      global $user;
      $account = $user;
    }
    if (!empty($newPassword) && ($this->owner_uid == $account->uid)
      && strlen($newPasword) > 6) {
      // Only the owner of the registry can change the password.
      $this->password = user_hash_password($newPassword);
      return $this->save();
    }
    return FALSE;
  }

  /**
   * Returns whether this registry requires a password to access.
   */
  public function requirePassword() {
    if (!isset($this->password) || empty($this->password)) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Registry default uri.
   */
  public function defaultUri() {
    return array('path' => 'registry/' . $this->url);
  }

  /**
   * Builds the display content for the registry.
   */
  public function buildContent($view_mode = 'full', $langcode = NULL) {
    $build = parent::buildContent($view_mode, $langcode);
    // Add the registry's products to the view content.
    $product_content = '';
    foreach ($products as $product_id => $product) {
      $product_content .= theme('commerce_registry_product_view', array('product' => $product));
    }
    $build['products'] = array(
      '#prefix' => '<div class="field commerce-registry-products"><div class="field-label">' . t('Products') . '',
      '#markup' => $product_content,
      '#suffix' => '</div>',
    );
    // Allow modules to modify the content of a registry's view.
    module_invoke_all('commerce_registry_view', $build);
    return $build;
  }

  /**
   * Adds a product to the registry.
   */
  public function addProduct($product, $page = '', $message = '', $quantity = 1, $account = NULL) {
    if (empty($account)) {
      global $user;
      $account = $user;
    }
    $newProduct = array(
      'product_id' => $product->product_id,
      'message' => $message,
      'quantity' => $quantity,
      'added_by_uid' => $account->uid,
      'added_time' => REQUEST_TIME,
      'settings' => array('page' => $page),
    );
    if (isset($this->registry_id)) {
      $newProduct['registry_id'] = $this->registry_id;
    }
    // Allow modules to alter the product info prior to adding to the registry.
    drupal_alter('commerce_registry_product_add', $newProduct);
    if (in_array($newProduct['product_id'], array_keys($this->products))) {
      $this->products[$newProduct['product_id']]['quantity'] += $newProduct['quantity'];
    }
    else {
      $this->products[$newProduct['product_id']] = $newProduct;
    }
    // Allow modules to act upon a product being added to a registry.
    module_invoke_all('commerce_registry_product_add', $newProduct);
  }

  /**
   * Saves all products on the registry to the database.
   */
  private function saveProducts() {
    if (isset($this->registry_id)) {
      db_delete('commerce_registry_products')
        ->condition('registry_id', $this->registry_id)
        ->execute();
      foreach ($this->products as $product_id => $product) {
        $record = array(
          'product_id' => $product_id,
          'registry_id' => $this->registry_id,
          'quantity' => $product['quantity'],
          'message' => $product['message'],
          'added_by_uid' => $product['added_by_uid'],
          'added_time' => $product['added_time'],
          'settings' => serialize($product['settings']),
        );
        drupal_write_record('commerce_registry_products', $record);
      }
    }
  }

  /**
   * Saves a registry.
   */
  public function save() {
    // Allow modules to act on insert and update of a registry.
    if (isset($this->is_new) && $this->is_new) {
      $this->name = 'Gift List';        
      $this->description = 'Gift List';        
      $this->public = 1;    
      $this->status = 1;        
      $this->type = 'gift';                   
      module_invoke_all('commerce_registry_insert', $this);      
      $this->created = REQUEST_TIME;
    }
    else {        
      module_invoke_all('commerce_registry_update', $this);
    }
    // We store the parent's return value so we can save products after the
    // registry's id has been created.
    $return = parent::save();
    $this->saveProducts();
    $this->saveUrls();
    return $return;
  }

  /**
   *
   */
  private function saveUrls() {
    if (!isset($this->registry_id) && !isset($this->is_new)) {
      return;
    }
    foreach ($this->urls as $url) {
      db_merge('commerce_registry_urls')
        ->key(array(
          'url' => $url,
          'registry_id' => $this->registry_id,
        ))
        ->fields(array(
          'url' => $url,
          'registry_id' => $this->registry_id,
        ))
        ->execute();
    }
  }

  /**
   * Adds an access permission to this registry for a given user.
   */
  public function setAccess($access_id, $access_type, $modes = array('view'), $message = NULL) {
    global $user;
    if (empty($message)) {
      $message = t('Access added by !user on registry edit form.', array('!user' => $user->name));
    }
    db_merge('commerce_registry_access')
      ->key(array(
        'registry_id' => $this->registry_id,
        'access_id' => $access_id,
        'access_type' => $access_type,
      ))
      ->fields(array(
        'registry_id' => $this->registry_id,
        'access_id' => $access_id,
        'access_type' => $access_type,
        'added_by' => $user->uid,
        'allowed_methods' => serialize($modes),
        'log_message' => $message,
      ))
      ->execute();
    if (empty($modes)) {
      db_delete('commerce_registry_access')
        ->condition('registry_id', $this->registry_id)
        ->condition('access_id', $access_id)
        ->condition('access_type', $access_type)
        ->execute();
    }
  }

  /**
   * Attempt to log in the user to the registry.
   */
  public function login($user, $password) {       
    $temp = new stdClass();
    $temp->pass = $this->password;
    if (!user_check_password($password, $temp)) {        
      // Incorrect password. Increment login attempts and set the timeout.
      $cookie_name = 'commerce_registry_' . $this->registry_id . '_' . $user->uid . '_login_attempts';
      if (!isset($_COOKIE[$cookie_name])) {
        setcookie($cookie_name, 1, REQUEST_TIME + 900);
      }
      else {
        setcookie($cookie_name, (int) $_COOKIE[$cookie_name] + 1, REQUEST_TIME + 900);
      }
      return FALSE;
    }
    // If the user is logged in, and enters the correct password, we give them
    // permission permanently so they don't have to type in a password every
    // time they want to view this registry.
    if (isset($user->uid) && $user->uid != 0) {   
        //echo 6555; exit;
        setcookie('commerce_registry_view_' . $this->registry_id, 1, REQUEST_TIME + 60*60);
      //$this->setUserAccess($user);
    }
    else {
            setcookie('commerce_registry_view_' . $this->registry_id, 1, REQUEST_TIME + 60*60*24);
    }
    return TRUE;
  }

  /**
   * Checks if the user has tried to access this registry more than 5 times in
   * 15 minutes.
   */
  public function loginLimit($user) {      
    $cookie_name = 'commerce_registry_' . $this->registry_id . '_' . $user->uid . '_login_attempts';
    if (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] > 5) {
      // If user has more than 5 attempts in the past 15 minutes, don't let them log in.
      $data = array(
        'registry' => $this,
        'request_info' => $_REQUEST,
        'timestamp' => REQUEST_TIME,
        'user' => $user,
      );
      ob_start();
      var_dump($data);
      $output = ob_get_contents();
      ob_end_clean();
      watchdog('commerce registry', '<h2>' . t('Repeated Login Attempt') . '</h2><hr><textarea rows=8 cols=80 disabled>' . $output . '</textarea>');
      return TRUE;
    }
    return FALSE;
  }
}

/**
 * Registry type class.
 */
class CommerceRegistryType extends Entity {
  public $type;
  public $label;
  public $locked = FALSE;
  public $weight = 0;

  /**
   * Registry type constructor.
   */
  public function __construct($values = array()) {
    parent::__construct($values, 'commerce_registry_type');
  }
}

/**
 * Commerce Registry UI controller.
 */
class CommerceRegistryTypeUIController extends EntityDefaultUIController {
  /**
   * Overrides hook_menu() defaults.
   */
  public function hook_menu() {
    $items = parent::hook_menu();
		$items[$this->path]['description'] = 'Manage registry entity types, including adding
		  and removing fields and the display of fields.';
    return $items;
  }
}

/**
 * Implements hook_field_extra_fields().
 */
function commerce_registry_field_extra_fields() {
  $fields = array();
  foreach (commerce_registry_types() as $type) {
    $fields['commerce_registry'][$type->type] = array(
      'form' => array(
        'commerce_registry_products' => array(
          'label' => t('Registry products'),
          'description' => t('The products that have been added to this registry.'),
          'weight' => 0,
        ),
      ),
      'display' => array(
        'commerce_registry_products' => array(
          'label' => t('Registry products'),
          'description' => t('The products that have been added to this registry.'),
          'weight' => 0,
        ),
      ),
    );
  }
  return $fields;
}

/**
 * Load a registry.
 */
function commerce_registry_load($registry_id, $reset = FALSE) {
  $registries = commerce_registry_load_multiple(array($registry_id), array(), $reset);
  return reset($registries);
}

/**
 * Load a registry by URL.
 */
function commerce_registry_load_by_url($url) {
  $registry_query = db_select('commerce_registry_urls', 'cru')
    ->fields('cru', array('registry_id'))
    ->condition('url', $url)
    ->execute()
    ->fetchCol();
  if (!empty($registry_query)) {
    return commerce_registry_load((int) $registry_query[0]);
  }
  return FALSE;
}

/**
 * Loads registries for a specific user.
 * @return array Array of registries for the user keyed by registry id.
 */
function commerce_registry_load_user_registries($account = NULL) {
  if (empty($account)) {
    global $user;
    $account = $user;
  }
  if ($account->uid == 0) {
    return array();
  }
  $regs = array();
  $registries = db_select('commerce_registry', 'cr')
    ->fields('cr', array('registry_id'))
    ->condition('owner_uid', $account->uid)
    ->execute();
  foreach ($registries as $registry) {
    $regs[$registry->registry_id] = commerce_registry_load($registry->registry_id);
  }
  return $regs;
}

/**
 * Load multiple registries based on certain conditions.
 */
function commerce_registry_load_multiple($registry_ids = array(), $conditions = array(), $reset = FALSE) {
  return entity_load('commerce_registry', $registry_ids, $conditions, $reset);
}

/**
 * Save registry.
 */
function commerce_registry_save($registry) {
  entity_save('commerce_registry', $registry);
}

/**
 * Delete single registry.
 */
function commerce_registry_delete($registry) {
  entity_delete('commerce_registry', entity_id('commerce_registry', $registry));
}

/**
 * Delete multiple registries.
 */
function commerce_registry_delete_multiple($registry_ids) {
  entity_delete_multiple('commerce_registry', $registry_ids);
}

/**
 * Load registry type.
 */
function commerce_registry_type_load($registry_type) {
  return commerce_registry_types($registry_type);
}
/**
 * List of registry types.
 */
function commerce_registry_types($type_name = NULL, $reset = FALSE) {
  $types = &drupal_static(__FUNCTION__, NULL, $reset);
  if (empty($types)) {
    $types = entity_load_multiple_by_name('commerce_registry_type', isset($type_name) ? array($type_name) : FALSE);
  }
  return isset($type_name) ? reset($types) : $types;
}

/**
 * Check if the type exists by machine name.
 */
function commerce_registry_type_exists($type_name) {
  $q = db_select('commerce_registry_type', 'crt')
    ->fields('crt')
    ->condition('type', $type_name)
    ->countQuery()
    ->execute()
    ->fetchCol();
  if ($q[0] > 0) {
    return TRUE;
  }
  return FALSE;
}

/**
 * Save registry type entity.
 */
function commerce_registry_type_save($registry_type) {
  entity_save('commerce_registry_type', $registry_type);
}

/**
 * Delete single registry type.
 */
function commerce_registry_type_delete($registry_type) {
  entity_delete('commerce_registry_type', entity_id('commerce_registry_type', $registry_type));
}

/**
 * Delete multiple registry types.
 */
function commerce_registry_type_delete_multiple($registry_type_ids) {
  entity_delete_multiple('commerce_registry_type', $registry_type_ids);
}

/**
 * Generates a unique registry URL.
 * @param stdClass $registry A registry object.
 * @return string The unique URL for the registry.
 */
function commerce_registry_generate_registry_url($registry) {
  $url = '';
  if (isset($registry->name) && !empty($registry->name)) {
    // Otherwise we generate the hash based on the registry name.
    $url = substr(md5($registry->name), 0, 8);
  }
  else {
    // We just generate an MD5 hash of the current time.
    $url = substr(md5(time()), 0, 8);
  }
  $isUnique = FALSE;
  while (!$isUnique) {
    // We loop through this technique for as long as the URL generated is not
    // unique.
    $unique = db_select('commerce_registry', 'cr')
      ->fields('cr')
      ->condition('url', $url)
      ->countQuery()
      ->execute()
      ->fetchCol();
    if ($unique[0] == 0) {
      $isUnique = TRUE;
    }
    else {
      $start = mt_rand(0, 10);
      $end = mt_rand(20, 32);
      // We add a random grouping of an MD5 hash to the URL.
      $add = substr(md5(time()), $start, $end);
      // But we only want 2 characters added at a time.
      $add = substr($add, 0, 2);
      $url .= $add;
    }
  }
  // Allow others to modify the generated URL or generate their own.
  $urls = array($url) + module_invoke_all('commerce_registry_generate_registry_url', $registry, $url);
  return $urls;
}
