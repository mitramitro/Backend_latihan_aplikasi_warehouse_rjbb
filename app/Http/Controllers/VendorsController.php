<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VendorsController extends Controller
{
    /**
     * Tampilkan daftar vendor dengan pagination.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10); // Default 10 item per halaman
        $vendors = Vendor::paginate($limit);


        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $vendors->items(),
            'pagination' => [
                'currentPage' => $vendors->currentPage(),
                'totalPages' => $vendors->lastPage(),
                'totalItems' => $vendors->total(),
                'itemsPerPage' => $vendors->perPage(),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Simpan vendor baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendors_code' => 'required|string|max:50|unique:vendors',
            'vendor_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'email' => 'required|email|unique:vendors'
        ]);

        $vendor = Vendor::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Vendor created successfully',
            'data' => $vendor
        ], Response::HTTP_CREATED);
    }

    /**
     * Tampilkan detail satu vendor.
     */
    public function show($id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'status' => 404,
                'message' => 'Vendor not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $vendor
        ], Response::HTTP_OK);
    }

    /**
     * Update data vendor berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'status' => 404,
                'message' => 'Vendor not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'vendors_code' => 'sometimes|string|max:50|unique:vendors,vendors_code,' . $id,
            'vendor_name' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
            'email' => 'sometimes|email|unique:vendors,email,' . $id
        ]);

        $vendor->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Vendor updated successfully',
            'data' => $vendor
        ], Response::HTTP_OK);
    }

    /**
     * Hapus vendor berdasarkan ID.
     */
    public function destroy($id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'status' => 404,
                'message' => 'Vendor not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $vendor->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Vendor deleted successfully'
        ], Response::HTTP_OK);
    }
}
