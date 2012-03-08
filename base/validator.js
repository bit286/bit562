// validator: checking newly entered data from forms.
// Dependency: Assumes jQuery is loaded.  Used #dataStore as a backdoor data pass.

// The strategy pattern sets up selecting algorithms at runtime.  The clients of the validator work with
// a constant interface, but the list of tasks performed depends on context (i.e., config).
var validator = {
	
	// Available checks list
	types: {},
	
	// Error messages in the current validation session.
	messages: [],
	
	// Current validation config object: A series of name: validaton type pairs in object form.
	// Determins which tests will be applied where. For example,
	// 		var newconfig = {
	//			lastname: 'isNonEmpty',
	//			areacode: 'isDigitsAndLength, 3',
	//			zip: 'isDigits'
	//		}
	// validate.config = newconfig;
	config: {},
	
	
	
	// The primary interface method where 'data' is an object of key => value pairs.  Usually, the
	// object is taken directly from a form. Note that types is filled from routines outside of validate.  
	// See following code.
	validate: function (data) {			
		
		var type,
			response;
			
		// Reset all messages.
		this.messages = [];
		
		for (dataname in data) {
			
			if (data.hasOwnProperty(dataname)) {
				
				type = this.config[dataname];
				
				if ( !type ) {
					continue;
				}
								   				
				response = this.performTest(dataname, data[dataname], type);
				
				if (!response.result) {
					msg = "Invalid value for *" + dataname + "*, " + response.validation.instructions();
					this.messages.push(msg);
				}
			}
		}
	},
	
	// Execute the test called for with the data value being looked at.
	performTest: function (dataname, value, type) {

		var msg, 
			checker, 
			result_ok,
			rule;
		
		// The first element is the validator, following that we have alternatives.
		rule = type.split(",");
		checker = this.types[rule[0]];

		// If I've asked for a checker and its not there...
		if (!checker) {
			throw {
				name : "Validation Error",
				message : "No handler to validate type " + type };
		}
		
		// This is where the test gets performed.
		result_ok = checker.validate(value, rule);
		
		return {
			result: result_ok,
			validation: checker,
			message: checker.instructions()
		};
		
	},
		
	hasErrors: function	() {
		return this.messages.length !== 0;
	}
};

// A validator for checking to see if a text field is empty.
validator.types.isNonEmpty = {
	
	validate: function (value, rule) {
//		var test1, test2, test3;
//		test1 = typeof value === "undefined";
//		test2 = value === null;
//		test3 = value === "";
//		alert("value = " + value + "   test1 = " + test1 + "  test2 = " + test2 + "  test3 = " + test3); 
		return !(typeof value === "undefined" || value === null || value === "");
	},
	
	instructions: function () {
		return "the value cannot be empty.";
	}

};

// There must be a value and it must be a particular length. dataname: "isLength,4" in config.
validator.types.isLength = {

	validate: function (valueStr, rule) {
		$("#dataStore").data("fieldsize", "" + rule[1]);
		return valueStr.length === parseInt(rule[1], 10);
	},
	
	instructions: function () {
		return "the length must be " + $("#dataStore").data("fieldsize") + " characters.";
	}
	
};

// Make sure a value is series of digits in string form.
validator.types.isDigits = {
	
	validate: function (value, rule) {
		return !/[^0-9]/.test(value);
	},
	
	instructions: function () {
		return "the value can only be a valid digits, e.g., 1, 2, 3, ..., 9.";
	}
	
};

//Make sure a value is a series of letters. Also allows spaces

validator.types.isLetters = {
	
	validate: function (value, rule){
		return !/^[a-zA-Z()]+$/.test(value);
	},
	
	instructions: function() {
		return "the value can only be letters A-Z";
	}
	
	
}

//Make sure a value follows a phone number pattern

validator.types.isPhoneNumber = {
	
	validate: function (value, rules){
		return !/^(\()?(\d{3})([\)-\. ])?(\d{3})([-\. ])?(\d{4})$/.test(value);
		
	},
	
	instructions: function() {
		return "the value must follow the pattern (xxx) xxx-xxxx";
	}
	
}

//Make sure a value follows a email pattern

validator.types.isEmail = {
	
	validate: function (value, rules){
		return !/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/.test(value);
	},
	
	instructions: function(){
		return "Email Invalid. Must follow x@xxx.xxx";
	}
}

// Make sure a value is a string of digits and a particular length.
validator.types.isDigitsAndLength = {
	
	validate: function (value, rule) {
		$("#dataStore").data("digitslength", "" + rule[1]);
		return !/[^0-9]/.test(value) && value.length === parseInt(rule[1], 10);
	},
	
	instructions: function () {
		return "the length must be " + $("#dataStore").data("digitslength") + " digits.";
	}
	
};

// Make sure a nonrequired string of digits is a particular length if present.
validator.types.isNotPresentOrDigitsAndLength = {
	
	validate: function (value, rule) {
		if (value.length === 0) {
			return true;
		}
		$("#dataStore").data("digitslength", "" + rule[1]);
		return !/[^0-9]/.test(value) && value.length === parseInt(rule[1], 10);
	},
	
	instructions: function() {
		return "the length must be " + $("#dataStore").data("digitslength") + " digits.";
	}
	
};