<?php
use App\Http\Controllers\HomebudgetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homebudget.index');
});

Route::get('/', [HomebudgetController::class, 'index'])->name('index');
Route::post('/post', [HomebudgetController::class, 'store'])->name('store');
Route::get('/edit/{id}', [HomebudgetController::class, 'edit'])->name('homebudget.edit');
Route::put('/update', [HomebudgetController::class, 'update'])->name('homebudget.update');
Route::post('/destroy/{id}', [HomebudgetController::class, 'destroy'])->name('homebudget.destroy');