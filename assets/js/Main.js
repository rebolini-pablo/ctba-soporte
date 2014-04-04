/**
 * Main Controller
 * @author Rebolini Pablo <rebolini.pablo@gmail.com> 
 */
require(["App", "Events"], function (App, Events) {
  var app = new App()
  ,     events = new Events();

  app.init();
  events.register();
});