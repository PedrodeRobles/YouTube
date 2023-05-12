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
            'videos' => $this->getVideos($request),
        ]);
    }

    public function gaming(Request $request)
    {
        return Inertia::render('Section/Gaming', [
            'videos' => $this->getVideos($request, ['category_id' => 1])
        ]);
    }

    public function music(Request $request)
    {
        return Inertia::render('Section/Music', [
            'videos' => $this->getVideos($request, ['category_id' => 2])
        ]);
    }

    public function news(Request $request)
    {
        return Inertia::render('Section/News', [
            'videos' => $this->getVideos($request, ['category_id' => 3])
        ]);
    }

    public function sports(Request $request)
    {
        return Inertia::render('Section/Sports', [
            'videos' => $this->getVideos($request, ['category_id' => 4])
        ]);
    }

    public function learning(Request $request)
    {
        return Inertia::render('Section/Learning', [
            'videos' => $this->getVideos($request, ['category_id' => 5])
        ]);
    }

    public function liked()
    {
        $likes = Likes::where('user_id', getUserLoggedId())->get();

        return Inertia::render('Section/Liked', [
            'liked' => $likes->load('video'),
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
                    'user'        => $video->user,
                    'userImg'     => asset('storage/' . $video->user->profile_image),
                    'views'       => $video->views,
                ];
            });

        return $videos;
    }

}
