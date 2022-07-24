<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home(Request $request)
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;

        if ( Auth::check() ) {
            $userAuth = true;
        } else {
            $userAuth = false;
        }
        /*-----*/

        /*Logged user verification*/
        $userLoggedName = null;
        
        if(Auth::check()) {
            $userLoggedName= auth()->user()->name;
            $userLoggedId= auth()->user()->id;
        } else {
            $userLoggedName = null;
            $userLoggedId = null;
        }
        /*-----*/

        return Inertia::render('Home', [
            'userAuth'       => $userAuth,
            'userLoggedName' => $userLoggedName,
            'userLoggedId'   => $userLoggedId,
            'videos'         => Video::where('title', 'LIKE', "%$request->q%")
                ->orderBy('id', 'DESC')
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
                        'user'        => User::where('id', $video->user_id)->first(), //Get relation with user
                        'views'       => $video->views,
                    ];
                }),
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_image' => asset('storage/' . $user->profile_image),
                    ];
                })
        ]);
    }

    public function gaming(Request $request)
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;

        if ( Auth::check() ) {
            $userAuth = true;
        } else {
            $userAuth = false;
        }
        /*-----*/

        /*Logged user verification*/
        $userLoggedName = null;
        
        if(Auth::check()) {
            $userLoggedName= auth()->user()->name;
            $userLoggedId= auth()->user()->id;
        } else {
            $userLoggedName = null;
            $userLoggedId = null;
        }
        /*-----*/

        return Inertia::render('Section/Gaming', [
            'userAuth'       => $userAuth,
            'userLoggedName' => $userLoggedName,
            'userLoggedId'   => $userLoggedId,
            'videos'         => Video::where('title', 'LIKE', "%$request->q%")
                ->where('category_id', 1)
                ->orderBy('id', 'DESC')
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
                        'user'        => User::where('id', $video->user_id)->first(), //Get relation with user
                        'views'       => $video->views,
                    ];
                }),
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_image' => asset('storage/' . $user->profile_image),
                    ];
                })
        ]);
    }

    public function music(Request $request)
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;

        if ( Auth::check() ) {
            $userAuth = true;
        } else {
            $userAuth = false;
        }
        /*-----*/

        /*Logged user verification*/
        $userLoggedName = null;
        
        if(Auth::check()) {
            $userLoggedName= auth()->user()->name;
            $userLoggedId= auth()->user()->id;
        } else {
            $userLoggedName = null;
            $userLoggedId = null;
        }
        /*-----*/

        return Inertia::render('Section/Music', [
            'userAuth'       => $userAuth,
            'userLoggedName' => $userLoggedName,
            'userLoggedId'   => $userLoggedId,
            'videos'         => Video::where('title', 'LIKE', "%$request->q%")
                ->where('category_id', 2)
                ->orderBy('id', 'DESC')
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
                        'user'        => User::where('id', $video->user_id)->first(), //Get relation with user
                        'views'       => $video->views,
                    ];
                }),
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_image' => asset('storage/' . $user->profile_image),
                    ];
                })
        ]);
    }

    public function news(Request $request)
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;

        if ( Auth::check() ) {
            $userAuth = true;
        } else {
            $userAuth = false;
        }
        /*-----*/

        /*Logged user verification*/
        $userLoggedName = null;
        
        if(Auth::check()) {
            $userLoggedName= auth()->user()->name;
            $userLoggedId= auth()->user()->id;
        } else {
            $userLoggedName = null;
            $userLoggedId = null;
        }
        /*-----*/

        return Inertia::render('Section/News', [
            'userAuth'       => $userAuth,
            'userLoggedName' => $userLoggedName,
            'userLoggedId'   => $userLoggedId,
            'news'           => true,
            'videos'         => Video::where('title', 'LIKE', "%$request->q%")
                ->where('category_id', 3)
                ->orderBy('id', 'DESC')
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
                        'user'        => User::where('id', $video->user_id)->first(), //Get relation with user
                        'views'       => $video->views,
                    ];
                }),
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_image' => asset('storage/' . $user->profile_image),
                    ];
                })
        ]);
    }

    public function sports(Request $request)
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;

        if ( Auth::check() ) {
            $userAuth = true;
        } else {
            $userAuth = false;
        }
        /*-----*/

        /*Logged user verification*/
        $userLoggedName = null;
        
        if(Auth::check()) {
            $userLoggedName= auth()->user()->name;
            $userLoggedId= auth()->user()->id;
        } else {
            $userLoggedName = null;
            $userLoggedId = null;
        }
        /*-----*/

        return Inertia::render('Section/Sports', [
            'userAuth'       => $userAuth,
            'userLoggedName' => $userLoggedName,
            'userLoggedId'   => $userLoggedId,
            'videos'         => Video::where('title', 'LIKE', "%$request->q%")
                ->where('category_id', 4)
                ->orderBy('id', 'DESC')
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
                        'user'        => User::where('id', $video->user_id)->first(), //Get relation with user
                        'views'       => $video->views,
                    ];
                }),
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_image' => asset('storage/' . $user->profile_image),
                    ];
                })
        ]);
    }

    public function learning(Request $request)
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;

        if ( Auth::check() ) {
            $userAuth = true;
        } else {
            $userAuth = false;
        }
        /*-----*/

        /*Logged user verification*/
        $userLoggedName = null;
        
        if(Auth::check()) {
            $userLoggedName= auth()->user()->name;
            $userLoggedId= auth()->user()->id;
        } else {
            $userLoggedName = null;
            $userLoggedId = null;
        }
        /*-----*/

        return Inertia::render('Section/Learning', [
            'userAuth'       => $userAuth,
            'userLoggedName' => $userLoggedName,
            'userLoggedId'   => $userLoggedId,
            'videos'         => Video::where('title', 'LIKE', "%$request->q%")
                ->where('category_id', 5)
                ->orderBy('id', 'DESC')
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
                        'user'        => User::where('id', $video->user_id)->first(), //Get relation with user
                        'views'       => $video->views,
                    ];
                }),
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_image' => asset('storage/' . $user->profile_image),
                    ];
                })
        ]);
    }

    public function liked(Request $request)
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;

        if ( Auth::check() ) {
            $userAuth = true;
        } else {
            $userAuth = false;
        }
        /*-----*/

        /*Logged user verification*/
        $userLoggedName = null;
        
        if(Auth::check()) {
            $userLoggedName= auth()->user()->name;
            $userLoggedId= auth()->user()->id;
        } else {
            $userLoggedName = null;
            $userLoggedId = null;
        }
        /*-----*/
        
        $liked = Likes::where('user_id', $userLoggedId)->get();
        
        $sum = collect($liked)
            ->reduce(function ($carry, $item){
                return $carry + $item["count"];
            }, 0);

            
        $videos = [];
        for ($i=0; $i < $sum; $i++) { 
            // array_push($like, $liked[$i]->video_id);
            $video = Video::where('id', $liked[$i]->video_id)->first();
            array_push($videos, $video);
        }

        return Inertia::render('Section/Liked', [
            'userAuth'       => $userAuth,
            'userLoggedName' => $userLoggedName,
            'userLoggedId'   => $userLoggedId,
            'liked'          => $liked->load('video'),
            'videos'         => Video::where('title', 'LIKE', "%$request->q%")
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
                        'user'        => User::where('id', $video->user_id)->first(), //Get relation with user
                        'views'       => $video->views,
                    ];
                }),
        ]);
    }

    public function subscriptions()
    {
        /*Show user´s img or show Log in and Register*/ 
        $userAuth = false;

        if ( Auth::check() ) {
            $userAuth = true;
        } else {
            $userAuth = false;
        }
        /*-----*/

        /*Logged user verification*/
        $userLoggedName = null;
        
        if(Auth::check()) {
            $userLoggedName= auth()->user()->name;
            $userLoggedId= auth()->user()->id;
        } else {
            $userLoggedName = null;
            $userLoggedId = null;
        }
        /*-----*/

        $subscriptions = Subscriber::where('user_id', $userLoggedId)->get();
        
        return Inertia::render('Section/Subscriptions', [
            'userAuth'       => $userAuth,
            'userLoggedName' => $userLoggedName,
            'userLoggedId'   => $userLoggedId,
            'subscriptions'  => $subscriptions->load('user'),
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_imageAsset' => asset('storage/' . $user->profile_image),
                        'profile_image' => $user->profile_image,
                    ];
                })
        ]);
    }

}
