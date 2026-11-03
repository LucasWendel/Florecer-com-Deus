<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FlorescerController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', [FlorescerController::class, 'home'])->name('home');
Route::get('/funil', [FlorescerController::class, 'funil'])->name('funil');
Route::post('/checkout', [FlorescerController::class, 'checkout'])->name('checkout');
Route::get('/confirmacao', [FlorescerController::class, 'confirmacao'])->name('confirmacao');
Route::get('/sobre', [FlorescerController::class, 'sobre'])->name('sobre');
Route::get('/status-do-pedido', [FlorescerController::class, 'statusPedido'])->name('status.pedido');
Route::post('/stripe/webhook', [FlorescerController::class, 'stripeWebhook'])
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->name('stripe.webhook');

// ── Área do participante ("Já estou participando") ──
Route::prefix('participante')->name('assinante.')->group(function () {
    Route::get('/', [SubscriberController::class, 'login'])->name('login');
    Route::post('/email', [SubscriberController::class, 'checkEmail'])->name('check-email');
    Route::get('/senha', [SubscriberController::class, 'showPassword'])->name('senha');
    Route::post('/senha', [SubscriberController::class, 'loginPassword'])->name('login-password');
    Route::get('/criar-senha', [SubscriberController::class, 'showSetPassword'])->name('definir-senha');
    Route::post('/criar-senha', [SubscriberController::class, 'setPassword'])->name('salvar-senha');
    Route::get('/area', [SubscriberController::class, 'area'])->name('area');
    Route::get('/formulario',   [SubscriberController::class, 'formulario'])->name('formulario');
    Route::post('/formulario',  [SubscriberController::class, 'enviarFormulario'])->name('enviar-formulario');
    Route::post('/sair', [SubscriberController::class, 'logout'])->name('logout');
});

// ── Dashboard do administrador ──
Route::prefix('dashboard')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'doLogin'])->name('do-login');
    Route::get('/assinante/{id}/editar', [AdminController::class, 'edit'])->name('edit');
    Route::post('/assinante/{id}/editar', [AdminController::class, 'update'])->name('update');
    Route::post('/assinante/{id}/excluir', [AdminController::class, 'delete'])->name('delete');
    Route::post('/assinante/{id}/resetar-senha', [AdminController::class, 'resetPassword'])->name('reset-password');
    Route::get('/assinante/{id}/formulario', [AdminController::class, 'formView'])->name('form-view');
    Route::get('/assinante/{id}/arquivo/{tipo}', [AdminController::class, 'downloadFile'])->name('download-file');
    Route::get('/exportar-excel', [AdminController::class, 'exportExcel'])->name('export-excel');
    Route::post('/sair', [AdminController::class, 'logout'])->name('logout');
});
