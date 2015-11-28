<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BusinessFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch ($this->method()) {
            case 'POST':
                return true;
            break;
            default:
                return $this->user()->id == $this->business->owner()->id;
            break;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'PATCH':
            case 'PUT':
            case 'POST':
                return [
                      'name' => 'required|min:3',
                      'slug' => 'required|min:3',
                      'description' => 'required|min:10',
                      'timezone' => 'timezone',
                      'strategy' => 'required'
                    ];
            break;
            default:
                return [];
            break;
        }
    }
}
