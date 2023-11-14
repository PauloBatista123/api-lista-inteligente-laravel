<?php

use App\Http\Controllers\CartaoController;
use App\Http\Controllers\CooperadoComLimiteEBloqueioController;
use App\Http\Controllers\CooperadoController;
use App\Http\Controllers\CooperadoSemLimiteImplantadoController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\ImportacaoController;
use App\Http\Controllers\LimitesCooperadoSemLimiteImplantadoController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Interfaces\TabelaProdutos;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('importacao/upload', [ImportacaoController::class, 'upload']);
Route::get('importacao/upload', [ImportacaoController::class, 'listar']);
Route::get('importacao/upload/{id}', [ImportacaoController::class, 'buscar']);

Route::post('historico', [HistoricoController::class, 'criar']);

Route::get('cooperado', [CooperadoController::class, 'buscar']);
Route::get('cooperado/{id}', [CooperadoController::class, 'buscarPorId']);

Route::put('produto/tipo-contato/{id}', [ProdutoController::class, 'alterarTipoContato']);
Route::get('produtos/itens/{id}', [ProdutoController::class, 'buscarPorId']);
Route::get('produtos/itens', [ProdutoController::class, 'listar']);
Route::get('produtos', [ProdutoController::class, 'listas']);

Route::get('listas', [ListaController::class, 'listar']);
Route::post('listas', [ListaController::class, 'criar']);
