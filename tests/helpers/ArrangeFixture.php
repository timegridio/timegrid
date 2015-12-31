<?php

trait ArrangeFixture
{
    /**
     * Business Owner
     *
     * @var App\Models\User
     */
    protected $owner = null;

    /**
     * Appointment Issuer
     *
     * @var App\Models\User
     */
    protected $issuer = null;

    /**
     * Appointment Contact
     *
     * @var App\Models\Contact
     */
    protected $contact = null;

    /**
     * Business
     *
     * @var App\Models\Business
     */
    protected $business = null;

    /**
     * Serivce
     *
     * @var App\Models\Service
     */
    protected $service = null;

    /**
     * Business Vacancy
     *
     * @var App\Models\Vacancy
     */
    protected $vacancy = null;

    /**
     * Arrange Fixture
     *
     * @return void
     */
    protected function arrangeFixture()
    {
        // Given there is...

        // a Business owned by Me (User)
        $this->owner = $this->createUser();

        $this->issuer = $this->createUser();

        $this->business = $this->createBusiness();
        $this->business->owners()->save($this->owner);

        // And the Business provides a Service
        $this->service = $this->makeService();
        $this->business->services()->save($this->service);

        // And the Service has Vacancies to be reserved
        $this->vacancy = $this->makeVacancy();
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);

        // And a Contact that holds an Appointment for that Service
        $this->contact = $this->createContact();
    }
}
