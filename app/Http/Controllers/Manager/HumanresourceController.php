<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Humanresource;

class HumanresourceController extends Controller
{
    public function index(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageHumanresources', $business);

        $humanresources = $business->humanresources;

        return view('manager.businesses.humanresources.index', compact('business', 'humanresources'));
    }

    public function create(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageHumanresources', $business);

        // BEGIN //

        $humanresource = new Humanresource(); // For Form Model Binding
        return view('manager.businesses.humanresources.create', compact('business', 'humanresource'));
    }

    public function store(Business $business, Request $request)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageHumanresources', $business);

        // BEGIN //

        $humanresource = new Humanresource($request->all());

        $humanresource->business()->associate($business->id);

        $humanresource->save();

        flash()->success(trans('manager.humanresources.msg.store.success'));

        return redirect()->route('manager.business.humanresource.show', [$business, $humanresource]);
    }

    public function show(Business $business, Humanresource $humanresource)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s humanresourceId:%s', $business->id, $humanresource->id));

        $this->authorize('manageHumanresources', $business);

        // BEGIN //

        return view('manager.businesses.humanresources.show', compact('business', 'humanresource'));
    }

    public function edit(Business $business, Humanresource $humanresource)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s humanresourceId:%s', $business->id, $humanresource->id));

        $this->authorize('manageHumanresources', $business);

        // BEGIN //

        return view('manager.businesses.humanresources.edit', compact('business', 'humanresource'));
    }

    public function update(Business $business, Humanresource $humanresource, Request $request)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s humanresourceId:%s', $business->id, $humanresource->id));

        $this->authorize('manageHumanresources', $business);

        // BEGIN //

        $humanresource->fill($request->all());
        $humanresource->save();

        flash()->success(trans('manager.humanresources.msg.update.success'));

        return redirect()->route('manager.business.humanresource.show', [$business, $humanresource]);
    }

    public function destroy(Business $business, Humanresource $humanresource)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s humanresourceId:%s', $business->id, $humanresource->id));

        $this->authorize('manageHumanresources', $business);

        // BEGIN //

        $humanresource = $humanresource->delete();

        flash()->success(trans('manager.humanresources.msg.destroy.success'));

        return redirect()->route('manager.business.humanresource.index', $business);
    }
}
