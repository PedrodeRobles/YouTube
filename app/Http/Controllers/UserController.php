<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

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

        /*Logged user verification*/
        if(Auth::check()) {
            $userLoggedId = auth()->user()->id;
        } else {
            $userLoggedId = null;
        }
        /*-----*/

        return Inertia::render('User/Index', [
            'userAuth'     => $userAuth,
            'userName'     => $userName,
            'subscribers'  => $subscribers,
            'videos'       => $videos->load('user'),
            'userId'       => $userId,
            'userLoggedId' => $userLoggedId,
            'userVideos'   => Video::where('user_id', $user->id)->orderBy('id', 'DESC')->get()->map(function($video) {
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
