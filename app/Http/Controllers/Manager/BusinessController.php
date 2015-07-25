<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Business;
use App\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\Authenticatable as User;
use App\Http\Requests\BusinessFormRequest;
use App\Http\Requests\BusinessPreferencesFormRequest;
use Notifynder;
use Session;
use Request;
use Flash;
use GeoIP;

class BusinessController extends Controller
{
    public function index()
    {
        $businesses = \Auth::user()->businesses;
        if ($businesses->count()==1) {
            $business = $businesses->first();
            return Redirect::route('manager.business.show', $business);
        }
        return view('manager.businesses.index', compact('businesses'));
    }

    public function create()
    {
        $location = GeoIP::getLocation();
        $timezone = $location['timezone'];
        $categories = Category::lists('slug', 'id')->transform(function ($item, $key) { return trans('app.business.category.'.$item); });
        return view('manager.businesses.create', compact('timezone', 'categories'));
    }

    public function store(BusinessFormRequest $request)
    {
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

        if (\Auth::user()->isOwner($existing_business)) {
            $existing_business->restore();
            Flash::success(trans('manager.businesses.msg.store.restored_trashed'));
        } else {
            Flash::error(trans('manager.businesses.msg.store.business_already_exists'));
        }
        return Redirect::route('manager.business.index');
    }

    public function show(Business $business, BusinessFormRequest $request)
    {
        Session::set('selected.business', $business);
        $notifications = $business->getNotificationsNotRead(100);
        $business->readAllNotifications();
        return view('manager.businesses.show', compact('business', 'notifications'));
    }

    public function edit(Business $business, BusinessFormRequest $request)
    {
        $location = GeoIP::getLocation();
        $timezone = in_array($business->timezone, \DateTimeZone::listIdentifiers()) ? $business->timezone : $timezone = $location['timezone'];
        $categories = Category::lists('slug', 'id')->transform(function ($item, $key) { return trans('app.business.category.'.$item); });
        $category = $business->category_id;
        return view('manager.businesses.edit', compact('business', 'category', 'categories', 'timezone'));
    }

    public function update(Business $business, BusinessFormRequest $request)
    {
        $business->update([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'description' => $request->get('description'),
            'timezone' => $request->get('timezone'),
            'postal_address' => $request->get('postal_address'),
            'phone' => $request->get('phone'),
            'strategy' => $request->get('strategy')
        ]);

        Flash::success(trans('manager.businesses.msg.update.success'));
        return \Redirect::route('manager.business.show', array($business->id));
    }

    public function destroy(Business $business, BusinessFormRequest $request)
    {
        $business->delete();

        Flash::success(trans('manager.businesses.msg.destroy.success'));
        return \Redirect::route('manager.business.index');
    }

    public function getPreferences(Business $business, BusinessPreferencesFormRequest $request)
    {
        $parameters = \Config::get('preferences.App\Business');
        $preferences = $business->preferences;
        return view('manager.businesses.preferences.edit', compact('business', 'preferences', 'parameters'));
    }

    public function postPreferences(Business $business, BusinessPreferencesFormRequest $request)
    {
        $parameters = \Config::get('preferences.App\Business');
        $parameters_keys = array_flip(array_keys($parameters));
        $preferences = $request->all();
        $preferences = array_intersect_key($preferences, $parameters_keys);
        
        foreach ($preferences as $key => $value) {
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
