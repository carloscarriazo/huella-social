<?php

use App\Http\Controllers\CasoController;
use App\Http\Controllers\GraficoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/planes', function () {
    return view('planes');
})->name('planes');

Route::get('/dashboard', function () {
    return redirect()->route('casos.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Gestión de Casos
    Route::resource('casos', CasoController::class);

    // Gráficos por tipo
    Route::get('casos/{caso}/graficos/{tipo}', [GraficoController::class, 'show'])->name('graficos.show');
    Route::post('casos/{caso}/graficos/{tipo}', [GraficoController::class, 'guardar'])->name('graficos.guardar');
});

require __DIR__.'/auth.php';
