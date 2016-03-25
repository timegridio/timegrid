<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\BusinessAlreadyRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessFormRequest;
use App\Services\BusinessService;
use Carbon\Carbon;
use Fenos\Notifynder\Facades\Notifynder;
use Illuminate\Support\Facades\Request;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Category;

class BusinessController extends Controller
{
    /**
     * Location data.
     *
     * @var array
     */
    protected $location = null;

    /**
     * Business service.
     *
     * @var App\Services\BusinessService
     */
    private $businessService;

    /**
     * Current localized time.
     *
     * @var Carbon\Carbon
     */
    private $time;

    /**
     * Create Controller.
     *
     * @param App\Services\BusinessService $businessService
     */
    public function __construct(BusinessService $businessService, Carbon $time)
    {
        $this->businessService = $businessService;

        $this->time = $time;

        parent::__construct();
    }

    /**
     * List all businesses.
     *
     * @return Response Rendered view for Businesses listing
     */
    public function index()
    {
        logger()->info(__METHOD__);

        // BEGIN

        $businesses = auth()->user()->businesses;

        if ($businesses->count() == 1) {
            logger()->info('Only one business to show');

            flash()->success(trans('manager.businesses.msg.index.only_one_found'));

            return redirect()->route('manager.business.show', $businesses->first());
        }

        return view('manager.businesses.index', compact('businesses'));
    }

    /**
     * create Business.
     *
     * @return Response Rendered view of Business creation form
     */
    public function create($plan = 'free')
    {
        logger()->info(__METHOD__);
        logger()->info("plan:$plan");

        // BEGIN

        $timezone = $this->guessTimezone(null);

        $countryCode = $this->getCountry();

        $locale = app()->getLocale();

        $categories = $this->listCategories();

        $business = new Business();

        return view('manager.businesses.create', compact(
            'business',
            'timezone',
            'categories',
            'plan',
            'countryCode',
            'locale'
        ));
    }

    /**
     * store Business.
     *
     * @param BusinessFormRequest $request Business form Request
     *
     * @return Response Redirect
     */
    public function store(BusinessFormRequest $request)
    {
        logger()->info(__METHOD__);

        // BEGIN

        try {
            $business = $this->businessService->register(auth()->user(), $request->all(), $request->get('category'));
        } catch (BusinessAlreadyRegistered $exception) {
            flash()->error(trans('manager.businesses.msg.store.business_already_exists'));

            return redirect()->back()->withInput(request()->all());
        }

        // Generate local notification
        $businessName = $business->name;
        Notifynder::category('user.registeredBusiness')
            ->from('App\Models\User', auth()->user()->id)
            ->to('Timegridio\Concierge\Models\Business', $business->id)
            ->url('http://localhost')
            ->extra(compact('businessName'))
            ->send();

        // Redirect success
        flash()->success(trans('manager.businesses.msg.store.success'));

        return redirect()->route('manager.business.service.create', $business);
    }

    /**
     * show Business.
     *
     * @param Business            $business Business to show
     * @param BusinessFormRequest $request  Business form Request
     *
     * @return Response Rendered view for Business show
     */
    public function show(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manage', $business);

        // BEGIN

        session()->set('selected.business', $business);

        $notifications = Notifynder::entity(Business::class)->getNotRead($business->id, 20);

        Notifynder::entity(Business::class)->readAll($business->id);

        $this->time->timezone($business->timezone);

        // Build Dashboard Report
        $dashboard['appointments_active_today'] = $business->bookings()->active()->ofDate($this->time->now())->get()->count();
        $dashboard['appointments_annulated_today'] = $business->bookings()->annulated()->ofDate($this->time->now())->get()->count();
        $dashboard['appointments_active_tomorrow'] = $business->bookings()->active()->ofDate($this->time->tomorrow())->get()->count();
        $dashboard['appointments_active_total'] = $business->bookings()->active()->get()->count();
        $dashboard['appointments_served_total'] = $business->bookings()->served()->get()->count();
        $dashboard['appointments_total'] = $business->bookings()->get()->count();

        $dashboard['contacts_registered'] = $business->contacts()->count();
        $dashboard['contacts_subscribed'] = $business->contacts()->whereNotNull('user_id')->count();

        $time = $this->time->toTimeString();

        return view('manager.businesses.show', compact('business', 'notifications', 'dashboard', 'time'));
    }

    /**
     * edit Business.
     *
     * @param Business $business Business to edit
     *
     * @return Response Rendered view of Business edit form
     */
    public function edit(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('update', $business);

        // BEGIN

        $timezone = $this->guessTimezone($business->timezone);

        $categories = $this->listCategories();

        $category = $business->category_id;

        logger()->info(sprintf('businessId:%s timezone:%s category:%s', $business->id, $timezone, $category));

        return view('manager.businesses.edit', compact('business', 'category', 'categories', 'timezone'));
    }

    /**
     * update Business.
     *
     * @param Business            $business Business to update
     * @param BusinessFormRequest $request  Business form Request
     *
     * @return Response Redirect
     */
    public function update(Business $business, BusinessFormRequest $request)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('update', $business);

        // BEGIN
        $category = $request->get('category');

        $data = [
                'name'            => $request->get('name'),
                'description'     => $request->get('description'),
                'timezone'        => $request->get('timezone'),
                'postal_address'  => $request->get('postal_address'),
                'phone'           => $request->get('phone'),
                'social_facebook' => $request->get('social_facebook'),
        ];

        $this->businessService->update($business, $data);

        $this->businessService->setCategory($business, $category);

        flash()->success(trans('manager.businesses.msg.update.success'));

        return redirect()->route('manager.business.show', compact('business'));
    }

    /**
     * destroy Business.
     *
     * @param Business $business Business to destroy
     *
     * @return Response Redirect to Businesses index
     */
    public function destroy(Business $business)
    {
        logger()->info(__METHOD__);

        $this->authorize('destroy', $business);

        logger()->info(sprintf('Deactivating: businessId:%s', $business->id));
        // BEGIN

        $this->businessService->deactivate($business);

        flash()->success(trans('manager.businesses.msg.destroy.success'));

        return redirect()->route('manager.business.index');
    }

    /////////////
    // HELPERS //
    /////////////

    /**
     * get business category list.
     *
     * TODO: SHOULD BE USED WITH VIEW COMPOSER
     *
     * @return array list of categories for combo
     */
    protected function listCategories()
    {
        return Category::pluck('slug', 'id')->transform(
            function ($item) {
                return trans('app.business.category.'.$item);
            }
        );
    }

    /**
     * guess user (client) timezone.
     *
     * @param string $timezone Default or fallback timezone
     *
     * @return string Guessed or fallbacked timezone
     */
    protected function guessTimezone($timezone = null)
    {
        if (!empty($timezone)) {
            return $timezone;
        }

        $this->getLocation();

        logger()->info(sprintf('TIMEZONE FALLBACK="%s" GUESSED="%s"', $timezone, $this->location['timezone']));

        $identifiers = timezone_identifiers_list();

        return in_array($this->location['timezone'], $identifiers) ? $this->location['timezone'] : $timezone;
    }

    protected function getCountry()
    {
        $this->getLocation();

        return array_get($this->location, 'isoCode', null);
    }

    protected function getLocation()
    {
        if ($this->location === null) {
            logger()->info('Getting location');

            $geoip = app('geoip');

            $this->location = $geoip->getLocation();

            logger()->info(serialize($this->location));
        }

        return $this->location;
    }
}
