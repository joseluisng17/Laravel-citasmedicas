<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// hacemos un middleware y metemos un grupo de rutas, el middleware es de autenticación, para no estar metiendo este middleware en cada
// archivo del controlador en su constructor, nos ahorramos lineas de codigo, Nota: hay que darlo de alta en el archivo app/http/Kernel.php
Route::middleware(['auth', 'admin'])->namespace('Admin')->group(function () {
    //Nota: el namespace que esta despues del middleware es para especificar en que carpeta estan los controladores y no estar 
    //agregando el nombre "Admin/SpecialtuController@index" antes de cada controlador.

    // Especiatly
    Route::get('/specialties', 'SpecialtyController@index');
    Route::get('/specialties/create', 'SpecialtyController@create');  // esta peticion devuelve una vista del formulario registro
    Route::get('/specialties/{specialty}/edit', 'SpecialtyController@edit');

    Route::post('/specialties', 'SpecialtyController@store'); // hacer envio formulario de registro
    Route::put('/specialties/{specialty}', 'SpecialtyController@update');
    Route::delete('/specialties/{specialty}', 'SpecialtyController@destroy');

    // Medicos
    Route::resource('doctors', 'DoctorController');

    // Pacientes
    Route::resource('patients', 'PatientController');

    // Charts
    Route::get('/charts/appointments/line', 'ChartController@appointments');
    Route::get('/charts/doctors/column', 'ChartController@doctors');
    Route::get('/charts/doctors/column/data', 'ChartController@doctorsJson');


});

Route::middleware(['auth', 'doctor'])->namespace('Doctor')->group(function () {
    Route::get('/schedule', 'ScheduleController@edit');
    Route::post('/schedule', 'ScheduleController@store');
   

});

Route::middleware('auth')->group(function () {

    Route::get('/appointments/create', 'AppointmentController@create');
    Route::post('/appointments', 'AppointmentController@store');


    Route::get('/appointments', 'AppointmentController@index');
    Route::get('/appointments/{appointment}', 'AppointmentController@show');

    Route::get('/appointments/{appointment}/cancel', 'AppointmentController@showCancelForm');
    Route::post('/appointments/{appointment}/cancel', 'AppointmentController@postCancel');

    Route::post('/appointments/{appointment}/confirm', 'AppointmentController@postConfirm');

    // JSON
    Route::get('/specialties/{specialty}/doctors', 'Api\SpecialtyController@doctors');
    Route::get('/schedule/hours', 'Api\ScheduleController@hours');

});



