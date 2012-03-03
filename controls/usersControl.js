// JavaScript Document

(function() {

  function USERSCONTROL() {

  }

  $U = new USERSCONTROL();
  $U.fn = USERSCONTROL.prototype;

  $U.fn.init = function() {
  };

  $U.fn.getThis = function() {
    return this;
  };

  $U.fn.setUpUsers = function() {

    // Put all javascript variable declarations at the top of the function.
    var users = {
      pipe : "users",
      tableName : "users",
      queryType : "select",
      email: "%"
    },
    usernames = [];

    // Load the data into structure, a jagged associative array.
    post(users);

    usernames = $S.getType("users");

    if ( usernames.length > 0 ) {
      $F.fillCategorySelector("users")
    }

    // Display the first data value or a clear screen.
    if ( usernames.length > 0 ) {
      
      $F.clearForm("users");
    }

    // Establish the carousel and set its events.
    $C.setC(usernames);
    $C.setSelect("userselect", $C.getC(), "users", "userName");
    $C.makeEventHandlers("userscontrol", "users", $U.bailout );

  };
 
   
		
  // Do nothing on bailout at the moment.
  $U.fn.bailout = function() {
  };

})();


// Establish the helpful hints for the forms input elements.
$(document).ready( function() {
  $("fieldset").click( function() {

    var top = 0,
    topStr = "",
    message = "",
    formLocation = {};

  $("fieldset").css("background-color", "#FFFFFF");
  $(this).css("background-color", "#DCCEA6");
  formLocation = $(this).position();
  top = Math.floor(formLocation.top) + 90;
  topStr = top + "px";
  $("#helpComments").css("top", topStr);
  switch ($(this).attr("id")) {

    case "userName":
      message = "<br /><br />Enter your desired user name. ";
      break;

    case "firstName":
      message = "<br /><br />Enter your first name.";
      break;

    case "lastName":
      message = "<br /><br />Enter your last name";
      break;

    case "email":
      message = "<br /><br />Enter your email address";
      break;

    case "password":
      message = "Enter your password";
      break;

    default:
      message = "";
      break;

  }
  $("#helpComments").html(message);
  });
});


