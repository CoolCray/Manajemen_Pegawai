<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeesController extends Controller
{
    public function index()
    {
        $data = Employee::with('position.division')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diambil',
            'data' => $data,

        ], 200);
    }
}
