<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Business;
use App\Contact;
use Notifynder;
use Illuminate\Support\Facades\Redirect;
use Flash;
use Session;
use Request;

class BusinessContactImportExportController extends Controller
{

    public function getImport(Business $business, Request $request)
    {
        return view('manager.contacts.import', compact('business'));
    }

    public function postImport(Business $business, Request $request)
    {
        $csv = $this->csvToArray(Request::get('data'));
        
        foreach ($csv as $key => $import) {
            $notes = $import['notes'];
            unset($import['notes']);
            $contact = Contact::create($import);
            $business->contacts()->attach($contact, ['notes' => $notes]);
            $business->save();                
        }

        $count = count($csv);
        Notifynder::category('user.importedContacts')
                   ->from('App\User', \Auth::user()->id)
                   ->to('App\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('count'))
                   ->send();

        Flash::success(trans('manager.contacts.msg.import.success'));
        return Redirect::route('manager.business.contact.index', [$business]);
    }

    private function csvToArray($data='', $delimiter=',')
    {        
        $rows = array_map('str_getcsv', explode("\n", $data));
        $header = array_shift($rows);
        $csv = array();
        foreach ($rows as $row) {
          $csv[] = array_combine($header, $row);
        }
        return $csv;
    }
}
