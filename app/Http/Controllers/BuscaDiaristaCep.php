<?php

namespace App\Http\Controllers;

use App\Services\ViaCEP;
use Illuminate\Http\Request;
use App\Models\Diarista;

class BuscaDiaristaCep extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, ViaCEP $viaCEP)
    {
        $endereco = $viaCEP->buscar($request->cep);

        if($endereco == false) {
            return response()->json(['erro'=>'Cep inválido'], 400);
        } else {}

        return [
            'diaristas' => Diarista::buscaPorCodigoIbge($endereco['ibge']),
            'quantidade_diaristas' => Diarista::quantidadePorCodigoIbge($endereco['ibge'])
        ];


    }
}
