<?php

require_once('simpletest/autorun.php');
require_once('simpletest/web_tester.php');
require_once('simpletest/browser.php');


class TestForHomepage extends WebTestCase {
    
    function testHomePage() {
    	$this->setMaximumRedirects(0);
    	$this->get('http://localhost/bit562/forms/login.php');
        $this->assertResponse(200);
        $this->assertTitle('Login');
        $this->clickSubmitById('submit');
        $this->assertCookie('PHPSESSID');
        $this->assertResponse(array(301, 302, 303, 307));
        $this->get('http://localhost/bit562/index.php');
        $this->assertTitle('BIT562 - Home');   
        $this->assertLink('Home');
        $this->clickLink('Home');
        $this->assertTitle('BIT562 - Home');
        $this->assertLink('Login');
        $this->clickLink('Login');
        $this->assertTitle('Login');
        $this->back();
        $this->assertLink('Project Files Form');
        $this->clickLink('Project Files Form');
        $this->assertTitle('Project Files');
        $this->back();
        $this->assertLink('Users Form');
        $this->clickLink('Users Form');
        $this->assertTitle('Users');
        $this->back();
        $this->assertLink('Code Snippets Form');
        $this->clickLink('Code Snippets Form');
        $this->assertTitle('Code Snippets');
        $this->back();
        $this->assertLink('Run jumpPointDoc');
        $this->clickLink('Run jumpPointDoc');
        $this->assertText('The jumpPoint run was successful.');
        $this->back();
        $this->assertLink('Output Docs');
        $this->clickLink('Output Docs');
        $this->assertResponse(array(301, 302, 303, 307));
        $this->back();
        $this->assertLink('Blessed Repository');
        $this->assertLink('Ed The Decider');
        $this->assertLink('Chris');
        $this->assertLink('Tom');
        $this->assertLink('Mason');
        $this->assertLink('Alfred');
        $this->assertLink('Tim');
        $this->assertLink('Logan');
        $this->assertLink('Mike O.');
        $this->assertLink('Mike M.');
        $this->assertLink('Igor');
        $this->assertLink('Shawn');
        $this->assertLink('PHP Manual');
        $this->assertLink('PHP');
        $this->assertLink('JavaScript');
        $this->assertLink('jQuery');
        $this->assertLink('SQL');
        $this->assertLink('HTML');
        $this->assertLink('HTML5');
        $this->assertLink('DOM');
        $this->assertLink('CSS');
        $this->assertLink('CSS3');
        $this->assertLink('About');
        print_r($links);

    }
}

?>