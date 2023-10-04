<?php

namespace App\Http\Controllers;
use App\HumanResources\Attendance\Application\AttendanceService;
use App\HumanResources\Attendance\Domain\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="attendances",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Attendance")
     *             ),
     *             @OA\Property(
     *                 property="total_working_hours",
     *                 type="number",
     *                 format="float",
     *                 description="Total working hours for the specified date range"
     *             )
     *         )
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


        $totalWorkingHours = $this->calculateTotalWorkingHours($attendances);


        return response()->json([
            'attendances' => $attendances,
            'total_working_hours' => $totalWorkingHours,
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


    
    public function index()
    {
        // Implement the logic to display attendance records
    }

    public function store(Request $request)
    {
        // Implement the logic to store attendance records
        $this->attendanceService->storeAttendance($request->all());
    }
}