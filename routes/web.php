<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController; // Kita pakai ini untuk blog publik
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReturnRequestController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin; // Namespace untuk semua controller Admin

/*
|--------------------------------------------------------------------------
| RUTE PUBLIK (Bisa diakses semua orang, login maupun tidak)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Produk & Kategori
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Blog (Kita gunakan PostController yang sudah ada method publiknya)
Route::get('/blog', [PostController::class, 'showPublicIndex'])->name('posts.index');
Route::get('/blog/{post:slug}', [PostController::class, 'showPublicPost'])->name('posts.show');

// Halaman Statis & Info
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');

// Testimoni & Promo
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
Route::get('/promos', [CouponController::class, 'index'])->name('promos.index');

// Kupon (Aksi apply & remove butuh session, jadi bisa di sini)
Route::post('/coupon', [CouponController::class, 'apply'])->name('coupon.apply');
Route::get('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');

// Lacak Pesanan
Route::get('/track-order', [OrderController::class, 'showTrackForm'])->name('orders.track.form');
Route::post('/track-order', [OrderController::class, 'findOrder'])->name('orders.track.find');


/*
|--------------------------------------------------------------------------
| RUTE AUTENTIKASI (Register & Login untuk Tamu, Logout untuk User)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


/*
|--------------------------------------------------------------------------
| RUTE UNTUK USER YANG SUDAH LOGIN (Customer & Admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Keranjang Belanja
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::post('/update/{cartItem}', [CartController::class, 'update'])->name('update');
        Route::post('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
    });

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', fn() => view('checkout.success'))->name('checkout.success');

    // Pesanan (Milik Customer)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/pay', [OrderController::class, 'confirmPayment'])->name('orders.confirmPayment');

    // Testimoni (Customer hanya bisa membuat)
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

    //alamat Pengguna
    Route::resource('addresses', AddressController::class);


    // Pengembalian Barang
    Route::get('/orders/{order}/returns/create', [ReturnRequestController::class, 'create'])->name('returns.create');
    Route::post('/returns', [ReturnRequestController::class, 'store'])->name('returns.store');
});


/*
|--------------------------------------------------------------------------
| RUTE KHUSUS ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // CRUD Utama
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('products', Admin\ProductController::class);
    Route::resource('posts', Admin\PostController::class);
    Route::resource('users', Admin\UserController::class);
    Route::resource('coupons', Admin\CouponController::class)->except(['show']);
    Route::resource('shipping-methods', Admin\ShippingMethodController::class)->except(['show']);
    Route::resource('payment-methods', Admin\PaymentMethodController::class);
    Route::resource('expenses', Admin\ExpenseController::class)->except(['show']);

    // Manajemen Pesanan
    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/update-status', [Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{order}/add-tracking', [Admin\OrderController::class, 'addTrackingNumber'])->name('orders.addTracking');

    // Manajemen Lainnya
    Route::get('/stocks', [Admin\StockController::class, 'index'])->name('stocks.index');
    Route::post('/stocks/{stock}', [Admin\StockController::class, 'update'])->name('stocks.update');
    Route::get('/messages', [Admin\ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/testimonials', [Admin\TestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials/{testimonial}/approve', [Admin\TestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::delete('/testimonials/{testimonial}', [Admin\TestimonialController::class, 'destroy'])->name('testimonials.destroy');
    Route::get('/returns', [Admin\ReturnRequestController::class, 'index'])->name('returns.index');
    Route::post('/returns/{returnRequest}', [Admin\ReturnRequestController::class, 'update'])->name('returns.update');
    Route::get('/payments/verify', [Admin\PaymentController::class, 'index'])->name('payments.verify.index');
    Route::post('/payments/verify/{order}', [Admin\PaymentController::class, 'verify'])->name('payments.verify.store');

    // Pengaturan Situs
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    // Laporan & Analitik
    Route::get('/analytics', [Admin\ReportController::class, 'analytics'])->name('analytics.index');
    Route::get('/reports/revenue', [Admin\ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('/reports/customers', [Admin\ReportController::class, 'topCustomers'])->name('reports.customers');
});
