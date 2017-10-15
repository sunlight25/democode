<?php

/**
 * @file
 * Plugin definition.
 */
$plugin = array(
  'title' => t('One row two columns'),
  'category' => t('onerowtwocols'),
  'icon' => 'twocol.png',
  'theme' => 'onerowtwocols',
  'css' => 'twocol.css',
  'regions' => array(
    'top' => t('Top'),
    'right' => t('Right side'),
    'left' => t('Left side')
  ),
);
