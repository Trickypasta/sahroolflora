<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReturnRequestController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\ShippingMethodController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\PostController as AdminPostController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReturnRequestController as AdminReturnRequestController;

use App\Http\Controllers\Admin;



/*
|--------------------------------------------------------------------------
| RUTE PUBLIK (Bisa diakses semua orang)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/blog', [PublicPostController::class, 'index'])->name('posts.index');
Route::get('/blog/{post:slug}', [PublicPostController::class, 'show'])->name('posts.show');
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/faq', function () {
    return view('faq');
})->name('faq');
Route::get('/terms-and-conditions', function () {
    return view('terms');
})->name('terms');
Route::get('/privacy-policy', function () {
    return view('privacy');
})->name('privacy');
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
Route::post('/coupon', [CouponController::class, 'apply'])->name('coupon.apply');
Route::get('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');
Route::get('/blog', [PostController::class, 'showPublicIndex'])->name('posts.index');
Route::get('/blog/{post:slug}', [PostController::class, 'showPublicPost'])->name('posts.show');
/*
|--------------------------------------------------------------------------
| RUTE TAMU (Hanya untuk yang BELUM LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('/promos', action: [CouponController::class, 'index'])->name('coupons.index');
    
});

/*
|--------------------------------------------------------------------------
| RUTE UNTUK SEMUA USER YANG SUDAH LOGIN (Customer & Admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Keranjang Belanja
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::post('/update/{cartItem}', [CartController::class, 'update'])->name('update');
        Route::post('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
        Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    });

    // Checkout & Pesanan Customer
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', function () {
        return view('checkout.success');
    })->name('checkout.success');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/pay', [OrderController::class, 'confirmPayment'])->name('orders.confirmPayment');

    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::get('/orders/{order}/returns/create', [ReturnRequestController::class, 'create'])->name('returns.create');
    Route::post('/returns', [ReturnRequestController::class, 'store'])->name('returns.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/track-order', [OrderController::class, 'showTrackForm'])->name('orders.track.form');
    Route::post('/track-order', [OrderController::class, 'findOrder'])->name('orders.track.find');
    Route::get('/coupons.index', action: [CouponController::class, 'index'])->name('coupons.index');

});

/*
|--------------------------------------------------------------------------
| RUTE KHUSUS ADMIN (Wajib login & punya role admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('products', AdminProductController::class);
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('posts', AdminPostController::class);
    Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials/{testimonial}/approve', [AdminTestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::delete('/testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');
    Route::resource('users', AdminUserController::class);
    Route::get('/returns', [AdminReturnRequestController::class, 'index'])->name('returns.index');
    Route::post('/returns/{returnRequest}', [AdminReturnRequestController::class, 'update'])->name('returns.update');
    Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::post('/stocks/{stock}', [StockController::class, 'update'])->name('stocks.update');
    Route::resource('/expenses', ExpenseController::class)->except(['index']);
    Route::resource('expenses', Admin\ExpenseController::class)->except(['show']);
    Route::resource('coupons', AdminCouponController::class)->except(['show', 'edit', 'update']);
    Route::resource('shipping-methods', ShippingMethodController::class)->except(['show']);
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::get('/payments/verify', [PaymentController::class, 'index'])->name('payments.verify.index');
    Route::post('/payments/verify/{order}', [PaymentController::class, 'verify'])->name('payments.verify.store');
    Route::get('/reports/customers', [Admin\ReportController::class, 'topCustomers'])->name('reports.customers');
    Route::post('/orders/{order}/add-tracking', [Admin\OrderController::class, 'addTrackingNumber'])->name('orders.addTracking');
    Route::get('/analytics', [Admin\ReportController::class, 'analytics'])->name('analytics.index');
    Route::get('/customers/{user}', [Admin\UserController::class, 'show'])->name('customers.show');
    Route::get('/reports/customers', [Admin\ReportController::class, 'topCustomers'])->name('reports.customers');
    Route::resource('posts', PostController::class)->except(['show']);
});
