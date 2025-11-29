<?php

use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ATMController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TNUWWBController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::any('/userLogin',[LoginController::class,'userLogin'])->name('userLogin');
Route::any('/',[LoginController::class,'login'])->name('login');
Route::any('/authenticate',[LoginController::class,'authenticate'])->name('authenticate');
Route::any('/logout',[LoginController::class,'logout'])->name('logout');
Route::any('/welcomePage',[LoginController::class,'sriNet'])->name('sriNet');
Route::get('/index',[EmployeeController::class,'index'])->name('index');
Route::get('create',[EmployeeController::class,'create'])->name('create');
Route::post('store',[EmployeeController::class,'store'])->name('store');
Route::any('destroy/{employee}',[EmployeeController::class,'destroy'])->name('destroy');
Route::any('edit/{employee}',[EmployeeController::class,'edit'])->name('edit');
Route::any('update/{employee}',[EmployeeController::class,'update'])->name('update');
Route::any('show/{employee}',[EmployeeController::class,'show'])->name('show');
Route::any('forgot-password',[LoginController::class,'showForgotPasswordForm'])->name('forgot.password.get');
Route::any('forgot-password',[LoginController::class,'submitForgotPasswordForm'])->name('forgot.password.post');
Route::any('reset-password',[LoginController::class,'showResetPasswordForm'])->name('reset.password.get');
Route::any('reset-password',[LoginController::class,'submitResetPasswordForm'])->name('reset.password.post');
// Route::group(['middleware' => ['auth:user,admin']], function () {
// Route::group(['middleware' => 'auth:web'], function(){
Route::delete('/employee/{employee}/image/{index}', [EmployeeController::class, 'deleteImage'])->name('employee.image.delete');

// });

Route::group(['middleware' => 'auth:admin'], function(){
//Transaction
    Route::get('/dashboard',[ATMController::class,'dashboard'])->name('dashboard');
    Route::any('/store/income',[ATMController::class,'income'])->name('income');
    Route::any('/destroyIncome/{income}',[ATMController::class,'destroyIncome'])->name('destroyIncome');
    Route::get('/daily-income', [ATMController::class, 'getDailyIncome']);
    Route::get('/monthly-income', [ATMController::class, 'getMonthlyIncome']);
    Route::any('/pdf',[ATMController::class,'download'])->name('download');

    Route::get('/transaction/index',[ATMController::class,'index'])->name('atm.index');
    Route::get('/transaction/create',[ATMController::class,'create'])->name('atm.create');
    Route::post('/transaction/store',[ATMController::class,'store'])->name('atm.store');
    Route::post('aeps',[ATMController::class,'aepsstore'])->name('aepsstore');
    Route::any('aeps/index',[ATMController::class,'aepsindex'])->name('aepsindex');
    Route::get('/aeps/{transaction}/edit', [ATMController::class, 'aepsedit'])->name('aepsedit');
    Route::any('/aeps/{transaction}', [ATMController::class, 'aepsupdate'])->name('aepsupdate');
    Route::any('aeps/destroy/{transaction}',[ATMController::class,'aepsdestroy'])->name('aepsdestroy');
    Route::any('/transaction/destroy/{transaction}',[ATMController::class,'destroy'])->name('atm.destroy');
    Route::any('/transaction/edit/{transaction}',[ATMController::class,'edit'])->name('atm.edit');
    Route::any('/transaction/update/{transaction}',[ATMController::class,'update'])->name('atm.update');
    Route::any('/transaction/show/{transaction}',[ATMController::class,'show'])->name('atm.show');
    // Route::get('/daily-transactions', action: [ATMController::class, 'getDailyTransactions']);
    Route::get('/daily-transactions', [ATMController::class, 'getDailyTransactions']);
    Route::get('/monthly-transactions', [ATMController::class, 'getMonthlyTransactions']);
    Route::get('/all-transaction-data', [ATMController::class, 'getAllTransactionData']);
    Route::get('/tnuwwb/index',[TNUWWBController::class,'index'])->name('tnuwwb.index');
    Route::get('/tnuwwb/create',[TNUWWBController::class,'create'])->name('tnuwwb.create');
    Route::post('/tnuwwb/store',[TNUWWBController::class,'store'])->name('tnuwwb.store');
    Route::any('/tnuwwb/destroy/{data}',[TNUWWBController::class,'destroy'])->name('tnuwwb.destroy');
    Route::any('/tnuwwb/edit/{data}',[TNUWWBController::class,'edit'])->name('tnuwwb.edit');
    Route::any('/tnuwwb/update/{data}',[TNUWWBController::class,'update'])->name('tnuwwb.update');
    Route::any('/tnuwwb/show/{data}',[TNUWWBController::class,'show'])->name('tnuwwb.show');
    Route::get('/tnuwwb/{id}/pdf', [TnuwwbController::class, 'downloadPdf'])->name('tnuwwb.pdf');
    Route::post('certificate',[CertificateController::class,'store'])->name('certificatestore');
    Route::any('certificate/index',[CertificateController::class,'index'])->name('certificateindex');
    Route::get('/certificate/{transaction}/edit', [CertificateController::class, 'edit'])->name('certificateedit');
    Route::put('/certificate/{transaction}', [CertificateController::class, 'update'])->name('certificateupdate');
    Route::delete('certificate/destroy/{transaction}',[CertificateController::class,'destroy'])->name('certificatedestroy');
});

