<?php

namespace App\HumanResources\Attendance\Application;
use App\HumanResources\Attendance\Domain\Attendance;


class AttendanceService
{
    public function storeAttendance(array $data)
    {

    Attendance::create($data);
    }

}

