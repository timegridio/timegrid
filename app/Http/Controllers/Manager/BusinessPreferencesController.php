<?php

namespace App\Http\Controllers\Manager;

use Gate;
use App\Models\Business;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Fenos\Notifynder\Facades\Notifynder;

class BusinessPreferencesController extends Controller
{
    /**
     * get Preferences
     *
     * @param  Business      $business Business to edit preferences
     * @return Response      Rendered settings form
     */
    public function getPreferences(Business $business)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf("businessId:%s", $business->id));

        if (Gate::denies('managePreferences', $business)) {
            abort(403);
        }

        $parameters = config()->get('preferences.App\Models\Business');
        $preferences = $business->preferences;
        return view('manager.businesses.preferences.edit', compact('business', 'preferences', 'parameters'));
    }

    /**
     * post Preferences
     *
     * @param  Business    $business Business to update preferences
     * @param  Request     $request
     * @return Response    Redirect
     */
    public function postPreferences(Business $business, Request $request)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf("businessId:%s", $business->id));

        if (Gate::denies('managePreferences', $business)) {
            abort(403);
        }

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $this->setBusinessPreferences($business, $request->all());

        $business_name = $business->name;
        Notifynder::category('user.updatedBusinessPreferences')
                   ->from('App\Models\User', auth()->user()->id)
                   ->to('App\Models\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('business_name'))
                   ->send();

        Flash::success(trans('manager.businesses.msg.preferences.success'));
        return redirect()->route('manager.business.show', $business);
    }

    /////////////
    // HELPERS //
    /////////////

    protected function setBusinessPreferences(Business $business, $preferences)
    {
        // Get parameters from app configuration
        $parameters = config()->get('preferences.App\Models\Business');
        
        // Get the keys of the parameters
        $parametersKeys = array_flip(array_keys($parameters));

        // Merge the user input with the parameter keys
        $mergedPreferences = array_intersect_key($preferences, $parametersKeys);
        
        // Store each parameter key-value pair to the business preferences
        foreach ($mergedPreferences as $key => $value) {
            $this->log->info(
                sprintf("set preference: businessId:%s key:%s='%s' type:%s",
                $business->id,
                $key,
                $value,
                $parameters[$key]['type']
                ));

            $business->pref($key, $value, $parameters[$key]['type']);
        }
    }
}
