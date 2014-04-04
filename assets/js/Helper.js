define('Helper', ['jquery', 'Message'], function (jQuery, Message) {

  var Helper = {

    /**
     * 
     */
    async_form: function (object) {
      "use strict";

      var promise
      ,     formData = new FormData(object);
      
      promise = jQuery.ajax({
        type: object.method,
        async: false,
        cache: false,
        data: formData,
        url: object.action,
        processData: false,
        contentType: false,

        success: function (data) {
          var status = data.status
          ,     message = undefined;

          if (data.hasOwnProperty('message'))
            message = data.message;

          jQuery('.js-async-loader').remove();

          if (Message.hasOwnProperty(status))
            return Message[status](message);
        },

        beforeSend: function () {
          var $form = jQuery(object)
          ,     $loader = jQuery('<div class="js-async-loader">' +
                                          '<i class="fa fa-refresh fa-spin fa-3x"></i></div>');

          $form.append($loader); 
        }
      });

      return false;
    }

  };

  return Helper;
});