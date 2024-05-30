<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CRUD;
use Illuminate\Support\Facades\DB;

class CRUDController extends Controller
{
    public function index()
    {
        return view('CRUD.index');
    }
    public function listar_clientes(Request $request)
    {
        if ($request->ajax()) {
            //$clientes= CRUD::all(); 
            $clientes = DB::table('c_r_u_d_s')->select('*')->get();
            //dd($clientes);
            $html = view('CRUD.parent.ajax_lista', compact('clientes'))->render();
            return response()->json([
                'code' => 200,
                'html' => $html,
                'msg' => 'success'
            ], 200);

        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error al acceder a la pagina :c'
            ], 404);
        }
    }
    public function eliminar_cliente(Request $request)
    {
        if ($request->ajax()) {
            $id_cliente = $request->id_cliente;
            $cliente = CRUD::find($id_cliente);

            if ($cliente) {
                $cliente->delete();
                return response()->json([
                    'code' => 200,
                    'msg' => 'success',
                    'message' => 'Cliente eliminado exitosamente.'
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'msg' => 'error',
                    'message' => 'Cliente no encontrado.'
                ], 404);
            }
        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error al acceder a la solicitud.'
            ], 404);
        }
    }


    public function registrar_clientes(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $tipo_form = $request->tipo_formulario;
            if ($tipo_form == 1) {//REGISTRAR
                $clientes = CRUD::create([
                    'nombre' => $request->nombre_cliente,
                    'apellido_paterno' => $request->apellido_paterno_cliente,
                    'apellido_materno' => $request->apellido_materno_cliente,
                    'edad' => $request->edad_cliente,
                    'correo' => $request->correo_empleado,
                    'telefono' => $request->numero_cliente
                ]);
                //dd($clientes);
                if ($clientes) {
                    return response()->json([
                        'code' => 200,
                        'msg' => 'succes',
                        'message' => 'Cliente registrado exitosamente.'
                    ], 200);
                } else {
                    return response()->json([
                        'code' => 404,
                        'msg' => 'error',
                        'message' => 'Error al registrar cliente.'
                    ], 404);
                }
            } else {//EDITAR
                $id_cliente = $request->id_cliente_editar;
                DB::table('c_r_u_d_s')->where('id', $id_cliente)->update([
                    'nombre' => $request->nombre_cliente,
                    'apellido_paterno' => $request->apellido_paterno_cliente,
                    'apellido_materno' => $request->apellido_materno_cliente,
                    'edad' => $request->edad_cliente,
                    'correo' => $request->correo_empleado,
                    'telefono' => $request->numero_cliente
                ]);
                return response()->json([
                    'code' => 200,
                    'msg' => 'succes',
                    'message' => 'Cliente actualizado exitosamente.'
                ], 200);
            }

        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error.'
            ], 404);
        }
    }
    public function obtener_cliente_por_id(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $cliente = CRUD::find($request->id_cliente);
            //dd($cliente); //prueba de que si se estén obteniendo los datos

            return response()->json([
                'code' => 200,
                'msg' => 'succes',
                'message' => 'Cliente encontrado.',
                'cliente' => $cliente
            ], 200);

        } else {
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error zl encontrar cliente.'
            ], 404);
        }
    }
}
