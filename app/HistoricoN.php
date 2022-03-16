<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class HistoricoN extends Model implements Auditable{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'historico_nucleos';

    protected $fillable = [
        'nucleo_id','inativo','comentario','operario',
    ];
}
