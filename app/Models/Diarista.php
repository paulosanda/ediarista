<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diarista extends Model
{
    use HasFactory;

    /**
     * Defini os campos que podem ser gravados
     *
     * @var array
     */

    protected $fillable = ['nome_completo', 'cpf', 'email', 'telefone', 'logradouro', 'numero', 'complemento','bairro', 'cidade', 'estado', 'cep', 'codigo_ibge', 'foto_usuario'];

    /**
     * Defini os campos que podem ser vistos na serialização
     *
     * @var array
     */
    protected $visible = ['nome_completo', 'cidade', 'foto_usuario', 'reputacao'];

    /**
     * Adiciona campo na serialização
     *
     * @var array
     */

    protected $appends = ['reputacao'];

    /**
     * Monta URL para a imagem
     *
     * @param string $valor
     * @return void
     */

    public function getFotoUsuarioAttribute(string $valor)
    {
        return config('app.url').'/'.$valor;
    }

    /**
     * Retorna a reputacao randomica
     */
    public function getReputacaoAttribute($valor)
    {
        return mt_rand(1, 5);
    }

     /**
      * Busca diaristas por código IBGE
      * @param integer $codigoibge
      * @return void
      */
    static public function buscaPorCodigoIbge(int $codigoibge)
    {
        return self::where('codigo_ibge', $codigoibge)->limit(6)->get();
    }

    /**
     * Retorna diaristas restantes
     * @param integer $codigoibge
     * @return void
     */
    static public function quantidadePorCodigoIbge(int $codigoibge)
    {
        $quantidade = self::where('codigo_ibge', $codigoibge)->count();

        return $quantidade > 6 ? $quantidade - 6 : 0;
    }
}
