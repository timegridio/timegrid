<?php namespace App\Http\Controllers;

use Session;
use Redirect;
use \App\Business;

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
			

			return Redirect::
route('manager.businesses.index')->with('message', 'Select a business');

		}

		$business = \App\Business::find( $business_id );

		return view('home', compact('business'));
	}

	public function select($business_slug)
	{
    	try {
	
	    		$business_id = \App\Business::where('slug', $business_slug)->first()->id;
	    		
	    	} catch (Exception $e) {
	
	    		return 'error';
	
	    	}
	
	    	Session::set('selected.business_id', $business_id);
	
		return Redirect::
route('manager.businesses.index')->with('message', 'Business selected');
	}

}
