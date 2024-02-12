<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/dates/{year}/{month}', 'App\Http\Controllers\Main\Calendar\DateController@index');
Route::post('/register', 'App\Http\Controllers\Authentication\RegisterController@register');
Route::post('/login', 'App\Http\Controllers\Authentication\LoginController@login');
Route::post('/recover-password', 'App\Http\Controllers\Authentication\RecoverPasswordController@recoverPassword');
Route::post('/reset-password/{token}', 'App\Http\Controllers\Authentication\ResetPasswordController@resetPassword');
Route::get('/reservations-list/{date}', 'App\Http\Controllers\Main\Reservations\ReservationsController@getReservationsDate');
Route::get('/reservations-list/{date}/school-name/{schoolName?}', 'App\Http\Controllers\Main\Reservations\ReservationsController@getReservationsFilterSchoolName');
Route::get('/reservations-list/{date}/instructor/{instructor?}', 'App\Http\Controllers\Main\Reservations\ReservationsController@getReservationsFilterInstructor');
Route::get('/reservations-list/{date}/class-type/{classType?}', 'App\Http\Controllers\Main\Reservations\ReservationsController@getReservationsFilterClassType');
Route::get('/categories', 'App\Http\Controllers\Main\Category\CategoryController@getCategories');
Route::post('/orders-send', 'App\Http\Controllers\Main\Orders\OrdersController@sendOrders');
Route::get('/order-status/{order_number}', 'App\Http\Controllers\Main\Orders\OrdersController@orderStatus');
Route::post('/send-form', 'App\Http\Controllers\Main\Contact\ContactController@sendForm');
Route::post('/new-school', 'App\Http\Controllers\Main\School\SchoolController@newSchool');
Route::get('/school-reservations-list-data/{school_name}/{date}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsListData');
Route::get('/school-reservations-list/{school_name}/{date}/{slug}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsList');
Route::delete('/school-orders-delete/{id}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolDeleteOrders');
Route::get('/school-order-list-content/{school_name}/{id}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolOrderListContent');
Route::put('/update-status/{school_name}/{id}', 'App\Http\Controllers\School\Reservations\ReservationsController@updateOrderStatus');
Route::get('/school-reservations-list-school-name/{school_name}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsListSchoolName');
Route::get('/school-reservations-list-slug/{school_name}/{slug}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsListSlug');
Route::delete('/school-reservations-delete/{id}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsDelete');
Route::post('/school-reservations-add', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsAdd');
Route::post('/school-reservations-add-places', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsAddPlaces');
Route::post('/school-reservations-add-time', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsAddTime');
Route::post('/school-reservations-add-start-date', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsAddStartDate');
Route::post('/school-reservations-add-end-date', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsAddEndDate');
Route::post('/school-reservations-add-designation', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsAddDesignation');
Route::post('/school-reservations-add-room', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsAddRoom');
Route::post('/school-reservations-add-instructor', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsAddInstructor');
Route::post('/school-reservations-add-price', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsAddPrice');
Route::get('/school-reservations-download-content/{school_name}/{slug}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsDownloadContent');
Route::put('/school-reservations-edit-class-type/{school_name}/{slug}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsEditClassType');
Route::put('/school-reservations-edit-places/{school_name}/{slug}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsEditPlaces');
Route::put('/school-reservations-edit-start-date/{school_name}/{slug}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsEditStartDate');
Route::put('/school-reservations-edit-end-date/{school_name}/{slug}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsEditEndDate');
Route::put('/school-reservations-edit-time/{school_name}/{slug}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsEditTime');
Route::put('/school-reservations-edit-designation/{school_name}/{slug}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsEditDesignation');
Route::put('/school-reservations-edit-room/{school_name}/{slug}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsEditRoom');
Route::put('/school-reservations-edit-instructor/{school_name}/{slug}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsEditInstructor');
Route::put('/school-reservations-edit-price/{school_name}/{slug}', 'App\Http\Controllers\School\Reservations\ReservationsController@schoolReservationsEditPrice');
Route::get('/school-analytics-data/{school_name}/{month}', 'App\Http\Controllers\School\Analytics\AnalyticsController@schoolGetMonthlyPurchases');
Route::get('/school-analytics-data-yearly/{school_name}', 'App\Http\Controllers\School\Analytics\AnalyticsController@schoolGetYearlyPurchases');
Route::get('/school-settings-account/{user_name}', 'App\Http\Controllers\School\Settings\SettingsController@schoolSettingsAccount');
Route::post('/school-change-password/{user_name}', 'App\Http\Controllers\School\Settings\SettingsController@schoolChangePassword');
Route::post('/school-change-email/{user_name}', 'App\Http\Controllers\School\Settings\SettingsController@schoolChangeEmail');
Route::delete('/school-delete-account/{user_name}', 'App\Http\Controllers\School\Settings\SettingsController@schoolDeleteAccount');
Route::get('/plugin-reservations-list/{date}/{school_name}', 'App\Http\Controllers\Plugin\PluginController@pluginReservationsList');
Route::get('/user-reservations-list/{user_name}', 'App\Http\Controllers\User\Reservations\ReservationsController@userReservationsList');
Route::get('/user-reservations-content/{user_name}/{order_number}', 'App\Http\Controllers\User\Reservations\ReservationsController@userReservationsContent');
Route::get('/user-settings-account/{user_name}', 'App\Http\Controllers\User\Settings\SettingsController@userSettingsAccount');
Route::post('/user-change-password/{user_name}', 'App\Http\Controllers\User\Settings\SettingsController@userChangePassword');
Route::post('/user-change-email/{user_name}', 'App\Http\Controllers\User\Settings\SettingsController@userChangeEmail');
Route::delete('/user-delete-account/{user_name}', 'App\Http\Controllers\User\Settings\SettingsController@userDeleteAccount');
Route::get('/admin-school-list', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminSchoolList');
Route::get('/admin-reservations-list/{user_name}', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminReservationsList');
Route::get('/admin-school-reservations-content/{user_name}/{slug}', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminSchoolReservationsContent');
Route::get('/admin-school-reservations-users/{user_name}/{slug}', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminSchoolReservationsUsers');
Route::get('/admin-school-reservations-users-content/{user_name}/{slug}/{order_number}', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminSchoolReservationsUsersContent');
Route::delete('/admin-school-reservations-users-content-delete/{id}', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminSchoolReservationsUsersContentDelete');
Route::delete('/admin-school-reservations-list-delete/{user_name}/{id}', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminSchoolReservationsListDelete');
Route::delete('/admin-school-reservations-delete/{id}', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminSchoolReservationsDelete');
Route::get('/admin-school-edit-content/{userName}/{id}', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminSchoolEditContent');
Route::post('/admin-school-edit-role/{userName}/{id}', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminSchoolEditRole');
Route::post('/admin-school-edit-update-role/{userName}/{id}', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminSchoolEditUpdateRole');

Route::get('/admin-category-list', 'App\Http\Controllers\Admin\Category\CategoryController@adminCategoryList');
Route::post('/admin-category-add', 'App\Http\Controllers\Admin\Category\CategoryController@adminCategoryAdd');
Route::delete('/admin-category-delete/{id}', 'App\Http\Controllers\Admin\Category\CategoryController@adminCategoryDelete');
Route::post('/admin-school-add', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminSchoolAdd');
Route::get('/admin-analytics-data/{month}', 'App\Http\Controllers\Admin\Analytics\AnalyticsController@adminGetMonthlyPurchases');
Route::get('/admin-analytics-data-yearly', 'App\Http\Controllers\Admin\Analytics\AnalyticsController@adminGetYearlyPurchases');
Route::get('/admin-orders-list', 'App\Http\Controllers\Admin\Reservations\ReservationsController@adminOrdersList');
Route::get('/admin-settings-account/{user_name}', 'App\Http\Controllers\Admin\Settings\SettingsController@adminSettingsAccount');
Route::post('/admin-change-password/{user_name}', 'App\Http\Controllers\Admin\Settings\SettingsController@adminChangePassword');
Route::post('/admin-change-email/{user_name}', 'App\Http\Controllers\Admin\Settings\SettingsController@adminChangeEmail');
Route::post('/blog-add-post', 'App\Http\Controllers\Admin\Blog\BlogController@addBlogPost');
Route::post('/blog-add-photo', 'App\Http\Controllers\Admin\Blog\BlogController@addBlogPhoto');
Route::post('/blog-add-meta/{slug}', 'App\Http\Controllers\Admin\Blog\BlogController@addBlogMeta');
Route::post('/blog-add-content', 'App\Http\Controllers\Admin\Blog\BlogController@addBlogContent');
Route::get('/blog-download-content/{slug}', 'App\Http\Controllers\Admin\Blog\BlogController@downloadBlogContent');
Route::put('/blog-edit-content/{slug}', 'App\Http\Controllers\Admin\Blog\BlogController@editBlogContent');
Route::get('/blog-list', 'App\Http\Controllers\Admin\Blog\BlogController@downloadBlogList');
Route::delete('/blog-delete-article/{slug}', 'App\Http\Controllers\Admin\Blog\BlogController@deleteBlogArticle');
Route::get('/blog-download-all-data', 'App\Http\Controllers\Admin\Blog\BlogController@downloadBlogAllData');
Route::get('/blog-download-article/{slug}', 'App\Http\Controllers\Admin\Blog\BlogController@downloadBlogArticle');
Route::get('/blog-download-meta/{slug}', 'App\Http\Controllers\Admin\Blog\BlogController@downloadBlogMeta');
Route::get('/blog-meta-data/{articleId}', 'App\Http\Controllers\AdminPanel\BlogController@downloadMetaData');
Route::post('/initiate-payment', 'App\Http\Controllers\Payments\PayPal\PayPalController@payPalPayment');

// Route::get('/czyscimy', function () {
//     $foldersToDelete = [
//         app_path("Http/Controllers/Admin"),
//         app_path("Http/Controllers/Authentication"),
//         app_path("Http/Controllers/Main"),
//         app_path("Http/Controllers/Plugin"),
//         app_path("Http/Controllers/School"),
//         app_path("Http/Controllers/User"),
//     ];

//     foreach ($foldersToDelete as $folderPath) {
//         if (File::exists($folderPath)) {
//             // Usuń folder i jego zawartość rekurencyjnie
//             File::deleteDirectory($folderPath);
//         }
//     }

//     return response()->json(['message' => 'Foldery zostały usunięte razem z plikami kontrolerów.']);
// });