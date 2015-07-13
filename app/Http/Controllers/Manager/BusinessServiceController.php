<?php

namespace App\Http\Controllers\Manager;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use Flash;
use App\Business;
use App\Service;

class BusinessServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Business $business)
    {
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
        return view('manager.businesses.services.create', compact('business'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Business $business, Request $request)
    {
        $service = Service::firstOrNew(Request::except('_token'));
        $service->business()->associate($business->id);
        $service->save();

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
        $service->update([
            'name'            => $request->get('name'),
            'description'     => $request->get('description'),
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
        $service->forceDelete();

        Flash::success( trans('manager.services.msg.destroy.success') );
        return Redirect::route('manager.business.service.index', $business);
    }
}
