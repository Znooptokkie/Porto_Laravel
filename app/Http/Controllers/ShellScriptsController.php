<?php

namespace App\Http\Controllers;

use App\Actions\GetShellScripts;
use App\Http\Requests\ShellScriptsIndexRequest;
use Illuminate\Contracts\View\View;

class ShellScriptsController extends Controller
{
    /**
     * Shows the shell scripts overview, optionally filtered by the search term. The locale is set by the SetPageLocale middleware.
     */
    public function __invoke(ShellScriptsIndexRequest $request, GetShellScripts $getScripts): View
    {
        $search = $request->validated('q');

        return view('shell-scripts', [
            ...$getScripts->handle($search),
            'search' => $search ?? '',
        ]);
    }
}
