/** Submit form with input changes **/
  // If the user clicks a checkbox or radio button on the form
  $('.trigger').click(function() {
    // submit the form
    $('form').submit();
  });
  // If the user makes a dropdown selection
  $('.dropdownTrigger').change(function() {
    // submit the form
    $('form').submit();
  });
/** Toggle Tags Checkbox Inputs Visibility **/
  $(".toggle").click(function (e) {
    $("#" + e.target.id + "-input").toggle();
    $("#" + e.target.id + "-down").toggle();
    $("#" + e.target.id + "-up").toggle();
  });
/** BOOTSTRAP POPOVERS **/
  $(function () {
    $('#mbta').popover();
  });
  $(function () {
    $('#climbPopover').popover();
  });
/** Toggle Pagination **/ 
  // If any page number is clicked,
  $(".pageNum").click(function (e) {
    // Get the ID of the page number clicked
    var selectedId = $(this).attr("id");
    // Get the ID of the active page
    var activeId = $(".active").attr("id");
    // Toggle the visibility of the active page
    $(".page" + activeId).toggle();
    // Remove active class from active page list item
    $("#" + activeId).removeClass("active");
    // Toggle the visibility of the selected page
    $(".page" + selectedId).toggle();
    // Add active class to the selected list item
    $("#" + selectedId).addClass("active");
    togglePageTurns();
  });
  // If a page turning button is selected
  $(".pageTurn").click(function (e) {
    // get active page
    var activeId = $(".active").attr("id");
    // if user clicked "next"
    if ($(this).attr("id") == "next") {
      // if there is a next page
      if ($("#" + (parseInt(activeId) + 1)).length) {
        // deactivate the current page button
        $("#" + activeId).removeClass("active");
        // make current page invisible
        $(".page" + activeId).toggle();
        // activate next page button
        $("#" + (parseInt(activeId) + 1)).addClass("active");
        // make next page hidden
        $(".page" + (parseInt(activeId) + 1)).toggle();
      }
    }
    // if user clicked "previous"
    else if ($(this).attr("id") == "prev") {
      // if the current page is not the first one
      if (activeId > 1) {
        // deactivate current page button
        $("#" + activeId).removeClass("active");
        // make current page invisible
        $(".page" + activeId).toggle();
        // activate previous page button
        $("#" + (parseInt(activeId) - 1)).addClass("active");
        // make previous page visible
        $(".page" + (parseInt(activeId) - 1)).toggle();
      }
    }
    togglePageTurns();
  });
  function togglePageTurns() {
    // If the first page is not the active page,
    if ($(".active").attr("id") != "1") {
      // the previous button is enabled
      $("#prev").removeClass("disabled").html('<a href="#prev" rel="prev">&laquo;</a>');
    }
    else {
      // otherwise, it is disabled
      $("#prev").addClass("disabled").html('<span>&laquo;</span>');
    }
    // if this is the last page
    if ($(".active").attr("id") == 3 ) {
      // the next button is disabled
      $("#next").addClass("disabled").html('<span>&raquo;</span>');
    }
    else {
      // otherwise, it is enabled
      $("#next").removeClass("disabled").html('<a href="#prev" rel="next">&raquo;</a>');
    }
  }