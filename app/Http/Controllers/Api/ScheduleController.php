<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\ScheduleServiceInterface;
use App\Services\ScheduleService;

use App\WorkDay;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    // como funciona la interfaz y el provider un ejemplo es el request
    // en ningun momento tenemos que hacer instancia de la clase request o crear un objeto de la clase request, esto se conoce como inyeccion de depentencias
    // así como funciona para request ahora asi también funciona para nuestro servicio,
    // solo agregamos el use App/Interface/ScheculeServiceInterface y el use App/Service/ScheduleService
    // y así podemos hacer uso de la interfaze que solo declara la variavle y uso del service que le da funcionalidad a la variable de clarada en interface
    // y apartir de $scheduleService ya podemos a cceder a la clase ScheduleSerice y a sus metodos.
    public function hours(Request $request, ScheduleServiceInterface $scheduleService){

        $rules = [
            'date' => 'required|date_format:"Y-m-d"',
            'doctor_id' => 'required|exists:users,id'
        ];

        $this->validate($request, $rules);

        $date = $request->input('date');
        $doctorId = $request->input('doctor_id');

                // ejemplo aquí ya podemos acceder al metodo de la clase ScheduleService
                // ahora el controlador se encuentra más simple, porque la logica de obtener el horario de un médico 
                // se ha trasladado a un servicio.
        return $scheduleService->getAvailableIntervals($date, $doctorId);
    }

}
