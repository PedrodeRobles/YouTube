<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Video;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class VideoController extends Controller
{
    public function create()
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;

        if ( Auth::check() ) {
            $userAuth = true;
        } else {
            $userAuth = false;
        }
        /*-----*/

        $categories = Category::all();

        return Inertia::render('User/CreateVideo', [
            'userAuth' => $userAuth,
            'categories' => $categories
        ]);
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
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;

        if ( Auth::check() ) {
            $userAuth = true;
        } else {
            $userAuth = false;
        }
        /*-----*/

        $video->image = asset('storage/' . $video->image);
        $video->video = asset('storage/' . $video->video);

        return Inertia::render('Video', [
            'userAuth' => $userAuth,
            'video'    => $video->load('user'),
            'iframe'   => $video->video,
            'image'    => $video->image,
            'videos'   => Video::orderByRaw("RAND()")
                ->limit(10)
                ->get()
                ->map(function($video) {
                    return [
                        'id'          => $video->id,
                        'title'       => $video->title,
                        'image'       => asset('storage/' . $video->image),
                        'video'       => asset('storage/' . $video->video),
                        'description' => $video->description,
                        'category_id' => $video->category_id,
                        'user_id'     => $video->user_id,
                        'likes'       => $video->likes,
                        'dislikes'    => $video->dislikes,
                        'views'       => $video->views,
                        'user'        => User::where('id', $video->user_id)->first(),
                    ];
                }),
        ]);
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
