<?php

namespace App\Http\Controllers;

use App\Productos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'producto'       => 'required|max:255',
            'categoria' => 'required',
        ]);

        $producto = new Productos();
        $producto->producto = $request->producto;
        $producto->categoria_id = $request->categoria;

        $producto->save();
        return response()->json(['code'=>200, 'message'=>'Producto Creado exitosamente','data' => $producto], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productos = Productos::where('categoria_id', $id)->get();

        return response()->json($productos);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categoria = Categorias::find($id);
        $datos = json_decode($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id)->delete();

        return response()->json(['success'=>'Post Deleted successfully']);
    }
}
