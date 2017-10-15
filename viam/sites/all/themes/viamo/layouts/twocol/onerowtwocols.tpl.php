<?php

/**
 * @file
 * Template for a 2 column panel layout.
 *
 * This template provides a two column panel display layout, with
 * each column roughly equal in width.
 *
 * Variables:
 * - $id: An optional CSS id to use for the layout.
 * - $content: An array of content, each item in the array is keyed to one
 *   panel of the layout. This layout supports the following sections:
 *   - $content['left']: Content in the left column.
 *   - $content['right']: Content in the right column.
 */
?>
<div class="py-5">
    <div class="panel-display panel-2col row" <?php if (!empty($css_id)) {print "id=\"$css_id\"";} ?>>
      <div class="col m12"><?php print $content['top']; ?></div>
      <div class="col m8">
        <div class="inside"><?php print $content['left']; ?></div>
      </div>
      <div class="col m4">
        <div class="inside"><?php print $content['right']; ?></div>
      </div>
    </div>
<div>
