<?php

function bunsen_preprocess_page(&$variables){
  drupal_add_library('system','ui.accordion');

  // Primary nav.
  $variables['primary_nav'] = FALSE;
  if ($variables['main_menu']) {
    // Build links.
    $variables['primary_nav'] = menu_tree_output(menu_tree_all_data(variable_get('menu_main_links_source', 'main-menu')));
    // Provide default theme wrapper function.
    $variables['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }

  if (drupal_is_front_page()){
    $variables['content_column_class'] = 'col-lg-12 text-center';
  }
  else{
    $variables['content_column_class'] = 'col-lg-12 content-page';
  }
}
