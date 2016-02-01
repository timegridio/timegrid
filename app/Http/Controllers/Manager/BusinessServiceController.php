<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Service;
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
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        return view('manager.businesses.services.index', compact('business'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        $types = $business->servicetypes->pluck('name', 'id');

        $service = new Service([
            'duration' => $business->pref('service_default_duration'),
        ]); // For Form Model Binding
        return view('manager.businesses.services.create', compact('business', 'service', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Business $business, Request $request)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $service = Service::firstOrNew($request->except('_token'));

        $service->business()->associate($business->id);

        if ($request->get('type_id')) {
            $service->type()->associate($request->get('type_id'));
        }

        $service->save();

        logger()->info("Stored serviceId:{$service->id}");

        flash()->success(trans('manager.service.msg.store.success'));

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
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s serviceId:%s', $business->id, $service->id));

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
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s serviceId:%s', $business->id, $service->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        $types = $business->servicetypes->pluck('name', 'id');

        return view('manager.businesses.services.edit', compact('service', 'types'));
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
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s serviceId:%s', $business->id, $service->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        //////////////////
        // FOR REFACTOR //
        //////////////////
        $service->update([
            'name'          => $request->get('name'),
            'color'         => $request->get('color'),
            'duration'      => $request->get('duration'),
            'description'   => $request->get('description'),
            'prerequisites' => $request->get('prerequisites'),
        ]);

        if ($request->get('type_id')) {
            $service->type()->associate($request->get('type_id'));
            $service->save();
        }

        flash()->success(trans('manager.business.service.msg.update.success'));

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
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s serviceId:%s', $business->id, $service->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $service->forceDelete();

        flash()->success(trans('manager.services.msg.destroy.success'));

        return redirect()->route('manager.business.service.index', $business);
    }
}
