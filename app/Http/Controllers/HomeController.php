<?php namespace App\Http\Controllers;

use Session;
use Redirect;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$business_id = Session::get('selected.business_id');

		if (!$business_id) {
			

			return Redirect::route('businesses.index')->with('message', 'Select a business');

		}

		$business = \App\Business::find( $business_id );

		return view('home', compact('business'));
	}

}
