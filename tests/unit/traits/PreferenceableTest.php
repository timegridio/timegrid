<?php

use App\Tests\Helpers\Stubs\PreferenceableStub;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PreferenceableTest extends TestCase
{
    use DatabaseTransactions;

    protected $preferenceable;

    /**
     * @test
     */
    public function it_has_preferences()
    {
        $preferenceableModel = new PreferenceableStub();

        $this->assertInstanceOf(MorphMany::class, $preferenceableModel->preferences());
    }

    /**
     * @test
     */
    public function it_sets_and_gets_a_string_preference()
    {
        $this->arrangeScenario();

        $setValue = 'string';

        $this->preferenceable->pref('test-preference', $setValue);

        $getValue = $this->preferenceable->pref('test-preference');

        $this->assertEquals($setValue, $getValue);
    }

    /**
     * @test
     */
    public function it_sets_and_gets_a_bool_preference()
    {
        $this->arrangeScenario();

        $setValue = true;

        $this->preferenceable->pref('test-preference', $setValue, 'bool');

        $getValue = $this->preferenceable->pref('test-preference');

        $this->assertEquals($setValue, $getValue);
    }

    /**
     * @test
     */
    public function it_sets_and_gets_a_int_preference()
    {
        $this->arrangeScenario();

        $setValue = 5;

        $this->preferenceable->pref('test-preference', $setValue, 'int');

        $getValue = $this->preferenceable->pref('test-preference');

        $this->assertEquals($setValue, $getValue);
    }

    /**
     * @test
     */
    public function it_sets_and_gets_a_float_preference()
    {
        $this->arrangeScenario();

        $setValue = 5.9;

        $this->preferenceable->pref('test-preference', $setValue, 'float');

        $getValue = $this->preferenceable->pref('test-preference');

        $this->assertEquals($setValue, $getValue);
    }

    /**
     * @test
     */
    public function it_sets_and_gets_a_unknown_type_preference()
    {
        $this->arrangeScenario();

        $setValue = 'sample';

        $this->preferenceable->pref('test-preference', $setValue, 'other');

        $getValue = $this->preferenceable->pref('test-preference');

        $this->assertEquals($setValue, $getValue);
    }

    /////////////
    // Helpers //
    /////////////

    protected function arrangeScenario()
    {
        $this->preferenceable = new PreferenceableStub(['id' => 1]);
    }
}
