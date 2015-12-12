<?php

/**
 * @file
 * template.php
 */

 // Load all theme includes
 $theme_path = drupal_get_path('theme', 'bunsen');
 $files = file_scan_directory($theme_path . '/preprocess', '/.php/');
 foreach ($files as $filepath => $file) {
   require_once($filepath);
 }

/*
* Implements hook_form_alter().
*/
function bunsen_form_alter(&$form, &$form_state, $form_id){
    $form_type = !empty($form['type']['#value']) ? $form['type']['#value'] : '';
    $form['#attributes']['class'][] = 'form-horizontal';

    // Add icons to action buttons
    $form['actions']['submit']['#value'] .= '&nbsp;&nbsp;<i class="fa fa-save"></i>';
    if(!empty($form['actions']['delete'])){
      $form['actions']['delete']['#value'] .= '&nbsp;&nbsp;<i class="fa fa-ban"></i>';
    }

    // Remove node settings at the bottom of form
    unset($form['additional_settings']);
    foreach($form as $key => $element){
      if (is_array($form[$key]) && isset($form[$key]['#group'])) {
        unset($form[$key]);
      }

      // Wrap certain form element types with Bootstrap column classes
      if(strrpos($key, 'field_', -strlen($key)) !== FALSE || $key == 'title'){
        $field_info = field_info_instance('node', $key, $form_type);
        $field_type = !empty($field_info['widget']['type']) ? $field_info['widget']['type'] : '';

        $column_prefix = '<span class="col-md-8">';
        $column_suffix = '</span>';
        $adjust_col = FALSE;

        if($key == 'title'){
          $form_elem = &$form[$key];
          $adjust_col = TRUE;
        }
        else{
          switch($field_type){
            case "text_textarea":
              break;
            case "file_generic":
              $form_elem = &$form[$key][LANGUAGE_NONE][0];
              $adjust_col = TRUE;
              break;
            case "number":
              $form_elem = &$form[$key][LANGUAGE_NONE][0]['value'];
              $column_prefix = '<span class="col-md-2 input-type-number">';
              $adjust_col = TRUE;
              break;
            case "text_textfield":
              $form_elem = &$form[$key][LANGUAGE_NONE][0]['value'];
              $adjust_col = TRUE;
              break;
            default:
              $form_elem = &$form[$key][LANGUAGE_NONE];
              $adjust_col = TRUE;
              break;
          }
        }
        if($adjust_col){
          $prefix = !empty($form_elem['#field_prefix']) ? $form_elem['#field_prefix'] : '';
          $suffix = !empty($form_elem['#field_suffix']) ? $form_elem['#field_suffix'] : '';
          $form_elem['#field_prefix'] = $column_prefix . $prefix;
          $form_elem['#field_suffix'] = $suffix . $column_suffix;
        }
      }
    }
}

/**
 * Implements hook_field_group_pre_render_alter().
 */
function bunsen_field_group_pre_render_alter(&$element, $group, &$form) {
  $key = '';
  if(!empty($group->group_name)){
    $key = $group->group_name;

    // Add class to top-level field groups
    if(!empty($form[$key])){
      $form[$key]['#attributes']['class'][] = 'field-group-parent';
    }
  }
  if($element['#type'] == 'fieldset' && !isset($element['#id'])){
    $element['#id'] = drupal_html_id('fieldset');
  }
}

/*
 * Implements of hook_js_alter
 */
function bunsen_js_alter(&$js) {
  unset($js['misc/collapse.js']);
}

function bunsen_preprocess_bootstrap_panel(&$variables) {
  $element = &$variables['element'];
  $attributes = &$variables['attributes'];
  if($element['#collapsible'] != $variables['collapsible']){
    $variables['collapsible'] = TRUE;
    $variables['collapsed'] = TRUE;

    if (!isset($element['#id'])) {
      $element['#id'] = drupal_html_id('bootstrap-panel');
    }

    $attributes['id'] = $element['#id'];
    $variables['target'] = '#' . $element['#id'] . ' > .collapse';
  }
}
