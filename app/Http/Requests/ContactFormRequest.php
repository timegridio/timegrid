<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Session;
use Input;

class ContactFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		$business = \App\Business::findOrFail( Session::get('selected.business_id') );

		return \Auth::user()->isOwner($business);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{

		$rules = [	'firstname' => 'required|min:3',
        			'lastname' => 'required|min:3',
        			'gender' => 'required|max:1',
        			'mobile' => 'phone',
        			'mobile_country' => 'required_with:mobile|max:2'
        		];
		
		switch ($this->method())
		{
			case 'PATCH':
			case 'PUT':
			case 'POST':
				return $rules;
				break;
			
			default:

        		return [];

				break;
		}
	}

}
