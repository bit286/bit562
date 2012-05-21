<?php

require_once(dirname(__FILE__).'/simpletest/autorun.php');
require_once(dirname(__FILE__).'/simpletest/web_tester.php');
class TestMenuSystem extends WebTestCase {
    function testPage() {
        $url = 'http://localhost/bit562/forms/login.php';
        $this->get($url);
        $this->assertResponse(200);
        $this->assertTitle('Login');
        $this->clickSubmitById('submit');
        $this->assertCookie('PHPSESSID');
        $this->assertResponse(200);
        $this->assertTitle('BIT562 - Home');
        $this->clickLink('Run jumpPointDoc');
        $this->assertResponse(200);
        $this->assertText('The jumpPoint run was successful.');
        $this->back();
        $this->clickLink('Output Docs');
        $this->assertResponse(200);
        $this->assertTitle('');
        $this->assertText('File');
        $this->back();
        //A test that will fail because it is a https page
        $this->clickLink('Free Project Hosting');//Trys to Open New Page that is secure https
        $this->showRequest();
        $this->showHeaders();
        $this->showSource();
        $this->showText();
        $this->assertTitle('HostZilla, Inc. | Cloud Web Hosting Service Provider');
        $this->back();
        $this->assertTitle('BIT562 - Home');
        $this->clickLink('Search Google');//Trys to Open New Page that is secure https
        $this->showRequest();
        $this->showHeaders();
        $this->showSource();
        $this->showText();
        $this->assertTitle('Google');
        $this->back();
        $this->assertTitle('BIT562 - Home');
        
        
    }
}