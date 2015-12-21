<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\SearchEngine;
use Illuminate\Support\Facades\Request;

class Search extends Controller
{
    /**
     * Search for elements within a Business.
     *
     * @param App\Models\Business $business
     *
     * @return Illuminate\View\View
     */
    public function postSearch(Business $business)
    {
        $this->authorize('manage', $business);

        $criteria = Request::input('criteria');

        $search = new SearchEngine($criteria);
        $search->setBusinessScope([$business->id])->run();

        return view('manager.search.index')->with(['results' => $search->results(), 'criteria' => $criteria]);
    }
}
