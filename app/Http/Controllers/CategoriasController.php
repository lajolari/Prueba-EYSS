<?php

namespace App\Http\Controllers;

use App\Categorias;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categorias::all();
        return view('welcome', ['categorias' => $categorias]);
    }

    /**
     * Update the specified resource in storage.
     * GET
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'edited'       => 'required|max:255',
        ]);

        $cat = Categorias::find($request->id);
        $cat->categoria = $request->edited;

        $cat->save();
        return response()->json(['code'=>200, 'message'=>'Categoria modificada exitosamente','data' => $cat], 200);
        
    }

    /**
     * Remove the specified resource from storage.
     * DELETE
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categorias::find($id)->delete();
        return response()->json(['success'=>'Categoria eliminada']);
    }
}
