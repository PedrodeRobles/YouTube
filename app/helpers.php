<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;

function getUserLoggedName()
{
    Auth::check() ? $userLoggedName= auth()->user()->name : $userLoggedName = null;

    return $userLoggedName;
}

function getUserLoggedId()
{
    Auth::check() ? $userLoggedId = auth()->user()->id : $userLoggedId = null;

    return $userLoggedId;
}

function getUserAuthImg()
{
    return User::where('id', getUserLoggedId())
        ->get()
        ->map(function ($user) {
            return [
                'id' => $user->id,
                'profile_image' => asset('storage/' . $user->profile_image),
                'image'         => $user->profile_image
            ];
    });
}
