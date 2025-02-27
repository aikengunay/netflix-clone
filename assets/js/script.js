// This function controls the mute/unmute functionality of a video
// Parameters:
//   - button: The button element that triggered this function
function volumeToggle(button) {
  // Get the current muted state of the video (true/false)
  var muted = $(".previewVideo").prop("muted");
  // Toggle the muted state to the opposite value
  // If it was muted (true), it becomes unmuted (false), and vice versa
  $(".previewVideo").prop("muted", !muted);

  //toggle change icon functionality
  // find class get rid of this class
  $(button).find("i").toggleClass("fa-volume-xmark");
  // add this class
  $(button).find("i").toggleClass("fa-volume-high");
}

function previewEnded() {
  //toggle preview video then change to image
  $(".previewVideo").toggle();
  $(".previewImage").toggle();
}
