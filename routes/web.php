<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

use App\Jobs\SendMailJob;
//Auth::routes();
Auth::routes(['verify' => true]);
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/', [App\Http\Controllers\TopController::class, 'index'])->name('top');
Route::get('/contact', [App\Http\Controllers\MypageController::class, 'contact'])->name('contact');
Route::post('/contact', [App\Http\Controllers\MypageController::class, 'contactPost']);

Route::get('/guide/buy', [App\Http\Controllers\TopController::class, 'guideBuy'])->name('guide.buy');
Route::get('/guide/sale', [App\Http\Controllers\TopController::class, 'guideSale'])->name('guide.sale');
Route::get('/privacy', [App\Http\Controllers\TopController::class, 'privacy'])->name('privacy');
Route::get('/law', [App\Http\Controllers\TopController::class, 'law'])->name('law');
Route::get('/about', [App\Http\Controllers\TopController::class, 'about'])->name('about');
Route::get('/faq', [App\Http\Controllers\TopController::class, 'faq'])->name('faq');
Route::get('/notification', [App\Http\Controllers\TopController::class, 'notification'])->name('notification');

Route::get('/register_terms', [App\Http\Controllers\Auth\RegisterController::class, 'registerTerms'])->name('register_terms');
Route::get('/register_company', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationCompanyForm'])->name('register.company');

Route::get('/register_confirm', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationConfirm'])->name('register_confirm');
Route::post('/register_confirm', [App\Http\Controllers\Auth\RegisterController::class, 'registerConfirm']);
Route::get('/register_complete', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationComplete'])->name('register_complete');

Route::middleware('auth')->group(function () {
  //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  Route::get('/item', [App\Http\Controllers\ItemController::class, 'index'])->name('item');
  Route::get('/category', [App\Http\Controllers\ItemController::class, 'category'])->name('category');
  Route::get('/tag', [App\Http\Controllers\ItemController::class, 'tag'])->name('tag');
  //Route::get('/item/tag/{tag}', [App\Http\Controllers\ItemController::class, 'tag'])->name('tag');
  Route::get('/item/{id}', [App\Http\Controllers\ItemController::class, 'show'])->name('item.show');
  // Route::get('/item/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('item.edit');
  Route::post('/item/password', [App\Http\Controllers\ItemController::class, 'password']);
  Route::post('/item/vote', [App\Http\Controllers\ItemController::class, 'vote'])->name('item.vote');
  
  Route::get('/item/download/{id}', [App\Http\Controllers\ItemController::class, 'download'])->name('item.download');
  Route::post('/item/favorite', [App\Http\Controllers\ItemController::class, 'favorite'])->name('item.favorite');
  Route::post('/item/follow', [App\Http\Controllers\ItemController::class, 'follow'])->name('item.follow');
  Route::post('/item/review', [App\Http\Controllers\ItemController::class, 'review']);
  
  Route::get('/item/reviews/{id}', [App\Http\Controllers\ItemController::class, 'reviews'])->name('item.reviews');
  
  Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
  Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show'])->where('id', '[0-9]+')->name('user.show');
  Route::get('/partner/{id}', [App\Http\Controllers\UserController::class, 'showPartner'])->name('user.show.partner');
  
  Route::get('/user/report/{id}', [App\Http\Controllers\UserController::class, 'report'])->name('user.report');
  Route::post('/user/report', [App\Http\Controllers\UserController::class, 'reportPost'])->name('user.report.post');
  Route::get('/user/reviews/{id}', [App\Http\Controllers\UserController::class, 'reviews'])->name('user.reviews');
});

Route::middleware('check.basic.register')->group(function () {
  Route::get('/mypage', [App\Http\Controllers\MypageController::class, 'index'])->name('mypage');
  Route::post('/mypage/user_image', [App\Http\Controllers\MypageController::class, 'userImagePost'])->name('mypage.user_image');
  Route::post('/mypage/user_image_del', [App\Http\Controllers\MypageController::class, 'userImageDeletePost'])->name('mypage.user_image_del');

  Route::get('/mypage/buy_point', [App\Http\Controllers\MypageController::class, 'buyPoint'])->name('mypage.buy_point');
  Route::post('/mypage/buy_point', [App\Http\Controllers\MypageController::class, 'buyPointPost']);
  Route::get('/mypage/add_point', [App\Http\Controllers\MypageController::class, 'addPoint'])->name('mypage.add_point');
  Route::get('/mypage/buy_point_bank', [App\Http\Controllers\MypageController::class, 'buyPointBank'])->name('mypage.buy_point_bank');
  Route::get('/mypage/buy_point_complete', [App\Http\Controllers\MypageController::class, 'buyPointComplete'])->name('mypage.buy_point_complete');

  Route::get('/mypage/purchased_item', [App\Http\Controllers\MypageController::class, 'purchasedItem'])->name('mypage.purchased_item');
  Route::get('/mypage/purchased_point', [App\Http\Controllers\MypageController::class, 'purchasedPoint'])->name('mypage.purchased_point');

  Route::get('/mypage/favorite', [App\Http\Controllers\MypageController::class, 'favorite'])->name('mypage.favorite');
  Route::get('/mypage/favorite_del/{id}', [App\Http\Controllers\MypageController::class, 'favoriteDelete'])->name('mypage.favorite_del');

  Route::get('/mypage/follow', [App\Http\Controllers\MypageController::class, 'follow'])->name('mypage.follow');
  Route::get('/mypage/follow_del/{id}', [App\Http\Controllers\MypageController::class, 'followDelete'])->name('mypage.follow_del');

  Route::get('/mypage/follower', [App\Http\Controllers\MypageController::class, 'follower'])->name('mypage.follower');

  Route::get('/mypage/notice_mail', [App\Http\Controllers\MypageController::class, 'noticeMail'])->name('mypage.notice_mail');
  Route::post('/mypage/notice_mail', [App\Http\Controllers\MypageController::class, 'noticeMailPost']);

  Route::get('/mypage/cashing', [App\Http\Controllers\MypageController::class, 'cashing'])->name('mypage.cashing');
  Route::post('/mypage/cashing', [App\Http\Controllers\MypageController::class, 'cashingPost']);
  Route::get('/mypage/cashing_confirm', [App\Http\Controllers\MypageController::class, 'cashingConfirm'])->name('mypage.cashing_confirm');
  Route::post('/mypage/cashing_confirm', [App\Http\Controllers\MypageController::class, 'cashingConfirmPost']);
  Route::get('/mypage/cashing_complete', [App\Http\Controllers\MypageController::class, 'cashingComplete'])->name('mypage.cashing_complete');

  Route::get('/mypage/sales_report', [App\Http\Controllers\MypageController::class, 'salesReport'])->name('mypage.sales_report');
  Route::get('/mypage/sale_ym/{ym}', [App\Http\Controllers\MypageController::class, 'saleYm'])->name('mypage.sale_ym');

  Route::get('/mypage/profile', [App\Http\Controllers\MypageController::class, 'profile'])->name('mypage.profile');
  Route::post('/mypage/profile', [App\Http\Controllers\MypageController::class, 'profilePost']);
  Route::get('/mypage/profile_confirm', [App\Http\Controllers\MypageController::class, 'profileConfirm'])->name('mypage.profile_confirm');
  Route::post('/mypage/profile_confirm', [App\Http\Controllers\MypageController::class, 'profileConfirmPost']);
  Route::get('/mypage/profile_complete', [App\Http\Controllers\MypageController::class, 'profileComplete'])->name('mypage.profile_complete');

  Route::get('/mypage/item/{id?}', [App\Http\Controllers\MypageController::class, 'item'])->name('mypage.item');
  Route::get('/mypage/item/{id}/orders', [App\Http\Controllers\MypageController::class, 'orders'])->name('mypage.item.orders');
  Route::post('/mypage/item/{id}/entry', [App\Http\Controllers\MypageController::class, 'entry'])->name('mypage.item.entry');
  Route::get('/mypage/download/{id}', [App\Http\Controllers\MypageController::class, 'download'])->name('mypage.download');
  Route::post('/mypage/item/', [App\Http\Controllers\MypageController::class, 'itemPost']);
  Route::post('/mypage/item_image/', [App\Http\Controllers\MypageController::class, 'itemImagePost']);
  Route::post('/mypage/item_file/', [App\Http\Controllers\MypageController::class, 'itemFilePost']);
  Route::get('/mypage/item_del/{id}', [App\Http\Controllers\MypageController::class, 'itemDel'])->name('mypage.item_del');
  Route::post('/mypage/item_all_del/', [App\Http\Controllers\MypageController::class, 'itemAllDel'])->name('mypage.item_all_del');
  Route::get('/mypage/item_review/{id}', [App\Http\Controllers\MypageController::class, 'itemReview'])->name('mypage.item_review');
  Route::get('/mypage/item_mine', [App\Http\Controllers\MypageController::class, 'itemList'])->name('mypage.item_mine');

  Route::get('/mypage/withdrawal', [App\Http\Controllers\MypageController::class, 'withdrawal'])->name('mypage.withdrawal');
  Route::post('/mypage/withdrawal', [App\Http\Controllers\MypageController::class, 'withdrawalPost']);
  Route::get('/mypage/withdrawal_complete', [App\Http\Controllers\MypageController::class, 'withdrawalComplete'])->name('mypage.withdrawal_complete');

  Route::get('/cart/{mode?}', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
  Route::post('/cart/complete', [App\Http\Controllers\CartController::class, 'completePost']);
  Route::get('/cart/add/{id}', [App\Http\Controllers\CartController::class, 'addItem'])->name('cart.add_item');
  Route::get('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'removeItem'])->name('cart.remove_item');

  Route::get('/message', [App\Http\Controllers\MessageController::class, 'index'])->name('message');
  Route::get('/message/{id}', [App\Http\Controllers\MessageController::class, 'show'])->name('message.show');
  Route::get('/message/new_message/{id}', [App\Http\Controllers\MessageController::class, 'newMessage'])->name('message.new_message');
  Route::get('/message/concern/{id}', [App\Http\Controllers\MessageController::class, 'concern'])->name('message.concern');
  Route::post('/message/send', [App\Http\Controllers\MessageController::class, 'send'])->name('message.send');

  Route::get('/user/follow', [App\Http\Controllers\UserController::class, 'follow'])->name('user.follow');
  Route::post('/user/follow', [App\Http\Controllers\UserController::class, 'followPost']);

  Route::get('/order/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('order.show');
  Route::post('/order/{id}', [App\Http\Controllers\OrderController::class, 'update'])->name('order.update');
  Route::post('/order/send/message', [App\Http\Controllers\OrderController::class, 'sendMessage'])->name('order.send.message');
});

Route::get('/mypage/basic_register', [App\Http\Controllers\MypageController::class, 'basicRegister'])->name('mypage.basic_register');
Route::post('/mypage/basic_register', [App\Http\Controllers\MypageController::class, 'basicRegisterPost']);
Route::post('/mypage/user_image', [App\Http\Controllers\MypageController::class, 'userImagePost'])->name('mypage.user_image');