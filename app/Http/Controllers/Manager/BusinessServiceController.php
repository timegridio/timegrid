<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Business;
use App\Service;
use Redirect;
use Flash;

class BusinessServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Business $business)
    {
        $this->log->info('BusinessServiceController: index');
        $services = $business->services;
        return view('manager.businesses.services.index', compact('business', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Business $business /* , ServiceFormRequest $request */)
    {
        $this->log->info("BusinessServiceController: create: businessId:{$business->id}");
        return view('manager.businesses.services.create', compact('business'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Business $business, Request $request)
    {
        $this->log->info("BusinessServiceController: store: businessId:{$business->id}");
        $service = Service::firstOrNew($request->except('_token'));
        $service->business()->associate($business->id);
        $service->save();
        $this->log->info("BusinessServiceController: create: businessId:{$business->id} serviceId:{$service->id}");

        Flash::success(trans('manager.service.msg.store.success'));
        return Redirect::route('manager.business.service.index', [$business]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Business $business, Service $service)
    {
        $this->log->info("BusinessServiceController: show: businessId:{$business->id} serviceId:{$service->id}");
        return view('manager.businesses.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Business $business, Service $service)
    {
        $this->log->info("BusinessServiceController: edit: businessId:{$business->id} serviceId:{$service->id}");
        return view('manager.businesses.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Business $business, Service $service, Request $request /*, ContactFormRequest $request */)
    {
        $this->log->info("BusinessServiceController: update: businessId:{$business->id} serviceId:{$service->id}");
        $service->update([
            'name'            => $request->get('name'),
            'description'     => $request->get('description'),
            'prerequisites'   => $request->get('prerequisites'),
        ]);

        Flash::success(trans('manager.business.service.msg.update.success'));
        return Redirect::route('manager.business.service.show', [$business, $service]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Business $business, Service $service)
    {
        $this->log->info("BusinessServiceController: destroy: businessId:{$business->id} serviceId:{$service->id}");
        $service->forceDelete();

        Flash::success(trans('manager.services.msg.destroy.success'));
        return Redirect::route('manager.business.service.index', $business);
    }
}
