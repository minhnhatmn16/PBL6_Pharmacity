<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceiverAddressController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartDetailController;
use App\Http\Controllers\VietnamZoneController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//user
Route::prefix('user')->controller(UserController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('verify-email', 'verifyEmail');
    Route::post('login', 'login');
    Route::post('forgot-password', 'forgotPassword');
    Route::post('reset-password', 'resetPassword');
    Route::post('resend-verify-email', 'resendVerifyEmail');
    Route::middleware('check.auth:user_api')->group(function () {
        Route::get('logout', 'logout');
        Route::get('profile', 'profile');
        Route::post('update-profile', 'updateProfile');
        Route::post('change-password', 'changePassword');
    });
});
Route::prefix('receiver-address')->controller(ReceiverAddressController::class)->group(function () {
    Route::middleware('check.auth:user_api')->group(function () {
        Route::post('add', 'add');
        Route::get('{id}', 'getAddress');
        Route::post('update/{id}', 'update');
        Route::get('', 'getAll');
        Route::delete('delete/{id}', 'delete');
    });
});


//admin
Route::middleware('auth:sanctum')->get('/admin', function (Request $request) {
    return $request->admin();
});

Route::prefix('admin')->controller(AdminController::class)->group(function (){
    Route::post('login','login');
    Route::post('forgot-password', 'forgotPassword');
    Route::post('reset-password', 'resetPassword');
    Route::post('verify-email', 'verifyEmail');
    Route::post('resend-verify-email', 'resendVerifyEmail');
    
    Route::middleware('check.auth:admin_api')->group(function(){
        Route::get('logout', 'logout');
        Route::get('profile', 'profile');
        Route::post('update-profile', 'updateProfile');
        Route::post('change-password', 'changePassword');
        Route::get('manage-users', 'manageUsers');
        Route::post('change-block/{id}', 'changeBlock');
        Route::post('delete-user/{id}', 'deleteUser');
        
        Route::middleware('check.role:1,2')->group(function(){
            Route::get('manage-admins', 'manageAdmins');
            Route::post('delete-admin/{id}','deleteAdmin');
                Route::middleware('check.role:2')->group(function(){
                    Route::post('change-role/{id}', 'changeRole');
                    Route::post('add-admin','addAdmin');
                });  	
            }); 

        
    });
});


//brand
Route::prefix('brands')->controller(BrandController::class)->group(function () {
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::post('add', 'add');
        Route::post('update/{id}', 'update');
        Route::get('all', 'getAllByAdmin');
        Route::delete('{id}', 'delete');
    });
    Route::get('names', 'getNameBrand');
    Route::get('slug/{slug}', 'getBySlug');
    Route::get('{id}', 'get');
    Route::get('', 'getAll');
});

//supplier
Route::prefix('suppliers')->controller(SupplierController::class)->group(function () {
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::post('add', 'add');
        Route::post('update/{id}', 'update');
        Route::get('names', 'getNameSupplier');
        Route::get('{id}', 'get');
        Route::delete('{id}', 'delete');
        Route::get('', 'getAll');
    });
});

//category
Route::prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::post('add', 'add');
        Route::post('update/{id}','update');
        Route::post('delete/{id}', 'delete');
        Route::post('delete-many', 'deleteMany');
        Route::get('all', 'getAll');
    });
    Route::get('names', 'getNameCategory');
    Route::get('slug/{slug}', 'getBySlug');
    Route::get('{id}', 'get');//get chính nó nếu không có danh sách con
    Route::get('', 'getAllCategories');
    
});


//product
Route::prefix('products')->controller(ProductController::class)->group(function () {
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::post('add', 'add');
        Route::post('update/{id}', 'update');
        Route::post('delete/{id}', 'delete');
        Route::post('delete-many', 'deleteMany');
        Route::get('all', 'getAllByAdmin');
    });
    Route::get('names', 'getNameProduct');
    Route::get('slug/{slug}', 'getBySlug');
    Route::get('{id}', 'get');
    Route::get('', 'getAll');
});


//Import
Route::prefix('imports')->controller(ImportController::class)->group(function () {
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::post('add', 'add');
        Route::post('update/{id}', 'update');
        Route::get('{id}', 'getImportDetails');
        Route::get('', 'getAll');
    });
});



//user order
Route::prefix('orders')->controller(OrderController::class)->group(function () {
    Route::middleware('check.auth:user_api')->group(function () {
        Route::post('buy-now', 'buyNow');
        Route::post('checkout-cart', 'checkoutCart');
        Route::get('detail/{id}', 'getOrderDetail');
        Route::post('cancel/{id}', 'cancelOrder');
        Route::get('history', 'getOrderHistory');
        Route::get('payos/{orderCode}', 'getPaymentInfo');
    });
    Route::post('payos/{orderCode}/cancel', 'cancelPayment');
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::get('all', 'getAll');
        Route::get('detail-order/{id}','getDetailOrder');
        Route::post('update-status/{id}', 'updateStatus');
    });
});
Route::prefix('payment-methods')->controller(PaymentController::class)->group(function () {
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::post('add', 'add');
        Route::post('update/{id}', 'update');
        Route::get('all', 'getAllByAdmin');
        Route::get('{id}', 'getPaymentMethod');
        Route::delete('{id}', 'delete');
    });
    Route::get('', 'getAll');
});


//payment
Route::prefix('payments')->controller(PaymentController::class)->group(function () {
    Route::get('vnpay-return', 'vnpayReturn');
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::post('update/{id}', 'updateStatus');
        Route::get('all', 'managePayment');
        Route::get('{id}', 'getPaymentDetail');  
    });
    Route::post('webhook', 'handlePayOSWebhook');
    Route::get('', 'getAll');
    
});
//delivery-methods
Route::prefix('delivery-methods')->controller(DeliveryController::class)->group(function () {
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::post('add', 'add');
        Route::post('update/{id}', 'update');
        Route::get('all', 'getAllByAdmin');
        Route::get('{id}', 'get');
        Route::delete('{id}', 'delete');
    });
    Route::get('', 'getAll');
});



//delivery
Route::prefix('deliveries')->controller(DeliveryController::class)->group(function () {
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::post('update/{id}', 'updateStatus');
        Route::get('all', 'manageDelivery');
        Route::get('{id}', 'getDeliveryDetail');
    });
    Route::get('', 'getAll');
});

//Cart
Route::prefix('cart')->controller(CartController::class)->group(function () {
    Route::middleware('check.auth:user_api')->group(function () {
        Route::get('/', 'get');
        Route::get('/', 'get');
        Route::post('add', 'add');
        Route::post('update', 'update');
        Route::post('delete/{id}', 'delete');
        Route::post('delete-many', 'deleteMany');
    });
});
//statistic
Route::prefix('statistics')->controller(StatisticController::class)->group(function () {
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::get('overview', 'getOverview');
        Route::get('revenue', 'getRevenue');
        Route::get('order', 'getOrders');
        Route::get('profit', 'getProfit');
        Route::get('top-product', 'getTopProduct');
    });
});




//Address
Route::get('/provinces', [VietnamZoneController::class, 'getProvinces']);
Route::get('/districts/{provinceId}', [VietnamZoneController::class, 'getDistricts']);
Route::get('/wards/{districtId}', [VietnamZoneController::class, 'getWards']);


//Disease
Route::prefix('disease')->controller(DiseaseController::class)->group(function (){
    Route::get('get', 'getDiseaseUser');
    Route::get('getCategory/{id}','getDiseaseCategory');
    Route::get('search', 'searchDisease');
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::post('add','add');
        Route::get('getAll','getAll');
        Route::post('update/{id}','update');
        Route::post('addCategory','addDiseaseCategory');
        Route::post('deleteCategory','deleteDiseaseCategory');
        Route::get('categoryDisease/{id}','getCategoryDisease');
        Route::post('delete/{id}', 'deleteDisease');

    });
    Route::get('{id}','get');

});


//Image 
Route::prefix('image')->controller(ImageController::class)->group(function (){
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::post('upload','uploadImage');
    });
});


//Reviews
Route::prefix('reviews')->controller(ReviewController::class)->group(function () {
    Route::get('product/{id}', 'getByProduct');
    Route::get('{id}', 'get');
    Route::middleware('check.auth:user_api')->group(function () {
        Route::get('history', 'getByUser');
        Route::get('{orderId}/{productId}', 'canReview');
        Route::post('add', 'add');
        Route::post('update/{id}', 'update');
        Route::post('delete/{id}', 'delete');
    });
    Route::middleware('check.auth:admin_api')->group(function () {
        Route::get('', 'getAll');
        Route::post('hidden/{id}','hiddenReview');
    });
});