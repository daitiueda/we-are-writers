$(function() {
  var $fixElement = $('.nav'); 
  var baseFixPoint = $fixElement.offset().top; 
  var fixClass = 'fixed'; 
  function fixFunction() {
      var windowScrolltop = $(window).scrollTop();
      if(windowScrolltop >= baseFixPoint) {
          $fixElement.addClass(fixClass);
      } else {
          $fixElement.removeClass(fixClass);
      }
  }

  $(window).on('load scroll', function() {
      fixFunction();
  });
});