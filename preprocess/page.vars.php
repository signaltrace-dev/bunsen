<?php

function bunsen_preprocess_page(&$variables){
  /*
  $main_menu = menu_tree_all_data('menu-contributions-and-data');
  $output = menu_tree_output($main_menu);
  $output['#theme_wrappers'][0] = 'menu_tree__primary';
  $vars['main_menu'] = $output;*/

  // Primary nav.
  $variables['primary_nav'] = FALSE;
  if ($variables['main_menu']) {
    // Build links.
    $variables['primary_nav'] = menu_tree_output(menu_tree_all_data(variable_get('menu_main_links_source', 'main-menu')));
    // Provide default theme wrapper function.
    $variables['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }
}
