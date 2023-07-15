<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

Route::redirect('/', 'login');
Route::redirect('/', 'register');

// Route::get('/hola', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/google-callback', function () {
    $user = Socialite::driver('google')->user();

    $userExists = User::where('google_id', $user->id)->first();
    
    if ($userExists) {
        Auth::login($userExists);
    } else {
        $newUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'google_id' => $user->id,
        ]);

        Auth::login($newUser);
    }

    return redirect('/');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $userLogged = auth()->user();

        return Inertia::render('Dashboard', ['userLogged' => $userLogged]);
    })->name('dashboard');
});

/*Sections*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('gaming', [PageController::class, 'gaming'])->name('gaming');
Route::get('music', [PageController::class, 'music'])->name('music');
Route::get('news', [PageController::class, 'news'])->name('news');
Route::get('sports', [PageController::class, 'sports'])->name('sports');
Route::get('learning', [PageController::class, 'learning'])->name('learning');
Route::get('liked', [PageController::class, 'liked'])->name('liked')->middleware('auth');
Route::get('subscriptions', [PageController::class, 'subscriptions'])->name('subscriptions')->middleware('auth');

/*Own videos*/
Route::get('/{user}', [UserController::class, 'index'])->name('userVideos');
Route::resource('videos', VideoController::class);
Route::post('subscribe', [UserController::class, 'subscribe'])->middleware('auth');
Route::delete('unsubscribe', [UserController::class, 'unsubscribe'])->name('unsubscribe')->middleware('auth');
Route::post('videos/subscribe', [VideoController::class, 'subscribe'])->middleware('auth');
Route::post('videos/like', [VideoController::class, 'like'])->name('like')->middleware('auth');
Route::delete('unlike', [VideoController::class, 'unlike'])->name('unlike')->middleware('auth');
Route::post('videos/dislike', [VideoController::class, 'dislike'])->name('dislike')->middleware('auth');
Route::delete('undislike', [VideoController::class, 'undislike'])->name('undislike')->middleware('auth');
Route::post('videos/comment', [VideoController::class, 'comment'])->name('comment')->middleware('auth');

Route::get('users/editProfile/{user:id}', [UserController::class, 'editProfile'])->name('editProfile');
Route::put('users/editProfileImg/{user:id}', [UserController::class, 'editProfileImg']);
Route::put('users/editProfileBackgroundImg/{user:id}', [UserController::class, 'editProfileBackgroundImg']);

