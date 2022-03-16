<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Doenca extends model implements Auditable{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'nome', 'descricao',
    ];

    public function anamneses(){
        return $this->belongsToMany(Anamnese::class);
    }
}
