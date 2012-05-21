<?php

require_once('simpletest/autorun.php');


class TestForLineType extends UnitTestCase {

function testWhatTypeOfLine() {
$this->assertTrue(file_exists('../classes/CodeLineIdentifier.php'));
 }
}

?>