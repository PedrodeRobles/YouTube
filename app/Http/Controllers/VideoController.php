<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Video;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Dislike;
use App\Models\User;
use App\Models\Subscriber;
use App\Models\Likes;
use App\Notifications\AddVideoNotification;
use App\Notifications\UpdateVideoNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function __construct()
    {
        // Aplica el middleware 'auth' a todos los métodos excepto 'show'
        $this->middleware('auth')->except('show');
    }

    public function create()
    {
        $categories = Category::all();

        return Inertia::render('User/CreateVideo', ['categories' => $categories]);
    }

    public function store(VideoRequest $request)
    {
        $filename = resizeImage($request->file('image'), 200, 'public/videos/images/');

        $video = $request->file('video')->store('videos/iframe', 'public');

        $newVideo = Video::create([
            'title'       => $request->title,
            'image'       => 'videos/images/' . $filename,
            'video'       => $video,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id'     => auth()->user()->id,
            'likes'       => 0,
            'dislikes'    => 0,
            'views'       => 0
        ]);

        Notification::send(auth()->user(), new AddVideoNotification($newVideo));

        $userLoggedId = auth()->user()->id;

        return redirect(route('userVideos', $userLoggedId));
    }

    public function show(Video $video, Request $request)
    {
        $userId = $video->user_id;

        $video->image = asset('storage/' . $video->image);
        $video->video = asset('storage/' . $video->video);
        $video->userImg = asset('storage/' . $video->user->profile_image);

        if (Auth::check()) {
            $authUserImage  = auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : null;
        } else {
            $authUserImage = null;
        }

        /*Get subscription record to validate if the user is subscribed to this channel*/
        $subscribed = Subscriber::where('user_id', getUserLoggedId())
            ->where('otherUser', $userId)
            ->first();
        /*-----*/

        /*Get 'like' record to validate if the user liked to this video*/
        $liked = Likes::where('user_id', getUserLoggedId())
            ->where('video_id', $video->id)
            ->first();
        /*-----*/

        /*Get 'dislike' record to validate if the user disliked to this video*/
        $disliked = Dislike::where('user_id', getUserLoggedId())
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
            ->get()
            ->map(function ($comment) {
                return [
                    'user_name'         => $comment->user->name,
                    'has_profile_image' => $comment->user->profile_image ? true : false,
                    'profile_image'     => asset('storage/' . $comment->user->profile_image),
                    'content'           => $comment->content
                ];
            });

        $videos = Video::limit(14)
            ->get()
            ->map(function($video) {
                return [
                    'id'          => $video->id,
                    'title'       => $video->title,
                    'image'       => asset('storage/' . $video->image),
                    'video'       => asset('storage/' . $video->video),
                    'user_id'     => $video->user_id,
                    'views'       => $video->views,
                    'user'        => $video->user,
                    'userImg'     => asset('storage/' . $video->user->profile_image),
                ];
            });

        return Inertia::render('Video', [
            'video'          => $video->load('user'),
            'iframe'         => $video->video,
            'image'          => $video->image,
            'subscribed'     => $subscribed,
            'liked'          => $liked,
            'disliked'       => $disliked,
            'userId'         => $userId,
            'comments'       => $comments,
            'videos'         => $videos,
            'authUserImage'  => $authUserImage,
            'users' => User::all()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'profile_image' => asset('storage/' . $user->profile_image),
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

        $categories = Category::all();

        return Inertia::render('User/Edit', [
            'categories' => $categories,
            'video'      => $video,
        ]);
    }

    public function update(VideoRequest $request, Video $video)
    {
        $currentImage = $video->image;
        $currentVideo = $video->video;

        $video->fill(array_filter($request->validated()));

        if ($request->file('image')) {
            Storage::delete('public/' . $currentImage);

            $filename = resizeImage($request->file('image'), 200, 'public/videos/images/');

            $video->image = 'videos/images/' . $filename;
        } 

        if ($request->file('video')) {
            Storage::delete('public/' . $currentVideo);
            $video->video = $request->file('video')->store('videos/iframe', 'public');
        }

        if ($request->file('image') || $request->file('video')) {
            $video->save();
        } else {
            $video->update(array_filter($request->validated()));
        }

        Notification::send(auth()->user(), new UpdateVideoNotification($video));

        return redirect(route('userVideos', $video->user->id));
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

        $subscription = Subscriber::where('user_id', $request->user_id)
            ->where('otherUser', $request->otherUser)
            ->first();

        if ($subscription == null) {
            Subscriber::create($request->all());
            
            /* Add a subscriber to the user */
            $user = User::where('id', $request->otherUser)->first();
            $user->subscribers;
            $user->update([
                'subscribers' => $user->subscribers + 1,
            ]);
            /*-----*/
        } else {
            return "Please press the Subscribe button only once. Reload page";
        }

        return redirect()->back();
    }

    public function like(Request $request)
    {
        $request->validate([
            'user_id'   => 'required',
            'video_id' => 'required',
        ]);

        $like = Likes::where('user_id', $request->user_id)
            ->where('video_id', $request->video_id)
            ->first();

        if ($like == null) {
            Likes::create($request->all());
    
            /* Add a like to the video */
            $video = Video::where('id', $request->video_id)->first();
            $video->likes;
            $video->update([
                'likes' => $video->likes + 1,
            ]);
            /*-----*/
        } else {
            return "Please press the Like button only once. Reload page";
        }


        return redirect()->back();
    }

    public function unlike(Request $request)
    {
        /*Get like record and delete */
        $like = Likes::where('user_id', $request->user_id)
            ->where('video_id', $request->video_id)
            ->first();

        if ($like != null) {
            /* Subtract a like to the video */
            $video = Video::where('id', $request->video_id)->first();
            $video->likes;
            $video->update([
                'likes' => $video->likes - 1,
            ]);

            $like->delete();
        } else {
            return "Please press the Like button only once. Reload page";
        }

        return redirect()->back();
    }

    public function dislike(Request $request)
    {
        $request->validate([
            'user_id'   => 'required',
            'video_id' => 'required',
        ]);

        $dislike = Dislike::where('user_id', $request->user_id)
            ->where('video_id', $request->video_id)
            ->first();

        if ($dislike == null) {
            Dislike::create($request->all());
    
            /* Add a like to the video */
            $video = Video::where('id', $request->video_id)->first();
            $video->dislikes;
            $video->update([
                'dislikes' => $video->dislikes + 1,
            ]);
            /*-----*/
        } else {
            return "Please press the Dislike button only once. Reload page";
        }


        return redirect()->back();
    }

    public function undislike(Request $request)
    {
        /*Get dislike record and delete */
        $dislike = Dislike::where('user_id', $request->user_id)
            ->where('video_id', $request->video_id)
            ->first();

        if ($dislike != null) {
            $dislike->delete();
            /*-----*/
    
            /* Subtract a dislike to the video */
            $video = Video::where('id', $request->video_id)->first();
            $video->dislikes;
            $video->update([
                'dislikes' => $video->dislikes - 1,
            ]);
        } else {
            return "Please press the Like button only once. Reload page";
        }


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
