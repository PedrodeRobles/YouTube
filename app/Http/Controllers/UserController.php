<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(User $user, Request $request)
    {
        $userVideos = Video::latest()
            ->where('user_id', $user->id)
            ->get();

        //This user data
        $userName    = $user->name;
        $subscribers = $user->subscribers;
        $userId      = $user->id;

        //query
        $videos = Video::latest()
        ->where('title', 'LIKE', "%$request->q%")
        ->get();

        //get logged user
        $userLoggedId = auth()->user()->id;

        return Inertia::render('User/Index', [
            'userVideos'   => $userVideos->load('user'),
            'userName'     => $userName,
            'subscribers'  => $subscribers,
            'videos'       => $videos->load('user'),
            'userId'       => $userId,
            'userLoggedId' => $userLoggedId,
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
