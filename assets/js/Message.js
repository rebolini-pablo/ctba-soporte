/**
 *
 */
define('Message', ['jquery'], function (jQuery) {
  var Message = {
    success: function (msg) {
      msg = (typeof msg === "undefined") ?
        "Operacion ejecutada con exito" : msg;
      
      jQuery('.app.app-messages').append(this.template(
        'success', msg
      ));
    },

    error: function (msg) {
      msg = (typeof msg === "undefined") ?
        "Se ha producido un error. Intente nuevamente" : msg;
      
      jQuery('.app.app-messages').append(this.template(
        'error', msg
      ));

    },

    info: function (msg) {
      if (typeof msg === "undefined")
        return;
      
      jQuery('.app.app-messages').append(this.template(
        'info', msg
      ));

    },

    template: function (type, msg) {
      return '<div class="message '+ type +'">' +
        '<span>'+ msg +'</span>' +
        '<i class="js-close-message fa fa-times pull-right"></i>' +
        '</div>';
    }
  }
  return Message;
});

