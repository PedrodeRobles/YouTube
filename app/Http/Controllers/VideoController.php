<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Video;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;

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
            'image'       => 'required|image|max:2048',
            'video'       => 'required|mimes:mp4|max:60000',
            'description' => 'max:200',
            'category_id' => 'required',
        ]);

        $image = $request->file('image')->store('images', 'public');
        $video = $request->file('video')->store('videos', 'public');

        Video::create([
            'title'       => $request->title,
            'image'       => $image,
            'video'       => $video,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id'     => auth()->user()->id,
            'likes'       => 0,
            'dislikes'    => 0,
            'views'       => 0
        ]);

        return Redirect::route('home');
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
