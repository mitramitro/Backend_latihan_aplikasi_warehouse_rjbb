<?php

namespace App\Http\Controllers;

use App\Models\DeviceGroup;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeviceGroupController extends Controller
{
    /**
     * Tampilkan daftar device group dengan pagination.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10); // Default 10 item per halaman
        $deviceGroups = DeviceGroup::paginate($limit);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $deviceGroups->items(),
            'pagination' => [
                'currentPage' => $deviceGroups->currentPage(),
                'totalPages' => $deviceGroups->lastPage(),
                'totalItems' => $deviceGroups->total(),
                'itemsPerPage' => $deviceGroups->perPage(),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Simpan device group baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_group_name' => 'required|string|max:100',
            'device_type' => 'required|string|max:50'
        ]);

        $deviceGroup = DeviceGroup::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Device group created successfully',
            'data' => $deviceGroup
        ], Response::HTTP_CREATED);
    }

    /**
     * Tampilkan detail satu device group.
     */
    public function show($id)
    {
        $deviceGroup = DeviceGroup::find($id);

        if (!$deviceGroup) {
            return response()->json([
                'status' => 404,
                'message' => 'Device group not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $deviceGroup
        ], Response::HTTP_OK);
    }

    /**
     * Update data device group berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $deviceGroup = DeviceGroup::find($id);

        if (!$deviceGroup) {
            return response()->json([
                'status' => 404,
                'message' => 'Device group not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'device_group_name' => 'sometimes|string|max:100',
            'device_type' => 'sometimes|string|max:50'
        ]);

        $deviceGroup->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Device group updated successfully',
            'data' => $deviceGroup
        ], Response::HTTP_OK);
    }

    /**
     * Hapus device group berdasarkan ID.
     */
    public function destroy($id)
    {
        $deviceGroup = DeviceGroup::find($id);

        if (!$deviceGroup) {
            return response()->json([
                'status' => 404,
                'message' => 'Device group not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $deviceGroup->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Device group deleted successfully'
        ], Response::HTTP_OK);
    }

    public function uniqueDeviceGroups()
    {

    $devices = DeviceGroup::select('id', 'device_group_name')->distinct()->get();

    return response()->json([
        "status" => 200,
        "message" => "Success",
        "data" => $devices
    ], Response::HTTP_OK);
    }

    //Jika ingin menggunakan query string /api/device_groups/types?device_group_name=CCTV
    public function getDeviceTypesByDeviceGroupName(Request $request)
    {
        $request->validate([
            'device_group_name' => 'required|string'
        ]);

        $deviceTypes = DeviceGroup::where('device_group_name', $request->device_group_name)
            ->pluck('device_type');

        return response()->json([
            "status" => 200,
            "message" => "Success",
            "data" => $deviceTypes
        ], Response::HTTP_OK);
    }
    //Jika ingin menggunakan route dengan parameter path di url /api/device_groups/types/CCTV
    //     public function getDeviceTypesByGroup($device_group_name)
    // {
    //     $deviceTypes = DeviceGroup::where('device_group_name', $device_group_name)
    //         ->pluck('device_type');

    //     if ($deviceTypes->isEmpty()) {
    //         return response()->json([
    //             "status" => 404,
    //             "message" => "Device types not found for the given group",
    //             "data" => []
    //         ], Response::HTTP_NOT_FOUND);
    //     }

    //     return response()->json([
    //         "status" => 200,
    //         "message" => "Success",
    //         "data" => $deviceTypes
    //     ], Response::HTTP_OK);
    // }
}
