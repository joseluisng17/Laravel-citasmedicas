<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancelledAppointment extends Model
{
    public function cancelled_by() 
    {
        // Cancellation N - 1 User  belongsTo
        return $this->belongsTo(User::class);
    }
}
