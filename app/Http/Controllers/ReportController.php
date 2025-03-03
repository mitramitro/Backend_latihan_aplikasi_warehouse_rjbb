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
                'site' => 'required|string',
                'manager_name' => 'required|string',
                'ict_name' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Simpan laporan baru
            $report = Report::create($request->all());

            // Panggil fungsi generate summary berdasarkan site
            $summaryData = $this->generateReportSummary($report);

            return response()->json([
                'success' => true,
                'message' => 'Report created successfully',
                'data' => $report,
                'summary' => $summaryData
            ], 201);
        } catch (\Exception $e) {
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

    /**
     * Update laporan.
     */
    public function update(Request $request, $id)
    {
        try {
            $report = Report::find($id);
            if (!$report) {
                return response()->json([
                    'success' => false,
                    'message' => 'Report not found'
                ], 404);
            }

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

    /**
     * Hapus laporan.
     */
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
    private function generateReportSummary(Report $report)
    {
        // Ambil perangkat berdasarkan site dari laporan
        $devices = Device::with('contract')
            ->where('location', $report->site) // Gunakan $report->site, bukan ID
            ->get()
            ->groupBy(['device_type', 'device_name']);
        // dd($devices);
        $summaryData = [];

        foreach ($devices as $type => $deviceGroup) {
            foreach ($deviceGroup as $deviceName => $items) {
                $kondisi_baik = $items->whereIn('condition', ['New', 'Used'])->count();
                $kondisi_rusak = $items->whereIn('condition', ['Damage', 'Repair', 'Unused', 'Dump'])->count();
                $status_sewa = $items->filter(fn($device) => $device->contract && $device->contract->contract_type === 'Kontrak')->count();
                $status_aset = $items->filter(fn($device) => $device->contract && $device->contract->contract_type === 'Non Kontrak')->count();

                $summaryData[] = [
                    'report_id' => $report->id,
                    'device_name' => $deviceName,
                    'device_type' => $type,
                    'status_used_new' => $kondisi_baik,
                    'status_damage' => $kondisi_rusak,
                    'status_rent' => $status_sewa,
                    'status_asset' => $status_aset,
                    'description' => '' // Keterangan dikosongkan
                ];
            }
        }

        // Simpan ke database
        ReportDevice::insert($summaryData);

        return $summaryData;
    }
}
