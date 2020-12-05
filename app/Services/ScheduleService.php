<?php namespace App\Services;

use App\WorkDay;
use App\Interfaces\ScheduleServiceInterface;
use Carbon\Carbon;
use App\Appointment;

class ScheduleService implements ScheduleServiceInterface{

    public function isAvailableInterval($date, $doctorId, Carbon $start){
        $exists = Appointment::where('doctor_id', $doctorId)
            ->where('scheduled_date', $date)
            ->where('scheduled_time', $start->format('H:i:s'))
            ->exists();

        return !$exists; // available if already none exists
    }

    private function getDayFromDate($date){

        $dateCarbon = new Carbon($date);
        // dayofWeek
        // Como Carbon lo acomoda:  0 = (sunday)  -  6 = (saturday)
        // como lo tenemos en nuestra base de datos WorkDay: 0 = (monday)  -  6 = (sunday)
        // Para adaptar Carbon a como lo tenemos en nuestra base de datos hacemos la siguiente logica
        $i = $dateCarbon->dayOfWeek;
        $day = ($i==0 ? 6 : $i-1);
        return $day;

    }

    public function getAvailableIntervals($date, $doctorId){

        $workDay = WorkDay::where('active', true)
        ->where('day', $this->getDayFromDate($date))
        ->where('user_id', $doctorId)
        ->first([
            'morning_start', 'morning_end',
            'afternoon_start', 'afternoon_end'
        ]);

        if (!$workDay){
            return [];
        }

        $morningIntervals = $this->getIntervals($workDay->morning_start, $workDay->morning_end, $date, $doctorId);

        $afternoonIntervals = $this->getIntervals($workDay->afternoon_start, $workDay->afternoon_end, $date, $doctorId);

        $data = [];
        $data['morning'] = $morningIntervals;
        $data['afternoon'] = $afternoonIntervals;

        return $data;
    }

    private function getIntervals($start, $end, $date, $doctorId){
        $start = new Carbon($start);
        $end = new Carbon($end);

        $intervals = [];

        while($start < $end){
            $interval = [];

           
            $interval['start'] = $start->format('g:i A');

            // cuando esta disponible un intervalo, o una cita
            $available = $this->isAvailableInterval($date, $doctorId, $start);

            $start->addMinutes(30);
            $interval['end'] = $start->format('g:i A');

            // si esta disponible el intervalo o la cita se agrega al arreglo.
            if($available){
                $intervals [] = $interval;
            }

        }

        return $intervals;
    }

}