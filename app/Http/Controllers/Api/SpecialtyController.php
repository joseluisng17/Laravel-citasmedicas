<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Specialty;

class SpecialtyController extends Controller
{
    public function doctors(Specialty $specialty){
        
        // estamos diciendo que apartir de la especilidad nos traiga los medicos asociados o relacionados
        // y con el builder get() le decirmos que nos traiga dos datos en especifico lo que viene siendo de la tabla users su id (user.id) 
        // y de la tabla users el name (users.name)
        return $specialty->users()->get([
            'users.id', 'users.name'
        ]);

    }

}
