<?php

namespace App\Http\Controllers;

use App\Models\ManageDevice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ManageDeviceController extends Controller
{
    /**
     * Tampilkan daftar perangkat yang dikelola dengan pagination.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10); // Default 10 item per halaman
        $manageDevices = ManageDevice::paginate($limit);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $manageDevices->items(),
            'pagination' => [
                'currentPage' => $manageDevices->currentPage(),
                'totalPages' => $manageDevices->lastPage(),
                'totalItems' => $manageDevices->total(),
                'itemsPerPage' => $manageDevices->perPage(),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Simpan perangkat yang dikelola ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'device_id' => 'required|exists:devices,id',
            'condition' => 'required|string|max:100',
            'date' => 'required|date'
        ]);

        $manageDevice = ManageDevice::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Managed device created successfully',
            'data' => $manageDevice
        ], Response::HTTP_CREATED);
    }

    /**
     * Tampilkan detail satu perangkat yang dikelola.
     */
    public function show($id)
    {
        $manageDevice = ManageDevice::find($id);

        if (!$manageDevice) {
            return response()->json([
                'status' => 404,
                'message' => 'Managed device not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $manageDevice
        ], Response::HTTP_OK);
    }

    /**
     * Update data perangkat yang dikelola berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $manageDevice = ManageDevice::find($id);

        if (!$manageDevice) {
            return response()->json([
                'status' => 404,
                'message' => 'Managed device not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'device_id' => 'sometimes|exists:devices,id',
            'condition' => 'sometimes|string|max:100',
            'date' => 'sometimes|date'
        ]);

        $manageDevice->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Managed device updated successfully',
            'data' => $manageDevice
        ], Response::HTTP_OK);
    }

    /**
     * Hapus perangkat yang dikelola berdasarkan ID.
     */
    public function destroy($id)
    {
        $manageDevice = ManageDevice::find($id);

        if (!$manageDevice) {
            return response()->json([
                'status' => 404,
                'message' => 'Managed device not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $manageDevice->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Managed device deleted successfully'
        ], Response::HTTP_OK);
    }
}
