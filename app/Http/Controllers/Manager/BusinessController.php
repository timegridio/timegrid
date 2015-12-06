<?php

namespace App\Http\Controllers\Manager;

use Gate;
use GeoIP;
use App\SearchEngine;
use App\Models\Business;
use App\Models\Category;
use Laracasts\Flash\Flash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Fenos\Notifynder\Facades\Notifynder;
use App\Http\Requests\BusinessFormRequest;

class BusinessController extends Controller
{
    /**
     * index
     *
     * @return Response Rendered view for Businesses listing
     */
    public function index()
    {
        $this->log->info(__METHOD__);

        $businesses = auth()->user()->businesses;

        if ($businesses->count() == 1) {
            $this->log->info('Only one business to show');
            Flash::success(trans('manager.businesses.msg.index.only_one_found'));
            return redirect()->route('manager.business.show', $businesses->first());
        }

        return view('manager.businesses.index', compact('businesses'));
    }

    /**
     * create Business
     *
     * @return Response Rendered view of Business creation form
     */
    public function create($plan = 'free')
    {
        $this->log->info(__METHOD__);

        # $plan = Request::query('plan') ?: 'free';
        $this->log->info("plan:$plan");

        $timezone = $this->guessTimezone(null);

        $categories = $this->listCategories();

        $business = new Business;
        Flash::success(trans('manager.businesses.msg.register', ['plan' => trans($plan)]));
        return view('manager.businesses.create', compact('business', 'timezone', 'categories', 'plan'));
    }

    /**
     * store Business
     *
     * @param  BusinessFormRequest $request Business form Request
     * @return Response                     Redirect
     */
    public function store(BusinessFormRequest $request)
    {
        $this->log->info(__METHOD__);

        //////////////////
        // FOR REFACTOR //
        //////////////////

        // Search Existing
        $existingBusiness = Business::withTrashed()->where(['slug' => $request->input('slug')])->first();

        // If found
        if ($existingBusiness !== null) {
            $this->log->info("  Found existing businessId:{$existingBusiness->id}");

            // If owned, restore
            if (auth()->user()->isOwner($existingBusiness->id)) {
                $this->log->info("  Restoring owned businessId:{$existingBusiness->id}");
                $existingBusiness->restore();

                Flash::success(trans('manager.businesses.msg.store.restored_trashed'));
                return redirect()->route('manager.business.service.create', $existingBusiness);
            }

            // If not owned, return message
            $this->log->info("  Already taken businessId:{$existingBusiness->id}");
            Flash::error(trans('manager.businesses.msg.store.business_already_exists'));
            return redirect()->back()->withInput(request()->all());
        }

        // Register new Business
        $business = new Business($request->all());
        $category = Category::find($request->get('category'));
        $business->strategy = $category->strategy;
        $business->category()->associate($category);
        $business->save();

        auth()->user()->businesses()->attach($business);
        auth()->user()->save();

        // Generate local notification
        $businessName = $business->name;
        Notifynder::category('user.registeredBusiness')
        ->from('App\Models\User', auth()->user()->id)
        ->to('App\Models\Business', $business->id)
        ->url('http://localhost')
        ->extra(compact('businessName'))
        ->send();

        // Redirect success
        Flash::success(trans('manager.businesses.msg.store.success'));
        return redirect()->route('manager.business.service.create', $business);
    }

    /**
     * show Business
     *
     * @param  Business            $business Business to show
     * @param  BusinessFormRequest $request  Business form Request
     * @return Response                      Rendered view for Business show
     */
    public function show(Business $business)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf("businessId:%s", $business->id));

        if (Gate::denies('manage', $business)) {
            abort(403);
        }

        session()->set('selected.business', $business);
        $notifications = $business->getNotificationsNotRead(100);
        $business->readAllNotifications();

        return view('manager.businesses.show', compact('business', 'notifications'));
    }

    /**
     * edit Business
     *
     * @param  Business            $business Business to edit
     * @return Response                      Rendered view of Business edit form
     */
    public function edit(Business $business)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf("businessId:%s", $business->id));

        if (Gate::denies('update', $business)) {
            abort(403);
        }

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $timezone = $this->guessTimezone($business->timezone);

        $categories = $this->listCategories();
        
        $category = $business->category_id;
        
        $this->log->info(sprintf("businessId:%s timezone:%s category:%s", $business->id, $timezone, $category));

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
        $this->log->info(__METHOD__);
        $this->log->info(sprintf("businessId:%s", $business->id));

        if (Gate::denies('update', $business)) {
            abort(403);
        }

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $category = Category::find(Request::get('category'));
        $business->category()->associate($category);

        $business->update([
            'slug' => $business->slug
            ], [
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'timezone' => $request->get('timezone'),
            'postal_address' => $request->get('postal_address'),
            'phone' => $request->get('phone'),
            'social_facebook' => $request->get('social_facebook'),
            'strategy' => $request->get('strategy')
            ]);

        Flash::success(trans('manager.businesses.msg.update.success'));
        return redirect()->route('manager.business.show', compact('business'));
    }

    /**
     * destroy Business
     *
     * @param  Business            $business Business to destroy
     * @return Response                      Redirect to Businesses index
     */
    public function destroy(Business $business)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf("businessId:%s", $business->id));

        if (Gate::denies('destroy', $business)) {
            abort(403);
        }
        
        //////////////////
        // FOR REFACOTR //
        //////////////////

        $business->delete();

        Flash::success(trans('manager.businesses.msg.destroy.success'));
        return redirect()->route('manager.business.index');
    }

    ////////////
    // SEARCH //
    ////////////

    /**
     * search elements in a business
     *
     * @param  Request $request Search criteria
     * @return Response         View with results or redirect to default
     */
    public function postSearch()
    {
        if (! session()->get('selected.business')) {
            return redirect()->route('user.directory.list');
        }

        $criteria = Request::input('criteria');
        
        $search = new SearchEngine($criteria);
        $search->setBusinessScope([session()->get('selected.business')->id])->run();

        return view('manager.search.index')->with(['results' => $search->results(), 'criteria' => $criteria]);
    }

    /////////////
    // HELPERS //
    /////////////

    /**
     * get business category list
     *
     * @return Array list of categories for combo
     */
    protected function listCategories()
    {
        return Category::lists('slug', 'id')->transform(
            function ($item) {
                return trans('app.business.category.'.$item);
            }
        );
    }

    /**
     * guess user (client) timezone
     *
     * @param  string $timezone Default or fallback timezone
     * @return string           Guessed or fallbacked timezone
     */
    protected function guessTimezone($timezone = null)
    {
        if (!empty($timezone)) {
            return $timezone;
        }

        $location = GeoIP::getLocation();

        $this->log->info(sprintf("Fallback timezone:%s Guessed timezone:%s", $timezone, $location['timezone']));

        return in_array($location['timezone'], \DateTimeZone::listIdentifiers()) ? $location['timezone'] : $timezone;
    }
}
