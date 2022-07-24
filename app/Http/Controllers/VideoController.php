<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Video;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Dislike;
use App\Models\User;
use App\Models\Subscriber;
use App\Models\Likes;
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
            $userLoggedId= auth()->user()->id;
        } else {
            $userAuth = false;
            $userLoggedName= null;
            $userLoggedId = null;
        }
        /*-----*/

        $categories = Category::all();

        return Inertia::render('User/CreateVideo', [
            'userAuth' => $userAuth,
            'userLoggedName' => $userLoggedName,
            'categories' => $categories,
            'userLoggedId' => $userLoggedId,
            'userAuthImg' => User::where('id', $userLoggedId)
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'profile_image' => asset('storage/' . $user->profile_image),
                        'image'         => $user->profile_image
                    ];
                }),
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

        $image = $request->file('image')->store('videos/images', 'public');
        $video = $request->file('video')->store('videos/iframe', 'public');

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

    public function show(Video $video, Request $request)
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;
        $userLoggedName = null;
        $userLoggedId = null;

        if ( Auth::check() ) {
            $userAuth = true;
            $userLoggedName= auth()->user()->name;
            $userLoggedId= auth()->user()->id;
            $userLoggedImg= auth()->user()->profile_image;
        } else {
            $userAuth = false;
            $userLoggedName = null;
            $userLoggedId = null;
            $userLoggedImg = null;
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

        /*Get 'like' record to validate if the user liked to this video*/
        $liked = Likes::where('user_id', $userLoggedId)
            ->where('video_id', $video->id)
            ->first();
        /*-----*/

        /*Get 'dislike' record to validate if the user disliked to this video*/
        $disliked = Dislike::where('user_id', $userLoggedId)
            ->where('video_id', $video->id)
            ->first();
        /*-----*/

        /*Search bar, Query*/
        $videos = Video::latest()
            ->where('title', 'LIKE', "%$request->q%")
            ->get();
        /*-----*/

        /*Get comments of this video */
        $comments = Comment::where('video_id', $video->id)
            ->orderBy('id', 'desc')
            ->get();

        return Inertia::render('Video', [
            'userAuth'       => $userAuth,
            'userLoggedName' => $userLoggedName,
            'video'          => $video->load('user'),
            'iframe'         => $video->video,
            'image'          => $video->image,
            'subscribed'     => $subscribed,
            'liked'          => $liked,
            'disliked'       => $disliked,
            'userLoggedId'   => $userLoggedId,
            'userLoggedImg'  => $userLoggedImg,
            'userId'         => $userId,
            'comments'       => $comments->load('user'),
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
            'users' => User::all()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'profile_image' => asset('storage/' . $user->profile_image),
                ];
            }),
            'userAuthImg' => User::where('id', $userLoggedId)
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'profile_image' => asset('storage/' . $user->profile_image),
                        'image'         => $user->profile_image
                    ];
                }),
        ]);
    }

    public function edit(Video $video)
    {
        /*Verify user*/
        if ($video->user_id != auth()->user()->id) {
            abort(403);
        }

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
            $userLoggedId= auth()->user()->id;
        } else {
            $userAuth = false;
            $userLoggedName= null;
            $userLoggedId= null;
        }
        /*-----*/

        $categories = Category::all();

        return Inertia::render('User/Edit', [
            'userAuth' => $userAuth,
            'userLoggedName' => $userLoggedName,
            'userLoggedId' => $userLoggedId,
            'categories' => $categories,
            'video'      => $video,
            'userAuthImg' => User::where('id', $userLoggedId)
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'profile_image' => asset('storage/' . $user->profile_image),
                        'image'         => $user->profile_image
                    ];
                }),
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
            $image = $request->file('image')->store('videos/images', 'public');
        }

        if ($request->file('video')) {
            Storage::delete('public/' . $video->video);
            $newVideo = $request->file('video')->store('videos/iframe', 'public');
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
        Storage::delete('public/' . $video->image);
        Storage::delete('public/' . $video->video);

        $video->delete();
        
        return redirect()->back();
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

    public function like(Request $request)
    {
        $request->validate([
            'user_id'   => 'required',
            'video_id' => 'required',
        ]);

        Likes::create($request->all());

        /* Add a like to the video */
        $video = Video::where('id', $request->video_id)->first();
        $video->likes;
        $video->update([
            'likes' => $video->likes + 1,
        ]);
        /*-----*/

        return redirect()->back();
    }

    public function unlike(Request $request)
    {
        /*Get like record and delete */
        $like = Likes::where('user_id', $request->user_id)
            ->where('video_id', $request->video_id)
            ->first();

        $like->delete();
        /*-----*/

        /* Subtract a like to the video */
        $video = Video::where('id', $request->video_id)->first();
        $video->likes;
        $video->update([
            'likes' => $video->likes - 1,
        ]);
        /*-----*/

        return redirect()->back();
    }

    public function dislike(Request $request)
    {
        $request->validate([
            'user_id'   => 'required',
            'video_id' => 'required',
        ]);

        Dislike::create($request->all());

        /* Add a like to the video */
        $video = Video::where('id', $request->video_id)->first();
        $video->dislikes;
        $video->update([
            'dislikes' => $video->dislikes + 1,
        ]);
        /*-----*/

        return redirect()->back();
    }

    public function undislike(Request $request)
    {
        /*Get dislike record and delete */
        $dislike = Dislike::where('user_id', $request->user_id)
            ->where('video_id', $request->video_id)
            ->first();

        $dislike->delete();
        /*-----*/

        /* Subtract a dislike to the video */
        $video = Video::where('id', $request->video_id)->first();
        $video->dislike;
        $video->update([
            'dislike' => $video->dislike - 1,
        ]);
        /*-----*/

        return redirect()->back();
    }

    public function comment(Request $request)
    {
        $request->validate([
            'user_id'  => 'required',
            'video_id' => 'required',
            'content'  => ' required',
        ]);

        Comment::create($request->all());

        return redirect()->back();
    }
}
