<?php namespace App\Http\Controllers;

use Session;
use Redirect;
use App\Business;

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

		if (empty($business_id)) {
			
			return Redirect::route('manager.businesses.index')->with('error', 'Select a business');

		}

		$business = Business::find( $business_id );

		if (empty($business)) {

			return Redirect::route('manager.businesses.index')->with('error', 'Bad business Select a business');

		}

		return view('user.businesses.show', compact('business'));
	}

	public function selector()
	{
		$businesses = Business::all();

		return view('user.businesses.index', compact('businesses'));
	}

	public function select($business_slug)
	{
    	try {
	
	    		$business_id = Business::where('slug', $business_slug)->first()->id;
	    		
	    	} catch (Exception $e) {
	
	    		return 'ERROR';
	
	    	}
	
	    	Session::set('selected.business_id', $business_id);
	
		return Redirect::route('home')->with('message', 'Business selected');
	}

}
