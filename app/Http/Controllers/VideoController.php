<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Video;
use App\Models\Category;

class VideoController extends Controller
{
    public function create()
    {
        $categories = Category::all();

        return Inertia::render('User/CreateVideo', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'image'       => 'required',
            'video'       => 'required',
            'description' => 'max:200',
            'category_id' => 'required',
        ]);

        Video::create(
            $request->all() + 
            [
                'user_id'  => auth()->user()->id,
                'likes'    => 0,
                'dislikes' => 0,
                'views'    => 0
            ]
        );
    }

    public function show(Video $video)
    {
        //
    }

    public function edit(Video $video)
    {
        //
    }

    public function update(Request $request, Video $video)
    {
        //
    }

    public function destroy(Video $video)
    {
        //
    }
}
