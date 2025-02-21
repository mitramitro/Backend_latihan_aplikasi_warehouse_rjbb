<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContractsController extends Controller
{
    /**
     * Tampilkan daftar kontrak dengan pagination.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10); // Default 10 item per halaman
        $contracts = Contract::paginate($limit);


        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $contracts->items(),
            'pagination' => [
                'currentPage' => $contracts->currentPage(),
                'totalPages' => $contracts->lastPage(),
                'totalItems' => $contracts->total(),
                'itemsPerPage' => $contracts->perPage(),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Simpan kontrak baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'status_contract' => 'required|string|max:50',
            'contract_type' => 'required|string|max:100',
            'contract_number' => 'required|string|unique:contracts',
            'invoice' => 'required|string|max:50'
        ]);

        $contract = Contract::create($validated);

        return response()->json([
            'status' => 201,
            'message' => 'Contract created successfully',
            'data' => $contract
        ], Response::HTTP_CREATED);
    }

    /**
     * Tampilkan detail satu kontrak.
     */
    public function show($id)
    {
        $contract = Contract::find($id);

        if (!$contract) {
            return response()->json([
                'status' => 404,
                'message' => 'Contract not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $contract
        ], Response::HTTP_OK);
    }

    /**
     * Update data kontrak berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $contract = Contract::find($id);

        if (!$contract) {
            return response()->json([
                'status' => 404,
                'message' => 'Contract not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'vendor_id' => 'sometimes|exists:vendors,id',
            'status_contract' => 'sometimes|string|max:50',
            'contract_type' => 'sometimes|string|max:100',
            'contract_number' => 'sometimes|string|unique:contracts,contract_number,' . $id,
            'invoice' => 'sometimes|string|max:50'
        ]);

        $contract->update($validated);

        return response()->json([
            'status' => 200,
            'message' => 'Contract updated successfully',
            'data' => $contract
        ], Response::HTTP_OK);
    }

    /**
     * Hapus kontrak berdasarkan ID.
     */
    public function destroy($id)
    {
        $contract = Contract::find($id);

        if (!$contract) {
            return response()->json([
                'status' => 404,
                'message' => 'Contract not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $contract->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Contract deleted successfully'
        ], Response::HTTP_OK);
    }
}
