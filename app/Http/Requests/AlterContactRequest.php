<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class AlterContactRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->contact === null || Auth::user()->contacts->contains($this->contact);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [  'firstname' => 'required|min:3',
                    'lastname' => 'required|min:2',
                    'gender' => 'required|max:1',
                    #'mobile_country' => 'required_with:mobile|size:2',
                    #'mobile' => 'phone',
                    'email' => 'email'
                ];

        switch ($this->method()) {
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
