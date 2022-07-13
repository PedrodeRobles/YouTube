<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Video;
use App\Models\Category;
use App\Models\User;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function create()
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;
        $userLoggedName = null;

        if ( Auth::check() ) {
            $userAuth = true;
            $userLoggedName= auth()->user()->name;
        } else {
            $userAuth = false;
            $userLoggedName= null;
        }
        /*-----*/

        $categories = Category::all();

        return Inertia::render('User/CreateVideo', [
            'userAuth' => $userAuth,
            'userLoggedName' => $userLoggedName,
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

        $userLoggedName = auth()->user()->name;

        return redirect(route('userVideos', $userLoggedName));
    }

    public function show(Video $video)
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;
        $userLoggedName = null;
        $userLoggedId = null;

        if ( Auth::check() ) {
            $userAuth = true;
            $userLoggedName= auth()->user()->name;
            $userLoggedId= auth()->user()->id;
        } else {
            $userAuth = false;
            $userLoggedName = null;
            $userLoggedId = null;
        }
        /*-----*/

        $userId = $video->user_id;

        $video->image = asset('storage/' . $video->image);
        $video->video = asset('storage/' . $video->video);

        /*Get subscription record to validate if the user is subscribed to this channel*/
        $subscribed = Subscriber::where('user_id', $userLoggedId)
            ->where('otherUser', $userId)
            ->first();
        /*-----*/


        return Inertia::render('Video', [
            'userAuth'       => $userAuth,
            'userLoggedName' => $userLoggedName,
            'video'          => $video->load('user'),
            'iframe'         => $video->video,
            'image'          => $video->image,
            'subscribed'     => $subscribed,
            'userLoggedId'   => $userLoggedId,
            'userId'         => $userId,
            'videos'         => Video::orderByRaw("RAND()")
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
        /*Validate that the user is the same as the user_id of the video*/
        if( auth()->user()->id != $video->user_id )
        {
            return abort(403);
        }

        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;
        $userLoggedName = null;

        if ( Auth::check() ) {
            $userAuth = true;
            $userLoggedName= auth()->user()->name;
        } else {
            $userAuth = false;
            $userLoggedName= null;
        }
        /*-----*/

        $categories = Category::all();

        return Inertia::render('User/Edit', [
            'userAuth' => $userAuth,
            'userLoggedName' => $userLoggedName,
            'categories' => $categories,
            'video'      => $video
        ]);
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title'       => 'required',
            'image'       => 'required|image|max:2048',
            'video'       => 'required|mimes:mp4|max:60000',
            'description' => 'max:200',
            'category_id' => 'required',
        ]);

        if ($request->file('image')) {
            Storage::delete('public/' . $video->image);
            $image = $request->file('image')->store('images', 'public');
        }

        if ($request->file('video')) {
            Storage::delete('public/' . $video->video);
            $newVideo = $request->file('video')->store('videos', 'public');
        }
        
        $video->update([
            'title'       => $request->title,
            'image'       => $image,
            'video'       => $newVideo,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        return redirect(route('userVideos', $video->user->name));
    }

    public function destroy(Video $video)
    {
        //
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'user_id'   => 'required',
            'otherUser' => 'required',
        ]);

        Subscriber::create($request->all());

        /* Add a subscriber to the user */
        $user = User::where('id', $request->otherUser)->first();
        $user->subscribers;
        $user->update([
            'subscribers' => $user->subscribers + 1,
        ]);
        /*-----*/

        return redirect()->back();
    }
}
