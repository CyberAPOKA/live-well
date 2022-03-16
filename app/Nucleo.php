<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Nucleo extends model implements Auditable{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'nome','cidade','bairro','rua','numero_endereco','complemento','cep','telefone','inativo','descricao',
    ];

    public function turmas(){
        return $this->HasMany(Turma::class);
    }

    public function bairro(){
        return $this->BelongsTo(Bairro::class);
    }
}
