<?php

use Illuminate\Support\Facades\Auth;

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