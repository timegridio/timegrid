<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Contact;
use Flash;
use Notifynder;
use Request;

/*******************************************************************************
 * The importer allows the business manager to import contacts from a CSV
 * clipboard. The export function will be added in the future.
 * This is a standalone controller and a better implementation of import export
 * will be designed.
 ******************************************************************************/
class BusinessContactImportExportController extends Controller
{
    /**
     * get Import form.
     *
     * @param Business $business Business to import Contacts to
     * @param Request  $request
     *
     * @return Response Rendered Import form view
     */
    public function getImport(Business $business, Request $request)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageContacts', $business);

        return view('manager.contacts.import', compact('business'));
    }

    /**
     * post Import.
     *
     * @param Business $business Business to import Contacts to
     * @param Request  $request  Submitted form data
     *
     * @return Response Redirect to Business addressbook
     */
    public function postImport(Business $business, Request $request)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageContacts', $business);

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $csv = $this->csvToArray(Request::get('data'));

        foreach ($csv as $import) {
            $import = array_map(function ($item) {
                return $item == 'NULL' ? null : $item;
            }, $import);

            if ($import['birthdate'] !== null) {
                $date = \DateTime::createFromFormat('Ymd', $import['birthdate']);
                $import['birthdate'] = $date->format('m/d/Y');
            }

            $notes = $import['notes'];
            unset($import['notes']);
            $contact = Contact::create($import);
            $business->contacts()->attach($contact, ['notes' => $notes]);
            $business->save();
        }

        $count = count($csv);
        $this->log->info("  Imported $count contacts");

        Notifynder::category('user.importedContacts')
                   ->from('App\Models\User', auth()->user()->id)
                   ->to('App\Models\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('count'))
                   ->send();

        Flash::success(trans('manager.contacts.msg.import.success'));

        return redirect()->route('manager.business.contact.index', [$business]);
    }

    /**
     * Converts submitted CSV string data into an Array.
     *
     * @param string $data CSV string of Contacts
     *
     * @return array Converted CSV into Array
     */
    private function csvToArray($data = '')
    {
        $this->log->info(__METHOD__);

        $rows = array_map('str_getcsv', explode("\n", $data));
        $header = array_shift($rows);
        $csv = [];
        foreach ($rows as $row) {
            $csv[] = array_combine($header, $row);
        }

        return $csv;
    }
}
