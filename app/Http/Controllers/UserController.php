<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class UserController extends Controller
{
    public function index(User $user, Request $request)
    {
        /*Get this data from this user*/
        $userName            = $user->name;
        $subscribers         = $user->subscribers;
        $userId              = $user->id;
        $userImage           = $user->profile_image;
        $userBackgroundImage = $user->bg_image;
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
            'userName'            => $userName,
            'subscribers'         => $subscribers,
            'videos'              => $videos->load('user'),
            'userId'              => $userId,
            'userImage'           => $userImage,
            'userBackgroundImage' => $userBackgroundImage,
            'userLoggedId'        => $userLoggedId,
            'userLoggedName'      => $userLoggedName,
            'subscribed'          => $subscribed,
            'userVideos'          => Video::where('user_id', $user->id)
                ->orderBy('id', 'DESC')
                ->get()->map(function($video) {
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
            'users' => User::all()
                ->map(function ($user) {
                    return [
                        'id'            => $user->id,
                        'name'          => $user->name,
                        'profile_image' => asset('storage/' . $user->profile_image),
                        'bg_image'      => asset('storage/' . $user->bg_image),
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

    public function unsubscribe(Request $request)
    {
        /*Get subscription record and delete */
        $subscription = Subscriber::where('user_id', $request->user_id)
            ->where('otherUser', $request->otherUser)
            ->first();
        
        if ($subscription != null) {
            $subscription->delete();

            /* Subtract a subscriber to the user */
            $user = User::where('id', $request->otherUser)->first();
            $user->subscribers;
            $user->update([
                'subscribers' => $user->subscribers - 1,
            ]);
        } else {
            return "Please press the Unsubscribe button only once. Reload page";
        }

        

        return redirect()->back();
    }

    public function editProfile(User $user)
    {
        /*Verify user*/
        if ($user->id != auth()->user()->id) {
            abort(403);
        }

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

        return Inertia::render('User/EditProfile', [
            'user'           => $user,
            'userLoggedId'   => $userLoggedId,
            'userLoggedName' => $userLoggedName,
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

    public function editProfileImg(User $user, Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image',
        ]);

        if ($request->file('profile_image')) {
            Storage::delete('public/' . $user->profile_image);
            // $image = $request->file('profile_image')->store('user/profile', 'public');

            $filename = resizeImage($request->file('profile_image'), 200, 'public/user/profile/');

            $user->update([
                'profile_image' => 'user/profile/' . $filename
            ]);
            /*-----*/
        }

        return redirect()->back();
    }

    public function editProfileBackgroundImg(User $user, Request $request)
    {
        $request->validate([
            'bg_image' => 'required|image',
        ]);

        if ($request->file('bg_image')) {
            Storage::delete('public/' . $user->bg_image);
            // $image = $request->file('bg_image')->store('user/background', 'public');

            $filename = resizeImage($request->file('bg_image'), 300, 'public/user/background/');

            $user->update([
                'bg_image' => 'user/background/' . $filename
            ]);
            /*-----*/
        }

        return redirect()->back();
    }
}
