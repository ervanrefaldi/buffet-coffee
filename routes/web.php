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
    // Ambil event yang sedang aktif ATAU akan datang (Upcoming)
    // Batasi 4 event untuk tampilan home
    $events = DB::table('events')
        ->where('end_date', '>=', date('Y-m-d')) 
        ->orderBy('start_date', 'asc')
        ->limit(4)
        ->get();

    // Ambil semua produk
    $products = \App\Models\Product::orderBy('created_at', 'desc')->get();

    return view('index', compact('events', 'products'));
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
| FORGOT PASSWORD
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\ForgotPasswordController;

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot-password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendCode'])->name('send-code');
Route::get('/verify-code', [ForgotPasswordController::class, 'showVerifyForm'])->name('verify-code');
Route::post('/verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('verify-code.post');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('reset-password');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password.post');

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
        'bio'   => ['nullable', 'max:20'],
    ], [
        'name.required'  => 'Nama wajib diisi.',
        'name.regex'     => 'Nama hanya boleh huruf.',
        'email.required' => 'Email wajib diisi.',
        'email.email'    => 'Format email tidak valid.',
        'phone.required' => 'Nomor telepon wajib diisi.',
        'phone.numeric'  => 'Nomor telepon hanya boleh angka.',
        'bio.max'        => 'Bio maksimal 20 karakter.',
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
    session()->invalidate();
    session()->regenerateToken();
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
Route::group(['prefix' => 'owner', 'middleware' => function ($request, $next) {
    if (!session()->has('user_id')) {
        return redirect('/login')->with('error', 'Silakan login sebagai owner.');
    }
    if (session('user_role') !== 'owner') {
        abort(403, 'Akses ditolak. Halaman ini khusus untuk Owner.');
    }
    return $next($request);
}], function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('owner.dashboard');
    });

    // Fitur: Kelola Event
    Route::resource('/event', \App\Http\Controllers\OwnerEventController::class);

    // Placeholder Routes for other features
    // Fitur: Kelola Menu
    Route::resource('/menu', \App\Http\Controllers\OwnerProductController::class);
    Route::get('/laporan', function () { return view('owner.laporan.index'); }); // Temporary
    Route::get('/admin', function () { return view('owner.admin.index'); });  // Temporary

    // Setup real routes for CRUD here
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

    // Ambil event yang sedang aktif ATAU akan datang (Upcoming)
    $events = DB::table('events')
        ->where('end_date', '>=', date('Y-m-d')) 
        ->orderBy('start_date', 'asc')
        ->get();

    return view('event', compact('events'));
});

/*
|--------------------------------------------------------------------------
| PRODUK
|--------------------------------------------------------------------------
*/
Route::get('/produk', function () {
    $products = \App\Models\Product::orderBy('category')->orderBy('name')->get();
    return view('pages.produk', compact('products'));
});

/*
|--------------------------------------------------------------------------
| MEMBERSHIP
|--------------------------------------------------------------------------
*/
Route::get('/membership', function () {
    return view('membership');
});

/*
|--------------------------------------------------------------------------
| ABOUT
|--------------------------------------------------------------------------
*/
Route::get('/about', function () {
    return view('pages.about');
});