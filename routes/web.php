<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use \UniSharp\LaravelFilemanager\Lfm;

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

// CACHE CLEAR ROUTE
Route::get('cache-clear', function () {
    Artisan::call('optimize:clear');
    request()->session()->flash('success', 'Successfully cache cleared.');
    return redirect()->back();
})->name('cache.clear');

// STORAGE LINKED ROUTE
Route::get('storage-link', [AdminController::class, 'storageLink'])->name('storage.link');

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Remove or comment out the GET route for logout
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Legacy Authentication (keeping for backward compatibility)
Route::get('user/login', [FrontendController::class, 'login'])->name('login.form');
Route::post('user/login', [FrontendController::class, 'loginSubmit'])->name('login.submit');
Route::get('user/logout', [FrontendController::class, 'logout'])->name('user.logout');
Route::get('user/register', [FrontendController::class, 'register'])->name('register.form');
Route::post('user/register', [FrontendController::class, 'registerSubmit'])->name('register.submit');

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/')->with('success', 'Email verified successfully!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('resent', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// Reset password
Route::get('password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Socialite
Route::get('login/{provider}', [AuthController::class, 'socialLogin'])->name('login.redirect');
Route::get('login/{provider}/callback', [AuthController::class, 'socialLoginCallback'])->name('login.callback');

// Legacy Social Login (keeping for backward compatibility)
Route::get('login/{provider}/', [LoginController::class, 'redirect'])->name('login.redirect');
Route::get('login/{provider}/callback/', [LoginController::class, 'Callback'])->name('login.callback');

Route::get('/', [FrontendController::class, 'home'])->name('home');

// Frontend Routes
Route::get('/home', [FrontendController::class, 'index']);
Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about-us');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/message', [MessageController::class, 'store'])->name('contact.store');
Route::get('product-detail/{slug}', [FrontendController::class, 'productDetail'])->name('product-detail');
Route::post('/product/search', [FrontendController::class, 'productSearch'])->name('product.search');
Route::get('/product-cat/{slug}', [FrontendController::class, 'productCat'])->name('product-cat');
Route::get('/product-sub-cat/{slug}/{sub_slug}', [FrontendController::class, 'productSubCat'])->name('product-sub-cat');
Route::get('/product-brand/{slug}', [FrontendController::class, 'productBrand'])->name('product-brand');

// Cart section
Route::get('/add-to-cart/{slug}', [CartController::class, 'addToCart'])->name('add-to-cart')->middleware('user');
Route::post('/add-to-cart', [CartController::class, 'singleAddToCart'])->name('single-add-to-cart')->middleware('user');
Route::get('cart-delete/{id}', [CartController::class, 'cartDelete'])->name('cart-delete');
Route::post('cart-update', [CartController::class, 'cartUpdate'])->name('cart.update');

Route::get('/cart', function () {
    return view('frontend.pages.cart');
})->name('cart');

// Checkout
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout')->middleware(['auth', 'verified', 'user']);
Route::post('checkout/store', 'CheckoutController@checkoutStore')->name('checkout.store');

// Wishlist
Route::get('/wishlist', function () {
    return view('frontend.pages.wishlist');
})->name('wishlist');
Route::get('/wishlist/{slug}', [WishlistController::class, 'wishlist'])->name('add-to-wishlist')->middleware('user');
Route::get('wishlist-delete/{id}', [WishlistController::class, 'wishlistDelete'])->name('wishlist-delete');
Route::post('cart/order', [OrderController::class, 'store'])->name('cart.order');
Route::get('order/pdf/{id}', [OrderController::class, 'pdf'])->name('order.pdf');
Route::get('/income', [OrderController::class, 'incomeChart'])->name('product.order.income');

Route::get('/product-grids', [FrontendController::class, 'productGrids'])->name('product-grids');
Route::get('/product-lists', [FrontendController::class, 'productLists'])->name('product-lists');
Route::match(['get', 'post'], '/filter', [FrontendController::class, 'productFilter'])->name('shop.filter');

// Order Track
Route::get('/product/track', [OrderController::class, 'orderTrack'])->name('order.track');
Route::post('product/track/order', [OrderController::class, 'productTrackOrder'])->name('product.track.order');

// Blog
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog-detail/{slug}', [FrontendController::class, 'blogDetail'])->name('blog.detail');
Route::get('/blog/search', [FrontendController::class, 'blogSearch'])->name('blog.search');
Route::post('/blog/filter', [FrontendController::class, 'blogFilter'])->name('blog.filter');
Route::get('blog-cat/{slug}', [FrontendController::class, 'blogByCategory'])->name('blog.category');
Route::get('blog-tag/{slug}', [FrontendController::class, 'blogByTag'])->name('blog.tag');

// NewsLetter
Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');

// Product Review
Route::resource('/review', 'ProductReviewController');
Route::post('product/{slug}/review', [ProductReviewController::class, 'store'])->name('review.store');

// Post Comment
Route::post('post/{slug}/comment', [PostCommentController::class, 'store'])->name('post-comment.store');
Route::resource('/comment', 'PostCommentController');

// Coupon
Route::post('/coupon-store', [CouponController::class, 'couponStore'])->name('coupon-store');

// Payment
Route::get('payment', [PayPalController::class, 'payment'])->name('payment');
Route::get('cancel', [PayPalController::class, 'cancel'])->name('payment.cancel');
Route::get('payment/success', [PayPalController::class, 'success'])->name('payment.success');

// Backend section start
Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'verified', 'admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/file-manager', function () {
        return view('backend.layouts.file-manager');
    })->name('file-manager');
    
    // user route
    Route::resource('users', 'Admin\UserController');
    // Banner
    Route::resource('banner', 'BannerController');
    // Brand
    Route::resource('brand', 'BrandController');
    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin-profile');
    Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('profile-update');
    // Category
    Route::resource('/category', 'CategoryController');
    // Product
    Route::resource('/product', 'ProductController');
    Route::resource('products', 'Admin\ProductController');
    // Ajax for sub category
    Route::post('/category/{id}/child', 'CategoryController@getChildByParent');
    // POST category
    Route::resource('/post-category', 'PostCategoryController');
    // Post tag
    Route::resource('/post-tag', 'PostTagController');
    // Post
    Route::resource('/post', 'PostController');
    // Message
    Route::resource('/message', 'MessageController');
    Route::get('/message/five', [MessageController::class, 'messageFive'])->name('messages.five');

    // Order
    Route::resource('/order', 'OrderController');
    Route::resource('orders', 'Admin\OrderController');
    // Shipping
    Route::resource('/shipping', 'ShippingController');
    // Coupon
    Route::resource('/coupon', 'CouponController');
    // Settings
    Route::get('settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('setting/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');

    // Notification
    Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('admin.notification');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('all.notification');
    Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('notification.delete');
    // Password Change
    Route::get('change-password', [AdminController::class, 'changePassword'])->name('change.password.form');
    Route::post('change-password', [AdminController::class, 'changPasswordStore'])->name('change.password');

    Route::get('/sales-data', [AdminController::class, 'getSalesData'])->name('admin.sales-data');
    Route::get('/product-sales', [AdminController::class, 'getProductSales'])->name('admin.product-sales');
    
    // Import products
    Route::get('product/import', 'ProductImportController@show')->name('product.import');
    Route::post('product/import', 'ProductImportController@import')->name('product.import.store');
    
    // User routes
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/{id}/status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('admin.users.status');
});

// User section start
Route::group(['prefix' => '/user', 'middleware' => ['auth', 'verified', 'user']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('user');
    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/profile/{id}', [HomeController::class, 'profileUpdate'])->name('user-profile-update');
    //  Order
    Route::get('/order', "HomeController@orderIndex")->name('user.order.index');
    Route::get('/order/show/{id}', "HomeController@orderShow")->name('user.order.show');
    Route::delete('/order/delete/{id}', [HomeController::class, 'userOrderDelete'])->name('user.order.delete');
    // Product Review
    Route::get('/user-review', [HomeController::class, 'productReviewIndex'])->name('user.productreview.index');
    Route::delete('/user-review/delete/{id}', [HomeController::class, 'productReviewDelete'])->name('user.productreview.delete');
    Route::get('/user-review/edit/{id}', [HomeController::class, 'productReviewEdit'])->name('user.productreview.edit');
    Route::patch('/user-review/update/{id}', [HomeController::class, 'productReviewUpdate'])->name('user.productreview.update');

    // Post comment
    Route::get('user-post/comment', [HomeController::class, 'userComment'])->name('user.post-comment.index');
    Route::delete('user-post/comment/delete/{id}', [HomeController::class, 'userCommentDelete'])->name('user.post-comment.delete');
    Route::get('user-post/comment/edit/{id}', [HomeController::class, 'userCommentEdit'])->name('user.post-comment.edit');
    Route::patch('user-post/comment/udpate/{id}', [HomeController::class, 'userCommentUpdate'])->name('user.post-comment.update');

    // Password Change
    Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
    Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');
});

// File Manager
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});

// Test Email
Route::get('/test-email', function() {
    $data = ['message' => 'This is a test email'];
    Mail::to('test@example.com')->send(new \App\Mail\TestMail($data));
    return 'Test email sent!';
});