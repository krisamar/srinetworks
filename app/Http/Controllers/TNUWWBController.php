<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TNUWWBModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class TNUWWBController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TNUWWBModel::orderBy('created_at','desc')->get();
        return view("tnuwwb.index", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tnuwwb.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $rules = [
                'date' => 'required',
                'application_no' => 'required',
                'mobile' => 'required',
                'name' => 'required',
                'paid' => 'required',
                'status' => 'required',
                'id_no' => 'required',
                'type' => 'required',
                'remarks' => 'nullable'
            ];

            // Add validation for 'others' only if status is 4
            if ($request->status == 4) {
                $rules['others'] = 'required';
            } else {
                $rules['others'] = 'nullable';
            }

            $message = [
                'date.required' => 'Please select the date',
                'application_no' => 'Please enter the Application No',
                'mobile.required' => 'Please enter the Mobile No',
                'name.required' => 'Please enter the Name',
                'paid.required' => 'Please select the Fee',
                'status.required' => 'Please select the status',
                'others.required' => 'Please enter the Others',
                'id_no.required' => 'Please enter the ID No',
                'type.required' => 'Please select the Type',
            ];

            $validator = Validator::make($data, $rules, $message);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            TNUWWBModel::create($data);
            DB::commit();
            return redirect()->route('tnuwwb.index')->with('flash_success','Details Created Successfully');
            // return redirect()->back()->with('flash_success','Details Created Successfully');
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('flash_error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TNUWWBModel $data)
    {
        return view('tnuwwb.view',['data'=> $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TNUWWBModel $data)
    {
        return view('tnuwwb.edit',['data'=> $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TNUWWBModel $data)
    {
        // try{
            // DB::beginTransaction();
            $datas = $request->all();
            $rules = [
                'date' => 'required',
                'application_no' => 'required',
                'mobile' => 'required',
                'name' => 'required',
                'paid' => 'required',
                'status' => 'required',
                'id_no' => 'required',
                'type' => 'required',
                'remarks' => 'nullable'
            ];

            // Add validation for 'others' only if status is 4
            if ($request->status == 4) {
                $rules['others'] = 'required';
            } else {
                $rules['others'] = 'nullable';
            }

            $message = [
                'date.required' => 'Please select the date',
                'application_no' => 'Please enter the Application No',
                'mobile.required' => 'Please enter the Mobile No',
                'name.required' => 'Please enter the Name',
                'paid.required' => 'Please select the Fee',
                'status.required' => 'Please select the status',
                'others.required' => 'Please enter the Others',
                'id_no.required' => 'Please enter the ID No',
                'type.required' => 'Please select the Type',
            ];

            $validator = Validator::make($datas, $rules, $message);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data->update($datas);
            // DB::commit();
            return redirect()->route('tnuwwb.index')->with('flash_success','Details Updated Successfully');

            // return redirect()->back()->with('flash_success','Details Updated Successfully');
        // }catch(\Exception $e){
        //     DB::rollBack();
        //     return back()->with('flash_error', $e->getMessage());
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TNUWWBModel $data)
    {
        if($data){
            $data->delete();
            return response()->json(['message' => 'The TNUWWB details deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'There something issue delete the TNUWWB details'], 404);
        }
    }

    public function downloadPdf($id)
    {
        $data = TNUWWBModel::findOrFail($id);

        $pdf = PDF::loadView('tnuwwb.pdf', compact('data'))->setPaper('A4', 'portrait');

        // return $pdf->download('TNUWWB_'.$data->application_no.'.pdf');
        return $pdf->stream('TNUWWB_'.$data->application_no.'.pdf');

    }

    public function updateStatus(Request $request, $id)
    {
        $data = TNUWWBModel::findOrFail($id);
        $request->validate(['status' => 'required']);
        $data->status = $request->status;
        $data->save();

        return response()->json(['success' => true]);
    }
}
