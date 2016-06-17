<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<div class="item item-feature">
<?php if (!empty($title)): ?>
  <?php print $title; ?>
<?php endif; ?>
<div class="item-feature-body col-md-10 col-md-offset-2">
  <?php foreach ($rows as $id => $row): ?>
      <?php print $row; ?>
  <?php endforeach; ?>
</div>
</div>
