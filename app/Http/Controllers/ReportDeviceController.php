<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportDevice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportDeviceController extends Controller
{
    /**
     * Tampilkan daftar perangkat berdasarkan report_id, serta informasi laporan terkait.
     */
    public function showByReport($reportId)
    {
        // Cek apakah laporan dengan report_id ada
        $report = Report::find($reportId);
        if (!$report) {
            return response()->json([
                'status' => 404,
                'message' => 'Report not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Ambil daftar perangkat dalam laporan berdasarkan report_id
        $reportDevices = ReportDevice::where('report_id', $reportId)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'report' => [
                'site' => $report->site,
                'manager_name' => $report->manager_name,
                'ict_name' => $report->ict_name,
                'report_date' => $report->report_date,
            ],
            'devices' => $reportDevices
        ], Response::HTTP_OK);
    }
}
