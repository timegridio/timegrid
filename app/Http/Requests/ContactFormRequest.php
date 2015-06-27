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

		if (! \Auth::user()->isOwner($business) ) return false;

    	$contact_id = $this->route('contacts');

    	if ($contact_id === null) return true;

	    return \App\Contact::find($contact_id)->isSuscribedTo($business);
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
