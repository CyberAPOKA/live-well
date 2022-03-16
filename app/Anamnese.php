<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Anamnese extends model implements Auditable{
    use \OwenIt\Auditing\Auditable;

    protected $table = "anamneses";
    protected $fillable = [
        'peso', 'altura', 'possui_doenca', 'toma_medicacao', 'alergia_medicacao','fumante','cirurgia', 
        'dor_ossea', 'dor_muscular', 'dor_articular','atestado', 'observacao', 'ano', 'pessoas_id', 
    ];

    public function pessoas(){
        return $this->belongsTo(Pessoa::class);
    }

    public function doencas(){
        return $this->belongsToMany(Doenca::class, 'anamneses_doencas');
    }
}
