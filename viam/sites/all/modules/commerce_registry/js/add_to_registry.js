(function ($) {
  Drupal.behaviors.commerce_registry = {
    attach: function (context, settings) {
      $('a.add_to_registry_click').click(function() {
        $('fieldset[id|="edit-commerce-registry"]').toggle();
      });
    }
  };
}) (jQuery);