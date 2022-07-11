<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index(User $user, Request $request)
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;

        if ( Auth::check() ) {
            $userAuth = true;
        } else {
            $userAuth = false;
        }
        /*-----*/

        /*Get this data from this user*/
        $userName    = $user->name;
        $subscribers = $user->subscribers;
        $userId      = $user->id;
        /*-----*/

        /*Search bar, Query*/
        $videos = Video::latest()
            ->where('title', 'LIKE', "%$request->q%")
            ->get();
        /*-----*/

        /*Get logged user*/
        $userLoggedId = null;
        $userLoggedName = null;
        /*-----*/

        /*Logged user verification*/
        if(Auth::check()) {
            $userLoggedId = auth()->user()->id;
            $userLoggedName = auth()->user()->name;
        } else {
            $userLoggedId = null;
            $userLoggedName = null;
        }
        /*-----*/

        /*Get subscription record to validate if the user is subscribed to this channel*/
        $subscribed = Subscriber::where('user_id', $userLoggedId)
            ->where('otherUser', $userId)
            ->first();
        /*-----*/

        return Inertia::render('User/Index', [
            'userAuth'       => $userAuth,
            'userName'       => $userName,
            'subscribers'    => $subscribers,
            'videos'         => $videos->load('user'),
            'userId'         => $userId,
            'userLoggedId'   => $userLoggedId,
            'userLoggedName' => $userLoggedName,
            'subscribed'     => $subscribed,
            'userVideos'     => Video::where('user_id', $user->id)->orderBy('id', 'DESC')->get()->map(function($video) {
                return [
                    'id'          => $video->id,
                    'title'       => $video->title,
                    'image'       => asset('storage/' . $video->image),
                    'video'       => asset('storage/' . $video->video),
                    'description' => $video->description,
                    'category_id' => $video->category_id,
                    'user_id'     => $video->user_id,
                    'likes'       => 0,
                    'dislikes'    => 0,
                    'views'       => 0 
                ];
            }),
        ]);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'user_id'   => 'required',
            'otherUser' => 'required',
        ]);

        Subscriber::create($request->all());

        return redirect()->back();
    }
}
