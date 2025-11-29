<?php

namespace App\Http\Controllers;

use App\Models\CertificateModel;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaction = CertificateModel::orderBy('created_at','desc')->paginate(20);
        return view('certificate.index',['transaction' => $transaction]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['date'] = $data['date'] ?? now()->format('Y-m-d');
        $data['status'] = $data['status'] ?? 1;

        if($data){
            CertificateModel::create($data);
            return response()->json(['message' => 'The certificate add successfully'], 200);
        } else {
            return response()->json(['message' => 'There are something issue to certificate details'], 404);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CertificateModel $transaction)
    {
    $transaction->mode = 1;
    return response()->json($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CertificateModel $transaction)
    {
        $transaction->update($request->all());

        return response()->json(['message' => 'Certificate updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CertificateModel $transaction)
    {
        if($transaction){
            $transaction->delete();
            return response()->json(['message' => 'The certificate deleted successfully'], 200);
        }else{
            return response()->json( ['message' => 'There are something issue to delete certificate details'], 404);
        }
    }
}
