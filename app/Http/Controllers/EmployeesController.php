<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeesController extends Controller
{
    /**
     * Tampilkan daftar karyawan dengan pagination.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10); // Default 10 item per halaman
        $employees = Employee::paginate($limit);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $employees->items(),
            'pagination' => [
                'currentPage' => $employees->currentPage(),
                'totalPages' => $employees->lastPage(),
                'totalItems' => $employees->total(),
                'itemsPerPage' => $employees->perPage(),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Simpan karyawan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'name' => 'required|string|max:100',
            'employee_number' => 'required|string|unique:employees',
            'position' => 'required|string|max:100',
            'fungsi' => 'required|string|max:100'
        ]);

        $employee = Employee::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Employee created successfully',
            'data' => $employee
        ], Response::HTTP_CREATED);
    }

    /**
     * Tampilkan detail satu karyawan.
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'status' => 404,
                'message' => 'Employee not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $employee
        ], Response::HTTP_OK);
    }

    /**
     * Update data karyawan berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'status' => 404,
                'message' => 'Employee not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'site_id' => 'sometimes|exists:sites,id',
            'name' => 'sometimes|string|max:100',
            'employee_number' => 'sometimes|string|unique:employees,employee_number,' . $id,
            'position' => 'sometimes|string|max:100',
            'fungsi' => 'sometimes|string|max:100'
        ]);

        $employee->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Employee updated successfully',
            'data' => $employee
        ], Response::HTTP_OK);
    }

    /**
     * Hapus karyawan berdasarkan ID.
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'status' => 404,
                'message' => 'Employee not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $employee->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Employee deleted successfully'
        ], Response::HTTP_OK);
    }
}
