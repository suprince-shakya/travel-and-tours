<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TourController;
use App\Http\Controllers\Frontend\CountryController;
use App\Http\Controllers\Frontend\RegionController;
use App\Http\Controllers\Frontend\CityController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\BlogCommentController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\DestinationController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\CompareController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController as AdminCountryController;
use App\Http\Controllers\Admin\RegionController as AdminRegionController;
use App\Http\Controllers\Admin\CityController as AdminCityController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\GuideController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogCommentController as AdminBlogCommentController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\HotelRoomController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Public Routes (no auth)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');
Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
Route::get('/countries/{slug}', [CountryController::class, 'show'])->name('countries.show');
Route::get('/regions/{slug}', [RegionController::class, 'show'])->name('regions.show');
Route::get('/cities/{slug}', [CityController::class, 'show'])->name('cities.show');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/{blog}/comments', [BlogCommentController::class, 'index'])->name('blog.comments.index');
Route::post('/blog/{blog}/comments', [BlogCommentController::class, 'store'])->name('blog.comments.store');
Route::get('/p/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::get('/about', [PageController::class, 'show'])->defaults('slug', 'about')->name('pages.about');
Route::get('/faq', [PageController::class, 'faq'])->name('pages.faq');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store']);
Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');
Route::post('/compare/add/{tourId}', [CompareController::class, 'add'])->name('compare.add');
Route::post('/compare/remove/{tourId}', [CompareController::class, 'remove'])->name('compare.remove');
Route::post('/compare/clear', [CompareController::class, 'clear'])->name('compare.clear');

/*
|--------------------------------------------------------------------------
| Admin Login (guest only)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Customer Auth (guest only)
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->name('customer.')->middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Customer Routes (auth required)
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->middleware('auth')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('customer.profile');
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('customer.password');
    Route::get('/bookings', [ProfileController::class, 'bookings'])->name('customer.bookings');
    Route::get('/reviews', [ProfileController::class, 'reviews'])->name('customer.reviews');
    Route::get('/wishlists', [ProfileController::class, 'wishlists'])->name('customer.wishlists');
    Route::post('/wishlist/toggle/{tourId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/wishlist/add/{tourId}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::get('/booking/{tourSlug}', [BookingController::class, 'step1'])->name('booking.step1');
    Route::post('/booking/{tourSlug}/step2', [BookingController::class, 'step2'])->name('booking.step2');
    Route::post('/booking/step3', [BookingController::class, 'step3'])->name('booking.step3');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/success/{bookingNumber}', [BookingController::class, 'success'])->name('booking.success');
    Route::get('/booking/invoice/{bookingNumber}', [BookingController::class, 'invoice'])->name('booking.invoice');
    Route::post('/booking/{bookingNumber}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::get('/payment/{bookingNumber}', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/callback/{gateway}', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (prefix admin, middleware auth + admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index']);

    Route::resource('users', UserController::class);
    Route::get('/customers', [UserController::class, 'customers'])->name('customers.index');
    Route::resource('categories', CategoryController::class);
    Route::get('/destinations', function () {
        return redirect()->route('admin.countries.index');
    })->name('destinations.index');
    Route::resource('countries', AdminCountryController::class);
    Route::get('/regions/by-country/{countryId}', [AdminRegionController::class, 'byCountry'])->name('regions.by-country');
    Route::get('/cities/by-country/{countryId}', [AdminCityController::class, 'byCountry'])->name('cities.by-country');
    Route::get('/cities/by-region/{regionId}', [AdminCityController::class, 'byRegion'])->name('cities.by-region');
    Route::resource('regions', AdminRegionController::class);
    Route::resource('cities', AdminCityController::class);
    Route::resource('tours', AdminTourController::class);

    Route::resource('bookings', AdminBookingController::class);
    Route::get('/bookings/{id}/invoice', [AdminBookingController::class, 'generateInvoice'])->name('bookings.invoice');
    Route::get('/bookings/export/csv', [AdminBookingController::class, 'export'])->name('bookings.export');

    Route::resource('payments', AdminPaymentController::class);
    Route::put('/payments/{id}/status', [AdminPaymentController::class, 'updateStatus'])->name('payments.status');

    Route::resource('reviews', AdminReviewController::class);
    Route::put('/reviews/{id}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::put('/reviews/{id}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');

    Route::resource('guides', GuideController::class);
    Route::resource('blogs', AdminBlogController::class);
    Route::resource('blog-categories', BlogCategoryController::class);
    Route::resource('blog-comments', AdminBlogCommentController::class);
    Route::put('/blog-comments/{id}/approve', [AdminBlogCommentController::class, 'approve'])->name('blog-comments.approve');
    Route::put('/blog-comments/{id}/reject', [AdminBlogCommentController::class, 'reject'])->name('blog-comments.reject');
    Route::resource('pages', AdminPageController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('hotels', HotelController::class);
    Route::resource('hotel-rooms', HotelRoomController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('coupons', CouponController::class);

    Route::resource('newsletters', AdminNewsletterController::class)->only(['index', 'destroy']);
    Route::get('/newsletters/export', [AdminNewsletterController::class, 'export'])->name('newsletters.export');
    Route::post('/newsletters/send', [AdminNewsletterController::class, 'send'])->name('newsletters.send');

    Route::resource('contacts', AdminContactController::class)->only(['index', 'show', 'destroy']);
    Route::put('/contacts/{id}/reply', [AdminContactController::class, 'reply'])->name('contacts.reply');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'password'])->name('profile.password');

    Route::get('/reports', function () {
        return redirect()->route('admin.reports.revenue');
    })->name('reports');
    Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('/reports/bookings', [ReportController::class, 'bookings'])->name('reports.bookings');
    Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    Route::get('/reports/tours', [ReportController::class, 'tours'])->name('reports.tours');
    Route::get('/reports/export/{type}/{format}', [ReportController::class, 'exportReport'])->name('reports.export');
});
