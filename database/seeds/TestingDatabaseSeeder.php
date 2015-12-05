<?php

use App\Models\User;
use App\Models\Contact;
use App\Models\Service;
use App\Models\Vacancy;
use App\Models\Business;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class TestingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds for a Demo Fixture
     *
     * @return void
     */
    public function run()
    {
        // Create some example Businesses with example owners
        $this->createBusinessOwnedBy($this->createRandomGuestUser(), 'Tomy\'s Garage');
        $this->createBusinessOwnedBy($this->createRandomGuestUser(), 'Pluto Garage');
        $this->createBusinessOwnedBy($this->createRandomGuestUser(), 'Jenny\'s');

        // Create a well known Demo Manager User
        $demoManagerUser = $this->createDemoManagerUser();

        // Create a Business managed by him
        $business = $this->createBusinessOwnedBy($demoManagerUser, 'Demo Venue');

        // Create a Demo Guest User
        $demoGuestUser = $this->createDemoGuestUser();

        // Create a Contact for Guest User
        $contact = $this->createDemoGuestUserContact($demoGuestUser);

        // Put the Contact into the Business addressbok
        $this->putUserGuestContactOf($contact, $business);

        // Generate some addressbook info to fill
        $this->generateDemoAddressBook($business, 200);

        // Generate Services provided by Business
        $serviceA = $this->publishServiceFor($business);
        $serviceB = $this->publishServiceFor($business);
        $serviceC = $this->publishServiceFor($business);
        
        // Publish Vacancies for each Service for Business
        $this->publishVacanciesFor($business, $serviceA);
        $this->publishVacanciesFor($business, $serviceA);
        $this->publishVacanciesFor($business, $serviceA);
        $this->publishVacanciesFor($business, $serviceB);
        $this->publishVacanciesFor($business, $serviceB);
        $this->publishVacanciesFor($business, $serviceC);
    }

    /////////////////////////
    // SAMPLE DATA HELPERS //
    /////////////////////////

    private function createDemoManagerUser()
    {
        // Create demo user (Business Manager)
        $user = factory(User::class)->create(['email' => 'demo@timegrid.io', 'password' => bcrypt('demomanager')]);

        return $user;
    }

    private function createDemoGuestUser()
    {
        // Create demo user (Business Guest)
        $user = factory(User::class)->create(['email' => 'guest@example.org', 'password' => bcrypt('demoguest')]);

        return $user;
    }

    private function createRandomGuestUser()
    {
        // Create random guest user (Business Guest)
        $user = factory(User::class)->create();

        return $user;
    }

    private function createBusinessOwnedBy(User $user, $name)
    {
        // Create demo Business
        $business = factory(Business::class)->create(['name' => $name]);

        $business->owners()->save($user);

        return $business;
    }

    private function createDemoGuestUserContact(User $user = null)
    {
        // Create demo Contact for Guest User
        $contact = factory(Contact::class)->create();
        if ($user) {
            $contact->user()->associate($user);
        }

        return $contact;
    }

    private function putUserGuestContactOf(Contact $contact, Business $business)
    {
        $business->contacts()->save($contact);
    }

    private function publishServiceFor(Business $business)
    {
        $service = factory(Service::class)->make();
        $service->business()->associate($business);
        $service->save();

        return $service;
    }

    private function publishVacanciesFor(Business $business, Service $service)
    {
        $vacancy = factory(Vacancy::class)->make();
        $vacancy->business()->associate($business);
        $vacancy->service()->associate($service);
        
        try {
            $vacancy->save();
        } catch (QueryException $e) {
            // We are Ok with getting some key collisions since
            // dates are generated randomly
        }

        return $vacancy;
    }

    private function generateDemoAddressBook(Business $business, $limit = 100)
    {
        for ($i = 0; $i<=$limit; $i++) {
            $contact = $this->createDemoGuestUserContact();
            $this->putUserGuestContactOf($contact, $business);
        }

        return $this;
    }
}
