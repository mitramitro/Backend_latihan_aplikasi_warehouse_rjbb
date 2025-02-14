<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitesController extends Controller
{
    /**
     * Tampilkan daftar site dengan pagination.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10); // Default 10 item per halaman
        $sites = Site::paginate($limit);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $sites->items(),
            'pagination' => [
                'currentPage' => $sites->currentPage(),
                'totalPages' => $sites->lastPage(),
                'totalItems' => $sites->total(),
                'itemsPerPage' => $sites->perPage(),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Simpan site baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100'
        ]);

        $site = Site::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Site created successfully',
            'data' => $site
        ], Response::HTTP_CREATED);
    }

    /**
     * Tampilkan detail satu site.
     */
    public function show($id)
    {
        $site = Site::find($id);

        if (!$site) {
            return response()->json([
                'status' => 404,
                'message' => 'Site not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $site
        ], Response::HTTP_OK);
    }

    /**
     * Update data site berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $site = Site::find($id);

        if (!$site) {
            return response()->json([
                'status' => 404,
                'message' => 'Site not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'site_name' => 'sometimes|string|max:100',
            'address' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:100',
            'province' => 'sometimes|string|max:100'
        ]);

        $site->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Site updated successfully',
            'data' => $site
        ], Response::HTTP_OK);
    }

    /**
     * Hapus site berdasarkan ID.
     */
    public function destroy($id)
    {
        $site = Site::find($id);

        if (!$site) {
            return response()->json([
                'status' => 404,
                'message' => 'Site not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $site->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Site deleted successfully'
        ], Response::HTTP_OK);
    }
}
