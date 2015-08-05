<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\Authenticatable as User;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessFormRequest;
use App\Http\Requests\BusinessPreferencesFormRequest;
use App\Http\Requests;
use App\Business;
use App\Category;
use Notifynder;
use Request;
use Session;
use Flash;
use GeoIP;
use Log;

class BusinessController extends Controller
{
    /**
     * index
     *
     * @return Response Rendered view for Businesses listing
     */
    public function index()
    {
        Log::info('Manager\BusinessController: index');
        $businesses = \Auth::user()->businesses;
        if ($businesses->count()==1) {
            Log::info('Manager\BusinessController: index: Only one business to show');
            $business = $businesses->first();
            return Redirect::route('manager.business.show', $business);
        }
        return view('manager.businesses.index', compact('businesses'));
    }

    /**
     * create Business
     *
     * @return Response Rendered view of Business creation form
     */
    public function create()
    {
        $plan = Request::query('plan') ?: 'free';
        Log::info("Manager\BusinessController: create: plan:$plan");
        Flash::success(trans('manager.businesses.msg.create.success', ['plan' => trans("pricing.plan.$plan.name")]));

        $location = GeoIP::getLocation();
        $timezone = $location['timezone'];
        Log::info("Manager\BusinessController: create: timezone:$timezone location:".serialize($location));

        $categories = Category::lists('slug', 'id')->transform(function ($item, $key) { return trans('app.business.category.'.$item); });
        return view('manager.businesses.create', compact('timezone', 'categories', 'plan'));
    }

    /**
     * store Business
     *
     * @param  BusinessFormRequest $request Business form Request
     * @return Response                     Redirect
     */
    public function store(BusinessFormRequest $request)
    {
        Log::info('Manager\BusinessController: store');
        $existing_business = Business::withTrashed()->where(['slug' => Request::input('slug')])->first();

        if ($existing_business === null) {

            $business = new Business(Request::all());
            $category = Category::find(Request::get('category'));
            $business->strategy = $category->strategy;
            $business->category()->associate($category);
            $business->save();
            \Auth::user()->businesses()->attach($business);
            \Auth::user()->save();

            $business_name = $business->name;
            Notifynder::category('user.registeredBusiness')
                       ->from('App\User', \Auth::user()->id)
                       ->to('App\Business', $business->id)
                       ->url('http://localhost')
                       ->extra(compact('business_name'))
                       ->send();

            Flash::success(trans('manager.businesses.msg.store.success'));
            return Redirect::route('manager.business.service.create', $business);
        }

        Log::info("Manager\BusinessController: store: [ADVICE] Found existing businessId:{$existing_business->id}");
        if (\Auth::user()->isOwner($existing_business)) {
            Log::info("Manager\BusinessController: store: [ADVICE] Restoring owned businessId:{$existing_business->id}");
            $existing_business->restore();
            Flash::success(trans('manager.businesses.msg.store.restored_trashed'));
        } else {
            Log::info("Manager\BusinessController: store: [ADVICE] Business already taken businessId:{$existing_business->id}");
            Flash::error(trans('manager.businesses.msg.store.business_already_exists'));
        }
        return Redirect::route('manager.business.index');
    }

    /**
     * show Business
     *
     * @param  Business            $business Business to show
     * @param  BusinessFormRequest $request  Business form Request
     * @return Response                      Rendered view for Business show
     */
    public function show(Business $business, BusinessFormRequest $request)
    {
        Log::info("Manager\BusinessController: show: businessId:{$business->id}");

        Session::set('selected.business', $business);
        $notifications = $business->getNotificationsNotRead(100);
        $business->readAllNotifications();
        return view('manager.businesses.show', compact('business', 'notifications'));
    }

    /**
     * edit Business
     *
     * @param  Business            $business Business to edit
     * @param  BusinessFormRequest $request  Business form Request
     * @return Response                      Rendered view of Business edit form
     */
    public function edit(Business $business, BusinessFormRequest $request)
    {
        Log::info("Manager\BusinessController: edit: businessId:{$business->id}");
        $location = GeoIP::getLocation();
        $timezone = in_array($business->timezone, \DateTimeZone::listIdentifiers()) ? $business->timezone : $timezone = $location['timezone'];
        $categories = Category::lists('slug', 'id')->transform(function ($item, $key) { return trans('app.business.category.'.$item); });
        $category = $business->category_id;
        Log::info("Manager\BusinessController: edit: businessId:{$business->id} timezone:$timezone category:$category location:".serialize($location));
        return view('manager.businesses.edit', compact('business', 'category', 'categories', 'timezone'));
    }

    /**
     * update Business
     *
     * @param  Business            $business Business to update
     * @param  BusinessFormRequest $request  Business form Request
     * @return Response                      Redirect
     */
    public function update(Business $business, BusinessFormRequest $request)
    {
        Log::info("Manager\BusinessController: update: businessId:{$business->id}");
        $business->update([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'description' => $request->get('description'),
            'timezone' => $request->get('timezone'),
            'postal_address' => $request->get('postal_address'),
            'phone' => $request->get('phone'),
            'social_facebook' => $request->get('social_facebook'),
            'strategy' => $request->get('strategy')
        ]);

        Flash::success(trans('manager.businesses.msg.update.success'));
        return \Redirect::route('manager.business.show', array($business->id));
    }

    /**
     * destroy Business
     *
     * @param  Business            $business Business to destroy
     * @param  BusinessFormRequest $request  Business form Request
     * @return Response                      Redirect to Businesses index
     */
    public function destroy(Business $business, BusinessFormRequest $request)
    {
        Log::info("Manager\BusinessController: destroy: businessId:{$business->id}");
        $business->delete();

        Flash::success(trans('manager.businesses.msg.destroy.success'));
        return \Redirect::route('manager.business.index');
    }

    //////////////////////////
    // Business Preferences //
    //////////////////////////

    /**
     * get Preferences
     *
     * @param  Business                       $business Business to edit preferences
     * @param  BusinessPreferencesFormRequest $request  Request
     * @return Response                                 Rendered settings form
     */
    public function getPreferences(Business $business, BusinessPreferencesFormRequest $request)
    {
        $parameters = \Config::get('preferences.App\Business');
        $preferences = $business->preferences;
        return view('manager.businesses.preferences.edit', compact('business', 'preferences', 'parameters'));
    }

    /**
     * post Preferences
     *
     * @param  Business                       $business Business to update preferences
     * @param  BusinessPreferencesFormRequest $request  Request
     * @return Response                                 Redirect
     */
    public function postPreferences(Business $business, BusinessPreferencesFormRequest $request)
    {
        Log::info("Manager\BusinessController: postPreferences: businessId:{$business->id}");
        $parameters = \Config::get('preferences.App\Business');
        $parameters_keys = array_flip(array_keys($parameters));
        $preferences = $request->all();
        $preferences = array_intersect_key($preferences, $parameters_keys);
        
        foreach ($preferences as $key => $value) {
            Log::info("Manager\BusinessController: postPreferences: businessId:{$business->id} key:$key value:$value type:{$parameters[$key]['type']}");
            $business->pref($key, $value, $parameters[$key]['type']);
        }

        $business_name = $business->name;
        Notifynder::category('user.updatedBusinessPreferences')
                   ->from('App\User', \Auth::user()->id)
                   ->to('App\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('business_name'))
                   ->send();

        Flash::success(trans('manager.businesses.msg.preferences.success'));
        return \Redirect::route('manager.business.show', $business);
    }
}
