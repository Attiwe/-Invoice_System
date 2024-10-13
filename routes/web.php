<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController ;
use App\Http\Controllers\RoleController ;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoicAttachmentsController;
use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\ArshefetController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    
    return view('auth.login');
});
Route::get('/dashboard', [HomeController::class, 'index'])
->middleware(['auth', 'verified'])
->name('dashboard');

 
    
 
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::controller(InvoiceController::class)->group(function () {
    Route::get('/invoices', 'index')->name('page.invoice');
    Route::get('/invoices/show', 'show')->name('invoice.show');
    Route::post('/store/store/store', 'store')->name('store.data');
    Route::get('cass/invoices/{id}', 'cases')->name('cases.invoices');
    Route::delete('delete/invoices/{id}', action: 'destroy')->name('destroy');
    Route::put('arshef/invoices/{id}', action: 'arshef')->name('arshef');///////////////////////////
    Route::get('edit/{id}/edit', 'edit')->name('invoice.edit');
    Route::put('/update/{id}', 'store_update')->name('invoice.store_update');
    Route::get('edit/status_invoices/{id}','edit_invoices')->name('edit.casesInvoices');
    Route::put('update/statusInvoice/{id}','status_update')->name('update.status_invoice');
    Route::get('invoice_paid/index','show_invoice_paid')->name('show.invoice_paid');
    Route::get('show/invoice_unpaid','show_invoice_unpaid')->name('show.invoice_unpaid');
    Route::get('show/part_invoices/','show_invoice_part')->name('show.invoice_part_paid');
    Route::get('print_pill/{id}','print_invoice')->name('page.print_invoice');
    Route::get('invoice/export/', 'export')->name('page.export_invoices');
});

Route::controller(InvoicAttachmentsController::class)->group(function () {
    Route::get('view_file/{invoice_number}/{file_name}', 'open_file')->name('show.file');
    Route::get('downlod_file/{invoice_number}/{file_name}', 'down_file')->name('dowenlod.file');
    Route::delete('delete/file/delete/', 'destroy')->name('destory.invoice');
    Route::post('store/file', 'store')->name('invoice.store');
});

Route::controller(SectionController::class)->group(function () {
    Route::get('/section', 'index')->name(name: 'page.section');
    Route::post('/section/store', 'store')->name('section.store');
    Route::put('/section/Update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('section.destroy');
});


Route::controller(ProductController::class)->group(function () {
    Route::get('/product', 'index')->name('page.porduct');
    Route::post('/product/store', 'store')->name('post.store');
    Route::put('/product/updat/{id}', 'update')->name('product.update');
    Route::delete('/product/{id}', 'destroy')->name('product.destrou');
});


Route::controller(ArshefetController::class)->group(function(){
    Route::get('invoices_arshfe','index')->name('page.invoice_arshefe');
    Route::put('invoice/update/{id}','update')->name('page.softDelet_update');
    Route::delete('invoice/{id}','destroy')->name('page.Arshef_destroy');

});


// premassion usars
  Route::group(['middleware' => ['auth']],
 function() {
    Route::resource('roles',RoleController::class);
    Route::resource('users', UserController::class);
 });

 
Route::controller(ReportController::class)->group(function(){
 
    Route::get('inovice_report','index')->name('page.inovice_report');
    Route::post('sarch/status_invoices','sarch_invoices')->name('sarch.report_invoice');

});

Route::controller(CustomerReportController::class)->group(function(){

    Route::get('customer_report','index')->name('page.customer_report');
    Route::post('customer_report/invoices','serch_customer')->name('custormer_report');

});

Route::get('/{page}', [AdminController::class, 'index'])->name('index');
