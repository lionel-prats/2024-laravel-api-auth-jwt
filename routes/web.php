<?php

use Illuminate\Support\Facades\Route;

use App\Jobs\FiltrarRegistroValidandoImagenesJob;

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

Route::get('/', function () {  
    return view('welcome');
    // Logger::dispatch();
    // Logger::dispatchAfterResponse();
    // Logger::dispatch()->onConnection("database");
    // Logger::dispatch()->onQueue("secondary"); // puse el job en la cola "secondary"
});

Route::get('/{id_registro}', function ($id_registro) {
    // $registro = Entrada::where('id', $id_registro)
    // ->select('id', 'idprotocolo', 'imagen1', 'imagen2', 'imagen3', 'imagen4')
    // ->first();
    
    // FiltrarRegistroValidandoImagenesJob::dispatch($registro);
    FiltrarRegistroValidandoImagenesJob::dispatchSync();

    return response()->json([
        'status' => 'success',
    ], 200);
});
