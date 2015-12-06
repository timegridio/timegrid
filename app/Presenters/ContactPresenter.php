<?php

namespace App\Presenters;

use App\Models\Contact;
use McCool\LaravelAutoPresenter\BasePresenter;

class ContactPresenter extends BasePresenter
{
    public function __construct(Contact $resource)
    {
        $this->wrappedObject = $resource;
    }

    /**
     * get fullname.
     *
     * @return string Contact firstname and lastname
     */
    public function fullname()
    {
        return trim($this->wrappedObject->firstname.' '.$this->wrappedObject->lastname);
    }

    /**
     * TODO: Check if needs to get moved to a calculator class.
     *
     * get Quality
     *
     * @return float Contact quality percentual score calculated from profile completion
     */
    public function quality()
    {
        $quality = 0;
        $quality += isset($this->wrappedObject->firstname) ? 1 : 0;
        $quality += isset($this->wrappedObject->lastname) ? 1 : 0;
        $quality += isset($this->wrappedObject->nin) ? 5 : 0;
        $quality += isset($this->wrappedObject->birthdate) ? 2 : 0;
        $quality += isset($this->wrappedObject->mobile) ? 4 : 0;
        $quality += isset($this->wrappedObject->email) ? 4 : 0;
        $quality += isset($this->wrappedObject->postal_address) ? 3 : 0;
        $total = 20;

        return $quality / $total * 100;
    }

    /**
     * ToDo: Use Carbon instead of DateTime.
     *
     * get Age
     *
     * @return int Age in years
     */
    public function age()
    {
        if ($this->wrappedObject->birthdate == null) {
            return;
        }

        $reference = new \DateTime();
        $born = new \DateTime($this->wrappedObject->birthdate);

        if ($this->wrappedObject->birthdate > $reference) {
            return;
        }

        $diff = $reference->diff($born);

        return $diff->y;
    }
}
