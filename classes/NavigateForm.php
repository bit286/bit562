<?php
require_once('../tests/simpletest/autorun.php');
require_once('../tests/simpletest/web_tester.php');

class TestOfRankings extends WebTestCase {
    function testWeAreTopOfGoogle() {
        $this->get('http://google.com/');
        $this->setField('q', 'Sustainable Bothell');
        $this->click("I'm Feeling Lucky");
        $this->assertTitle('SustainableBothell.Com');
    }
}
?>