<?php

class WebTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://127.0.0.1:8000/');
    }

    public function testTitle()
    {
        $this->url('/');
        # $this->waitForPageToLoad(4000);
        $this->assertEquals('timegrid.io', $this->title());
    }

    public function testEntrar()
    {
        $this->url('/');
        $this->click('Entrar');
        $this->assertEquals('timegrid.io', $this->title());
    }

}
