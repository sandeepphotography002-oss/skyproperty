<?php

use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|---------------------------------------------------------------------
| Sky Property Morni Hills
|---------------------------------------------------------------------
*/

Route::get('/',            [SiteController::class, 'home'])->name('home');
Route::get('/properties',  [SiteController::class, 'properties'])->name('properties');
Route::get('/about',       [SiteController::class, 'about'])->name('about');
Route::get('/contact',     [SiteController::class, 'contact'])->name('contact');

Route::post('/enquiry', [SiteController::class, 'enquiry'])
    ->middleware('throttle:10,1')          // ek IP se ghante mein das
    ->name('enquiry');

Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt',  [SiteController::class, 'robots'])->name('robots');

/* Wildcard sabse aakhir mein. Upar hota to /about ko bhi ek property
   ka slug samajh kar 404 de deta. */
Route::get('/property/{slug}', [SiteController::class, 'show'])->name('property');

/*
|---------------------------------------------------------------------
| Admin
|---------------------------------------------------------------------
| Login Laravel ka apna hai (auth middleware). Naya user banane ka
| rasta site par nahi hai -- account artisan se banta hai, taaki koi
| bahar se khud ko admin na bana le.
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [PropertyController::class, 'dashboard'])->name('dashboard');

    Route::get('properties',               [PropertyController::class, 'index'])->name('properties.index');
    Route::get('properties/create',        [PropertyController::class, 'create'])->name('properties.create');
    Route::post('properties',              [PropertyController::class, 'store'])->name('properties.store');
    Route::get('properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('properties/{property}',    [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

    Route::post('properties/{property}/images',        [PropertyController::class, 'uploadImages'])->name('properties.images');
    Route::delete('properties/{property}/images',      [PropertyController::class, 'deleteImage'])->name('properties.images.delete');
    Route::post('properties/{property}/cover',         [PropertyController::class, 'setCover'])->name('properties.cover');

    Route::get('enquiries',               [EnquiryController::class, 'index'])->name('enquiries.index');
    Route::put('enquiries/{enquiry}',     [EnquiryController::class, 'update'])->name('enquiries.update');
    Route::delete('enquiries/{enquiry}',  [EnquiryController::class, 'destroy'])->name('enquiries.destroy');
});

/* Login. Breeze jaan-boojh kar nahi liya -- wo npm aur vite build
   maangta hai, aur yahan bas ek maalik ko andar aana hai. */
Route::get('login',   [AuthController::class, 'form'])->middleware('guest')->name('login');
Route::post('login',  [AuthController::class, 'login'])->middleware(['guest', 'throttle:8,1'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
