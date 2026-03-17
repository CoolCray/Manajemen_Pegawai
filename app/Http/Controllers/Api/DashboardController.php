<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Division;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $totalDivisions = Division::count();
        $totalMonthlySalary = Employee::sum('salary');

        $recentEmployees = Employee::with(['position.division'])
            ->orderBy('join_date', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($emp) {
                return [
                    'id' => $emp->id,
                    'name' => $emp->name,
                    'email' => $emp->email,
                    'position' => $emp->position->name ?? 'N/A',
                    'division' => $emp->position->division->name ?? 'N/A',
                    'join_date' => $emp->join_date,
                    'profile_picture_url' => $emp->profile_picture ? asset('storage/' . $emp->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($emp->name) . '&color=7F9CF5&background=EBF4FF'
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_employees' => $totalEmployees,
                'total_divisions' => $totalDivisions,
                'total_salary_monthly' => $totalMonthlySalary,
                'recent_employees' => $recentEmployees
            ]
        ], 200);
    }
}
