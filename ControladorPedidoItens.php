<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido_itens;
use App\Produto;

class ControladorPedidoItens extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $ped = new Pedido_itens();
        $ped->descricao = $request->input('desc');
        $ped->pedido_id = $request->input('id_ped');
        $ped->produto_id = $request->input('id_prod');
        $ped->qte = $request->input('qte');
        $ped->vlr_total = $request->input('vlr');
        $ped->save();
    }

    public function baixar($id,$qte)
    {
      $item = Produto::find($id);
      $item->estoque -= $qte;
      $item->save();
    }


    public function show($id)
    {
        $ped = Pedido_itens::find($id);
        if (isset($ped)) {
            return json_encode($ped);            
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
        //
    }
}
