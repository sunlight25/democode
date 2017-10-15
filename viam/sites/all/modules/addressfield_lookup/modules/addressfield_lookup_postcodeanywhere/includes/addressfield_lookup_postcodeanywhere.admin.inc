<?php

/**
 * @file
 * Admin functionality for the PostcodeAnywhere Address Field lookup service.
 */

/**
 * Form builder: PostcodeAnywhere address field lookup service configuration.
 */
function addressfield_lookup_postcodeanywhere_config_form() {
  $form['addressfield_lookup_postcodeanywhere_login'] = array(
    '#title' => t('Login'),
    '#type' => 'textfield',
    '#default_value' => variable_get('addressfield_lookup_postcodeanywhere_login', FALSE),
    '#description' => t('The login associated with the Royal Mail license (not required for click licenses).'),
  );

  $form['addressfield_lookup_postcodeanywhere_license'] = array(
    '#title' => t('License'),
    '#type' => 'textfield',
    '#default_value' => variable_get('addressfield_lookup_postcodeanywhere_license', FALSE),
    '#description' => t('API key to use to authenticate to Postcode Anywhere.'),
  );

  $form['addressfield_lookup_postcodeanywhere_country_quality'] = array(
    '#title' => t('Minimum addressing quality'),
    '#type' => 'select',
    '#options' => array_combine(range(1, 5), range(1, 5)),
    '#default_value' => variable_get('addressfield_lookup_postcodeanywhere_country_quality', 4),
    '#description' => t('The minimum quality value (1 least to 5 most) of address data required. This quality value is used to filter supported countries pulled from <a href="@country_url" target="_blank">PCA Predict</a>', array('@country_url' => 'https://www.pcapredict.com/support/webservice/extras/lists/countrydata/3')),
    '#element_validate' => array('element_validate_integer_positive'),
  );

  // Add a custom submit function.
  $form['#submit'][] = 'addressfield_lookup_postcodeanywhere_config_form_submit';

  return system_settings_form($form);
}

/**
 * Form submit handler: Redirect back to the address field lookup services page.
 */
function addressfield_lookup_postcodeanywhere_config_form_submit($form, &$form_state) {
  // Show warning if supported countries data quality level is below 3.
  if ($form_state['values']['addressfield_lookup_postcodeanywhere_country_quality'] < 3) {
    drupal_set_message(t('You have selected an addressing quality below 4. This is not recommended and could result in poor quality address lookups.'), 'warning');
  }

  $form_state['redirect'] = 'admin/config/regional/addressfield-lookup';
}
