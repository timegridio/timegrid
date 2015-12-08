<?php

namespace App\Http\Requests;

class ContactFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = ['firstname'   => 'required|min:3',
                    'lastname'  => 'required|min:3',
                    'gender'    => 'required|max:1',
                    'birthdate' => 'date_format:'.trans('app.dateformat.carbon'),
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
