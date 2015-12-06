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
}
