<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class NavComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('business', session()->get('selected.business'));
        $view->with('route', Request::route()->getName());
    }
}
