<?php

namespace App\HumanResources\Attendance\Domain;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $appends = [
        'total_working_hours'
    ];

    public function getTotalWorkHoursAttribute()
    {
        $totalHours = 0;


        $checkIn = Carbon::parse($this->check_in);
        $checkOut = Carbon::parse($this->check_out);


        $workingHours = $checkOut->diffInHours($checkIn);


        $totalHours += $workingHours;


        return $totalHours;
    }
}