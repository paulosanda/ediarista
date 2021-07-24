<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiaristaRequest;
use Illuminate\Http\Request;
use App\Models\Diarista;
use App\Services\ViaCEP;

class DiaristaController extends Controller
{
    public function __construct(
        protected ViaCEP $viaCep
    ) {

    }

    /**
     * Lista as diaristas
     *
     * @return void
     */
    public function index()
    {
        $diaristas = Diarista::get();
        return view('index',['diaristas' => $diaristas]);
    }

    /**
     * Retorna formulário de cadastro
     *
     * @return void
     */

    public function  create()
    {
        return view('create');
    }

    /**
     * Grava nova diarista na base de dados
     *
     */
    public function store(DiaristaRequest $request)
    {
        //dd($request->all());
        $dados = $request->except('_token');
        $dados['foto_usuario'] = $request->foto_usuario->store('public');

        $dados['cpf'] = str_replace(['.', '-'], '', $dados['cpf']);
        $dados['cep'] = str_replace('-', '', $dados['cep']);
        $dados['telefone'] = str_replace(['(',')','-', ' '],'', $dados['telefone']);
        $dados['codigo_ibge'] = $this->viaCep->buscar($dados['cep'])['ibge'];


        Diarista::create($dados);

        return redirect()->route('diaristas.index');
    }

    /**
     * Retorna diarista para editar
     *
     * @param [type] $id
     * @return void
     */
    public function edit($id)
    {
        $diarista = Diarista::findOrFail($id);

        return view('edit',['diarista' => $diarista]);
    }

    /**
     * Atualiza dados de uma diarista no BD
     *
     */
    public function update(int $id, DiaristaRequest $request)
    {
        $diarista = Diarista::findOrFail($id);

        $dados = $request->except('_token', '_method');

        $dados['cpf'] = str_replace(['.', '-'], '', $dados['cpf']);
        $dados['cep'] = str_replace('-', '', $dados['cep']);
        $dados['telefone'] = str_replace(['(',')','-', ' '],'', $dados['telefone']);
        $dados['codigo_ibge'] = $this->viaCep->buscar($dados['cep'])['ibge'];

        if($request->hasFile('foto_usuario')) {
            $dados['foto_usuario'] = $request->foto_usuario->store('public');
        }

        $diarista->update($dados);

        return redirect()->route('diaristas.index');
    }

    /**
     * Apaga registro
     */
    public function destroy( int $id)
    {
        $diarista = Diarista::findOrFail($id);

        $diarista->delete();

        return redirect()->route('diaristas.index');

    }
}
