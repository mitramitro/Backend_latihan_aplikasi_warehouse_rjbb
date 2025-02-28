<?php

namespace App\Http\Controllers;

use App\Models\ReportDevice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportDeviceController extends Controller
{
    /**
     * Tampilkan daftar perangkat dalam laporan dengan pagination.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $report_id = $request->query('report_id');

        // Jika ada report_id, filter berdasarkan report tersebut
        if ($report_id) {
            $reportDevices = ReportDevice::where('report_id', $report_id)->paginate($limit);
        } else {
            $reportDevices = ReportDevice::paginate($limit);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $reportDevices->map(function ($device) {
                return [
                    'report_id' => $device->report_id,
                    'nama_perangkat' => $device->nama_perangkat,
                    'tipe_perangkat' => $device->tipe_perangkat,
                    'kondisi_baik' => $device->kondisi_baik,
                    'kondisi_rusak' => $device->kondisi_rusak,
                    'status_sewa' => $device->status_sewa,
                    'status_aset' => $device->status_aset,
                    'keterangan' => $device->keterangan
                ];
            }),
            'pagination' => [
                'currentPage' => $reportDevices->currentPage(),
                'totalPages' => $reportDevices->lastPage(),
                'totalItems' => $reportDevices->total(),
                'itemsPerPage' => $reportDevices->perPage(),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Tampilkan detail satu laporan summary berdasarkan report_id.
     */
    public function show($report_id)
    {
        $reportDevice = ReportDevice::where('report_id', $report_id)->first();

        if (!$reportDevice) {
            return response()->json([
                'status' => 404,
                'message' => 'Report summary not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => [
                'report_id' => $reportDevice->report_id,
                'nama_perangkat' => $reportDevice->nama_perangkat,
                'tipe_perangkat' => $reportDevice->tipe_perangkat,
                'kondisi_baik' => $reportDevice->kondisi_baik,
                'kondisi_rusak' => $reportDevice->kondisi_rusak,
                'status_sewa' => $reportDevice->status_sewa,
                'status_aset' => $reportDevice->status_aset,
                'keterangan' => $reportDevice->keterangan
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Simpan perangkat baru ke dalam laporan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_id' => 'required|exists:reports,id',
            'nama_perangkat' => 'required|string|max:100',
            'tipe_perangkat' => 'required|string|max:100',
            'kondisi_baik' => 'required|integer|min:0',
            'kondisi_rusak' => 'required|integer|min:0',
            'status_sewa' => 'required|integer|min:0',  // Diperbaiki jadi integer
            'status_aset' => 'required|integer|min:0',  // Diperbaiki jadi integer
            'keterangan' => 'nullable|string|max:255'
        ]);

        $device = ReportDevice::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Report device created successfully',
            'data' => $device
        ], Response::HTTP_CREATED);
    }

    /**
     * Tampilkan detail satu perangkat dalam laporan.
     */


    /**
     * Update data perangkat dalam laporan berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $device = ReportDevice::find($id);

        if (!$device) {
            return response()->json([
                'status' => 404,
                'message' => 'Report device not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'nama_perangkat' => 'sometimes|string|max:100',
            'tipe_perangkat' => 'sometimes|string|max:100',
            'kondisi_baik' => 'sometimes|integer|min:0',
            'kondisi_rusak' => 'sometimes|integer|min:0',
            'status_sewa' => 'sometimes|integer|min:0',  // Diperbaiki jadi integer
            'status_aset' => 'sometimes|integer|min:0',  // Diperbaiki jadi integer
            'keterangan' => 'sometimes|string|max:255'
        ]);

        $device->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Report device updated successfully',
            'data' => $device
        ], Response::HTTP_OK);
    }

    /**
     * Hapus perangkat dari laporan berdasarkan ID.
     */
    public function destroy($id)
    {
        $device = ReportDevice::find($id);

        if (!$device) {
            return response()->json([
                'status' => 404,
                'message' => 'Report device not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $device->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Report device deleted successfully'
        ], Response::HTTP_OK);
    }
}
