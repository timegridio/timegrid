<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManagerSearchControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateBusiness, CreateService, CreateContact, CreateAppointment;

    /**
     * @var App\Models\Business
     */
    protected $business;

    /**
     * @var App\Models\User
     */
    protected $owner;

    /**
     * Service One.
     *
     * @var App\Models\Service
     */
    protected $serviceOne;

    /**
     * Service Two.
     *
     * @var App\Models\Service
     */
    protected $serviceTwo;

    /**
     * Service Three.
     *
     * @var App\Models\Service
     */
    protected $serviceThree;

    /**
     * Contact One.
     *
     * @var App\Models\Contact
     */
    protected $contactOne;

    /**
     * Contact Two.
     *
     * @var App\Models\Contact
     */
    protected $contactTwo;

    /**
     * Contact Three.
     *
     * @var App\Models\Contact
     */
    protected $contactThree;

    /**
     * Appointment.
     *
     * @var App\Models\Appointment
     */
    protected $appointment;

    //////////////
    // Services //
    //////////////

    /**
     * @test
     */
    public function it_finds_a_service_by_name()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->owner);

        $criteria = $this->serviceOne->name;

        $this->post('biz/'.$this->business->slug.'/manage/search/', ['business' => $this->business, 'criteria' => $criteria]);

        $this->see($this->serviceOne->name);
    }

    //////////////
    // Contacts //
    //////////////

    /**
     * @test
     */
    public function it_finds_a_contact_by_email()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->owner);

        $criteria = $this->contactOne->email;

        $this->post('biz/'.$this->business->slug.'/manage/search/', ['business' => $this->business, 'criteria' => $criteria]);

        $this->see($this->contactOne->name);
    }

    /**
     * @test
     */
    public function it_finds_a_contact_by_name()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->owner);

        $criteria = $this->contactOne->name;

        $this->post('biz/'.$this->business->slug.'/manage/search/', ['business' => $this->business, 'criteria' => $criteria]);

        $this->see($this->contactOne->name);
    }

    /////////////////
    // Appointment //
    /////////////////

    /**
     * @test
     */
    public function it_finds_an_appointment_by_code()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->owner);

        $criteria = $this->appointment->code;

        $this->post('biz/'.$this->business->slug.'/manage/search/', ['business' => $this->business, 'criteria' => $criteria]);

        $this->see($this->appointment->date);
    }

    //////////////////////
    // Scenario Helpers //
    //////////////////////

    protected function arrangeBusinessWithOwner()
    {
        $this->owner = $this->createUser();

        $this->business = $this->createBusiness();
        $this->business->owners()->save($this->owner);

        $this->contactOne = $this->createContact();
        $this->contactTwo = $this->createContact();
        $this->contactThree = $this->createContact();

        $this->business->contacts()->save($this->contactOne);
        $this->business->contacts()->save($this->contactTwo);
        $this->business->contacts()->save($this->contactThree);

        $this->serviceOne = $this->createService();
        $this->serviceTwo = $this->createService();
        $this->serviceThree = $this->createService();

        $this->appointment = $this->makeAppointment($this->business, $this->createUser(), $this->contactOne);
        $this->appointment->save();

        $this->business->services()->save($this->serviceOne);
        $this->business->services()->save($this->serviceTwo);
        $this->business->services()->save($this->serviceThree);
    }
}
