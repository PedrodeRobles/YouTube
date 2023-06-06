<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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

function resizeImage($request)
{
    /*Change image dimension*/
    $path= $request->file('image');
    // Resize and encode to required type
    $img = Image::make($path)->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode();
        //Provide the file name with extension 
    $filename = time(). '.' .$path->getClientOriginalExtension();
    //Put file with own name
    Storage::put($filename, $img);
    //Move file to your location 
    Storage::move($filename, 'public/videos/images/' . $filename);
    /*-----*/

    return $filename;
}
