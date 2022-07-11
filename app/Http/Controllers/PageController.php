<?php

namespace App\Http\Controllers;

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

        return Inertia::render('Home', [
            'userAuth' => $userAuth,
            'videos'   => Video::where('title', 'LIKE', "%$request->q%")
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
        ]);
    }
}
