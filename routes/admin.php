<?php


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Permissions\PermissionController;
use App\Http\Controllers\Admin\Posts\PostController;
use App\Http\Controllers\Admin\Roles\RoleController;
use App\Http\Controllers\Admin\Series\SeriesController;
use App\Http\Controllers\Admin\Slides\SlideController;
use App\Http\Controllers\Admin\Users\ProfileController;
use App\Http\Controllers\Admin\Users\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Categories\CategoryController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::middleware('canAny:access_dashboard,access_users,access_roles,access_permissions,access_slides')->get('/', function () {
        // Chuyển hướng dựa trên quyền truy cập
        return redirect()->route('admin.dashboard');
    })->name('index');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('canAny:access_dashboard')
        ->name('dashboard');

    Route::prefix('users')->name('users.')->middleware('canAny:access_users')->group(function () { // Chức năng quản lý tài khoản
        Route::get('/index', [UserController::class, 'index'])->name('index'); // Hiển thị danh sách tài khoản
        Route::get('/create', [UserController::class, 'create'])->name('create'); // Hiển thị form tạo tài khoản
        Route::post('/store', [UserController::class, 'store'])->name('store'); // Xử lý tạo tài khoản
        Route::get('/{id}', [UserController::class, 'show'])->whereNumber('id')->name('show'); // Hiển thị chi tiết tài khoản
        Route::get('/edit/{id}', [UserController::class, 'edit'])->whereNumber('id')->name('edit'); // Hiển thị form chỉnh sửa
        Route::post('/update/{id}', [UserController::class, 'update'])->whereNumber('id')->name('update'); // Xử lý chỉnh sửa
        Route::post('/delete/{id}', [UserController::class, 'delete'])->whereNumber('id')->name('delete'); // Xử lý xóa
        // 🚀 Hiển thị giao diện phân vai trò
        Route::get('/assign-roles/{id}', [UserController::class, 'showAssignRolesForm'])->name('showAssignRolesForm');
        // 🚀 Xử lý gán vai trò cho người dùng
        Route::post('/assign-roles/{id}', [UserController::class, 'assignRoles'])->name('assignRoles');
        Route::post('/{id}/toggle-block', [UserController::class, 'toggleBlock'])->whereNumber('id')->name('toggleBlock');
        Route::get('/get-user-info/{id}', [UserController::class, 'getUserInfo'])->name('getUserInfo'); // Lấy thông tin user
        Route::get('/autocomplete', [UserController::class, 'autocomplete'])->name('autocomplete'); // Lấy vai trò theo từ
    });

    // Route cho load view
    Route::post('/load-view', [\App\Http\Controllers\Admin\ViewController::class, 'loadView'])->name('loadView');

    // Autocomplete permissions (allow roles or permissions access)
    Route::get('/permissions/autocomplete', [PermissionController::class, 'autocomplete'])
        ->middleware('canAny:access_roles,access_permissions')
        ->name('permissions.autocomplete');

    Route::prefix('profiles')->name('profiles.')->group(function () { // Chức năng quản lý hồ sơ
        Route::get('/edit/{user_id}', [ProfileController::class, 'edit'])->name('edit'); // Hiển thị form chỉnh sửa
        Route::post('/update/{user_id}', [ProfileController::class, 'update'])->name('update'); // Xử lý chỉnh sửa
    });

    Route::prefix('roles')->name('roles.')->middleware('canAny:access_roles')->group(function () { // Chức năng quản lý vai trò
        Route::get('/index', [RoleController::class, 'index'])->name('index'); // Hiển thị danh sách vai trò
        Route::get('/create', [RoleController::class, 'create'])->name('create'); // Hiển thị form tạo mới vai trò
        Route::post('/store', [RoleController::class, 'store'])->name('store'); // Xử lý thêm mới vai trò
        Route::get('/{id}', [RoleController::class, 'show'])->whereNumber('id')->name('show'); // Hiển thị chi tiết vai trò
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->whereNumber('id')->name('edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->whereNumber('id')->name('update');
        Route::delete('/delete/{id}', [RoleController::class, 'delete'])->whereNumber('id')->name('delete');
        Route::get('/autocomplete', [RoleController::class, 'autocomplete'])->name('autocomplete'); // Lấy vai trò theo từ
        Route::post('/{role}/toggle-status', [RoleController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{role}/toggle-featured', [RoleController::class, 'toggleFeatured'])->name('toggle-featured');
    });

    // Chức năng quản lý quyền
    Route::prefix('permissions')->name('permissions.')->middleware('canAny:access_permissions')->group(function () {
        Route::get('/index', [PermissionController::class, 'index'])->name('index'); // Hiển thị danh sách quyền
        Route::get('/create', [PermissionController::class, 'create'])->name('create'); // Hiển thị form tạo mới quyền
        Route::post('/store', [PermissionController::class, 'store'])->name('store'); // Xử lý thêm mới quyền
        Route::get('/{id}', [PermissionController::class, 'show'])->whereNumber('id')->name('show'); // Hiển thị chi tiết quyền
        Route::get('/edit/{id}', [PermissionController::class, 'edit'])->whereNumber('id')->name('edit'); // Hiển thị form sửa quyền
        Route::post('/update/{id}', [PermissionController::class, 'update'])->whereNumber('id')->name('update'); // Xử lý sửa quyền
        Route::delete('/delete/{id}', [PermissionController::class, 'delete'])->whereNumber('id')->name('delete'); // Xử lý xóa quyền
        Route::post('/{permission}/toggle-status', [PermissionController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/', [ProfileController::class, 'update'])->name('update');
    });

    // Roles - Using resource routes
    // Route::resource('roles', RoleController::class);

    // Permissions - Using resource routes
    // Route::resource('permissions', PermissionController::class);

    // Categories
    Route::resource('categories', CategoryController::class);
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show'); // Hiển thị chi tiết danh mục
    Route::post('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::post('/categories/{category}/toggle-featured', [CategoryController::class, 'toggleFeatured'])->name('categories.toggle-featured');

    // Posts
    Route::resource('posts', PostController::class)->middleware('canAny:access_users');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show'); // Hiển thị chi tiết bài viết

    // Slides
    Route::resource('slides', \App\Http\Controllers\Admin\Slides\SlideController::class)->middleware('canAny:access_users');
    Route::get('/slides/{slide}', [\App\Http\Controllers\Admin\Slides\SlideController::class, 'show'])->name('slides.show'); // Hiển thị chi tiết slide
    Route::post('/slides/{slide}/toggle-status', [\App\Http\Controllers\Admin\Slides\SlideController::class, 'toggleStatus'])->name('slides.toggle-status');
    Route::post('/slides/{slide}/toggle-featured', [\App\Http\Controllers\Admin\Slides\SlideController::class, 'toggleFeatured'])->name('slides.toggle-featured');
    
    Route::middleware('canAny:access_users')->group(function () {
        Route::get('/home-banner', [\App\Http\Controllers\Admin\HomeBannerController::class, 'edit'])->name('home-banner.edit');
        Route::post('/home-banner', [\App\Http\Controllers\Admin\HomeBannerController::class, 'update'])->name('home-banner.update');
    });


    Route::prefix('posts')->name('posts.')->middleware('canAny:access_users')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PostController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\PostController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\PostController::class, 'store'])->name('store');
        Route::get('/{post}', [\App\Http\Controllers\Admin\PostController::class, 'show'])->name('show'); // Hiển thị chi tiết bài viết
        Route::get('/{post}/edit', [\App\Http\Controllers\Admin\PostController::class, 'edit'])->name('edit');
        Route::post('/{post}', [\App\Http\Controllers\Admin\PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [\App\Http\Controllers\Admin\PostController::class, 'destroy'])->name('destroy');
        Route::post('/{post}/toggle-status', [\App\Http\Controllers\Admin\PostController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{post}/toggle-featured', [\App\Http\Controllers\Admin\PostController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::post('/{post}/toggle-status', [\App\Http\Controllers\Admin\PostController::class, 'toggleStatus'])->name('toggle-status-json');
        Route::post('/{post}/toggle-featured', [\App\Http\Controllers\Admin\PostController::class, 'toggleFeatured'])->name('toggle-featured-json');
    });

    // Post Categories Management
    Route::prefix('post-categories')->name('post-categories.')->middleware('canAny:access_users')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PostCategoryController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\PostCategoryController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\PostCategoryController::class, 'store'])->name('store');
        Route::get('/autocomplete', [\App\Http\Controllers\Admin\PostCategoryController::class, 'autocomplete'])->name('autocomplete');
        Route::get('/{category}', [\App\Http\Controllers\Admin\PostCategoryController::class, 'show'])->name('show'); // Hiển thị chi tiết danh mục bài viết
        Route::get('/{category}/edit', [\App\Http\Controllers\Admin\PostCategoryController::class, 'edit'])->name('edit');
        Route::post('/{category}', [\App\Http\Controllers\Admin\PostCategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [\App\Http\Controllers\Admin\PostCategoryController::class, 'destroy'])->name('destroy');
        Route::post('/{category}/toggle-status', [\App\Http\Controllers\Admin\PostCategoryController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{category}/toggle-status', [\App\Http\Controllers\Admin\PostCategoryController::class, 'toggleStatus'])->name('toggle-status-json');
        Route::post('/{category}/toggle-featured', [\App\Http\Controllers\Admin\PostCategoryController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::post('/{category}/toggle-featured', [\App\Http\Controllers\Admin\PostCategoryController::class, 'toggleFeatured'])->name('toggle-featured-json');
    });

    // Post Tags Management
    Route::prefix('post-tags')->name('post-tags.')->middleware('canAny:access_users')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PostTagController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\PostTagController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\PostTagController::class, 'store'])->name('store');
        Route::get('/{tag}', [\App\Http\Controllers\Admin\PostTagController::class, 'show'])->name('show'); // Hiển thị chi tiết tag
        Route::get('/{tag}/edit', [\App\Http\Controllers\Admin\PostTagController::class, 'edit'])->name('edit');
        Route::post('/{tag}', [\App\Http\Controllers\Admin\PostTagController::class, 'update'])->name('update');
        Route::delete('/{tag}', [\App\Http\Controllers\Admin\PostTagController::class, 'destroy'])->name('destroy');
        Route::post('/{tag}/toggle-status', [\App\Http\Controllers\Admin\PostTagController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{tag}/toggle-status', [\App\Http\Controllers\Admin\PostTagController::class, 'toggleStatus'])->name('toggle-status-json');
        Route::post('/{tag}/toggle-featured', [\App\Http\Controllers\Admin\PostTagController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::post('/{tag}/toggle-featured', [\App\Http\Controllers\Admin\PostTagController::class, 'toggleFeatured'])->name('toggle-featured-json');
    });

    // Cấu hình thông tin liên hệ (chỉ có 1 bản ghi)
    Route::prefix('contact-info')->name('contact-info.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ContactInfoController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\Admin\ContactInfoController::class, 'store'])->name('store');
        Route::get('/show', [\App\Http\Controllers\Admin\ContactInfoController::class, 'show'])->name('show');
    });

    // Debug route
    Route::post('contact-info-debug', function (\Illuminate\Http\Request $request) {
        try {
            $service = app(\App\Services\Admin\ContactInfoService::class);
            $result = $service->updateContactInfo($request->all());

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
                'error' => $e->getTraceAsString()
            ], 500);
        }
    })->name('contact-info.debug');



    // ===== DRIVER SERVICE ADMIN ROUTES =====
    Route::prefix('driver')->name('driver.')->middleware('canAny:access_driver_services,access_driver_testimonials,access_driver_contacts')->group(function () {

        // Dashboard
        Route::get('/', [\App\Http\Controllers\Admin\Driver\DriverDashboardController::class, 'index'])->name('dashboard');
        Route::get('/chart-data', [\App\Http\Controllers\Admin\Driver\DriverDashboardController::class, 'getChartData'])->name('chart-data');
        Route::get('/real-time-stats', [\App\Http\Controllers\Admin\Driver\DriverDashboardController::class, 'getRealTimeStats'])->name('real-time-stats');

        // Quản lý dịch vụ lái xe
        Route::prefix('services')->name('services.')->middleware('auth')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\Driver\DriverServiceController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\Driver\DriverServiceController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\Driver\DriverServiceController::class, 'store'])->name('store');
            Route::post('/update-order', [\App\Http\Controllers\Admin\Driver\DriverServiceController::class, 'updateOrder'])->name('update-order');
            Route::get('/{driverService}/edit', [\App\Http\Controllers\Admin\Driver\DriverServiceController::class, 'edit'])->name('edit');
            Route::post('/{driverService}', [\App\Http\Controllers\Admin\Driver\DriverServiceController::class, 'update'])->name('update');
            Route::delete('/{driverService}', [\App\Http\Controllers\Admin\Driver\DriverServiceController::class, 'destroy'])->name('destroy');
            Route::post('/{driverService}/toggle-status', [\App\Http\Controllers\Admin\Driver\DriverServiceController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{driverService}/toggle-featured', [\App\Http\Controllers\Admin\Driver\DriverServiceController::class, 'toggleFeatured'])->name('toggle-featured');
            Route::get('/{driverService}/view', [\App\Http\Controllers\Admin\Driver\DriverServiceController::class, 'view'])->name('view'); // Hiển thị HTML view
            Route::get('/{driverService}', [\App\Http\Controllers\Admin\Driver\DriverServiceController::class, 'show'])->name('show'); // Trả về JSON data cho modal
        });

        // Quản lý quy tắc giá cố định
        Route::prefix('pricing-rules')->name('pricing-rules.')->middleware('canAny:access_driver_services')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\Driver\DriverPricingRuleController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\Driver\DriverPricingRuleController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\Driver\DriverPricingRuleController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\App\Http\Controllers\Admin\Driver\DriverPricingRuleController::class, 'edit'])->name('edit');
            Route::post('/{id}', [\App\Http\Controllers\Admin\Driver\DriverPricingRuleController::class, 'update'])->name('update');
            Route::put('/{id}', [\App\Http\Controllers\Admin\Driver\DriverPricingRuleController::class, 'update'])->name('update-put');
            Route::delete('/{id}', [\App\Http\Controllers\Admin\Driver\DriverPricingRuleController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/delete', [\App\Http\Controllers\Admin\Driver\DriverPricingRuleController::class, 'destroy'])->name('destroy-post');
            Route::post('/{id}/toggle-status', [\App\Http\Controllers\Admin\Driver\DriverPricingRuleController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{id}/toggle-featured', [\App\Http\Controllers\Admin\Driver\DriverPricingRuleController::class, 'toggleFeatured'])->name('toggle-featured');
        });

        // Quản lý khoảng cách
        Route::prefix('distance-tiers')->name('distance-tiers.')->middleware('canAny:access_driver_services')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\Driver\DriverDistanceTierController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\Driver\DriverDistanceTierController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\Driver\DriverDistanceTierController::class, 'store'])->name('store');
            Route::get('/{id}', [\App\Http\Controllers\Admin\Driver\DriverDistanceTierController::class, 'show'])->name('show'); // Hiển thị chi tiết khoảng cách
            Route::get('/{id}/edit', [\App\Http\Controllers\Admin\Driver\DriverDistanceTierController::class, 'edit'])->name('edit');
            Route::post('/{id}', [\App\Http\Controllers\Admin\Driver\DriverDistanceTierController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\Admin\Driver\DriverDistanceTierController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/delete', [\App\Http\Controllers\Admin\Driver\DriverDistanceTierController::class, 'destroy'])->name('destroy-post');
            Route::post('/{id}/toggle-status', [\App\Http\Controllers\Admin\Driver\DriverDistanceTierController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{id}/toggle-featured', [\App\Http\Controllers\Admin\Driver\DriverDistanceTierController::class, 'toggleFeatured'])->name('toggle-featured');
        });

        // Quản lý giá theo khoảng cách linh hoạt
        Route::prefix('pricing-tiers')->name('pricing-tiers.')->middleware('canAny:access_driver_services')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\Driver\DriverPricingTierController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\Driver\DriverPricingTierController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\Driver\DriverPricingTierController::class, 'store'])->name('store');
            Route::get('/{id}', [\App\Http\Controllers\Admin\Driver\DriverPricingTierController::class, 'show'])->name('show'); // Hiển thị chi tiết mức giá
            Route::get('/{id}/edit', [\App\Http\Controllers\Admin\Driver\DriverPricingTierController::class, 'edit'])->name('edit');
            Route::post('/{id}', [\App\Http\Controllers\Admin\Driver\DriverPricingTierController::class, 'update'])->name('update');
            Route::post('/{id}', [\App\Http\Controllers\Admin\Driver\DriverPricingTierController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\Admin\Driver\DriverPricingTierController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/toggle-status', [\App\Http\Controllers\Admin\Driver\DriverPricingTierController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{id}/toggle-featured', [\App\Http\Controllers\Admin\Driver\DriverPricingTierController::class, 'toggleFeatured'])->name('toggle-featured');
        });

        // Test routes (temporary)
        Route::prefix('test')->name('test.')->group(function () {
            Route::get('/pricing', [\App\Http\Controllers\Admin\Driver\TestPricingController::class, 'test'])->name('pricing');
            Route::get('/distance-tiers', [\App\Http\Controllers\Admin\Driver\TestPricingController::class, 'testDistanceTiers'])->name('distance-tiers');
            Route::get('/pricing-rules', [\App\Http\Controllers\Admin\Driver\TestPricingController::class, 'testPricingRules'])->name('pricing-rules');
            Route::get('/pricing-tiers', [\App\Http\Controllers\Admin\Driver\TestPricingController::class, 'testPricingTiers'])->name('pricing-tiers');
        });

        // Quản lý testimonials
        Route::prefix('testimonials')->name('testimonials.')->middleware('canAny:access_driver_testimonials')->group(function () {
            Route::resource('/', \App\Http\Controllers\Admin\Driver\TestimonialController::class)->except(['show']);
            Route::get('/{testimonial}', [\App\Http\Controllers\Admin\Driver\TestimonialController::class, 'show'])->name('show');
            Route::get('/{testimonial}/info', [\App\Http\Controllers\Admin\Driver\TestimonialController::class, 'getTestimonialInfo'])->name('getTestimonialInfo');
            Route::post('/{testimonial}/toggle-status', [\App\Http\Controllers\Admin\Driver\TestimonialController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{testimonial}/toggle-featured', [\App\Http\Controllers\Admin\Driver\TestimonialController::class, 'toggleFeatured'])->name('toggle-featured');
            Route::post('/update-order', [\App\Http\Controllers\Admin\Driver\TestimonialController::class, 'updateOrder'])->name('update-order');
            Route::get('/filter/status', [\App\Http\Controllers\Admin\Driver\TestimonialController::class, 'filterByStatus'])->name('filter-by-status');
            Route::get('/search', [\App\Http\Controllers\Admin\Driver\TestimonialController::class, 'search'])->name('search');
            Route::post('/bulk-action', [\App\Http\Controllers\Admin\Driver\TestimonialController::class, 'bulkAction'])->name('bulk-action');
        });

        // Quản lý liên hệ từ website lái xe
        Route::prefix('contacts')->name('contacts.')->middleware('canAny:access_driver_contacts')->group(function () {
            Route::resource('/', \App\Http\Controllers\Admin\Driver\DriverContactController::class)->except(['show']);
            Route::get('/{id}', [\App\Http\Controllers\Admin\Driver\DriverContactController::class, 'show'])->name('show'); // Hiển thị chi tiết liên hệ
            Route::post('/{id}/status', [\App\Http\Controllers\Admin\Driver\DriverContactController::class, 'updateStatus'])->name('update-status');
            Route::post('/{id}/mark-read', [\App\Http\Controllers\Admin\Driver\DriverContactController::class, 'markAsRead'])->name('mark-read');
            Route::post('/{id}/toggle-status', [\App\Http\Controllers\Admin\Driver\DriverContactController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{id}/toggle-featured', [\App\Http\Controllers\Admin\Driver\DriverContactController::class, 'toggleFeatured'])->name('toggle-featured');
            Route::get('/filter/status', [\App\Http\Controllers\Admin\Driver\DriverContactController::class, 'filterByStatus'])->name('filter-by-status');
            Route::get('/search', [\App\Http\Controllers\Admin\Driver\DriverContactController::class, 'search'])->name('search');
            Route::post('/bulk-action', [\App\Http\Controllers\Admin\Driver\DriverContactController::class, 'bulkAction'])->name('bulk-action');
            Route::get('/export', [\App\Http\Controllers\Admin\Driver\DriverContactController::class, 'export'])->name('export');
        });
    });

    // Upload routes
    Route::post('upload/image', [\App\Http\Controllers\UploadController::class, 'upload'])
        ->middleware('auth')
        ->name('upload.image');

    // CKEditor upload - chấp nhận cả query string và không có
    Route::post('upload/ckeditor', [\App\Http\Controllers\UploadController::class, 'uploadImage'])
        ->middleware('auth')
        ->name('upload.ckeditor');
});
