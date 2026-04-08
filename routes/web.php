<?php

use App\Models\User;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;

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

Route::get('/', function () {
    return redirect('login');  
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'users'         => (int) User::count(),
        'roles'         => (int) Role::count(),
        'permissions'   => (int) Permission::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/user', UserController::class)->except('create', 'show', 'edit');
    Route::post('/user/destroy-bulk', [UserController::class, 'destroyBulk'])->name('user.destroy-bulk');
    
    Route::resource('/role', RoleController::class)->except('create', 'show', 'edit');

    Route::resource('/permission', PermissionController::class)->except('create', 'show', 'edit');

});

Route::middleware('auth', 'verified')->group(function () {
    $uikitRoutes = [
        'formlayout' => 'uikit/FormLayout',
        'input'      => 'uikit/InputDoc',
        'button'     => 'uikit/ButtonDoc',
        'table'      => 'uikit/TableDoc',
        'list'       => 'uikit/ListDoc',
        'tree'       => 'uikit/TreeDoc',
        'panel'      => 'uikit/PanelsDoc',
        'overlay'    => 'uikit/OverlayDoc',
        'media'      => 'uikit/MediaDoc',
        'menu'       => 'uikit/MenuDoc',
        'message'    => 'uikit/MessagesDoc',
        'file'       => 'uikit/FileDoc',
        'charts'     => 'uikit/ChartDoc',
        'timeline'   => 'uikit/TimelineDoc',
        'misc'       => 'uikit/MiscDoc',
    ];

    foreach ($uikitRoutes as $segment => $view) {
        Route::get("/uikit/{$segment}", fn () => Inertia::render('SakaiView', ['view' => $view]))->name("uikit.{$segment}");
    }

    Route::get('/documentation', fn () => Inertia::render('SakaiView', ['view' => 'pages/Documentation']))->name('documentation');

    Route::get('/landing', fn () => Inertia::render('SakaiView', ['view' => 'pages/Landing']))->name('landing');

    Route::get('/pages/empty', fn () => Inertia::render('SakaiView', ['view' => 'pages/Empty']))->name('pages.empty');
    Route::get('/pages/crud',  fn () => Inertia::render('SakaiView', ['view' => 'pages/Crud']))->name('pages.crud');
});

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
