<?php

namespace App\HumanResources\Attendance\Application;
use App\HumanResources\Attendance\Domain\Attendance;


class AttendanceService
{
    public function storeAttendance(array $data)
    {

    Attendance::create($data);
    }
    public static function groupByOwnersService($files)
    {
        $groupedData = [];

        foreach ($files as $file => $owner) {
            if (!isset($groupedData[$owner])) {
                $groupedData[$owner] = [];
            }

            $groupedData[$owner][] = $file;
        }

        return $groupedData;
    }
}

