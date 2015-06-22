<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Business;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\Authenticatable as User;
use App\Http\Requests\BusinessFormRequest;
use Request;
use Flash;

class BusinessesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$businesses = \Auth::user()->businesses()->get();
		return view('manage.businesses.index', compact('businesses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('manage.businesses.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(BusinessFormRequest $request)
	{
		# $this->validate($request, $this->rules);
				
		$business = \App\Business::create( Request::all() );

		\Auth::user()->businesses()->attach($business);

		\Auth::user()->save();

		Flash::success(trans('business.create.success'));

		return Redirect::route('manage.businesses.index')->with('message', 'Business created');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, BusinessFormRequest $request)
	{
		$business = Business::findOrFail($id);
		return view('manage.businesses.show', compact('business'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, BusinessFormRequest $request)
	{
        $business = Business::findOrFail($id);
        return view('manage.businesses.edit', compact('business'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, BusinessFormRequest $request)
	{
        $user = \Auth::user();

        $business = Business::findOrFail($id);

        $business->update([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'), 
            'description' => $request->get('description')
        ]);

        Flash::success(trans('businesses.msg.edit.success'));

        return \Redirect::route('manage.businesses.show', array($business->id));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, BusinessFormRequest $request)
	{
	    $user = \Auth::user();

        $business = Business::findOrFail($id);

        $business->delete();

        Flash::success(trans('business.msg.deleted'));

        return \Redirect::route('manage.businesses.index');
	}

}
