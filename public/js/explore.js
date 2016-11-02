// If any page number is clicked,
$(".pageNum").click(function (e) {
  // Get the ID of the page number clicked
  var selectedId = $(this).attr("id");
  // Get the ID of the active page
  var activeId = $(".active").attr("id");
});
// If a page turning button is selected
$(".pageTurn").click(function (e) {
  // get active page
  var activeId = $(".active").attr("id");
  // if user clicked "next"
  if ($(this).attr("id") == "next") {
    // if the first page is active
    if (activeId == "first" && $("#second").length) {
      // activate second section and hide first section
      activateDeactivate(activeId, "second");
    }
    // if the second page is active
    if (activeId == "second" && $("#third").length) {
      // activate third section and hide second section
      activateDeactivate(activeId, "third");
    }
  }
  // if user clicked "previous"
  else if ($(this).attr("id") == "prev") {
    // if the second page is active
    if (activeId == "second") {
      // activate first section and hide second section
      activateDeactivate(activeId, "first");
    }
    // if the third page is active
    if (activeId == "third") {
      // activate second section and hide third section
      activateDeactivate(activeId, "second");
    }
  }
});
function activateDeactivate(activeId, selectedId) {
  // Toggle the visibility of the active list
  $("." + activeId + "Page").toggle();
  // Remove active class from active page number
  $("#" + activeId).removeClass("active");
  // Toggle the visibility of the selected list
  $("." + selectedId + "Page").toggle();
  // Add active class to the selected pagenumber
  $("#" + selectedId).addClass("active");
  togglePageTurns();
}
function togglePageTurns() {
  // If the first page is not the active page,
  if ($(".active").attr("id") != "first") {
    // the previous button is enabled
    $("#prev").removeClass("disabled").html('<a href="#prev" rel="prev">&laquo;</a>');
  }
  else {
    // otherwise, it is disabled
    $("#prev").addClass("disabled").html('<span>&laquo;</span>');
  }
  // if the third page or second and last possible page is active
  if ($(".active").attr("id") == "third" || ($(".active").attr("id") == "second") <?php if (isset($count)) {if ($count < 21) echo("&& true"); else echo("&& false");} ?> ) {
    // the next button is disabled
    $("#next").addClass("disabled").html('<span>&raquo;</span>');
  }
  else {
    // otherwise, it is enabled
    $("#next").removeClass("disabled").html('<a href="#prev" rel="next">&raquo;</a>');
  }
}