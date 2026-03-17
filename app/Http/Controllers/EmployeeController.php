<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     */
    public function index()
    {
        $divisions = Division::all();
        return view('employees.index', compact('divisions'));
    }

    /**
     * DataTables AJAX handler.
     */
    public function list(Request $request)
    {
        $query = Employee::with(['position.division']);

        if ($request->has('division_id') && $request->division_id != '') {
            $query->whereHas('position', function($q) use ($request) {
                $q->where('division_id', $request->division_id);
            });
        }

        if ($request->has('position_id') && $request->position_id != '') {
            $query->where('position_id', $request->position_id);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                return '
                    <div class="flex gap-2 justify-center">
                        <button onclick="editEmployee('.$row->id.')" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded text-xs transition shadow-sm">Edit</button>
                        <button onclick="deleteEmployee('.$row->id.')" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-1 rounded text-xs transition shadow-sm">Hapus</button>
                    </div>
                ';
            })
            ->editColumn('salary', function($row){
                return 'Rp ' . number_format($row->salary, 0, ',', '.');
            })
            ->addColumn('profile_picture_url', function($row){
                return $row->profile_picture ? asset('storage/' . $row->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($row->name) . '&color=7F9CF5&background=EBF4FF';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Get employee details for editing.
     */
    public function show(Employee $employee)
    {
        return response()->json($employee->load('position'));
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|unique:employees,nip',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'position_id' => 'required|exists:positions,id',
            'salary' => 'required|numeric',
            'join_date' => 'required|date',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('employees', 'public');
        }

        Employee::create($validated);

        return response()->json(['message' => 'Pegawai berhasil ditambahkan!']);
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|unique:employees,nip,' . $employee->id,
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'position_id' => 'required|exists:positions,id',
            'salary' => 'required|numeric',
            'join_date' => 'required|date',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($employee->profile_picture) {
                Storage::disk('public')->delete($employee->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('employees', 'public');
        }

        $employee->update($validated);

        return response()->json(['message' => 'Data pegawai berhasil diperbarui!']);
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(Employee $employee)
    {
        if ($employee->profile_picture) {
            Storage::disk('public')->delete($employee->profile_picture);
        }
        $employee->delete();
        return response()->json(['message' => 'Pegawai berhasil dihapus!']);
    }

    /**
     * Get positions by division.
     */
    public function getPositions(Division $division)
    {
        return response()->json($division->positions);
    }

    /**
     * Get all divisions.
     */
    public function listDivisions()
    {
        return response()->json(Division::all());
    }
}
