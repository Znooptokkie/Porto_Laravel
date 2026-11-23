<?php

namespace App\Http\Controllers;

use App\Actions\GetLeetcodeOverview;
use App\Http\Requests\LeetcodeIndexRequest;
use Illuminate\Contracts\View\View;

class LeetcodeController extends Controller
{
    /**
     * Shows the LeetCode overview. Search and filters come from the query string; the language preference is mirrored in a cookie by the frontend.
     */
    public function __invoke(LeetcodeIndexRequest $request, GetLeetcodeOverview $getOverview): View
    {
        $filters = $request->validated();

        return view('leetcode', [
            'overview' => $getOverview->handle($filters),
            'filters' => $filters,
        ]);
    }
}
