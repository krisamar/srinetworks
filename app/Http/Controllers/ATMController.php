<?php

namespace App\Http\Controllers;

use App\Models\ATMModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ATMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaction = ATMModel::orderBy('created_at', 'desc')->paginate(20);
        return view('atm.index',['transaction' => $transaction]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('atm.create');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'date' => 'required',
            'method' => 'required',
            'name' => 'required',
            'amount' => 'required|numeric',
            'via_app' => 'required',
            'via_bank' => 'required',
            'sender_name' => 'required',
            'images' => 'nullable|image|mimes:jpeg,jpg,png,svg,gif|max:2048',
            'sender_mobile' => 'nullable|numeric',
            'remarks' => 'nullable'
        ];

        $messages = [
            'date.required' => 'Please select the date',
            'method.required' => 'Please select the method',
            // 'mobile_number.required' => 'Please enter the mobile number',
            // 'mobile_number.numeric' => 'Please enter the mobile number in numeric',
            // 'mobile_number.max' => 'Please enter the mobile number max 10 digit',
            'amount.required' => 'Please enter the amount',
            'amount.required' => 'Please enter the amount in numeric',
            'name.required' => 'Enter the Name',
            'via_app.required' => 'Please select the App',
            'via_bank.required' => 'Please select the Bank',
            'sender_name.required' => 'Please enter the sender name',
            'images.image' => 'Please upload the image only jpeg, jpg, png format only',
            'images.max' => 'Please upload the image only 2048MB size',
            // 'sender_mobile.required' => 'Please enter the sender mobile number',
            'sender_mobile.numeric' => 'Please enter the sender mobile number in numeric',
            'sender_mobile.max' => 'Please enter the sender mobile max 10 digit',
            // 'remarks.required' => 'Please enter the remarks'
        ];

        if ($data['method'] == '0') {
            $rules['mobile_number'] = 'required|numeric';
            $messages = array_merge($messages, [
                'mobile_number.required' => 'Please enter the mobile number',
                'mobile_number.numeric' => 'Please enter the mobile number in numeric',
            ]);
        } else if($data['method'] == '1'){
            $rules['acc_no'] = 'required';
            $rules['ifsc'] = 'required';
        
            $messages = array_merge($messages, [
                'acc_no.required' => 'Please enter the account number',
                'ifsc.required' => 'Please enter the IFSC code',
            ]);
        }
        

        $validator = Validator::make($data, $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data['date'] = date('Y-m-d', strtotime($request->date));
        if ($request->hasFile('images')) {
            $imageName = time().'.'.$request->file('images')->extension();
            $request->file('images')->move(public_path('images/transaction'), $imageName);
            $data['images'] = $imageName;
        } else {
            $data['images'] = null; // If no image is uploaded
        }
        

        ATMModel::create($data);

        return redirect()->route('atm.create')->with('flash_success', 'The transaction details added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ATMModel $transaction)
    {
        return view('atm.view',['transaction' => $transaction]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ATMModel $transaction)
    {
        return view('atm.edit',['transaction' => $transaction]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ATMModel $transaction)
    {
        $data = $request->all();

        $rules = [
            'date' => 'required',
            'method' => 'required',
            'name' => 'required',
            'amount' => 'required|numeric',
            'via_app' => 'required',
            'via_bank' => 'required',
            'sender_name' => 'required',
            'images' => 'nullable|image|mimes:jpeg,jpg,png,svg,gif|max:2048',
            'sender_mobile' => 'nullable|numeric',
            'remarks' => 'nullable'
        ];

        $messages = [
            'date.required' => 'Please select the date',
            // 'mobile_number.required' => 'Please enter the mobile number',
            // 'mobile_number.numeric' => 'Please enter the mobile number in numeric',
            // 'mobile_number.max' => 'Please enter the mobile number max 10 digit',
            'amount.required' => 'Please enter the amount',
            'amount.required' => 'Please enter the amount in numeric',
            'name.required' => 'Enter the Name',
            'via_app.required' => 'Please select the App',
            'via_bank.required' => 'Please select the Bank',
            'sender_name.required' => 'Please enter the sender name',
            'images.image' => 'Please upload the image only jpeg, jpg, png format only',
            'images.max' => 'Please upload the image only 2048MB size',
            // 'sender_mobile.required' => 'Please enter the sender mobile number',
            'sender_mobile.numeric' => 'Please enter the sender mobile number in numeric',
            'sender_mobile.max' => 'Please enter the sender mobile max 10 digit',
            // 'remarks.required' => 'Please enter the remarks'
        ];

        if ($request->method == 0) {
            $rules['mobile_number'] = 'required|numeric';
        
            $messages = [
                'mobile_number.required' => 'Please enter the mobile number',
                'mobile_number.numeric' => 'Please enter the mobile number in numeric',
            ];
        } else {
            $rules['acc_no'] = 'required';
            $rules['ifsc'] = 'required';
        
            $messages = [
                'acc_no.required' => 'Please enter the account number',
                'ifsc.required' => 'Please enter the IFSC code',
            ];
        }

        $validator = Validator::make($data, $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->hasFile('images')) {
            $imageName = time().'.'.$request->file('images')->extension();
            $request->file('images')->move(public_path('images/transaction'), $imageName);
            $data['images'] = $imageName;
        } else {
            $data['images'] = null; // If no image is uploaded
        }
        

        $transaction->update($data);

        return redirect()->route('atm.index')->with('flash_success', 'The transaction details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ATMModel $transaction)
    {
        if($transaction){
            $transaction->delete();
            return response()->json(['message' => 'The transaction deleted successfully'], 200);
        }else{
            return response()->json(['message' => 'There are something issue to delete transaction details'], 404);
        }
    }

// Daily transactions method (for the first graph - keep this as is)
public function getDailyTransactions()
{
    $currentMonth = Carbon::now()->format('Y-m'); // Get YYYY-MM
    $today = Carbon::now()->day; // Get today's date (day number)

    $labels = [];
    $totalTransactions = [];

    for ($day = 1; $day <= $today; $day++) { // Loop from Day 1 to Today
        $date = Carbon::now()->format('Y-m-') . str_pad($day, 2, '0', STR_PAD_LEFT); // YYYY-MM-DD
        $labels[] = "Day " . $day;

        // Fetch total transaction amount per day
        $transaction = ATMModel::selectRaw("COALESCE(SUM(amount), 0) as total_amount")
            ->whereDate('date', $date)
            ->first();

        $totalTransactions[] = (int) ($transaction->total_amount ?? 0);
    }

    return response()->json([
        'labels' => $labels, // Days from 1 to Today
        'totalTransactions' => $totalTransactions // Total transactions per day
    ]);
}

// New method for monthly transactions within the current year
public function getMonthlyTransactions()
    {
        try {
            $currentYear = Carbon::now()->year;
            $labels = [];
            $monthlyTransactions = [];

            for ($month = 1; $month <= 12; $month++) {
                $monthName = Carbon::create($currentYear, $month, 1)->format('F');
                $labels[] = $monthName;

                $startDate = Carbon::create($currentYear, $month, 1)->startOfMonth()->format('Y-m-d');
                $endDate = Carbon::create($currentYear, $month, 1)->endOfMonth()->format('Y-m-d');

                $transaction = ATMModel::selectRaw("COALESCE(SUM(amount), 0) as total_amount")
                    ->whereBetween('date', [$startDate, $endDate])
                    ->first();

                $monthlyTransactions[] = (int) ($transaction->total_amount ?? 0);
            }

            return response()->json([
                'labels' => $labels,
                'monthlyTransactions' => $monthlyTransactions
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch monthly transactions'], 500);
        }
    }

// Combined method to get both daily and monthly data in one request (optional)
public function getAllTransactionData()
{
    // Get daily transaction data (current month)
    $currentMonth = Carbon::now()->format('Y-m');
    $today = Carbon::now()->day;
    
    $dailyLabels = [];
    $dailyTransactions = [];
    
    for ($day = 1; $day <= $today; $day++) {
        $date = Carbon::now()->format('Y-m-') . str_pad($day, 2, '0', STR_PAD_LEFT);
        $dailyLabels[] = "Day " . $day;
        
        $transaction = ATMModel::selectRaw("COALESCE(SUM(amount), 0) as total_amount")
            ->whereDate('date', $date)
            ->first();
            
        $dailyTransactions[] = (int) ($transaction->total_amount ?? 0);
    }
    
    // Get monthly transaction data (current year)
    $currentYear = Carbon::now()->year;
    $currentMonth = Carbon::now()->month;
    
    $monthlyLabels = [];
    $monthlyTransactions = [];
    
    for ($month = 1; $month <= $currentMonth; $month++) {
        $monthName = Carbon::create($currentYear, $month, 1)->format('F');
        $monthlyLabels[] = $monthName;
        
        $startDate = Carbon::create($currentYear, $month, 1)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::create($currentYear, $month, 1)->endOfMonth()->format('Y-m-d');
        
        $transaction = ATMModel::selectRaw("COALESCE(SUM(amount), 0) as total_amount")
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->first();
            
        $monthlyTransactions[] = (int) ($transaction->total_amount ?? 0);
    }
    
    return response()->json([
        'daily' => [
            'labels' => $dailyLabels,
            'transactions' => $dailyTransactions
        ],
        'monthly' => [
            'labels' => $monthlyLabels,
            'transactions' => $monthlyTransactions
        ]
    ]);
}

    public function income(Request $request){
        $rules = ['date' => 'required', 'amount' => 'required|numeric'];
        $messages = [
            'date.required' => 'Please select the date',
            'amount.required' => 'Please enter the amount',
            'amount.numeric' => 'Please enter the amount only numeric'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $income = DB::table('table_income')->insert([
                'date' => $request->date,
                'amount' => $request->amount,
                'created_at' => now(), // Adding timestamps manually
                'updated_at' => now()
            ]);
            return redirect()->back()->with('flash_success','')->with('', $income);
        }
    }
    public function getDailyIncome()
    {
        $incomeData = DB::table('table_income')
            ->selectRaw('DATE(date) as income_date, SUM(amount) as total_income')
            ->groupBy('income_date')
            ->orderBy('income_date', 'ASC')
            ->get();
    
        $labels = $incomeData->pluck('income_date')->toArray();
        $totalIncome = $incomeData->pluck('total_income')->toArray();
    
        return response()->json([
            'labels' => $labels, 
            'totalIncome' => $totalIncome
        ]);
    }

public function getMonthlyIncome()
{
    $incomeData = DB::table('table_income')
        ->selectRaw('DATE_FORMAT(date, "%Y-%m") as income_month, SUM(amount) as total_income')
        ->groupBy('income_month')
        ->orderBy('income_month', 'ASC')
        ->get();

    $labels = $incomeData->pluck('income_month')->toArray();
    $monthlyIncome = $incomeData->pluck('total_income')->toArray();

    return response()->json([
        'labels' => $labels, 
        'monthlyIncome' => $monthlyIncome
    ]);
}

}
