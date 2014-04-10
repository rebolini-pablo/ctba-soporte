/**
 *
 */
define("Template", ["jquery", "underscore"], function (jQuery, _) {
  
  // Constructor
  function Template() {
    
    /**
     *
     */
    this.template = null;
    
    /**
     *
     */
     this.compiled = null;
    
    /**
     *
     */
    _.templateSettings.variable = "app";
  }

  // Prototype
  Template.prototype = {

    /**
     *
     */
    parse: function (template, data) {
      this.data = data;

      if (template.indexOf('.') >= 0) {
        this.template = template.split('.').join('/') + '.html';
      }

      else {
        this.template = template + '.html';
      }

      this.fetch(this.template);

      return this;
    },

    fetch: function (path) {
      path = _base_url +
        '/assets/js/template/' + path;
      
      var promise = $.ajax({url: path, async: false})
      ,     self = this;

      promise.done(function (data) {
        self.compiled = _.template(data);
      });
    },

    render: function (target, callback) {
      var self = this;

      if (typeof target === "undefined")
        target = '.app.app-main';

      $(target).append(
        self.compiled(this.data)
      );

      if (typeof callback !== 'undefined') 
        callback();      
    }
  };

  return Template;
});