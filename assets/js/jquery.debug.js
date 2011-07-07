jQuery.fn.debug = function() {
  return this.each(function(){
    
  });
};
jQuery.log = function(message) {
  if(window.console) {
     console.debug(message);
  } else {
     alert(message);
  }
};
