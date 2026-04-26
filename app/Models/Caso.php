<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caso extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'tipo',
        'descripcion',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'estado',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function graficos()
    {
        return $this->hasMany(Grafico::class);
    }

    public function genograma()
    {
        return $this->hasOne(Grafico::class)->where('tipo', 'genograma');
    }

    public function mapaRedes()
    {
        return $this->hasOne(Grafico::class)->where('tipo', 'mapa_redes');
    }

    public function ecomapa()
    {
        return $this->hasOne(Grafico::class)->where('tipo', 'ecomapa');
    }
}
