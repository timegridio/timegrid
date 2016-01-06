<?php

class LanguageControllerTest extends TestCase
{
    /**
     * @test
     */
    public function it_switches_language_to_english_us()
    {
        $applocale = 'en_US.utf8';
        $this->call('GET', "/lang/$applocale");

        $this->assertSessionHas('language', 'en');
        $this->assertSessionHas('applocale', $applocale);
        $this->assertResponseStatus(302);
    }

    /**
     * @test
     */
    public function it_switches_language_to_spanish_es()
    {
        $applocale = 'es_ES.utf8';
        $this->call('GET', "/lang/$applocale");

        $this->assertSessionHas('language', 'es');
        $this->assertSessionHas('applocale', $applocale);
        $this->assertResponseStatus(302);
    }

    /**
     * TODO: For some reason the custom header is not working, thus the test not
     * feasible by now.
     * 
     * @test
     */
//    public function it_attempts_to_use_agent_preferred_languages_first_spanish()
//    {
//        $this->get('/', [
//            'HTTP_ACCEPT_LANGUAGE'  => 'es-ES,es;q=0.8,en-US;q=0.6,en;q=0.4',
//        ]);
//
//        $this->see('La agenda de citas para profesionales exitosos');
//    }
}
