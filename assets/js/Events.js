define("Events", ["jquery", "Helper", "Message"], function (jQuery, Helper, Message) {
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

    // Resolve ticket button
    // @todo Tratar como un form-async
    jQuery('.js-resolve-ticket').on('click', function (event) {
      event.preventDefault();

      if (confirm('Esta accion marcara el ticket seleccionado como: Resuelto')) {
        var id = jQuery(this).attr('data-id');
        var promise = $.post(_base_url + '/ticket/close', {id: id});

        promise.done(function (data) {
          var status = data.status
          ,   message = null;

          if (data.hasOwnProperty('message'))
            message = data.message;

          if (Message.hasOwnProperty(status))
            Message[status](message);

          if (status === "success") {
            setTimeout(function () {
              document.location.reload();
            }, 2000);
          }

        });
      }

      return;
    });
  };



  return Events;
});