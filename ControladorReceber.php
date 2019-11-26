<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\receber_titulo;
use App\usuario;
use DB;

class ControladorReceber extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('receber');
    }

     public function index()
    {
        $rec = DB::table('receber_titulos')
            ->join('clientes', 'clientes.id', '=', 'receber_titulos.cliente_id')
            ->OrderBy('receber_titulos.id')
            ->select('receber_titulos.*', 'clientes.razao')
            ->get();
        return $rec->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rec = new receber_titulo();
        $rec->data_venc = $request->input('venc');
        $rec->data_inc = $request->input('inc');
        $rec->valor = $request->input('valor');
        $rec->cliente_id = $request->input('usuario');
        $rec->observacao = $request->input('observacao');
        $rec->save();
        return json_encode($rec);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rec = receber_titulo::find($id);
        if (isset($rec)) {
            return json_encode($rec);            
        }
        return response('receber não encontrado', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rec = receber_titulo::find($id);
        if (isset($rec)) {
            $rec->delete();
            return response('OK', 200);
        }
        return response('Produto não encontrado', 404);
    }

    public function baixar($id)
    {
      
      $rec = receber_titulo::find($id);
      $rec->baixado=1;
      $rec->save();
    }


}
