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
        $propertiesScore = [
            'firstname'      => 3,
            'lastname'       => 7,
            'nin'            => 10,
            'birthdate'      => 5,
            'mobile'         => 20,
            'email'          => 15,
            'postal_address' => 25,
        ];
        $totalScore = array_sum($propertiesScore);

        $qualityScore = 0;
        foreach ($propertiesScore as $property => $score) {
            if (trim($this->wrappedObject->$property) != '') {
                $qualityScore += $score;
            }
        }

        return ceil($qualityScore / $totalScore * 100);
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
