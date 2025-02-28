<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportDevice;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Tampilkan daftar laporan dengan pagination.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $reports = Report::paginate($limit);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $reports->items(),
            'pagination' => [
                'currentPage' => $reports->currentPage(),
                'totalPages' => $reports->lastPage(),
                'totalItems' => $reports->total(),
                'itemsPerPage' => $reports->perPage(),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Simpan laporan baru ke database dan buat summary otomatis di ReportDevice.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'report_date' => 'required|date',
                'site' => 'required|string'
            ]);

            // Jika validasi gagal, kembalikan response JSON
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Simpan data jika validasi lolos
            $report = Report::create($request->all());

            // Berikan response sukses
            return response()->json([
                'success' => true,
                'message' => 'Report created successfully',
                'data' => $report
            ], 201);
        } catch (\Exception $e) {
            // Tangkap error lainnya
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan detail satu laporan.
     */
    public function show($id)
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json([
                'status' => 404,
                'message' => 'Report not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $report
        ], Response::HTTP_OK);
    }


    public function update(Request $request, $id)
    {
        try {
            // Cek apakah report ada
            $report = Report::find($id);
            if (!$report) {
                return response()->json([
                    'success' => false,
                    'message' => 'Report not found'
                ], 404);
            }

            // Validasi input
            $validator = Validator::make($request->all(), [
                'report_date' => 'required|date',
                'site' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update report
            $report->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Report updated successfully',
                'data' => $report
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }




    public function destroy($id)
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Report not found'
            ], 404);
        }

        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Report deleted successfully'
        ], 200);
    }




    /**
     * Generate summary perangkat berdasarkan laporan (ReportDevice).
     */
    private function generateReportSummary($reportId)
    {
        $devices = Device::select(
            'device_type',
            'device_name',
            DB::raw("SUM(CASE WHEN condition IN ('New', 'Used') THEN 1 ELSE 0 END) as kondisi_baik"),
            DB::raw("SUM(CASE WHEN condition IN ('Damage', 'Repair', 'Unused', 'Dump') THEN 1 ELSE 0 END) as kondisi_rusak"),
            DB::raw("SUM(CASE WHEN contract_id = 'Kontrak' THEN 1 ELSE 0 END) as status_sewa"),
            DB::raw("SUM(CASE WHEN contract_id = 'Non Kontrak' THEN 1 ELSE 0 END) as status_aset")
        )
            ->groupBy('device_type', 'device_name')
            ->get();

        $summaryData = [];

        foreach ($devices as $device) {
            $summaryData[] = [
                'report_id' => $reportId,
                'nama_perangkat' => $device->device_name,
                'tipe_perangkat' => $device->device_type,
                'kondisi_baik' => $device->kondisi_baik,
                'kondisi_rusak' => $device->kondisi_rusak,
                'status_sewa' => $device->status_sewa,
                'status_aset' => $device->status_aset,
                'keterangan' => $this->getDeviceKeterangan($device->device_name)
            ];
        }

        // Simpan ke database
        ReportDevice::insert($summaryData);

        return $summaryData;
    }

    /**
     * Menentukan keterangan berdasarkan nama perangkat.
     */
    private function getDeviceKeterangan($deviceName)
    {
        $keteranganMapping = [
            'Indoor' => '7 unit Sewa SCU',
            'Outdoor' => 'Sewa SCU',
            'PTZ' => 'Sewa SCU',
            'Radio BS' => 'Sewa Mobilkom',
            'Radio IS' => 'Sewa Mobilkom',
            'Switch' => '1 unit Sewa PSI',
            'Access Point' => 'Sewa PSI',
            'PC Desktop' => 'Sewa Berca',
            'Mini PC' => 'Sewa Berca',
            'Laptop Type 2' => 'Sewa Berca',
            'Laptop Type 3' => 'Sewa Berca',
            'TV' => '3 unit Sewa SCU',
        ];

        return $keteranganMapping[$deviceName] ?? null;
    }
}
