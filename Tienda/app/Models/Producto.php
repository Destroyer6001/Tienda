<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['nombre', 'descripcion' ,'precio', 'cantidad_disponible', 'marca_id', 'categoria_id'];
    use HasFactory;

    public function categorias()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }

    public function marcas()
    {
        return $this->belongsTo(Marca::class, 'marca_id', 'id');
    }

    public function compras()
    {
        return $this->belongsToMany(Compra::class, 'compra_productos')->withPivot('precio','subtotal','cantidad')->withTimestamps();
    }
}
