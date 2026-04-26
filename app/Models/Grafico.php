<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grafico extends Model
{
    use HasFactory;

    protected $fillable = [
        'caso_id',
        'tipo',
        'datos',
    ];

    protected $casts = [
        'datos' => 'array',
    ];

    public function caso()
    {
        return $this->belongsTo(Caso::class);
    }
}
