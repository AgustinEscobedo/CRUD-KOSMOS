<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRUDController; 

Route::get('/', function () {
    return view('welcome');
});

Route::controller(CRUDController::class)->group(function(){
    // Rutas para mi CRUDController
    Route::get('kosmos', 'index')->name('cursos.index');
    Route::post('lista_clientes','listar_clientes')->name('clientes.lista');
    Route::post('registro_clientes','registrar_clientes')->name('clientes.registrar');
    Route::post('obtener_cliente_id','obtener_cliente_por_id')->name('clientes.obtener_cliente');
    Route::post('eliminar_cliente', 'eliminar_cliente')->name('clientes.eliminar');

});
