<?php
require_once('simpletest/autorun.php');
require_once('../classes/source.php');

class TestSourcelineObject extends UnitTestCase {
    function testSourceLineHasLineType() {
        $line = "puts 'hello'";
        $sourceline = new Sourceline($line);
        $this->assertNotNull($sourceline->linetype);
    }

    function testSourceLineIsComment() {
        $line[0] = '// this is a line comment';
        $line[1] = '/* this starts a block comment';
        foreach ($line as &$l) {
            $sourceline = new Sourceline($l);
            $p = '/comment/';
            $this->assertPattern($p, $sourceline->linetype);
        }
    }

    function testSourceLineIsCodeline() {
        $line = 'echo "this is a php codeline"';
        $sourceline = new Sourceline($line);
        $p = 'codeline';
        $this->assertEqual($sourceline->linetype, $p);
    }

}


