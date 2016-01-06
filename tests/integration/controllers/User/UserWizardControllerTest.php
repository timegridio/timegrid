<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserWizardControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateBusiness;

    /**
     * @test
     */
    public function it_shows_the_default_wizard_for_business_owner()
    {
        $owner = $this->createUser();

        $business = $this->createBusiness();

        $business->owners()->save($owner);

        $this->actingAs($owner);

        $this->visit(route('home'));

        $this->see($business->name);

        $this->seePageIs($business->slug.'/manage/dashboard');
    }

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
