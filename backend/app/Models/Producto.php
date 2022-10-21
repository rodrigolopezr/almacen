<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function categoria(){
         return $this->belongsTo(Categoria::class,'categoria_id', 'id');
    }

    public function atributos(){
        return $this->hasMany(Atributo::class);
    }
}
