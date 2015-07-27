<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\ConciergeStrategy as Concierge;
use App\Business;
use App\Vacancy;
use Redirect;
use Flash;

class BusinessVacancyController extends Controller
{
    /**
     * TODO: This should probably not be a resource Controller
     */

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // TODO: Provide elegant Vacancy display
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Business $business)
    {
        $dates = Concierge::generateAvailability($business->vacancies);
        $services = $business->services;
        return view('manager.businesses.vacancies.edit', compact('business', 'dates', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Business $business, Request $request)
    {
        $dates = $request->get('vacancy');
        $success = false;
        foreach ($dates as $date => $vacancy) {
            foreach ($vacancy as $serviceId => $capacity) {
                switch (trim($capacity)) {
                    case '':
                        // Dont update, leave as is
                        break;
                    default:
                        $vacancy = Vacancy::updateOrCreate(['business_id' => $business->id, 'service_id' => $serviceId, 'date' => $date], ['capacity' => intval($capacity)]);
                        $success = true;
                        break;
                }
            }
        }
        if (!$success) {
            Flash::warning(trans('manager.vacancies.msg.store.nothing_changed'));
            return Redirect::back();
        }
        Flash::success(trans('manager.vacancies.msg.store.success'));
        return Redirect::route('manager.business.show', [$business]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // TODO: Provide elegant display of individual Vacancy
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
