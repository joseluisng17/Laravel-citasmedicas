<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Specialty;

use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Middleware
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $doctors = User::doctors()->get();
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialties = Specialty::all();
        return view('doctors.create', compact('specialties')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'dni' => 'nullable|digits:8',
            'address' => 'nullable|min:5',
            'phone' => 'nullable|min:6'
        ];

        $this->validate($request, $rules);

        // esto se llama: mass assigment.  Hay que agregar en User en el array fillable
        $user = User::create(
            $request->only('name', 'email', 'dni', 'address', 'phone') 
            + [
                'role' => 'doctor',
                'password' => bcrypt($request->input('password'))
            ]
        );
        // asociamos especialidades al medico, attach se encarga de hacer relaciones segun lo que se le envie en el argumento de attach.
        // por eso dentro de attach enviamos el arreglo de las especialidades para que se guarden en la relación con el médico.
        $user->specialties()->attach($request->input('specialties'));

        $notification = 'El médico se ha registrado correctamente';
        return redirect('/doctors')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor = User::doctors()->findOrFail($id);
        $specialties = Specialty::all();
        // obtener el id de las especialidades con la funcion pluck, como se trata de una realción de muchis a muchos y hay que pasar
        // por una tabla intermedia hay que especificar que id se quiere de que tabla en este caso decimos que de la tabla specialties
        // queremos el id de esa tabla. por eso se pone specialties.id
        $specialty_ids = $doctor->specialties()->pluck('specialties.id');
        return view('doctors.edit', compact('doctor', 'specialties', 'specialty_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'dni' => 'nullable|digits:8',
            'address' => 'nullable|min:5',
            'phone' => 'nullable|min:6'
        ];

        $this->validate($request, $rules);

        $user = User::doctors()->findOrFail($id);

        $data = $request->only('name', 'email', 'dni', 'address', 'phone');
        $password = $request->input('password');
        if($password)
            $data['password'] = bcrypt($password);
        
        $user->fill($data);
        $user->save(); // llamar save para que se produsca el update

        // antes al registrar se uso attach pero en este caso no combiene porque se estarian agregando más relaciones y estariamos
        // añadiendo más registros a la tabla intermedia, en este caso como queremos actualizar y como no sabes cuales ya tiene y
        // cuales no tiene combiene usar sync, para que laravel se encarge de srinconizar las especialidades del usuario.
        $user->specialties()->sync($request->input('specialties'));

        $notification = 'La información del médico se ha actualizado correctamente.';
        return redirect('/doctors')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $doctor)
    {
        $doctorName = $doctor->name;
        $doctor->delete();
        
        $notification = "El médico $doctorName se ha eliminado correctamente.";
        return redirect('/doctors')->with(compact('notification'));
    }
}
