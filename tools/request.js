HTTP = {};

HTTP.fireFox = false;

// Try these functions until one works.
HTTP._factories = [
	function() { HTTP.fireFox = true; return new XMLHttpRequest(); },
	function() {return new ActiveXObject("Msxml2.XMLHTTP");},
	function() {return new ActiveXObject("Microsoft.XMLHTTP");},
];

// When we find a factory that works, store it here.
HTTP._factory = null;

HTTP.newRequest = function() 
{
	if ( HTTP._factory != null )
		return HTTP._factory();
		
	for ( var i=0; i<HTTP._factories.length; i++ )
	{
		try
		{
			var factory = HTTP._factories[i];
			var request = factory();
			if ( request != null )
			{
				HTTP._factory = factory;
				return request;
			}
		}
		catch(e)
		{
			continue;
		}
	}
	
	// If here, nothing worked.  Set up error message.
	HTTP._factory = function()
	{
		throw new Error("XMLHttpRequest not supported.");
	}
	
	// Throw an error.
	HTTP._factory();
	
};


/**
 * Send an HTTP POST request to a specified URL, using the names and values
 * of the properties of the values object as the body of the request.
 */
 
HTTP.post = function(url, values, callback, structure, synchronous, errorHandler)
{
	var request = HTTP.newRequest();
	request.onreadystatechange = function()
	{
		if ( request.readyState == 4 )
		{
			if ( request.status == 200 )
			{
				callback.call(structure.getThis(), HTTP._getResponse(request));
			}
			else
			{
				if ( errorHandler )
					errorHandler(request.status, request.statusText);
				else
					callback(null);
			}
		}
	}
	
	var doNotWaitForReply = true;
	if ( synchronous == false ) {
		doNotWaitForReply = false;
	}
	
	request.open("POST", url, doNotWaitForReply);
	
	// This header tells the server how to interpret the body of the request.
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Encode the properties of the values object and send them as
	// the body of the request.
	if ( $S.getType('marker').length > 0 ) {
		values.izoid = $S.getType('marker')[0].izoid;
	}
	request.send(HTTP.encodeFormData(values));

	// Handle Firefox's behavior when a synchronous call is requested.  It doesn't do the onreadystate 
	// callback in the same way IE does.
	if ( doNotWaitForReply == false && HTTP.fireFox ) {
		callback.call(structure.getThis(), HTTP._getResponse(request));		
	}
	
};

/**
 *  Encode the property name/value pairs of an object as if they were from
 *  an HTML form, using application/x-ww-form-urlencoded format.
 */
HTTP.encodeFormData = function(data)
{
	var pairs = [];
	var regexp = /%20/g;  // A regular expression to match an encoded space.
	
	for ( var name in data)
	{
		var value = data[name].toString();
		var pair = encodeURIComponent(name).replace(regexp,"+") + '=' +
			  encodeURIComponent(value).replace(regexp,"+");
		pairs.push(pair);
	}
	
	// Concatenate all the name/value pairs, separating them with &
	return pairs.join('&');
}; 


HTTP._getResponse = function(request)
{
	switch(request.getResponseHeader("Content-Type"))
	{
		case "text/xml":
			return request.responseXML;
		case "text/json":
		case "text/javascript":
		case "application/javascript":
		case "application/x-javascript":
			// Note: only do this is the Javascript code is frm a trusted servant.
			return eval(request.responseText);
		default:
			return request.responseText;
	}
};

// Short form of a standard synchronous post.
function post( obj ) {
	HTTP.post("../php/jumpPoint.php", obj, $S.XMLtoStructure, $S, false);
};	

// Handle the login page.
function startLogin( obj ) {
	HTTP.post("../php/jumpStart.php", obj, $S.XMLtoStructure, $S, false);
};

// Return the marker.
function marker( obj ) {
	HTTP.post("../php/setAuthor.php", obj, $S.XMLtoStructure, $S, false);
};

// Handle the addition of users to the database.
function users( obj ) {
	HTTP.post("../php/addUsers.php", obj, $S.XMLtoStructure, $S, false);
};

// Short form of an analytics submission.
function analytics( command, description ) {
	var obj = { "tableName" : "analytics",
	            "queryType" : "insert",
				"pipe" : "analytics",
				"command" : command };
	if ( typeof description != "undefined" )
		obj.description = description;
	HTTP.post("../php/jumpPoint.php", obj, $S.XMLtoStructure, $S, true);
};

