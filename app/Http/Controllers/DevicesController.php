<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DevicesController extends Controller
{
    /**
     * Tampilkan daftar device dengan pagination.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10); // Default 10 item per halaman

        $devices = Device::with(['userResponsible', 'userDevice'])->paginate($limit);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => collect($devices->items())->map(function ($device) {
                return [
                    'id' => $device->id,
                    'device_name' => $device->device_name,
                    'brand_and_type' => $device->brand_and_type,
                    'serial_number' => $device->serial_number,
                    'device_type' => $device->device_type,
                    'ip_address' => $device->ip_address,
                    'tag_name' => $device->tag_name,
                    'location' => $device->location,
                    'contract_id' => $device->contract_id,
                    'installation_year' => $device->installation_year,
                    'description' => $device->description,
                    'user_responsible' => $device->userResponsible ? [
                        'id' => $device->userResponsible->id,
                        'name' => $device->userResponsible->name,
                        'position' => $device->userResponsible->position,
                    ] : null,
                    'user_device' => $device->userDevice ? [
                        'id' => $device->userDevice->id,
                        'name' => $device->userDevice->name,
                        'position' => $device->userDevice->position,
                    ] : null,
                    'condition' => $device->condition,
                    'created_at' => $device->created_at,
                    'updated_at' => $device->updated_at,
                ];
            }),
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
        try {
            $validated = $request->validate([
                'device_name' => 'required|string|max:255',
                'brand_and_type' => 'required|string|max:255',
                'serial_number' => 'required|string|max:255|unique:devices',
                'device_type' => 'required|string|max:255',
                'ip_address' => 'sometimes|nullable|ip',
                'tag_name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'contract_id' => 'sometimes|nullable|exists:contracts,id',
                'installation_year' => 'required|digits:4',
                'description' => 'nullable|string',
                'user_responsible' => 'required|exists:employees,id',  // Ambil dari employees
                'user_device' => 'required|exists:employees,id',       // Ambil dari employees
                'condition' => 'required|string|max:255',
            ]);

            Log::info('Data sebelum insert:', $validated);

            $device = Device::create($validated);

            Log::info('Data berhasil disimpan:', $device->toArray());

            return response()->json([
                'status' => 201,
                'message' => 'Device created successfully',
                'data' => $device
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('Error saat insert device: ' . $e->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
