(function ($) {
  Drupal.behaviors.bunsen_main = {
    attach: function (context, settings) {
      $(document).ready(function(){
        var bunsenMain = this;

        $('.accordion').accordion({
          collapsible: true,
          active: false,
          heightStyle: "content"
        });
      });
    }
  };
}(jQuery));
