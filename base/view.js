// Dependencies: jQuery.js must be loaded before structure.js
/*jsl:option explicit*/

( function () {

function VIEW() {
  this.V = [];
}

$V = new VIEW();
$V.fn = VIEW.prototype;

$V.fn.init = function() {
  makeProperty(this.V, "V", function(x) { return typeof x == "object"; });
};

$V.fn.getThis = function() {
  return this;
};

// Wrapper is an object with { before: put before name html, after: put after html} format.
// Example: { before : "<strong>", after : "</strong>" }
$V.fn.fillOneTable = function( stem, dataObj, wrapper ) {
  for ( var name in dataObj ) {
    var selector = stem + name;
    if ( wrapper ) {
      $(selector).html( wrapper.before + dataObj[name] + wrapper.after );
    }
    else {
      $(selector).html(dataObj[name]);
    }
  }
};

// objs are the rows of the table being constructed.  Pass in as an array.
//  addToName ==> id without the pound sign, e.g., projectDisplay.
// frame ==> The name of the frame to use in the display.
// objs ==> an array of objects to display wrapped in the frame html.
$V.fn.fillTableRows = function( addToName, frame, objs ) {

  for ( var i=0; i<objs.length; i+= 1 ) {
    this.add(addToName, frame, objs[i]);
  }

};

// Combine an html string with variable markers and an object's data.  Append the result to the passed id.
$V.fn.add = function( appendID, df, obj, tag) {
  if ( df.length < 30 )
    df = this.findFrame(df).frame;
  var pieces = df.split("~");
  for (var i=1; i<pieces.length; i+=2 ) {
    pieces[i] = obj[pieces[i]];
  }
  var pieceStr = "";
  if ( !tag ) {
    pieceStr = pieces.join("");
    $('<div>').html(pieceStr).appendTo('#' + appendID);
  }
  else {
    pieceStr = pieces.join("");
    $(tag).html(pieces.join(""));
  }
};

// Bring the page and frames  for a page into the STRUCTURE.
$V.fn.load = function( pageName ) {
  post($S.getMany( { "tableName" : "pages",
             "foreignKey" : "name",
             "foreignValue" : pageName,
             "security" : "0"
             } ));
  var page_ID = this.findPage(pageName).object_ID;
  post($S.getMany( { "tableName" : "frames",
             "foreignKey" : "pageoid",
             "foreignValue" : page_ID,
             "security" : "0"
            } ));

  var frames = $S.getType("frames");
};

// Locate a particular page in the STRUCTURE.
$V.fn.findPage = function( pageName ) {

  // Look in loaded pages.
  var pages = $S.getType("pages");
  if ( pages.length === 0 ) {
    return pages;
  }

  // Locate the specific page.
  for ( var i=0; i<pages.length; i+=1 ) {
    if ( pages[i].name == pageName ) {
      return pages[i];
    }
  }

  return pages;

};

// Locate a particular frame by name.
$V.fn.findFrame = function( frameName ) {
  var frames = $S.getType("frames");
  if ( frames.length === 0 ) {
    return frames;
  }
  for ( var i=0; i<frames.length; i+=1 ) {
    if ( frames[i].name == frameName ) {
      return frames[i];
    }
  }
  return "<div><p class=\"errormessage\">Frame not found: " + frameName + "</p></div>";
};

//Package button information as html.  Pass an object with buttontext, buttonID, buttonClass, and functionCall as options.
$V.fn.makeButton = function( buttonInfo ) {
  var html = "";
  html = "<button ";
  if ( buttonInfo.buttonID ) {
    html += " id=\"" + buttonInfo.buttonID + "\"";
  }
  if ( buttonInfo.buttonClass ) {
    html += " class=\"" + buttonInfo.buttonClass + "\"";
  }
  html += " onclick=\"" + buttonInfo.functionCall + "\"";
  html += ">" + buttonInfo.buttonText + "</button>";
  return html;
};

// Wrap an object or a collection of objects in html.  Uses the tableName of the
// object to decide upon the type of html wrapping.  Returns html, does not
// do inserts.
// patternName = a string representing the pattern name.
// comments = a boolean with true indicating that comments should be looked up and packaged.
//
// After comments, include the object(s) to be packaged.  "packager" expects an open end list of objects.
// The list can include as many objects as you like.  If the list item is an array, packager will loop through
// the array, packaging each object in the array.
//
// If there are no objects for packager to work on, an empty html string is returned.
$V.fn.packager = function(patternName, comments) {

// Add comment lookup if comments = true;

  var patterns = {};
  var i = 0;
  var j = 0;
  var html = "";
  var pieces = [];
  var df = "";
  var argArray = [];
  var patternView = {};
  var patternList = $S.many("name", patternName, "patternview");

  // From Crockford: Javascript: the Good Parts, p. 61.
  var isArray = function (value) {
      return value && typeof value === 'object' && value.constructor === Array;
  };

  // Put html around a single object.
  var frameTheObject = function (obj) {

    var df = "";
    var i = 0;
    var fhtml = "";

    // Get the objects html frame from the pattern object.
    df = patterns[obj.tableName];

    if ( typeof df === "undefined" ) {
      // Match of object and html frame failed.
      fhtml = "<p class=\"error\">Error: " + obj.tableName + " does not have a frame in pattern " + patternName + "<\p>";
    }
    else {
      // Package the obj with html.
      pieces = df.split("~");
      for ( i=1; i<pieces.length; i+=2 ) {
        pieces[i] = obj[pieces[i]];
      }
      fhtml = pieces.join("");

      // Add in comments if they are requested.  Check for commentsPresent in the object itself also.
      if ( comments && obj.commentPresent && obj.commentPresent !== "false") {
        fhtml += commentFraming( obj );
      }
    }

    return fhtml;

  };

  var commentFraming = function ( obj ) {

    var myComments = [];
    var otherComments = [];
    var i = 0;
    var allComments = [];
    var html = "";

    $S.clearType("allcomments");
    post($S.getComments( { "target_ID" : obj.object_ID } ));

    allComments = $S.getType("allcomments");
    for ( i; i<allComments.length; i+=1 ) {
      if ( allComments[i].authoroid === $S.findAuthor() ) {
        myComments.push(allComments[i]);
      }
      else {
        otherComments.push( allComments[i] );
      }
    }

    for ( i=0; i<myComments.length; i+=1 ) {
      html += frameTheObject(myComments[i]);
    }

    for ( i=0; i<otherComments.length; i+=1 ) {
      html += frameTheObject(otherComments[i]);
      // Fix it so all comments are able to be deleted when mouse hovers over name.
      // Each name has a commentName span surrounding the name.  Has to be done after display!
    }

    return html;

  };

  // If patternList is empty, the pattern needs to be loaded.
  if ( patternList.length === 0 ) {
    patternView = { "pipe" : "patternview",
            "queryType" : "select",
            "tableName" : "patternview",
            "name" : patternName
            };
    post(patternView);
    patternList = $S.many("name", patternName, "patternview");
  }

  // Put the pattern into an object.
  for ( i; i<patternList.length; i+=1 ) {
    patterns[patternList[i].datatype] = patternList[i].frame;
  }

  // Handle an open ended list of object arguments
  for ( i=2; i<arguments.length; i+= 1 ) {

    // An acceptable argument is an object or an array of objects.
    if ( typeof arguments[i] === 'object' ) {
      if ( isArray(arguments[i]) ) {
        argArray = arguments[i];
        for ( j=0; j<argArray.length; j+=1 ) {
          html += frameTheObject(argArray[j]);
        }
      }
      else {
        html += frameTheObject(arguments[i]);
      }
    } else {
      // Add an error message for improper object argument.
      html += "<p class=\"error\">Error: Packager has received an improper argument. Not an object.";
    }

  }

  return html;

};

// Information on screen is usually displayed in a div container (display).
// This routine makes sure the height of the container includes the last child.
$V.fn.setDisplayHeight = function(display) {
  var displayHeight =  $(display).children(":last").position().top  + 150;
  var childHeight = $(display).children(":last").height();
  displayHeight = new String(Math.round(displayHeight) + childHeight);
  $(display).css("height", displayHeight + "px");
};

$V.fn.setFormDisplayHeight = function(display) {
//  var $bottom = $(display).children(":last").children(":last");
//  var displayHeight = $bottom.position().top + 25;
//  var childHeight = $bottom.height();
//  displayHeight = new String(Math.round(displayHeight) + childHeight);
//  $(display).css("height", displayHeight + "px");
};

$V.init();

})();
