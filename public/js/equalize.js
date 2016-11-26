// on page load, equalize
$(document).ready(function(){
  equalize();
  // on resize, reset the heights then equalize
  $( window ).resize(function() {
    $("ul#hike-list li > .thumbnail").map(function (i,e) {
      $(e).height("auto");
    });
    equalize();
  });
});

function equalize() {
  // if the window is less than 768 but greater than 495
  if (window.innerWidth < 768 && window.innerWidth > 495) {
    // initialize maxHeight
    var maxHeight = 0;
    // find the greatest height of the hike list items
    $("ul#hike-list li > .thumbnail").map(function (i,e) {
      // if this is greater than the maxHeight, remember if
      if ($(e).height() > maxHeight) maxHeight = $(e).height();
    });
    // set the height of all the hike list items to the maxHeight
    $("ul#hike-list li > .thumbnail").map(function (i,e) {
      $(e).height(maxHeight);
    });
  }
}