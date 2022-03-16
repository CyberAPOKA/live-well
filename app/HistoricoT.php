<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class HistoricoT extends Model implements Auditable{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'historico_turmas';

    protected $fillable = [
        'turma_id','inativo','comentario','operario',
    ];
}
