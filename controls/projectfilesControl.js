// JavaScript Document

(function() {

  function PROJECTFILESCONTROL() {

  }

  $PF = new PROJECTFILESCONTROL();
  $PF.fn = PROJECTFILESCONTROL.prototype;

  $PF.fn.init = function() {
  };

  $PF.fn.getThis = function() {
    return this;
  };

  $PF.fn.setUpProjectFiles = function() {

    // Put all javascript variable declarations at the top of the function.
    var projectfiles = {
      pipe : "projectfiles",
      tableName : "projectfiles",
      queryType : "select",
      project : "BIT561"
    },
        filenames = [];

    // Load the data into structure, a jagged associative array.
    post(projectfiles);

    filenames = $S.getType("projectfiles");

    // Set up the category selector.
    // Assumes the data objects have a category member.
    if ( filenames.length > 0 ) {
      $F.fillCategorySelector("projectfiles", "selectFileCategory");
    }

    // Display the first data value or a clear screen.
    if ( filenames.length > 0 ) {
      $F.present("projectfiles", filenames[0]);
    } else {
      $F.clearForm("projectfiles");
    }

    // Establish the carousel and set its events.
    $C.setC(filenames);
    $C.setSelect("fileselect", $C.getC(), "projectfiles", "name");
    $C.makeEventHandlers("filecontrol", "projectfiles", $PF.bailout );

    // Put an event on the category selector.
    $("#selectFileCategory")
      .change(function(e) {
        $F.categorySelector(this, "fileselect", "projectfiles");
      });

  };

  // Do nothing on bailout at the moment.
  $PF.fn.bailout = function() {
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

    case "source":
      message = "Type in the location of the source code file being"+
    " converted into HTML."+
    " If running this on local xampp server put in the"+
    " complete location: drive, path, filename, and extension."+
    " If running this on a public linux server put in"+
    " the relitive paths from jumpPoint.php to your source file."+
    " Sample: jumpPoint.php";
      break;

    case "destination":
      message = "Enter the location of the HTML file created by the"+
        " autodoc conversion. "+
        " If running on local xampp server put in the complete"+
        " location: drive, path, filename, and extension."+
        " If running on public linux server enter in relitave"+
        " path from jumpPoint.php. Sample: ../doc/jumpPoint.html";
      break;

    case "project":
      message = "Enter the name of the project files to be processed"+
        " with the autodoc command.";
      break;

    case "name":
      message = "Name is a short, one line description of the"+
        " file being converted. Names are used in indexes and"+
        " drop down selectors as a quick way to indicate which"+
        " file is being chosen.";
      break;

    case "description":
      message = "A longer description of the contents of a"+
        " project source code file. The description can be used"+
        " in a document describing all project work.";
      break;

    case "category":
      message = "Creating categories such a php, css, etc., makes"+
        " it easier to find particular files in projects with a"+
        " large number of files.";
      break;

    default:
      message = "";
      break;
  }
  $("#helpComments").html(message);
  });
});

