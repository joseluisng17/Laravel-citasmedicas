<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Specialty;

use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{
     // Middleware
   // public function __construct()
    //{
     //   $this->middleware('auth');
    //}
    
    public function index(){

        // mandamos llamar todo los datos de specialty
        $specialties = Specialty::all();
        // hacemos una inyección de los datos specialty
        return view('specialties.index', compact('specialties'));
    }

    public function create(){
        return view('specialties.create');
    }

    // función para vailar formulario. Se creo por que se repetia codigo y con esto ya solo mandamos llamar la función donde queramos hacer validación de formulario.
    private function performValidation(Request $request){

        $rules = [
            'name' => 'required|min:3'
        ];
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre.',
            'name.min' => 'Como mínimo el nombre debe tener 3 caracteres'
        ]; 
 
        $this->validate($request, $rules, $messages);
    }

    public function store(Request $request){

        //dd($request->all());

        $this->performValidation($request);

        $specialty = new Specialty();
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save(); // INSERT

        $notification = 'La especialidad se ha registrdo correctamente';
        return redirect('/specialties')->with(compact('notification'));
    }

    public function edit(Specialty $specialty){
        
        return view('specialties.edit', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty){
        //dd($request->all());
 
        $this->performValidation($request);
 
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save(); // UPDATE
 
        $notification = 'La especialidad se ha actualizado correctamente';
        return redirect('/specialties')->with(compact('notification'));
    }

    public function destroy(Specialty $specialty){

        $deletedSpecialty = $specialty->name;
        $specialty->delete();

        $notification = 'La especialidad '. $deletedSpecialty .' se ha eliminado correctamente';
        return redirect('/specialties')->with(compact('notification'));

    }
}
