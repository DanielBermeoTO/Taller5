<?php

// app/Models/salida.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    use HasFactory;

    // Definir la tabla y las columnas que se pueden asignar masivamente
    protected $table = 'salida';  // Nombre de la tabla en la base de datos
    protected $fillable = ['fecha_salida', 'nombre', 'precio'];
}
?>
