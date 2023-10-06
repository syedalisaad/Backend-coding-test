<?php

namespace App\Http\Controllers;

use App\HumanResources\Attendance\Application\AttendanceService;
use App\HumanResources\Attendance\Domain\Attendance;
use App\Imports\AttendanceImport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Get attendance information for an employee including total working hours.
     *
     * @OA\Get(
     *     path="/employee/attendance/{employee_id}",
     *     operationId="getAttendanceInformation",
     *     tags={"Attendance"},
     *     summary="Get attendance information for an employee",
     *     summary="Get attendance information for an employee",
     *     @OA\Parameter(
     *         name="employee_id",
     *         in="path",
     *         required=true,
     *         description="Employee ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         required=true,
     *         description="Start date (YYYY-MM-DD)",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         required=true,
     *         description="End date (YYYY-MM-DD)",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Employee not found"
     *     )
     * )
     */
    public function AttendanceInformation(Request $request, $employee_id)
    {
        // Retrieve attendance records for the employee
        $attendances = Attendance::where('employee_id', $employee_id)
            ->whereDate('check_in', '>=', $request->start_date)
            ->whereDate('check_out', '<=', $request->end_date)
            ->get();




        return response()->json([
            $attendances
        ]);
    }

    private function calculateTotalWorkingHours($attendances)
    {
        $totalHours = 0;

        foreach ($attendances as $attendance) {
            $checkIn = Carbon::parse($attendance->check_in);
            $checkOut = Carbon::parse($attendance->check_out);


            $workingHours = $checkOut->diffInHours($checkIn);


            $totalHours += $workingHours;
        }

        return $totalHours;
    }

     /**
     * @OA\Get(
     *     path="/attendance",
     *     summary="Get a list of all attendance records",
     *     tags={"Attendance"},
     *     operationId="index",

     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     *
     * Display a listing of the attendance records.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $attendances = Attendance::all();
        return response()->json($attendances, 200);
    }
 /**
     * @OA\Post(
     *     path="/api/attendance",
     *     summary="Import attendance data from an Excel file",
     *     tags={"Attendance"},
     *     operationId="store",
     *     @OA\RequestBody(
     *         description="Excel file to import",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="file",
     *                     type="file",
     *                     description="The Excel file to import",
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attendance data imported successfully",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     ),
     * )
     *
     * Import attendance data from an Excel file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx',
        ]);
        // Process the uploaded file
        $file = $request->file('file');
        Excel::import(new AttendanceImport, $file);

        $this->attendanceService->storeAttendance($request->all());
        // Use Laravel Excel to import data from the file using the AttendanceImport class


        // Return a response indicating success
        return response()->json(['message' => 'Attendance data imported successfully']);
    }

}