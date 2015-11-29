<?php

use App\User;
use App\Contact;
use App\Service;
use App\Vacancy;
use App\Business;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
        $this->createBusinessOwnedBy($this->createRandomGuestUser());
        $this->createBusinessOwnedBy($this->createRandomGuestUser());
        $this->createBusinessOwnedBy($this->createRandomGuestUser());

        // Create a well known Demo Manager User
        $demoManagerUser = $this->createDemoManagerUser();

        // Create a Business managed by him
        $business = $this->createBusinessOwnedBy($demoManagerUser);

        // Create a Demo Guest User
        $demoGuestUser = $this->createDemoGuestUser();

        // Create a Contact for Guest User
        $contact = $this->createDemoGuestUserContact($demoGuestUser);

        // Put the Contact into the Business addressbok
        $this->makeUserGuestContactOf($contact, $business);

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

    private function createDemoManagerUser()
    {
        // Create demo user (Business Manager)
        $user = factory(User::class)->make();
        $user->email = 'demo@timegrid.io';
        $user->password = bcrypt('demomanager');
        $user->save();

        return $user;
    }

    private function createDemoGuestUser()
    {
        // Create demo user (Business Guest)
        $user = factory(User::class)->make();
        $user->email = 'guest@example.org';
        $user->password = bcrypt('demoguest');
        $user->save();

        return $user;
    }

    private function createRandomGuestUser()
    {
        // Create random guest user (Business Guest)
        $user = factory(User::class)->make();
        $user->save();

        return $user;
    }

    private function createBusinessOwnedBy(User $user)
    {
        // Create demo Business
        $business = factory(Business::class)->make();
        $business->save();
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
        $contact->save();

        return $contact;
    }

    private function makeUserGuestContactOf(Contact $contact, Business $business)
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
        } catch (\Illuminate\Database\QueryException $e) {
            // We are Ok with getting some key collisions since
            // dates are generated randomly
        }

        return $vacancy;
    }

    private function generateDemoAddressBook(Business $business, $limit = 100)
    {
        for($i = 0; $i<=$limit; $i++)
        {
            $contact = $this->createDemoGuestUserContact();
            $this->makeUserGuestContactOf($contact, $business);
        }

        return $this;
    }
}
