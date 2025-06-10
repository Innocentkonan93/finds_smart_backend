<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AiapplicationController;
use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\ComponentpageController;
use App\Http\Controllers\Admin\FormsController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\RoleandaccessController;
use App\Http\Controllers\Admin\CryptocurrencyController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\JobsController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\PacksController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('admin.authentication.signin');
});

//amin dashboard
Route::prefix('admin')->group(function () {
    Route::get('/signin', [AuthenticationController::class, 'signin'])->name('admin.signin');
    Route::get('/signup', [AuthenticationController::class, 'signup'])->name('admin.signup');
    //amin dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::post('/login', [AuthenticationController::class, 'login'])->name('admin.login');
    Route::get('/logout', [AuthenticationController::class, 'logout'])->name('admin.logout');
});


Route::controller(HomeController::class)->group(function () {
    Route::get('calendar', 'calendar')->name('calendar');
    Route::get('chatmessage', 'chatMessage')->name('chatMessage');
    Route::get('chatempty', 'chatempty')->name('chatempty');
    Route::get('email', 'email')->name('email');
    Route::get('error', 'error1')->name('error');
    Route::get('faq', 'faq')->name('faq');
    Route::get('gallery', 'gallery')->name('gallery');
    Route::get('kanban', 'kanban')->name('kanban');
    Route::get('pricing', 'pricing')->name('pricing');
    Route::get('termscondition', 'termsCondition')->name('termsCondition');
    Route::get('widgets', 'widgets')->name('widgets');
    Route::get('chatprofile', 'chatProfile')->name('chatProfile');
    Route::get('veiwdetails', 'veiwDetails')->name('veiwDetails');
    Route::get('blankPage', 'blankPage')->name('blankPage');
    Route::get('comingSoon', 'comingSoon')->name('comingSoon');
    Route::get('maintenance', 'maintenance')->name('maintenance');
    Route::get('starred', 'starred')->name('starred');
    Route::get('testimonials', 'testimonials')->name('testimonials');
});

// aiApplication
Route::prefix('aiapplication')->group(function () {
    Route::controller(AiapplicationController::class)->group(function () {
        Route::get('/codegenerator', 'codeGenerator')->name('codeGenerator');
        Route::get('/codegeneratornew', 'codeGeneratorNew')->name('codeGeneratorNew');
        Route::get('/imagegenerator', 'imageGenerator')->name('imageGenerator');
        Route::get('/textgeneratornew', 'textGeneratorNew')->name('textGeneratorNew');
        Route::get('/textgenerator', 'textGenerator')->name('textGenerator');
        Route::get('/videogenerator', 'videoGenerator')->name('videoGenerator');
        Route::get('/voicegenerator', 'voiceGenerator')->name('voiceGenerator');
    });
});

// Authentication
Route::prefix('authentication')->group(function () {
    Route::controller(AuthenticationController::class)->group(function () {
        Route::get('/forgotpassword', 'forgotPassword')->name('forgotPassword');
        Route::get('/signin', 'signin')->name('signin');
        Route::get('/signup', 'signup')->name('signup');
    });
});

// chart
Route::prefix('chart')->group(function () {
    Route::controller(ChartController::class)->group(function () {
        Route::get('/columnchart', 'columnChart')->name('columnChart');
        Route::get('/linechart', 'lineChart')->name('lineChart');
        Route::get('/piechart', 'pieChart')->name('pieChart');
    });
});

// Componentpage
Route::prefix('componentspage')->group(function () {
    Route::controller(ComponentpageController::class)->group(function () {
        Route::get('/alert', 'alert')->name('alert');
        Route::get('/avatar', 'avatar')->name('avatar');
        Route::get('/badges', 'badges')->name('badges');
        Route::get('/button', 'button')->name('button');
        // Route::get('/calendar', 'calendar')->name('calendar');
        Route::get('/card', 'card')->name('card');
        Route::get('/carousel', 'carousel')->name('carousel');
        Route::get('/colors', 'colors')->name('colors');
        Route::get('/dropdown', 'dropdown')->name('dropdown');
        Route::get('/imageupload', 'imageUpload')->name('imageUpload');
        Route::get('/list', 'list')->name('list');
        Route::get('/pagination', 'pagination')->name('pagination');
        Route::get('/progress', 'progress')->name('progress');
        Route::get('/radio', 'radio')->name('radio');
        Route::get('/starrating', 'starRating')->name('starRating');
        Route::get('/switch', 'switch')->name('switch');
        Route::get('/tabs', 'tabs')->name('tabs');
        Route::get('/tags', 'tags')->name('tags');
        Route::get('/tooltip', 'tooltip')->name('tooltip');
        Route::get('/typography', 'typography')->name('typography');
        Route::get('/videos', 'videos')->name('videos');
    });
});

// Dashboard
Route::prefix('dashboard')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/index2', 'index2')->name('index2');
        Route::get('/index3', 'index3')->name('index3');
        Route::get('/index4', 'index4')->name('index4');
        Route::get('/index5', 'index5')->name('index5');
        Route::get('/index6', 'index6')->name('index6');
        Route::get('/index7', 'index7')->name('index7');
        Route::get('/index8', 'index8')->name('index8');
        Route::get('/index9', 'index9')->name('index9');
        Route::get('/index10', 'index10')->name('index10');
        Route::get('/wallet', 'wallet')->name('wallet');
    });
});

// Forms
Route::prefix('forms')->group(function () {
    Route::controller(FormsController::class)->group(function () {
        Route::get('/form-layout', 'formLayout')->name('formLayout');
        Route::get('/form-validation', 'formValidation')->name('formValidation');
        Route::get('/form', 'form')->name('form');
        Route::get('/wizard', 'wizard')->name('wizard');
    });
});

// invoice/invoiceList
Route::prefix('invoice')->group(function () {
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoice-add', 'invoiceAdd')->name('invoiceAdd');
        Route::get('/invoice-edit', 'invoiceEdit')->name('invoiceEdit');
        Route::get('/invoice-list', 'invoiceList')->name('invoiceList');
        Route::get('/invoice-preview', 'invoicePreview')->name('invoicePreview');
    });
});

// Settings
Route::prefix('settings')->group(function () {
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/company', 'company')->name('company');
        Route::get('/currencies', 'currencies')->name('currencies');
        Route::get('/language', 'language')->name('language');
        Route::get('/notification', 'notification')->name('notification');
        Route::get('/notification-alert', 'notificationAlert')->name('notificationAlert');
        Route::get('/payment-gateway', 'paymentGateway')->name('paymentGateway');
        Route::get('/theme', 'theme')->name('theme');
    });
});

// Table
Route::prefix('table')->group(function () {
    Route::controller(TableController::class)->group(function () {
        Route::get('/tablebasic', 'tableBasic')->name('tableBasic');
        Route::get('/tabledata', 'tableData')->name('tableData');
    });
});

// Users
Route::prefix('users')->group(function () {
    Route::controller(UsersController::class)->group(function () {
        Route::get('/add-user', 'addUser')->name('addUser');
        Route::get('/users-grid', 'usersGrid')->name('usersGrid');
        Route::get('/users-list', 'usersList')->name('usersList');
        Route::get('/clients-list', 'clientsList')->name('clientsList');
        Route::get('/professionnals-list', 'professionalsList')->name('professionalsList');
        Route::get('/view-profile/{id}', 'viewProfile')->name('viewProfile');
        Route::post('/store-user', 'storeUser')->name('storeUser');
        Route::put('/update-user/{id}', 'updateUser')->name('updateUser');
        Route::delete('/delete-user/{id}', 'deleteUser')->name('deleteUser');
    });
});

// Users
Route::prefix('blog')->group(function () {
    Route::controller(BlogController::class)->group(function () {
        Route::get('/addBlog', 'addBlog')->name('addBlog');
        Route::get('/blog', 'blog')->name('blog');
        Route::get('/blogDetails', 'blogDetails')->name('blogDetails');
    });
});

// Users
Route::prefix('roleandaccess')->group(function () {
    Route::controller(RoleandaccessController::class)->group(function () {
        Route::get('/assignRole', 'assignRole')->name('assignRole');
        Route::get('/roleAaccess', 'roleAaccess')->name('roleAaccess');
    });
});

// Users
Route::prefix('cryptocurrency')->group(function () {
    Route::controller(CryptocurrencyController::class)->group(function () {
        Route::get('/marketplace', 'marketplace')->name('marketplace');
        Route::get('/marketplacedetails', 'marketplaceDetails')->name('marketplaceDetails');
        Route::get('/portfolio', 'portfolio')->name('portfolio');
        // Route::get('/wallet', 'wallet')->name('wallet');
    });
});


//

Route::prefix('notifications')->group(function () {
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications-list', 'notificationsList')->name('notificationsList');
        // Route::get('/view-notification', 'viewNotification')->name('viewNotification');
        Route::get('/view-notification/{id}', 'viewNotification')->name('viewNotification');
        Route::put('/mark-as-read/{id}', 'markAsRead')->name('markAsRead');
        Route::delete('/delete-notification/{id}', 'deleteNotification')->name('deleteNotification');
        Route::put('/mark-all-as-read', 'markAllAsRead')->name('markAllAsRead');
    });
});


Route::prefix('documents')->group(function () {
    Route::controller(DocumentController::class)->group(function () {
        Route::get('/documents-list', 'documentsList')->name('documentsList');
        Route::get('/view-document/{id}', 'viewDocument')->name('viewDocument');
        Route::delete('/delete-document/{id}', 'deleteDocument')->name('deleteDocument');
        Route::put('/update-document/{id}', 'updateDocument')->name('updateDocument');
    });
});


Route::prefix('ads')->group(function () {
    Route::controller(AdsController::class)->group(function () {
        Route::get('/ads-list', 'adsList')->name('adsList');
        Route::get('/view-ad/{id}', 'viewAd')->name('viewAd');
        Route::get('/add-ad', 'addAd')->name('addAd');
        Route::post('/store-ad', 'storeAd')->name('storeAd');
        Route::put('/update-ad/{id}', 'updateAd')->name('updateAd');
        Route::delete('/delete-ad/{id}', 'deleteAd')->name('deleteAd');
    });
});

Route::prefix('orders')->group(function () {
    Route::controller(OrdersController::class)->group(function () {
        Route::get('/orders-list', 'ordersList')->name('ordersList');
        Route::get('/view-order/{id}', 'viewOrder')->name('viewOrder');
        Route::get('/add-order', 'addOrder')->name('addOrder');
        Route::post('/store-order', 'storeOrder')->name('storeOrder');
        Route::put('/update-order/{id}', 'updateOrder')->name('updateOrder');
        Route::delete('/delete-order/{id}', 'deleteOrder')->name('deleteOrder');
    });
});

Route::prefix('jobs')->group(function () {
    Route::controller(JobsController::class)->group(function () {
        Route::get('/jobs-list', 'jobsList')->name('jobsList');
        Route::get('/view-job/{id}', 'viewJob')->name('viewJob');
        Route::get('/add-job', 'addJob')->name('addJob');
        Route::post('/store-job', 'storeJob')->name('storeJob');
        Route::put('/update-job/{id}', 'updateJob')->name('updateJob');
        Route::delete('/delete-job/{id}', 'deleteJob')->name('deleteJob');
    });
});


Route::prefix('services')->group(function () {
    Route::controller(ServicesController::class)->group(function () {
        Route::get('/services-list', 'servicesList')->name('servicesList');
        Route::get('/view-service/{id}', 'viewService')->name('viewService');
        Route::get('/add-service', 'addService')->name('addService');
        Route::post('/store-service', 'storeService')->name('storeService');
        Route::put('/update-service/{id}', 'updateService')->name('updateService');
        Route::delete('/delete-service/{id}', 'deleteService')->name('deleteService');
    });
});


Route::prefix('packs')->group(function () {
    Route::controller(PacksController::class)->group(function () {
        Route::get('/packs-list', 'packsList')->name('packsList');
        Route::get('/view-pack/{id}', 'viewPack')->name('viewPack');
        Route::get('/add-pack', 'addPack')->name('addPack');
        Route::post('/store-pack', 'storePack')->name('storePack');
        Route::put('/update-pack/{id}', 'updatePack')->name('updatePack');
        Route::delete('/delete-pack/{id}', 'deletePack')->name('deletePack');
    });
});

Route::prefix('transactions')->group(function () {
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transactions-list', 'transactionsList')->name('transactionsList');
        Route::get('/view-transaction/{id}', 'viewTransaction')->name('viewTransaction');
        Route::get('/add-transaction', 'addTransaction')->name('addTransaction');
        Route::post('/store-transaction', 'storeTransaction')->name('storeTransaction');
        Route::put('/update-transaction/{id}', 'updateTransaction')->name('updateTransaction');
        Route::delete('/delete-transaction/{id}', 'deleteTransaction')->name('deleteTransaction');
    });
});

Route::prefix('pages')->group(function () {
    Route::controller(PageController::class)->group(function () {
        Route::get('/terms-condition', 'termsCondition')->name('viewTermsCondition');
        Route::get('/edit-terms-condition', 'editTermsCondition')->name('editTermsCondition');
        Route::put('/update-terms-condition/{id}', 'updateTermsCondition')->name('updateTermsCondition');
        Route::get('/privacy-policy', 'privacyPolicy')->name('privacyPolicy');
        Route::get('/edit-privacy-policy', 'editPrivacyPolicy')->name('editPrivacyPolicy');
        Route::put('/update-privacy-policy/{id}', 'updatePrivacyPolicy')->name('updatePrivacyPolicy');
    });
}); 

