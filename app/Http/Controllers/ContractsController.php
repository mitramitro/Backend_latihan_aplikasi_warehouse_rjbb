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
        // Validate based on status_contract
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'status_contract' => 'required|string|max:50',
            'contract_type' => 'required|string|max:100',
            'contract_number' => $request->status_contract === 'Non Kontrak' 
                ? 'nullable|string' // Allow null if 'Non Kontrak'
                : 'required|string|unique:contracts', // Otherwise, it must be unique
            'invoice' => 'required|string|max:50'
        ]);
    
        // Replace contract_number with '__' if it's empty and status is 'Non Kontrak'
        if ($request->status_contract === 'Non Kontrak' && empty($validated['contract_number'])) {
            $validated['contract_number'] = '__';
        }
    
        // Create the contract
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
    
        // Validate based on status_contract
        $validated = $request->validate([
            'vendor_id' => 'sometimes|exists:vendors,id',
            'status_contract' => 'sometimes|string|max:50',
            'contract_type' => 'sometimes|string|max:100',
            'contract_number' => $request->status_contract === 'Non Kontrak' 
                ? 'nullable|string'  // Allow null if 'Non Kontrak'
                : 'sometimes|string|unique:contracts,contract_number,' . $id, // Ignore current contract for uniqueness check
            'invoice' => 'sometimes|string|max:50'
        ]);
    
        // Replace contract_number with '__' if it's empty and status is 'Non Kontrak'
        if ($request->status_contract === 'Non Kontrak' && empty($validated['contract_number'])) {
            $validated['contract_number'] = '__';
        }
    
        // Update the contract
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
