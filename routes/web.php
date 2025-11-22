<?php

include_once('admin.php');
include_once('driver.php');

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Home\Posts\PostController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Home\Posts\PostController as HomePostController;
use App\Http\Controllers\Home\SlideController as HomeSlideController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/_setup', function () {
    Artisan::call('key:generate');
    Artisan::call('migrate', ['--force' => true]);
    Artisan::call('storage:link');
    return '✅ Laravel initialized';
});
Route::get('/_log', function () {
    return nl2br(file_get_contents(storage_path('logs/laravel.log')));
});

// Trang chủ mới - Dịch vụ lái xe
Route::get('/', [App\Http\Controllers\Driver\HomeController::class, 'index'])->name('driver.home');

// Demo route for contact info components
Route::get('/demo/contact-info', function () {
    return view('demo.contact-info');
})->name('demo.contact-info');

// Test contact info helper
Route::get('/test/contact-info', function () {
    return view('test-contact');
})->name('test.contact-info');

// Test admin contact info
Route::get('/test/admin-contact-info', function () {
    return view('test-admin-form');
})->name('test.admin-contact-info');

// Test global contact variables
Route::get('/test/global-contact', function () {
    return view('test-global-contact');
})->name('test.global-contact');

// Test updated pages
Route::get('/test/home-updated', function () {
    return view('driver.home');
})->name('test.home-updated');

Route::get('/test/contact-updated', function () {
    return view('driver.contact');
})->name('test.contact-updated');

// Test all pages
Route::get('/test/all-pages', function () {
    return view('test-all-pages');
})->name('test.all-pages');

// Trang đặt xe
Route::get('/booking', function () {
    return view('booking');
})->name('booking');

// Test driver layout with updated footer
Route::get('/test/driver-layout', function () {
    return view('driver.home');
})->name('test.driver-layout');

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login.index'); // Hiển thị form login
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post'); // Xử lý đăng nhập
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout'); // Xử lý đăng xuất
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login'); // Hiển thị form đăng nhập với google
Route::get('/auth/google/callback', [GoogleController::class, 'callback']); // Xử lý đăng nhập với google

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register.index'); // Hiển thị form đăng ký
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register'); // Xử lý đăng ký
Route::post('/send-otp-register', [RegisterController::class, 'sendOtp'])->name('send.register'); // Gửi OTP đăng ký tài khoản

Route::get('/forgot-password', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('forgot.password.index'); // Hiển thị form quên mật khẩu
Route::post('/send-otp-forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('send.forgot.password'); // Gửi OTP quên mật khẩu
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password'); // Xử lý tạo lại mật khẩu

// Routes cho phần trang chủ (không yêu cầu đăng nhập)
Route::prefix('home')->name('home.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/{id}', [PostController::class, 'show'])->name('show');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');
});

Route::post('/upload', [UploadController::class, 'upload'])->name('upload');

// Home Post routes
Route::get('/posts', [HomePostController::class, 'index'])->name('home.posts.index');
Route::get('/posts/{slug}', [HomePostController::class, 'show'])->name('home.posts.show');

// Admin routes
require __DIR__ . '/admin.php';

Route::get('/slides', [HomeSlideController::class, 'index'])->name('home.slides');

// Review routes
Route::post('/review/send-email', [ReviewController::class, 'sendReviewEmail'])->name('review.send-email');
Route::get('/review/{token}', [ReviewController::class, 'showReviewForm'])->where('token', '[A-Fa-f0-9]{32}')->name('review.form');
Route::post('/review/{token}', [ReviewController::class, 'submitReview'])->where('token', '[A-Fa-f0-9]{32}')->name('review.submit');

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create('/')
            ->addImage(Url::create('/favicon.ico')))
        ->add(Url::create('/gioi-thieu'))
        ->add(Url::create('/dich-vu'))
        ->add(Url::create('/bang-gia'))
        ->add(Url::create('/tin-tuc'))
        ->add(Url::create('/lien-he'));

    return $sitemap->toResponse(request());
});
