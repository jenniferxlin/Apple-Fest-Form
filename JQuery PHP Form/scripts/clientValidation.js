//Set TEST_PHP_FORM variable to true to test PHP/server-side form validation
// without client-side jQuery validation too.

var TEST_PHP_FORM = false;

$(document).ready(function () {
  if (!TEST_PHP_FORM) {
  //tracks when user tries to submit form
  $("#appleForm").on("submit", function() {
    //initially assumes form is valid
    var validForm = true;

    //checks if first name, last name, and email input are valid
    var firstnameValid = $("#firstName").prop("validity").valid;
    var lastnameValid = $("#lastName").prop("validity").valid;
    var emailValid = $("#userEmail").prop("validity").valid;
    var firstchoiceValid = $("#firstChoice").val();
    var secondchoiceValid = $("#secondChoice").val();
    var thirdchoiceValid = $("#thirdChoice").val();

    //hides error messages if first name, last name, and email are valid
    if(firstnameValid) {
      $("#firstNameError").hide();
    }
    if (lastnameValid) {
      $("#lastNameError").hide();
    }
    if (emailValid) {
      $("#emailError").hide();
    }

    //hides error messages if an option is selected (not on "Please Select")
    if (firstchoiceValid != "") {
      $("#firstchoiceError").hide();
    }

    if (secondchoiceValid != "") {
      $("#secondchoiceError").hide();
    }

    if (thirdchoiceValid != "") {
      $("#thirdchoiceError").hide();
    } else {
      //show error messages if names and email are invalid
      if (!firstnameValid) {
      $("#firstNameError").show();
    } if (!lastnameValid) {
      $("#lastNameError").show();
    } if (!emailValid) {
      $("#emailError").show();
    }

      //show error messages if option not selected
      if (firstchoiceValid == ""){
      $("#firstchoiceError").show();
    } if (secondchoiceValid == ""){
      $("#secondchoiceError").show();
    } if (thirdchoiceValid == ""){
      $("#thirdchoiceError").show();
    }

    //don't let user submit
    validForm = false;
  }
  return validForm;

  });

//resets all form elements and removes error messages
//learned to reload from Stack Overflow:
// https://stackoverflow.com/questions/30347724/refresh-page-with-reset-button
$("#appleForm").on("reset", function() {
    document.location.reload(true);
    $("#firstNameError").hide();
    $("#lastNameError").hide();
    $("#emailError").hide();
    $("#firstchoiceError").hide();
    $("#secondchoiceError").hide();
    $("#thirdchoiceError").hide();
  });
}

});
