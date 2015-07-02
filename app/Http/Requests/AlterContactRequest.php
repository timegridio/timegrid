<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Business;
use App\Contact;
use Route;

class AlterContactRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->contact === null || \Auth::user()->contacts->contains($this->contact);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [  'firstname' => 'required|min:3',
                    'lastname' => 'required|min:3',
                    'gender' => 'required|max:1',
                    'mobile' => 'phone',
                    'mobile_country' => 'required_with:mobile|max:2' /* FIXME: LENGHT MUST BE EXACT 2 */
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
