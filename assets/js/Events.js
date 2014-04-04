define("Events", ["jquery", "Helper"], function (jQuery, Helper) {
  function Events () {

  }

  Events.prototype.register = function () {
    // Al seleccionar un archivo, coloca la ruta en el input visible
    jQuery('.js-pretty-upload-upload').change(function() {
      jQuery(this).parent()
        .find('input[type="text"]')
        .val( jQuery(this).val() );
    });

    // Inicia el input file
    jQuery('.js-PrettyUpload-fire').on('click', function () {
      jQuery(this).parent()
        .parent()
        .find('.js-pretty-upload-upload')
        .click();
     });

    // Async Form
    jQuery('.js-async-form').on('submit', function (event) {
      event.preventDefault();
      Helper.async_form(this);
    });

    // Close Messages
    jQuery(document).on('click', '.js-close-message', function () {
      var $message = jQuery(this).parent();

      $message.slideUp(function(){
        $message.remove()
      });

    });
  };



  return Events;
});