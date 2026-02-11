<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/fix-storage', function () {
    try {
        try {
            Artisan::call('optimize:clear');
        } catch (\Exception $e) {
            // Ignore if cache table is missing
        }
        
        $link = public_path('storage');
        $status = "No existing storage link found.";
        if (file_exists($link)) {
            if (is_link($link)) {
                $status = "Link existed as symlink. Removing and recreating...";
                unlink($link);
            } else if (is_dir($link)) {
                $status = "Link existed as DIRECTORY (WRONG). Renaming to storage_old...";
                rename($link, public_path('storage_old_' . time()));
            }
        }
        
        Artisan::call('storage:link');
        
        // Fix Database Paths
        $fixedProducts = 0;
        foreach (\App\Models\Product::all() as $p) {
            if ($p->image) {
                // Clean common wrong prefixes
                $newPath = str_replace(['storage/', 'public/', 'public/storage/'], '', $p->image);
                if ($newPath !== $p->image) {
                    $p->image = $newPath;
                    $p->save();
                    $fixedProducts++;
                }
            }
        }

        $fixedEvents = 0;
        foreach (\App\Models\Event::all() as $e) {
            if ($e->image) {
                $newPath = str_replace(['storage/', 'public/', 'public/storage/'], '', $e->image);
                if ($newPath !== $e->image) {
                    $e->image = $newPath;
                    $e->save();
                    $fixedEvents++;
                }
            }
        }
        
        $appUrl = config('app.url');
        $imgbbKey = config('services.imgbb.key') ?? env('IMGBB_API_KEY');
        $imgbbStatus = $imgbbKey ? "Set (First 5 chars: " . substr($imgbbKey, 0, 5) . "...)" : "NOT SET";
        
        // Check image existence
        $lastProduct = \App\Models\Product::orderBy('created_at', 'desc')->first();
        $fileCheck = "N/A";
        if ($lastProduct && $lastProduct->image && !filter_var($lastProduct->image, FILTER_VALIDATE_URL)) {
             $fullPath = storage_path('app/public/' . $lastProduct->image);
             $exists = file_exists($fullPath);
             $fileCheck = "Product '{$lastProduct->name}' image: " . ($exists ? "Exists at $fullPath" : "NOT FOUND at $fullPath");
        }

        return "
            <h1>System Fix Report</h1>
            <p><b>Storage Link:</b> " . $status . " (New link created)</p>
            <p><b>Cache:</b> Cleared</p>
            <p><b>APP_URL:</b> " . $appUrl . "</p>
            <p><b>ImgBB API Key:</b> " . $imgbbStatus . "</p>
            <p><b>Last Product File Check:</b> " . $fileCheck . "</p>
            <p><b>Fixed Product Paths:</b> " . $fixedProducts . "</p>
            <p><b>Fixed Event Paths:</b> " . $fixedEvents . "</p>
            <hr>
            <h3>How to fix broken images:</h3>
            <ol>
                <li>Check <b>GitHub Secrets</b>: Is 'IMGBB_API_KEY' set?</li>
                <li>Wait for GitHub Actions to be <b>Green</b>.</li>
                <li><b>Delete</b> the broken product and <b>Upload</b> it again.</li>
            </ol>
        ";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\ForgotPasswordController;

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
})->name('register');

Route::post('/register', [AuthController::class, 'store']);

/*
|--------------------------------------------------------------------------
| AUTH - LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| FORGOT PASSWORD
|--------------------------------------------------------------------------
*/
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

Route::get('/orders', [\App\Http\Controllers\UserOrderController::class, 'index'])->name('user.orders.index');
Route::get('/orders/{id}/invoice', [\App\Http\Controllers\UserOrderController::class, 'invoice'])->name('user.orders.invoice');
Route::delete('/orders/{id}', [\App\Http\Controllers\UserOrderController::class, 'destroy'])->name('user.orders.destroy');

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
    \Illuminate\Support\Facades\Auth::logout();
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

/*
|--------------------------------------------------------------------------
| CART SYSTEM
|--------------------------------------------------------------------------
*/
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
Route::post('/cart/update/{id}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/delete/{id}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/cart/checkout', [\App\Http\Controllers\PaymentController::class, 'cartCheckoutPage'])->name('checkout.cart');
Route::post('/cart/checkout/process', [\App\Http\Controllers\PaymentController::class, 'processCartCheckout'])->name('checkout.cart.process');

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
Route::middleware(\App\Http\Middleware\EnsureOwnerOrAdmin::class)->prefix('owner')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\OwnerDashboardController::class, 'index'])->name('owner.dashboard');

    // Fitur: Kelola Event
    Route::resource('/event', \App\Http\Controllers\OwnerEventController::class);

    Route::resource('/menu', \App\Http\Controllers\OwnerProductController::class);
    Route::get('/orders', [\App\Http\Controllers\OwnerOrderController::class, 'index'])->name('owner.orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\OwnerOrderController::class, 'show'])->name('owner.orders.show');
    Route::post('/orders/{id}/status', [\App\Http\Controllers\OwnerOrderController::class, 'updateStatus'])->name('owner.orders.updateStatus');
    Route::delete('/orders/{id}', [\App\Http\Controllers\OwnerOrderController::class, 'destroy'])->name('owner.orders.destroy');
    
    // Fitur: Kelola Transaksi
    Route::get('/transactions', [\App\Http\Controllers\OwnerTransactionController::class, 'index'])->name('owner.transactions.index');
    Route::get('/transactions/{id}', [\App\Http\Controllers\OwnerTransactionController::class, 'show'])->name('owner.transactions.show');
    Route::post('/transactions/{id}/status', [\App\Http\Controllers\OwnerTransactionController::class, 'updateStatus'])->name('owner.transactions.updateStatus');
    Route::delete('/transactions/{id}', [\App\Http\Controllers\OwnerTransactionController::class, 'destroy'])->name('owner.transactions.destroy');

    Route::get('/laporan', [\App\Http\Controllers\OwnerReportController::class, 'index'])->name('owner.laporan.index');
    Route::get('/laporan/export/excel', [\App\Http\Controllers\OwnerReportController::class, 'exportExcel'])->name('owner.laporan.export.excel');
    Route::get('/laporan/export/word', [\App\Http\Controllers\OwnerReportController::class, 'exportWord'])->name('owner.laporan.export.word');
    
    // Khusus Master Owner (untuk mengelola staf/admin)
    Route::middleware(\App\Http\Middleware\EnsureMasterOwner::class)->group(function() {
        Route::resource('/admin', \App\Http\Controllers\OwnerAdminController::class)->names('admin');
    });
});

/*
|--------------------------------------------------------------------------
| TRANSAKSI / CHECKOUT
|--------------------------------------------------------------------------
*/
Route::get('/menu/{id}/checkout', [\App\Http\Controllers\MenuController::class, 'checkout'])->name('menu.checkout');
Route::post('/checkout', [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('checkout.process');

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
| PRODUK / MENU
|--------------------------------------------------------------------------
*/
Route::get('/menu', function () {
    $products = \App\Models\Product::orderBy('category')->orderBy('name')->get();
    return view('pages.menu', compact('products'));
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
