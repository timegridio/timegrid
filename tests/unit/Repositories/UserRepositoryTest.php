<?php

use App\TG\Repositories\UserRepository;

class UserRepositoryTest extends TestCase
{
    use CreateUser;

    /**
     * @var UserRepository
     */
    protected $users;

    public function setUp()
    {
        parent::setUp();

        $this->users = new UserRepository();
    }

    /**
     * @test
     */
    public function it_finds_a_user_by_email()
    {
        $user = $this->createUser();

        $retrievedUser = $this->users->findOrCreate($user);

        $this->assertEquals($retrievedUser->email, $user->email);
    }

    /**
     * @test
     */
    public function it_creates_a_user_when_not_found()
    {
        $user = $this->makeUser();

        $retrievedUser = $this->users->findOrCreate($user);

        $this->assertEquals($retrievedUser->email, $user->email);
    }
}
