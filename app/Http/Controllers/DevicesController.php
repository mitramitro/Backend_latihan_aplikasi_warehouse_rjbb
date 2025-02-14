<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DevicesController extends Controller
{
    /**
     * Tampilkan daftar device dengan pagination.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10); // Default 10 item per halaman
        $devices = Device::paginate($limit);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $devices->items(),
            'pagination' => [
                'currentPage' => $devices->currentPage(),
                'totalPages' => $devices->lastPage(),
                'totalItems' => $devices->total(),
                'itemsPerPage' => $devices->perPage(),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Simpan device baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_name' => 'required|string|max:255',
            'brand_and_type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:devices',
            'device_type' => 'required|string|max:255',
            'ip_address' => 'required|ip',
            'tag_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contract_id' => 'required|exists:contracts,id',
            'installation_year' => 'required|digits:4',
            'description' => 'nullable|string',
            'user_responsible' => 'required|string|max:255',
            'user_device' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
        ]);

        $device = Device::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Device created successfully',
            'data' => $device
        ], Response::HTTP_CREATED);
    }

    /**
     * Tampilkan detail satu device.
     */
    public function show($id)
    {
        $device = Device::find($id);

        if (!$device) {
            return response()->json([
                'status' => 404,
                'message' => 'Device not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $device
        ], Response::HTTP_OK);
    }

    /**
     * Update data device berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $device = Device::find($id);

        if (!$device) {
            return response()->json([
                'status' => 404,
                'message' => 'Device not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'device_name' => 'sometimes|string|max:255',
            'brand_and_type' => 'sometimes|string|max:255',
            'serial_number' => 'sometimes|string|max:255|unique:devices,serial_number,' . $device->id,
            'device_type' => 'sometimes|string|max:255',
            'ip_address' => 'sometimes|ip',
            'tag_name' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'contract_id' => 'sometimes|exists:contracts,id',
            'installation_year' => 'sometimes|digits:4',
            'description' => 'nullable|string',
            'user_responsible' => 'sometimes|string|max:255',
            'user_device' => 'sometimes|string|max:255',
            'condition' => 'sometimes|string|max:255',
        ]);

        $device->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Device updated successfully',
            'data' => $device
        ], Response::HTTP_OK);
    }

    /**
     * Hapus device berdasarkan ID.
     */
    public function destroy($id)
    {
        $device = Device::find($id);

        if (!$device) {
            return response()->json([
                'status' => 404,
                'message' => 'Device not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $device->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Device deleted successfully'
        ], Response::HTTP_OK);
    }
}
