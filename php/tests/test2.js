//Comment case 1 is this line

//Comment Case 2: same line comment
var commentCase2 = new Object();//here is the test comment

//Comment case 3: should we be parsing for multi-line comments?
//unimplemented

//Func Case 1: the word function in the comment

//Func Case 2
function someFunc() {
    var funcCase2 = new Object();
}

//Func Case 3: func with comment on same line
function anotherFunc() {//testing comment on same line as func declaration
    var funcCase3 = new Object();
}

//Func Case 4: var = func() , should this be a func-block
var funcCase4 = function() {
    var extraVar = new Object();
}