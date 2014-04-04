/**
 * App Controller
 * @author Rebolini Pablo <rebolini.pablo@gmail.com>
 */
define("App", ["jquery", 'Template'],  function (jQuery, Template) {
    "use strict";

    // Constructor
    function App () {
      var $app = jQuery('.app.app-main');
      this.current = $app.attr('data-current');
      this.template = new Template;
      this.data  = $app.attr('data-json');

      if (this.data)
        this.data = jQuery.parseJSON(this.data);
    }


    App.prototype = {
      init: function () {
        
        // Parse current template
        if (this.current) {
          this.template.parse(this.current, this.data).render();
        }

      },
    };

    return App;
  }
);

