<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\FoodController as AdminFoodController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

use App\Http\Controllers\User\CategoryController as UserCategoryController;
use App\Http\Controllers\User\FoodController as UserFoodController;
use App\Http\Controllers\User\OrderItemController as UserOrderItemController;
use App\Http\Controllers\User\ReportController as UserReportController;

use App\Http\Controllers\Guest\CategoryController as GuestCategoryController;
use App\Http\Controllers\Guest\FoodController as GuestFoodController;

use App\Events\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'indexGuest'])->middleware('blockIfLoggedIn')->name('welcome');

Route::get('/register', [AuthController::class, 'showRegistrationPage'])->name('register.page');
Route::post('/register/verify', [AuthController::class, 'registerProcess'])->name('register.verify');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('guest')->name('guest.')->middleware('blockIfLoggedIn')->group(function () {
    Route::get('/foods', [GuestFoodController::class, 'index'])->name('foods.index');
    Route::get('/categories', [GuestCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{id}', [GuestCategoryController::class, 'show'])->name('categories.show');
    Route::get('/orders', fn() => redirect('/register'))->name('orders.index');
    Route::get('/reports', fn() => redirect('/register'))->name('reports.index');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'indexAdmin'])->name('dashboard');
    Route::resource('foods', AdminFoodController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('orders', AdminOrderController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('reports', AdminReportController::class);
    Route::get('/reports/load/{type}', [AdminReportController::class, 'load'])->name('reports.load');
});

Route::prefix('user')->name('member.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'indexCustomer'])->name('dashboard');
    Route::get('/foods', [UserFoodController::class, 'memberIndex'])->name('foods.index');
    Route::resource('categories', UserCategoryController::class);

    Route::get('/orders', [UserOrderItemController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [UserOrderItemController::class, 'show'])->name('orders.show');
    Route::get('/orders/cart', [UserOrderItemController::class, 'cart'])->name('orders.cart');
    Route::post('/orders/store', [UserOrderItemController::class, 'store'])->name('orders.store');
    Route::get('/orders/create', [UserOrderItemController::class, 'create'])->name('orders.create');

    Route::post('/orders/add', [UserOrderItemController::class, 'addToCart'])->name('orders.add');
    Route::post('/orders/remove', [UserOrderItemController::class, 'removeFromCart'])->name('orders.remove');
    Route::post('/orders/update', [UserOrderItemController::class, 'updateCart'])->name('orders.update');
    Route::post('/orders/checkout', [UserOrderItemController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders/clear', [UserOrderItemController::class, 'clearCart'])->name('orders.clear');
    Route::post('/orders/{order}/pay', [UserOrderItemController::class, 'pay'])->name('orders.pay');

});
Broadcast::routes(['middleware' => ['auth']]);
Route::post('/broadcasting/auth', function () {
    return response()->json(['user' => auth()->user()], 200);
});

Route::middleware('auth')->get('/order-status/{id}', function ($id) {
    $order = \App\Models\Order::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    return response()->json(['status' => $order->status]);
});



