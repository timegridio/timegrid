<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SearchEngine;
use Timegridio\Concierge\Models\Business;

class Search extends Controller
{
    /**
     * Search for elements within a Business.
     *
     * @param Timegridio\Concierge\Models\Business $business
     *
     * @return Illuminate\View\View
     */
    public function postSearch(Business $business, Request $request)
    {
        $this->authorize('manage', $business);

        $criteria = $request->input('criteria');

        $search = new SearchEngine($criteria);
        $search->setBusinessScope([$business->id])->run();

        $results = $search->results();

        return view('manager.search.index')->with(compact('results', 'criteria'));
    }
}
