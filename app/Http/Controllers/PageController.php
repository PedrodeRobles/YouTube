<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Video;

class PageController extends Controller
{
    public function home()
    {
        $videos = Video::all();

        return Inertia::render('Home', ['videos' => $videos->load('user')]);
    }
}
