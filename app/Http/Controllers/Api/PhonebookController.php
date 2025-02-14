<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Phonebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhonebookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Ambil semua data phonebook
            $data = Phonebook::all();

            return response()->json([
                'success' => true,
                'message' => 'Data retrieved successfully',
                'data'    => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'notelepon' => 'required|string|max:15|unique:phonebooks',
            'alamat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            // Simpan data baru
            $phonebook = Phonebook::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data created successfully',
                'data'    => $phonebook,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create data',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Cari data berdasarkan ID
            $phonebook = Phonebook::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Data retrieved successfully',
                'data'    => $phonebook,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'error'   => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'notelepon' => 'required|string|max:15|unique:phonebooks,phone,' . $id,
            'alamat' => 'nullable|string', // Validasi untuk alamat
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            // Cari data dan update
            $phonebook = Phonebook::findOrFail($id);
            $phonebook->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data updated successfully',
                'data'    => $phonebook,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update data',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Cari data dan hapus
            $phonebook = Phonebook::findOrFail($id);
            $phonebook->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data deleted successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete data',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }
}
