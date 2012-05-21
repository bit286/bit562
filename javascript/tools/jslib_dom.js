if ( ! jsLib ) { var jsLib = {}; }
if ( ! jsLib.dom ) { jsLib.dom = {}; }

jsLib.dom.walk = function ( nodeFn, preFn, postFn, node ) {
    if ( nodeFn == undefined ) return;
    if ( node == undefined ) node = document.documentElement;
    
    // If the node is an element
    if (node.nodeType == 1) {

        // Pass the node to the main function
        nodeFn(node);
        if ( node.hasChildNodes() ) {
            // If necessary, pass the node to the pre-child function
            if ( preFn !== undefined ) preFn(node);

            // Use a recursive call to process each child node
            for(var i = 0; i < node.childNodes.length; i++) {
                jsLib.dom.walk( nodeFn, preFn, postFn, node.childNodes[i]);
            }

            // If necessary, pass the node to the post-child function
            if ( postFn !== undefined ) postFn(node);
        }
    }
}

jsLib.dom.getElementsByClassName = function ( className ) {   
    // Define a variable to store the elements
    var elements = [];

    // Define the main function
    var nodeTest = function (node) {
        if ( className == node.className ) {
            elements.push( node );
        }
    }

    // Call the walk method
    jsLib.dom.walk(nodeTest);
    
    return (elements.length > 0) ? elements : undefined;
}

jsLib.dom.getElementsByClassNames = function ( classes ) {
    // Convert the classes string into an array of strings
    classes = classes.split( /[\s]+/ );
    var classREs = [], re;
    for ( var i = 0; i < classes.length; i++ ) {
        re = new RegExp( "(^|[\\s])" + classes[i] + "([\\s]|$)" );
        classREs.push ( re );
    }
    
    // Define a variable to store the elements
    var elements = [];

    // Define the main function
    var nodeTest = function (node) {
        for ( var i = 0; i < classREs.length; i++ ) {
            if ( classREs[i].test(node.className) ) {
                elements.push( node );
            }
        }
    }

    // Call the walk method
    jsLib.dom.walk(nodeTest);
    
    return (elements.length > 0) ? elements : undefined;
}