<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserWizardControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    /**
     * @test
     */
    public function it_shows_the_terms_and_conditions()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $this->visit(route('wizard.terms'));

        $this->see('TERMS AND CONDITIONS');
    }

    /**
     * @test
     */
    public function it_shows_the_pricing_table()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $this->visit(route('wizard.pricing'));

        $this->see('Ideal for freelancers');
    }

    /**
     * @test
     */
    public function it_shows_the_wizard_welcome()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $this->visit(route('wizard.welcome'));

        $this->see('Please tell us what would you like to do');
    }
}
