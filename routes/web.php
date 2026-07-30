<?php

use App\Livewire\Admin;
use App\Livewire\Client;
use App\Livewire\Home;
use App\Livewire\Portfolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::livewire('portfolio', Portfolio::class)->name('portfolio');

/*
|--------------------------------------------------------------------------
| Customer area
|--------------------------------------------------------------------------
|
| Customers can request a service and follow its progress. Email verification
| is not enforced here so walk-in customers registered by the shop can use
| the tracker right away.
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', fn () => redirect()->route(
        Auth::user()->isAdmin() ? 'admin.dashboard' : 'orders.index',
    ))->name('dashboard');

    Route::livewire('orders', Client\Orders\Index::class)->name('orders.index');
    Route::livewire('orders/new', Client\Orders\Create::class)->name('orders.create');
    Route::livewire('orders/{order}', Client\Orders\Show::class)->name('orders.show');
});

/*
|--------------------------------------------------------------------------
| Shop area
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::livewire('/', Admin\Dashboard::class)->name('dashboard');

    Route::livewire('orders', Admin\Orders\Index::class)->name('orders.index');
    Route::livewire('orders/new', Admin\Orders\Create::class)->name('orders.create');
    Route::livewire('orders/{order}', Admin\Orders\Show::class)->name('orders.show');

    Route::livewire('customers', Admin\Customers\Index::class)->name('customers.index');

    Route::livewire('portfolio', Admin\Portfolio\Index::class)->name('portfolio.index');
    Route::livewire('portfolio/new', Admin\Portfolio\Edit::class)->name('portfolio.create');
    Route::livewire('portfolio/{item}', Admin\Portfolio\Edit::class)->name('portfolio.edit');
});

require __DIR__.'/settings.php';
