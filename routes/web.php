<?php

use App\Models\Location;
use App\Models\LocationSubscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/a.json', function () {
    // return json_decode(Storage::disk('public')->get('light.json'));
    return json_decode(Storage::disk('public')->get('availability.json'));
    return Storage::disk('public')->get('availability.json');
})->name('a.json');

Route::get('/', function () {
    return view('clever');
})->name('home');

Route::get('/clever', function () {
    // dd(Auth::user()->subscriptions->where('location_id', 5)->where('type', 'ccs')->first());
    return view('clever');
});

Route::get('/test', function () {
    return view('test');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
