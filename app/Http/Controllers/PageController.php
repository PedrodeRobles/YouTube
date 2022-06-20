<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Video;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $videos = Video::latest()
            ->where('title', 'LIKE', "%$request->q%")
            ->get();

        return Inertia::render('Home', ['videos' => $videos->load('user')]);
    }
}
