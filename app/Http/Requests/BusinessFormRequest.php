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
        return true;
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
                return [
                      'name' => 'required|min:4',
                      'description' => 'required|min:10',
                      'timezone' => 'timezone',
                      'strategy' => 'required'
                    ];
                break;
            case 'POST':
                return [
                      'name' => 'required|min:4',
                      'slug' => 'required|min:4|unique:businesses',
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
