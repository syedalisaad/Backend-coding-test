<?php

namespace App\Imports;

use App\HumanResources\Attendance\Domain\Attendance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class AttendanceImport implements ToModel, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // Assuming the Excel columns are in the following order: employee_id, name, check_in, check_out
        return new Attendance([
            'employee_id' => $row[0],
            'name' => $row[1],
            'check_in' => $row[2],
            'check_out' => $row[3],
        ]);
    }

    public function rules(): array
    {
        return [
            '0' => 'required|exists:employees,id', // Check if employee_id exists in the employees table
            '1' => 'required|in:P,A,L', // Check if name is one of 'P', 'A', 'L'
            '2' => 'nullable|date_format:Y-m-d H:i:s', // Check if check_in is a valid timestamp
            '3' => 'nullable|date_format:Y-m-d H:i:s', // Check if check_out is a valid timestamp
        ];
    }
}
