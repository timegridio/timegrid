<?php

namespace App\Http\Controllers\Manager;

use Gate;
use GeoIP;
use App\Models\Category;
use App\Models\Business;
use Laracasts\Flash\Flash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Fenos\Notifynder\Facades\Notifynder;
use App\Http\Requests\BusinessFormRequest;
use App\Http\Requests\BusinessPreferencesFormRequest;

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

        if ($businesses->count()==1) {
            $this->log->info('Manager\BusinessController: index: Only one business to show');
            $business = $businesses->first();
            Flash::success(trans('manager.businesses.msg.index.only_one_found'));
            return redirect()->route('manager.business.show', $business);
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
        $this->log->info(__METHOD__);

        $plan = Request::query('plan') ?: 'free';
        $this->log->info("Manager\BusinessController: create: plan:$plan");

        $location = GeoIP::getLocation();
        $timezone = $location['timezone'];
        $this->log->info("Manager\BusinessController: create: timezone:$timezone location:".serialize($location));

        $categories = Category::lists('slug', 'id')->transform(
            function ($item, $key) {
                return trans('app.business.category.'.$item);
            }
        );

        Flash::success(trans('manager.businesses.msg.create.success', ['plan' => trans("pricing.plan.$plan.name")]));
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
        $this->log->info(__METHOD__);

        // Search Existing
        $existingBusiness = Business::withTrashed()->where(['slug' => $request->input('slug')])->first();

        // If found
        if ($existingBusiness !== null) {
            $this->log->info("  Found existing businessId:{$existingBusiness->id}");

            // If owned, restore
            if (auth()->user()->isOwner($existingBusiness)) {
                $this->log->info("  Restoring owned businessId:{$existingBusiness->id}");
                $existingBusiness->restore();
                Flash::success(trans('manager.businesses.msg.store.restored_trashed'));
                return redirect()->route('manager.business.service.create', $existingBusiness);
            }

            # If not owned, return message
            $this->log->info("  Already taken businessId:{$existingBusiness->id}");
            Flash::error(trans('manager.businesses.msg.store.business_already_exists'));
            return redirect()->route('manager.business.index');
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
        $business_name = $business->name;
        Notifynder::category('user.registeredBusiness')
                   ->from('App\Models\User', auth()->user()->id)
                   ->to('App\Models\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('business_name'))
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
        $this->log->info(sprintf("  businessId:%s", 
                                    $business->id
                                ));

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
        $this->log->info(sprintf("  businessId:%s", 
                                    $business->id
                                ));

        if (Gate::denies('update', $business)) {
            abort(403);
        }

        $location = GeoIP::getLocation();
        $timezone = in_array($business->timezone, \DateTimeZone::listIdentifiers()) ? $business->timezone : $timezone = $location['timezone'];
        $categories = Category::lists('slug', 'id')->transform(
            function ($item, $key) {
                return trans('app.business.category.'.$item);
            }
        );
        
        $category = $business->category_id;
        $this->log->info("  businessId:{$business->id} timezone:$timezone" .
                         "category:$category location:".serialize($location));
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
        $this->log->info(sprintf("  businessId:%s", 
                                    $business->id
                                ));

        if (Gate::denies('update', $business)) {
            abort(403);
        }

        $category = Category::find(Request::get('category'));
        $business->category()->associate($category);

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
        return redirect()->route('manager.business.show', array($business->id));
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
        $this->log->info(sprintf("  businessId:%s", 
                                    $business->id
                                ));

        if (Gate::denies('destroy', $business)) {
            abort(403);
        }

        $business->delete();

        Flash::success(trans('manager.businesses.msg.destroy.success'));
        return redirect()->route('manager.business.index');
    }
}
