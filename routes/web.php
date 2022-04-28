<?php

use App\Models\Location;
use App\Models\LocationSubscriber;
use App\Models\ChargePoint;
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

// Route::get('/', function () {
//     return view('clever');
// })->name('home');

Route::get('/clever', function () {
    // dd(Auth::user()->subscriptions->where('location_id', 5)->where('type', 'ccs')->first());
    return view('clever');
});

Route::get('/', function () {
    return view('new', [
        // 'locations' => Location::first()->get(),
    ]);
})->name('home');

Route::get('/my-chargepoints', function () {
    return view('new', [
        'myChargepoints' => true,
    ]);
})->name('my-chargepoints');

Route::get('/chargepoints/{chargePoint:clever_id}', function (Request $request, ChargePoint $chargePoint) {
    dd($chargePoint);
});

Route::get('/locations/{location}', function (Request $request, Location $location) {
    dd($location->load('availability', 'subscribers', 'chargePoints', 'connectors'));
});

Route::get('/unsubscribe/{locationSubscriber:uuid}', function (Request $request, LocationSubscriber $locationSubscriber) {
    $locationSubscriber->delete();
    return redirect()->route('home')->withErrors(['success' => 'You have been unsubscribed from this location.']);
})->name('unsubscribe');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/favorite/{location}', function (Request $request, Location $location) {
    return LocationSubscriber::updateOrCreate([
        'location_id' => $location->id,
        'user_id' => auth()->user()->id,
        'type' => $request->plugType,
    ]);
});

Route::get('/telegram-webhook', function (Request $request) {
    dd($request->all());
});
