<?php

use App\Http\Controllers\Bo\BoAllCompanyController;
use App\Http\Controllers\Bo\BoBasicInformationController;
use App\Http\Controllers\Bo\BoCategoryController;
use App\Http\Controllers\Bo\BoReservationController;
use App\Http\Controllers\Bo\BoReservationManagmentController;
use App\Http\Controllers\Bo\BoScheduleController;
use App\Http\Controllers\Bo\BoServiceController;
use App\Http\Controllers\Bo\BoUserCompanyController;
use App\Http\Controllers\Bo\BoUserController;
use App\Http\Controllers\Fo\FoReservationController;
use App\Http\Controllers\Fo\FoSearchingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')->name('bo.')->group(function () {
    Route::controller(BoUserController::class)->name('users.')->middleware(['auth', 'verified', 'role:super-admin', 'set_to_bo'])->group(function() {
        Route::get('pouzivatelia', 'all')->name('all'); 
        Route::get('pouzivatel/vytvorenie', 'create')->name('create'); 
        Route::post('pouzivatel', 'store')->name('store');
        Route::get('pouzivatel/{id}/upravenie', 'edit')->name('edit');
        Route::put('pouzivatel/upravenie/{id}', 'updateOthers')->name('update-others');
        Route::put('pouzivatel/upravenie-hesla/{id}', 'updatePassword')->name('update-password');
        Route::post('pouzivatel/pridelenie-role/{id}', 'assignRole')->name('assign-role');
        Route::post('pouzivatel/odobranie-role/{id}', 'removeRole')->name('remove-role');
        Route::post('pouzivatel/obnovenie/{id}', 'restore')->name('restore');
        Route::delete('pouzivatel/{id}', 'destroy')->name('destroy');
    });

    Route::controller(BoAllCompanyController::class)->name('all-companies.')->middleware(['auth', 'verified', 'role:super-admin', 'set_to_bo'])->group(function() {
        Route::get('vsetky-podniky', 'all')->name('all');
        Route::post('vsetky-podniky/obnovenie/{id}', 'restore')->name('restore');
        Route::post('vsetky-podniky/vyber-podniku/{id}', 'selectCompany')->name('select-company');
    });

    Route::controller(BoCategoryController::class)->name('categories.')->middleware(['auth', 'verified', 'role:super-admin', 'set_to_bo'])->group(function() {
        Route::get('kategorie', 'all')->name('all');
        Route::get('kategoria/vytvorenie', 'create')->name('create');
        Route::post('kategoria', 'store')->name('store');
        Route::get('kategoria/{id}/upravenie', 'edit')->name('edit');
        Route::put('kategoria/{id}', 'update')->name('update');
        Route::post('kategoria/obnovenie/{id}', 'restore')->name('restore');
        Route::delete('kategoria/{id}', 'destroy')->name('destroy');
    });

    Route::controller(BoReservationManagmentController::class)->name('reservation-management.')->middleware(['auth', 'verified', 'role:super-admin', 'set_to_bo'])->group(function() {
        Route::get('manazment-rezervacii', 'all')->name('all');
        Route::post('manazment-rezervacii/odoslat-notifikacie', 'sendNotifications')->name('send-notifications');
    });
    //////////////////////////////////////////////

    Route::controller(BoUserCompanyController::class)->name('user-companies.')->middleware(['auth', 'verified', 'role:super-admin|owner', 'set_to_bo'])->group(function() {
        Route::get('podniky', 'all')->name('all');
        Route::post('podniky/vyber-podniku/{id}', 'selectCompany')->name('select-company');
        Route::get('podnik/preparation-for-new-company', 'preparationForNewCompany')->name('preparation-for-new-company');
        Route::get('podnik/vytvorenie-zakladnych-informacii', 'createBasicInformations')->name('create-basic-informations');
        Route::post('podnik/vytvorenie-zakladnych-informacii', 'storeBasicInformations')->name('store-basic-informations');
        Route::get('podnik/vytvorenie-otvaracich-hodin', 'createSchedule')->name('create-schedule');
        Route::post('podnik/vytvorenie-otvaracich-hodin', 'storeSchedule')->name('store-schedule');
    });

    Route::controller(BoBasicInformationController::class)->name('basic-informations.')->middleware(['auth', 'verified', 'is_selected_company', 'set_to_bo'])->group(function() {
        Route::get('zakladne-informacie', 'show')->name('show');
        Route::get('zakladne-informacie/{id}/upravenie', 'edit')->name('edit');
        Route::put('zakladne-informacie/{id}', 'update')->name('update');
        Route::delete('zrusenie-podniku/{id}', 'destroy')->name('destroy');
    });

    Route::controller(BoScheduleController::class)->name('schedules.')->middleware(['auth', 'verified', 'is_selected_company', 'set_to_bo'])->group(function() {
        Route::get('otvaracie-hodiny', 'show')->name('show');
        Route::get('otvaracie-hodiny/upravenie', 'edit')->name('edit');
        Route::put('otvaracie-hodiny', 'update')->name('update');
    });

    Route::controller(BoServiceController::class)->name('services.')->middleware(['auth', 'verified', 'is_selected_company', 'set_to_bo'])->group(function() {
        Route::get('sluzby', 'all')->name('all');
        Route::get('sluzba/vytvorenie', 'create')->name('create');
        Route::post('sluzba', 'store')->name('store');
        Route::get('sluzba/{id}/upravenie', 'edit')->name('edit');
        Route::put('sluzba/{id}', 'update')->name('update');
        Route::delete('sluzba/{id}', 'destroy')->name('destroy');
    });

    Route::controller(BoReservationController::class)->name('reservations.')->middleware(['auth', 'verified', 'is_selected_company', 'set_to_bo'])->group(function() {
        Route::get('rezervacie', 'all')->name('all');
        Route::get('rezervacia/{id}/zrušenie', 'edit')->name('edit');
        Route::put('rezervacia/{id}', 'update')->name('update');
        Route::post('rezervacia/filtrovanie', 'filterStartDate')->name('filter-start-date');
    });
});

Route::name('fo.')->group(function () { 
    Route::controller(FoSearchingController::class)->name('searching.')->middleware(['set_to_fo'])->group(function() {
        Route::get('vyber-mesta', 'selectCity')->name('select-city');
        Route::get('podniky/{selectedCity}', 'all')->name('all');
        Route::post('podniky/{selectedCity}/filtrovanie', 'filterCategory')->name('filter-category');
        Route::get('podniky/{selectedCity}/filtrovanie', 'searchCompanyName')->name('search-company-name');
        Route::get('podnik/{selectedCity}/{idCompany}', 'showCompany')->name('show-company');
        Route::get('podnik/{selectedCity}/{idCompany}/sluzby', 'showCompanyServices')->name('show-company-services')->middleware(['auth', 'verified']);
        Route::get('podnik/{selectedCity}/{idCompany}/{idService}', 'showDateTime')->name('show-date-time')->middleware(['auth', 'verified']);
        Route::post('podnik/{selectedCity}/{idCompany}/{idService}', 'store')->name('store')->middleware(['auth', 'verified']);
        Route::get('vytvorena-rezervacia', 'showCreatedReservation')->name('show-created-reservation')->middleware(['auth', 'verified']);
    });

    Route::controller(FoReservationController::class)->name('reservations.')->middleware(['auth', 'verified', 'set_to_fo'])->group(function() {
        Route::get('moje-rezervacie/kalendar', 'showCalendar')->name('show-calendar');
        Route::get('moje-rezervacie/den/{day}', 'showDay')->name('show-day');
        Route::get('moja-rezervacia/{day}/{id}', 'edit')->name('edit');
        Route::put('moja-rezervacia/{day}/{id}', 'update')->name('update');
    });
});

Route::get('/', function () {
    return redirect()->route('fo.searching.select-city');
})->middleware(['set_to_fo']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
