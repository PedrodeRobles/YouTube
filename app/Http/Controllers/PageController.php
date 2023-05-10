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
        return Inertia::render('Home', [
            'videos'         => $this->getVideos($request),
            'userAuthImg' => User::where('id', getUserLoggedId())
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

    public function gaming(Request $request)
    {
        return Inertia::render('Section/Gaming', [
            'videos'         => $this->getVideos($request, ['category_id' => 1]),
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_image' => asset('storage/' . $user->profile_image),
                    ];
                }),
            'userAuthImg' => User::where('id', getUserLoggedId())
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

    public function music(Request $request)
    {
        return Inertia::render('Section/Music', [
            'videos' => $this->getVideos($request, ['category_id' => 2]),
            'users'  => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_image' => asset('storage/' . $user->profile_image),
                    ];
                }),
            'userAuthImg' => User::where('id', getUserLoggedId())
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

    public function news(Request $request)
    {
        return Inertia::render('Section/News', [
            'news'           => true,
            'videos'         => $this->getVideos($request, ['category_id' => 3]),
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_image' => asset('storage/' . $user->profile_image),
                    ];
                }),
            'userAuthImg' => User::where('id', getUserLoggedId())
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

    public function sports(Request $request)
    {
        return Inertia::render('Section/Sports', [
            'videos' => $this->getVideos($request, ['category_id' => 4]),
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_image' => asset('storage/' . $user->profile_image),
                    ];
                }),
            'userAuthImg' => User::where('id', getUserLoggedId())
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

    public function learning(Request $request)
    {
        return Inertia::render('Section/Learning', [
            'videos' => $this->getVideos($request, ['category_id' => 5]),
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_image' => asset('storage/' . $user->profile_image),
                    ];
                }),
            'userAuthImg' => User::where('id', getUserLoggedId())
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

    public function liked()
    {
        $likes = Likes::where('user_id', getUserLoggedId())->get();

        return Inertia::render('Section/Liked', [
            'liked'          => $likes->load('video'),
            'userAuthImg' => User::where('id', getUserLoggedId())
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

    public function subscriptions()
    {
        $subscriptions = Subscriber::where('user_id', getUserLoggedId())->get();
        
        return Inertia::render('Section/Subscriptions', [
            'subscriptions'  => $subscriptions->load('user'),
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'profile_imageAsset' => asset('storage/' . $user->profile_image),
                        'profile_image' => $user->profile_image,
                    ];
                }),
            'userAuthImg' => User::where('id', getUserLoggedId())
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

    private function getVideos($request, $where = [])
    {
        $videos = Video::where('title', 'LIKE', "%$request->q%")
            ->orderBy('id', 'DESC')
            ->where($where)
            ->get()
            ->map(function($video) {
                return [
                    'id'          => $video->id,
                    'title'       => $video->title,
                    'image'       => asset('storage/' . $video->image),
                    // 'video'       => asset('storage/' . $video->video),
                    // 'description' => $video->description,
                    // 'category_id' => $video->category_id,
                    // 'user_id'     => $video->user_id,
                    'user'        => $video->user,
                    'userImg'     => asset('storage/' . $video->user->profile_image),
                    'views'       => $video->views,
                ];
            });

            // Video::where('title', 'LIKE', "%$request->q%")
            //     ->get()
            //     ->map(function($video) {
            //         return [
            //             'id'          => $video->id,
            //             'title'       => $video->title,
            //             'image'       => asset('storage/' . $video->image),
            //             'video'       => asset('storage/' . $video->video),
            //             'description' => $video->description,
            //             'category_id' => $video->category_id,
            //             'user_id'     => $video->user_id,
            //             'user'        => User::where('id', $video->user_id)->first(), //Get relation with user
            //             'views'       => $video->views,
            //         ];
            //     })

        return $videos;
    }

}
