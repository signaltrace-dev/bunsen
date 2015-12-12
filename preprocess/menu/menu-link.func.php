<?php
/**
 * @file
 * menu-link.func.php
 */

/**
 * Overrides theme_menu_link().
 */
function bunsen_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  // On primary navigation menu, class 'active' is not set on active menu item.
  // @see https://drupal.org/node/1896674
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }

  if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    }
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
      // Generate as standard dropdown.
      //$element['#title'] .= ' <span class="caret"></span>';
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      //$element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
      //$element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }


  // Add FontAwesome icons based on link function
  $icon = "";

  if(!empty($element['#original_link']['menu_name']) && $element['#original_link']['menu_name'] == 'user-menu'){
    $element['#attributes']['class'][] = 'user-action';

    if($element['#href'] == 'user'){
      global $user;
      $element['#title'] = $user->name;
      $icon = "<i class='fa fa-user'></i>&nbsp;&nbsp;";
      $element['#attributes']['class'][] = 'user-action-account';
    }

    if($element['#href'] == 'user/logout'){
      $icon = "<i class='fa fa-sign-out'></i> ";
      $element['#attributes']['class'][] = 'user-action-logout';
    }
  }

  $element['#localized_options'] += array(
    'html' => TRUE,
  );

  $output = l($icon . $element['#title'], $element['#href'], $element['#localized_options']);
  return '<li ' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
