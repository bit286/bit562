if ( ! jsLib ) { var jsLib = {}; }
if ( ! jsLib.dom ) { jsLib.dom = {}; }

// Define an array that stores the functions to call when the DOM is ready
jsLib.dom.readyList = [];

// Define a Boolean property that indicates if the DOM is ready
jsLib.dom.isReady = false;

// Define a method that stores the functions to run when the DOM is ready
jsLib.dom.ready = function ( fn ) {
    if ( fn instanceof Function ) {
        if ( jsLib.dom.isReady ) {
            fn.call(document);
        } else {
            jsLib.dom.readyList.push( fn );
        }
    } else {
        if ( jsLib.dom.isReady ) {
            while ( jsLib.dom.readyList.length > 0 ) {
                fn = jsLib.dom.readyList.pop();
                fn.call(document);
            }
        }
    }
}

// Define a method that initializes the DOM library
jsLib.dom.readyInit = function () {
    if ( document.addEventListener ) {   // DOM event model
        document.addEventListener(
            "DOMContentLoaded",
            function () {
                jsLib.dom.isReady = true;
                jsLib.dom.ready();
            },
            false
        );
    } else if ( document.attachEvent ) { // IE event model
        // Are we in an iframe?
        if ( document.documentElement.doScroll && window == window.top ) {
            // No, we're not in an iframe. Use doScroll polling to
            // simulate DOMContentLoaded. By Diego Perini at
            // http://javascript.nwbox.com/IEContentLoaded/
            var doScrollPoll = function () {
                if ( jsLib.dom.isReady ) return;
                try {
                    document.documentElement.doScroll("left");
                } catch( error ) {
                    setTimeout( doScrollPoll, 0 );
                    return;
                }
                jsLib.dom.isReady = true;
                jsLib.dom.ready();
            }
            doScrollPoll();
        } else {
            // Yes, we are in an iframe or doScroll isn't supported.
            // Use the onreadystatechange event
            document.attachEvent(
                "onreadystatechange",
                function () {
                    if ( document.readyState === "complete" ) {
                        jsLib.dom.isReady = true;
                        jsLib.dom.ready();
                    }
                }
            );
        }
        
        // Use the onload event as a last resort
        if ( window.attachEvent ) {   
            window.attachEvent(
                "onload",
                function () {
                    jsLib.dom.isReady = true;
                    jsLib.dom.ready();
                }
            );
        }
    }
}

// Call the method that initializes the DOM library
jsLib.dom.readyInit();