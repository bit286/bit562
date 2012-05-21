<?php

require_once(dirname(__FILE__).'/simpletest/autorun.php');
require_once(dirname(__FILE__).'/simpletest/web_tester.php');
class TestMenuSystem extends WebTestCase {
    function testPage() {
        $url = 'http://nexisgen.com/bit562/forms/login.php';
        $this->get($url);
        $this->assertResponse(200);
        $this->assertTitle('Login');
        $this->clickSubmitById('submit');
        $this->assertCookie('PHPSESSID');
        $this->assertResponse(200);
        if($this->assertTitle('BIT562 - Home'))
        {echo ('Successfully Loged in to the site. This test passed');}
        else echo ('this test failed');
        $this->clickLink('Run jumpPointDoc');
        $this->assertResponse(200);
        $this->assertText('The jumpPoint run was successful.');
        if($this->assertText('The jumpPoint run was successful.'))
        {echo ('Successfully ran jumpPointdoc. This test passed');}
        else echo ('this test failed');
        $this->back();
        //Try google
        $this->clickLink('Search Google');//Trys to Open New Page that is secure https
        $this->assertResponse(200);
        $this->showRequest();
        $this->showHeaders();
        $this->showSource();
        $this->showText();
        $this->assertTitle('Google');
        if($this->assertTitle('Google'))
        {echo ('Successfully ran navagated back to home page and clicked on Search Google. This test passed');}
        else echo ('this test failed');
        // end
        $this->back();
        $this->clickLink('Output Docs');
        $this->assertResponse(200);
        $this->assertTitle('');
        $this->assertText('File');
        //A test that will fail.
        $this->back();
        $this->clickLink('not here');
        $this->assertText('text not here');
        echo ('This test failed');
        //A test that will fail because it is a https page
        $this->clickLink('Free Project Hosting');//Trys to Open New Page that is secure https
        $this->showRequest();
        $this->showHeaders();
        $this->showSource();
        $this->showText();
        $this->assertTitle('HostZilla, Inc. | Cloud Web Hosting Service Provider');
        $this->back();
        echo ('Click BACK button to return to provious page');
        $this->showRequest();
        $this->showHeaders();
        $this->showSource();
        $this->showText();
        if($this->assertTitle('Login'))
        {echo ('This test passed');}
        else echo ('this test failed');
        
        $this->showRequest();
        $this->showHeaders();
        $this->showSource();
        $this->showText();
        $this->clickSubmitById('submit');
        $this->clickLink('Search Google');//Trys to Open New Page that is secure https
        $this->showRequest();
        $this->showHeaders();
        $this->showSource();
        $this->showText();
        $this->assertTitle('Google');
        $this->back();
        $this->assertTitle('BIT562 - Home');
        //Test for a Joomla page
        $url = 'http://www.joomla.org';
        $this->get($url);
        $string = $this->showSource();
        //use sub strin function to pars string to see if text snip in in the source.
        $this->assertText('<meta name="generator" content="Joomla!');
        
        
    }
}