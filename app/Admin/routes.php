<?php

use App\Admin\Controllers\ImpersonateController;
use Illuminate\Routing\Router;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.dashboard');
    Route::resource('config', 'ConfigController', array('names' => 'admin.config'));
    Route::resource('cashing', 'CashingController', array('names' => 'admin.cashing'));
    Route::resource('orderpoint', 'OrderpointController', array('names' => 'admin.orderpoint'));
    Route::resource('user', 'UserController', array('names' => 'admin.user'));
    Route::resource('shop', 'ShopController', array('names' => 'admin.shop'));
    Route::get('item/{id}/edit', 'ItemController@edit')->name('admin.item.edit');
    Route::put('item/{id}', 'ItemController@update')->name('admin.item.update');
    Route::get('item/{id}/delete', 'ItemController@delete')->name('admin.item.delete');
    Route::resource('item', 'ItemController', ['only' => ['index', 'show'], 'names' => 'admin.item']);
    Route::resource('review', 'ReviewController', array('names' => 'admin.review'));
    Route::get('orderitem', 'OrderitemController@index')->name('admin.orderitem.index');
    Route::get('orderitem/{id}', 'OrderitemController@detail')->name('admin.orderitem.detail');
    Route::post('orderitem/{id}/vote', 'OrderitemController@vote')->name('admin.orderitem.vote');
    Route::post('orderitem/{id}/message', 'OrderitemController@message')->name('admin.orderitem.message');
    Route::post('orderitem/{id}/action', 'OrderitemController@action')->name('admin.orderitem.action');
    Route::get('orderitem/{id}/delete', 'OrderitemController@delete')->name('admin.orderitem.delete');
    Route::resource('orderitem', 'OrderitemController', array('names' => 'admin.orderitem'));
    Route::resource('htmlpart', 'HtmlpartController', array('names' => 'admin.htmlpart'));
    Route::resource('notification', 'NotificationController', array('names' => 'admin.notification'));
    Route::resource('contact', 'ContactController', array('names' => 'admin.contact'));
    Route::resource('userrequest', 'UserrequestController', array('names' => 'admin.userrequest'));
    Route::resource('company', 'CompanyController', array('names' => 'admin.company'));
    Route::resource('template', 'TemplateController', array('names' => 'admin.template'));
    Route::resource('category', 'CategoryController', array('names' => 'admin.category'));
    Route::get('analysis', 'AnalysisController@index')->name('admin.analysis');
    // バッジ既読化API
    Route::post('badge/confirm', 'BadgeController@confirm')->name('admin.badge.confirm');
});

Route::get('impersonate/{id}', [ImpersonateController::class, 'impersonate'])->middleware(['web', 'auth.admin'])->name('impersonate');
