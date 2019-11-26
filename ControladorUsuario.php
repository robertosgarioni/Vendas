<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\usuario;

class Controladorusuario extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('usuario');
    }

    public function index()
    {
       $cli = usuario::all();
        return json_encode($cli);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cli = new usuario();
        $cli->email = $request->input('email');
        $cli->telefone1 = $request->input('telefone1');
        $cli->cep = $request->input('cep');
        $cli->endereco = $request->input('endereço');
        $cli->numero = $request->input('numero');
        $cli->dta_criacao_user = $request->input('dta_criacao_user');
        $cli->save();
        return json_encode($cli);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cli = usuario::find($id);
        if (isset($cli)) {
            return json_encode($cli);
        }
        return response('usuario não encontrado', 404);
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


        $cli = usuario::find($id);
        if (isset($cli)) {
        $cli->email = $request->input('email');
        $cli->telefone1 = $request->input('telefone1');
        $cli->cep = $request->input('cep');
        $cli->endereco = $request->input('endereço');
        $cli->numero = $request->input('numero');
        $cli->dta_criacao_user = $request->input('dta_criacao_user'); 
        $cli->save();
        return json_encode($cli);
         }
        return response('Usuario não encontrado', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $cli = usuario::find($id);
        if (isset($cli)) {
            $cli->delete();
            return response('OK', 200);
        }
        return response('Produto não encontrado', 404);
    }
}
