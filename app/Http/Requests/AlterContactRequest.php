<?php

namespace App\Http\Requests;

class AlterContactRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        //return $this->contact === null || auth()->user()->contacts->contains($this->contact);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = ['firstname'  => 'required|min:3',
                    'lastname' => 'required|min:2',
                    'gender'   => 'required|max:1',
                    //'mobile_country' => 'required_with:mobile|size:2',
                    //'mobile' => 'phone',
                    'email' => 'email',
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
