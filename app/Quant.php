<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Quant extends Model implements Auditable{
    use \OwenIt\Auditing\Auditable;

    protected $table = "quant_pessoa_turmas";

    protected $fillable = [
        'quantidade',
    ];
}
