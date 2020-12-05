<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    // laravel en automatico busca una tabla Specialties en la cual consultar
    // en dado caso que nosotros no hayamos puesto la tabla en plural y en ingles por ejemplo que hayamos puesto "especialidades" al nombre
    // de la tabla tendriamso que especificar a que tabla va trabajar o consultar este modelo por ejemplo:

        // protected $table = 'especialidades';

    // pero para horrar se el timpo de estar especificando con que tabla trabajar es mejor seguir con la convención de laravel
    // Los modelos deben ser en Singular y las migraciones en plural y en minusculas.

    // $specialty->users
    public function users(){
        
        // esto significa que una especialidad se asocia con multiples usuarios.
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
