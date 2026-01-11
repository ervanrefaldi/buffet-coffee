<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('index');
});

/*
|--------------------------------------------------------------------------
| AUTH - REGISTER
|--------------------------------------------------------------------------
*/
Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', [AuthController::class, 'store']);

/*
|--------------------------------------------------------------------------
| AUTH - LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| PROFILE USER
|--------------------------------------------------------------------------
*/
Route::get('/profile', function () {
    if (!session()->has('user_id')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $user = DB::table('users')
        ->where('users_id', session('user_id'))
        ->first();

    if (!$user) {
        session()->flush();
        return redirect('/login');
    }

    return view('profile', compact('user'));
});

Route::post('/profile/update', function (Request $request) {
    if (!session()->has('user_id')) {
        return redirect('/login');
    }

    // VALIDASI
    $request->validate([
        'name'  => ['required', 'regex:/^[a-zA-Z\s]+$/'],
        'email' => ['required', 'email'],
        'phone' => ['required', 'numeric'],
        'bio'   => ['nullable'],
    ], [
        'name.required'  => 'Nama wajib diisi.',
        'name.regex'     => 'Nama hanya boleh huruf.',
        'email.required' => 'Email wajib diisi.',
        'email.email'    => 'Format email tidak valid.',
        'phone.required' => 'Nomor telepon wajib diisi.',
        'phone.numeric'  => 'Nomor telepon hanya boleh angka.',
    ]);

    // CEK EMAIL UNIK (KECUALI MILIK SENDIRI)
    $emailExists = DB::table('users')
        ->where('email', $request->email)
        ->where('users_id', '!=', session('user_id'))
        ->exists();

    if ($emailExists) {
        return back()
            ->withErrors(['email' => 'Email sudah digunakan user lain.'])
            ->withInput();
    }

    // UPDATE DATABASE
    DB::table('users')
        ->where('users_id', session('user_id'))
        ->update([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'bio'        => $request->bio,
            'updated_at' => now(),
        ]);

    // UPDATE SESSION
    session([
        'user_name'  => $request->name,
        'user_email' => $request->email,
        'user_phone' => $request->phone,
    ]);

    return redirect('/profile')->with('success', 'Profile berhasil diperbarui.');
});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    session()->flush();
    return redirect('/')->with('success', 'Berhasil logout.');
});

/*
|--------------------------------------------------------------------------
| EMAIL VERIFICATION
|--------------------------------------------------------------------------
*/
Route::get('/verify-email', EmailVerificationPromptController::class)
    ->middleware('auth')
    ->name('verification.notice');

/*
|--------------------------------------------------------------------------
| USER ONLY
|--------------------------------------------------------------------------
*/
Route::get('/cart', function () {
    if (!session()->has('user_id')) {
        return redirect('/login');
    }

    return 'Halaman Cart (user only)';
});

Route::get('/checkout', function () {
    if (!session()->has('user_id')) {
        return redirect('/login');
    }

    return 'Halaman Checkout (user only)';
});

/*
|--------------------------------------------------------------------------
| OWNER ONLY
|--------------------------------------------------------------------------
*/
Route::get('/admin', function () {
    if (!session()->has('user_id')) {
        return redirect('/login');
    }

    if (session('user_role') !== 'owner') {
        abort(403);
    }

    return 'Dashboard Owner';
});

/*
|--------------------------------------------------------------------------
| PAGE
|--------------------------------------------------------------------------
*/
Route::get('/tentang', [PageController::class, 'about']);

/*
|--------------------------------------------------------------------------
| EVENT
|--------------------------------------------------------------------------
*/
Route::get('/event', function () {

    // Ambil hanya event yang masih aktif (berdasarkan tanggal)
    $events = DB::table('events')
        ->where('start_date', '<=', date('Y-m-d'))
        ->where('end_date', '>=', date('Y-m-d'))
        ->orderBy('start_date', 'asc')
        ->get();

    return view('event', compact('events'));
});
