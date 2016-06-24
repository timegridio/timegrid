<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserPreferencesController extends Controller
{
    protected $user;

    public function __construct()
    {
        parent::__construct();

        $this->user = auth()->user();
    }

    public function getPreferences()
    {
        logger()->info(__CLASS__.':'.__METHOD__);

        // BEGIN

        $parameters = config()->get('preferences.App\Models\User');
        $preferences = $this->user->preferences;

        return view('user.preferences.edit', compact('preferences', 'parameters'));
    }

    public function postPreferences(Request $request)
    {
        logger()->info(__CLASS__.':'.__METHOD__);

        // BEGIN

        $this->setUserPreferences($request->all());

        flash()->success(trans('user.msg.preferences.success'));

        return redirect()->back();
    }

    /////////////
    // HELPERS //
    /////////////

    protected function setUserPreferences($preferences)
    {
        // Get parameters from app configuration
        $parameters = config()->get('preferences.App\Models\User');

        // Get the keys of the parameters
        $parametersKeys = array_flip(array_keys($parameters));

        // Merge the user input with the parameter keys
        $mergedPreferences = array_intersect_key($preferences, $parametersKeys);

        foreach ($mergedPreferences as $key => $value) {
            logger()->info(sprintf(
                "set preference: UserId:%s key:%s='%s' type:%s",
                $this->user->id,
                $key,
                $value,
                $parameters[$key]['type']
            ));

            $this->user->pref($key, $value, $parameters[$key]['type']);
        }
    }
}
