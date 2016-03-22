<?php

namespace App\Http\ViewComposers;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserHelpComposer
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
        $locale = app()->getLocale();

        $filename = Request::route()->getName().'.md';

        $filepath = 'userhelp'.DIRECTORY_SEPARATOR.$locale.DIRECTORY_SEPARATOR.$filename;

        $help = Storage::exists($filepath)
            ? Markdown::convertToHtml(Storage::get($filepath))
            : '';

        $view->with('help', $help);
    }
}
