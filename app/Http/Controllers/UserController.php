<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(User $user)
    {
        $userVideos = Video::latest()
            ->where('user_id', $user->id)
            ->get();

        $userName = $user->name;

        return Inertia::render('User/Index', [
            'userVideos' => $userVideos->load('user'),
            'userName'   => $userName
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
