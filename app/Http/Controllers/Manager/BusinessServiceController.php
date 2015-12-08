<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Service;
use Flash;
use Illuminate\Http\Request;

class BusinessServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Business $business)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        $services = $business->services;

        return view('manager.businesses.services.index', compact('business', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Business $business)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        $service = new Service(); // For Form Model Binding
        return view('manager.businesses.services.create', compact('business', 'service'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Business $business, Request $request)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $service = Service::firstOrNew($request->except('_token'));
        $service->business()->associate($business->id);
        $service->save();

        $this->log->info("Stored serviceId:{$service->id}");

        Flash::success(trans('manager.service.msg.store.success'));

        return redirect()->route('manager.business.service.index', [$business]);
    }

    /**
     * Display the specified resource.
     *
     * @param Business $business Business to show service of
     * @param Service  $service  Service to show
     *
     * @return Response
     */
    public function show(Business $business, Service $service)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s serviceId:%s', $business->id, $service->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        return view('manager.businesses.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Business $business Business to edit service of
     * @param Service  $service  Service to edit
     *
     * @return Response
     */
    public function edit(Business $business, Service $service)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s serviceId:%s', $business->id, $service->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        return view('manager.businesses.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Business $business Business to update service of
     * @param Service  $service  Service to update
     *
     * @return Response
     */
    public function update(Business $business, Service $service, Request $request)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s serviceId:%s', $business->id, $service->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $service->update([
            'name'            => $request->get('name'),
            'description'     => $request->get('description'),
            'prerequisites'   => $request->get('prerequisites'),
        ]);

        Flash::success(trans('manager.business.service.msg.update.success'));

        return redirect()->route('manager.business.service.show', [$business, $service]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Business $business Business to destroy service of
     * @param Service  $service  Service to destroy
     *
     * @return Response
     */
    public function destroy(Business $business, Service $service)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s serviceId:%s', $business->id, $service->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $service->forceDelete();

        Flash::success(trans('manager.services.msg.destroy.success'));

        return redirect()->route('manager.business.service.index', $business);
    }
}
