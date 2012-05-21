<?php
/***********************************************************
*
* AutoDocTests.php
* A testsuite for tests created to examinie AUTODOC featuers.
*
*
*************************************************************/

require_once('simpletest'/autorun.php');
class AutoDocTests extendes TestsSuite {
function autodocTests() {
$this->TestSuite('All tests');
$this->addFile('TestsForSourceLineObject.php');
$this->addFile('CodeLineIdentifierTesting.php');
$this->addFile('TestOfClassCodeObject.php');
}
}
?>
