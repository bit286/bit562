<?php
require_once(dirname(__FILE__) . '/simpletest/autorun.php');
require_once(dirname(__FILE__) . '/simpletest/extensions/dom_tester.php');

class TestForCss extends DomTestCase {

    function testHomeCss() {
#            $login = 'http://localhost/bit562/forms/login.php';
        $home = 'http://localhost/bit562/index.php';
#        $this->assertTrue($this->get($login));
#            $this->clickSubmitById('submit');
        $this->assertTrue($this->get($home));
        $this->assertEqual($this->getUrl(), $home); 
        $this->assertElementsBySelector('h2', array('Mission', 'Vision Statement'));
    }
}
?>
