<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;  // ¡¡ESTO ES CLAVE!!

class Link extends Model
{
    use HasFactory;

    // Campos que se pueden rellenar masivamente
    protected $fillable = ['nombre', 'enlace'];

    // Si la tabla NO tiene created_at / updated_at
    public $timestamps = false;
    
    public function __construct()
    {

    }

}