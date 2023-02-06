<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', static function () {
    return view('welcome');
});

// Главная
Route::get('/', IndexController::class)->name('index');

// Регулярное выражения на проверку slug прописано в App\Providers\RouteServiceProvider

Route::get('/page/{page:slug}', PageController::class)->name('page.show');

// Каталог товаров: категория, бренд и товар
Route::controller(CatalogController::class)->name('catalog.')->prefix('catalog')->group(function () {
    // Главная
    Route::get('/index', 'index')->name('index');

    // Категории каталога товаров
    Route::get('/category/{category:slug}', 'category')->name('category');

    // Бренд каталога товаров
    Route::get('/brand/{brand:slug}', 'brand')->name('brand');

    // Товар - страница
    Route::get('/product/{product:slug}', 'product')->name('product');

    // Поиск - страница
    Route::get('search', 'search')->name('search');
});

// Корзина
Route::controller(BasketController::class)->name('basket.')->prefix('basket')->group(function () {
    // Главная список всех товаров в корзине
    Route::get('/index', 'index')->name('index');

    // Проверка страница с формой оформления заказа
    Route::get('/checkout', 'checkout')->name('checkout');

    // Оформление заказа
    // Проверка формы, отправка данных формы для сохранения заказа в БД
    Route::post('/save-order', 'saveOrder')->name('save-order');
    // Редирект успешного оформления, страница после успешного сохранения заказа в БД
    Route::get('/success', 'success')->name('success');

    // Добавление, отправка формы добавления товара в корзину
    Route::post('/add/{product:slug}', 'add')->name('add');

    // Изменение кол-ва
    // Кнопка '-', отправка формы изменения кол-ва отдельного товара в корзине
    Route::post('/minus/{product:slug}', 'minus')->name('minus');
    // Кнопка '+', отправка формы изменения кол-ва отдельного товара в корзине
    Route::post('/plus/{product:slug}', 'plus')->name('plus');

    // Удаление из корзины, отправка формы удаления отдельного товара из корзины
    Route::post('/remove/{product:slug}', 'remove')->name('remove');
    // отправка формы для удаления всех товаров из корзины
    Route::post('/clear', 'clear')->name('clear');

    // Возвращает профиль пользователя в формате JSON, получение данных профиля для оформления
    Route::post('/basket/profile', 'profile')->name('basket.profile');
});

Route::get('page/{page:slug}', PageController::class)->name('page.show');

/**
 *  Список маршрутов можно посмотреть в классе Laravel\Ui\AuthRouteMethods
 */
Route::name('user.')->prefix('user')->group(function () {
    // регистрация, вход в ЛК, восстановление пароля
    Auth::routes();

    Route::middleware('auth')->group(function () {
        // главная страница личного кабинета пользователя
        Route::get('/index', [ UserController::class, 'index' ])->name('index');

        // CRUD-операции над профилями пользователя
        Route::resource('profile', ProfileController::class)->except([ 'destroy', ]);
        Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
            Route::delete('/delete/{profile:slug}', 'delete')->name('delete');
        });

        // Заказы в личном кабинете
        Route::controller(OrderController::class)->prefix('order')->name('order.')->group(function () {
            // Просмотр списка заказов в личном кабинете
            Route::get('/', 'index')->name('index');
            // Просмотр отдельного заказа в личном кабинете
            Route::get('/{order:id}', 'show')->name('show');
        });
    });
});

// Личный кабинет Admin. Панель управления магазином для администратора сайта
// первый способ добавления посредников
// 'auth' - аутентификация пользователя
// 'admin' - пользователь является администратором
// middleware('auth', 'admin') - чтобы не прописывать в каждом конструкторе контроллера

//  namespace('Admin') - пространство имен контроллера
//  name('admin.') - имя маршрута, например admin.index
//  prefix('admin') - префикс маршрута, например admin/index
//  middleware('auth', 'admin') - один или несколько посредников

Route::name('admin.')->prefix('admin')->middleware('auth', 'admin')->group(function () {
    // главная страница панели управления
    Route::get('index', AdminIndexController::class)->name('index');

    // CRUD-операции над категориями каталога
    Route::resource('category', AdminCategoryController::class)->except([ 'destroy', ]);
    Route::controller(AdminCategoryController::class)->prefix('category')->name('category.')->group(function () {
        Route::delete('/delete/{category:slug}', 'delete')->name('delete');
    });

    // CRUD-операции над брендами каталога
    Route::resource('brand', AdminBrandController::class)->except([ 'destroy', ]);
    Route::controller(AdminBrandController::class)->prefix('brand')->name('brand.')->group(function () {
        Route::delete('/delete/{brand:slug}', 'delete')->name('delete');
    });

    // CRUD-операции над товарами каталога
    Route::resource('product', AdminProductController::class)->except([ 'destroy', ]);
    Route::controller(AdminProductController::class)->prefix('product')->name('product.')->group(function () {
        Route::delete('/delete/{product:slug}', 'delete')->name('delete');
        // доп.маршрут для показа товаров категории
        Route::get('/category/{category:slug}', 'category')->name('category');
    });

    // CRUD-операции над заказами, просмотр и редактирование заказов
    Route::resource('order', AdminOrderController::class)->except([ 'create', 'store', 'destroy', ]);

    // CRUD-операции над пользователями, просмотр и редактирование пользователей
    Route::resource('user', AdminUserController::class)->except([ 'create', 'store', 'show', 'destroy', ]);

    // CRUD-операции над страницами сайта
    Route::resource('page', AdminPageController::class)->except([ 'destroy', ]);
    Route::controller(AdminPageController::class)->prefix('page')->name('page.')->group(function () {
        Route::delete('/delete/{page:slug}', 'delete')->name('delete');

        // загрузка изображения из wysiwyg-редактора
        Route::post('/upload/image', 'uploadImage')->name('upload.image');
        // удаление изображения в wysiwyg-редакторе
        Route::delete('/remove/image', 'removeImage')->name('remove.image');
    });
});









// второй способ добавления посредников
// Route::group([
//     'as' => 'admin.', // имя маршрута, например admin.index
//     'prefix' => 'admin', // префикс маршрута, например admin/index
//     'namespace' => 'Admin', // пространство имен контроллера
//     'middleware' => ['auth', 'admin'] // один или несколько посредников
// ], function () {
//     Route::get('index', 'IndexController')->name('index');
// });


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
