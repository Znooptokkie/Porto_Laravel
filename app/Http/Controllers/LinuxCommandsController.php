<?php

namespace App\Http\Controllers;

use App\Actions\GetLinuxCommands;
use App\Enums\LinuxCommandKeyword;
use App\Http\Requests\LinuxCommandsIndexRequest;
use Illuminate\Contracts\View\View;

class LinuxCommandsController extends Controller
{
    /**
     * Shows the Linux commands overview, optionally filtered by the search term and the keyword. The language preference is mirrored in a cookie by the frontend.
     */
    public function __invoke(LinuxCommandsIndexRequest $request, GetLinuxCommands $getCommands): View
    {
        app()->setLocale($request->cookie('locale') === 'en' ? 'en' : 'nl');

        $search = $request->validated('q');
        $keyword = LinuxCommandKeyword::tryFrom((string) $request->validated('keyword'));

        return view('linux-commands', [
            ...$getCommands->handle($search, $keyword),
            'search' => $search ?? '',
            'keywords' => LinuxCommandKeyword::cases(),
            'selectedKeyword' => $keyword,
        ]);
    }
}
