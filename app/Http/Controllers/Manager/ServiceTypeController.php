<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ServiceTypeController extends Controller
{
    /**
     * Show the form for editing the service types.
     *
     * @param Business $business Business to edit service of
     *
     * @return Response
     */
    public function edit(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageServices', $business);

        // BEGIN
        $servicetypes = $business->servicetypes->all();
    
        return view('manager.businesses.servicetype.edit', compact('business', 'servicetypes'));
    }

    /**
     * Update the business service types.
     *
     * @param Business $business
     * @param Request $request
     *
     * @return Response
     */
    public function update(Business $business, Request $request)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageServices', $business);

        // BEGIN

        $servicetypeSheet = $request->input('servicetypes');

        $regex = '/(?P<name>[a-zA-Z\d\-\ ]+)\:(?P<description>[a-zA-Z\d\ ]+)/im';

        preg_match_all($regex, $servicetypeSheet, $matches, PREG_SET_ORDER);

        $publishing = collect($matches)->map(
            function ($item) {
                $data = array_only($item, ['name', 'description']);
                $data['slug'] = str_slug($data['name']);
                return $data;
            });

        foreach ($business->servicetypes as $servicetype) {
            if (!$this->isPublished($servicetype, $publishing)) {
                $servicetype->delete();
            }
        }

        foreach ($publishing as $servicetypeData) {
            $servicetype = ServiceType::firstOrNew($servicetypeData);

            $business->servicetypes()->save($servicetype);
        }

        flash()->success(trans('servicetype.msg.update.success'));

        return redirect()->route('manager.business.service.index', [$business]);
    }

    protected function isPublished(ServiceType $servicetype, Collection & $publishing)
    {
        foreach ($publishing as $key => $item) {
            if ($item['name'] == $servicetype->name) {
                $publishing->forget($key);
                return true;
            }
        }
        return false;
    }
}
