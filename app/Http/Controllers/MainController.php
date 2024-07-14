<?php

namespace App\Http\Controllers;

use App\Models\hrc_employee_assignments;
use App\Models\hrc_employees;
use App\Models\pr_employee_payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function GetData()
    {
        $user_1 = hrc_employees::first();
        //  dd($user_1->assignments);
        $user = hrc_employees::with('assignments')->first();
        $payroll = pr_employee_payroll::first();
        //dd($payroll);
        // dd($user_1->assignments->first()->assignment_name);
        return view('EmployeeData');
    }

    public function Employeesdatatable(Request $request)
    {
        DB::connection()->enableQueryLog();

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'];
        $filter_date = $request->date;
        //dd($filter_date);


        $query = hrc_employees::query();

        if ($searchValue) {
            $query = $query->where('name', 'LIKE', '%' . $searchValue . '%');
        }
        $columns = ['name', 'person_number', 'HIRE_DATE', 'TerminationDate', 'Count', 'assignment_name', 'assignment_status', 'start_effective_date', 'end_effective_date', 'payrolls_name', 'payroll_start_effective_date', 'payroll_end_effective_date'];
        $orderColumn = $columns[$request->input('order')[0]['column']];
        $orderDirection = $request->input('order')[0]['dir'];

        // Debugging: Uncomment to inspect the orderColumn
        // dd($orderColumn);

        if (in_array($orderColumn, ['assignment_name', 'assignment_status', 'start_effective_date', 'end_effective_date'])) {
            $query->leftJoin('hrc_employee_assignments', 'hrc_employees.person_id', '=', 'hrc_employee_assignments.person_id')
                ->orderBy('hrc_employee_assignments.' . $orderColumn, $orderDirection);
        } else {
            $query->orderBy('hrc_employees.' . $orderColumn, $orderDirection);
        }
        //dd($filter_date);
        if ($filter_date != null) {
            $query = $query->where('HIRE_DATE', 'LIKE', '%' . $filter_date . '%');
        }
        $totalRecords = $query->count();
        if ($start > 0) {
            $query->skip($start);
        }
        // $employees = $query->with(['assignments', 'EmployeePayroll.payrollsDetails'])
        //->join("")
        //where("")
        // ->select("",'','','hrc_employees.id')
        //     ->take($length)
        //    ->get();
        $employees = $query->with(['assignments', 'EmployeePayroll.payrollsDetails'])->take($length)->get();

        $data_arr = [];
        foreach ($employees as $item) {
            $payroll = $item->EmployeePayroll;

            if ($item->assignments->isNotEmpty()) {
                foreach ($item->assignments as $assignment) {
                    $data_arr[] = [
                        $item->name ?? '',
                        $item->person_number ?? '',
                        $item->HIRE_DATE ?? '',
                        $item->TerminationDate ?? '',
                        $item->assignments->count() ?? '',
                        $assignment->assignment_name ?? '',
                        $assignment->assignment_status ?? '',
                        $assignment->start_effective_date ?? '',
                        $assignment->end_effective_date ?? '',
                        $payroll ? $payroll->payrollsDetails->name : 'Not Assigned',
                        $payroll ? $payroll->start_effective_date : '',
                        $payroll ? $payroll->end_effective_date : '',
                    ];
                }
            } else {
                $data_arr[] = [
                    $item->name ?? '',
                    $item->person_number ?? '',
                    $item->HIRE_DATE ?? '',
                    $item->TerminationDate ?? '',
                    '', // Count
                    '', // Assignment Name
                    '', // Assignment Status
                    '', // Start Effective Date
                    '', // End Effective Date
                    $payroll ? $payroll->payrollsDetails->name : 'Not Assigned',
                    $payroll ? $payroll->start_effective_date : '',
                    $payroll ? $payroll->end_effective_date : '',
                ];
            }
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data_arr,
        ];
        $queries = DB::getQueryLog();
        //    dd($queries);

        return response()->json($response);
    }
}