<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;
use Exception;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Session::get('role');
        $email = Session::get('email');
        if($role == 2 ){
            $employee = Employee::all();
        } else{
            $employee = Employee::getEmployeeData($email);
            $employee = $employee ? collect([$employee]) : collect(); 
        }

        if (!$employee) {
            return redirect()->back()->withErrors(['error' => 'Employee not found']);
        }else{
            return view('index', ['employee'=>$employee]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $request->all();
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|numeric|unique:users,mobile',
            'role' => 'required',
            'salary' => 'required|numeric',
            'city' => 'required',
            'password' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,svg,gif|max:2048'
        ];

        $message = [
            'name.required' => 'Please enter the name',
            'email.required' => 'Please enter the email',
            'email.email' => 'Please enter the valid email',
            'email.unique' => 'The email is already use',
            'mobile.required' => 'Please enter the mobile',
            'mobile.numeric' => 'Please enter the mobile is numeric value',
            'mobile.unique' => 'The mobile is already use',
            'role.required' => 'Please enter the role',
            'salary.required' => 'Please enter the salary',
            'salary.numeric' => 'Please enter the salary is numeric value',
            'city.required' => 'Please enter the city',
            'password.required' => 'Please enter the Password',
            'image.required' => 'Please upload the image',
            'image.image' => 'Please upload the image only jpeg, jpg, png format only',
            'image.max' => 'Please upload the image only 2048MB size'
        ];

        $validator = Validator::make($data, $rules, $message);

        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $data['image'] = $imageName;

        $twilioSid = getenv('TWILIO_SID');
        $twilioAuthToken = getenv('TWILIO_AUTH_TOKEN');
        $twilioWhatsappNumber = 'whatsapp:'.getenv('TWILIO_WHATSAPP_NUMBER');
        $to = 'whatsapp:+91'.$request->mobile;
        $message = 'Thanks for joining our Family';

        $client = new Client($twilioSid, $twilioAuthToken);
        try{
            Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'role' => $request->role,
                'salary' => $request->salary,
                'city' => $request->city,
                'image' => $imageName
            ]);
    
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'role' => '1'
            ]);

            $messageResponse = $client->messages->create(
                $to,
                    [
                        'from' => $twilioWhatsappNumber,
                        'body' => $message
                    ]
            );

            return redirect()->route('index')->with('flash_success','The Employee created successfully');
        } catch(Exception $e){
            return back()->with('flash_success', 'WhatsApp message failed: '.$e->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('view',['employee' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('edit',['employee'=>$employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->all();
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|numeric|unique:users,mobile',
            'role' => 'required',
            'salary' => 'required|numeric',
            'city' => 'required',
            'password' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,svg,gif|max:2048'
        ];

        $message = [
            'name.required' => 'Please enter the name',
            'email.required' => 'Please enter the email',
            'email.email' => 'Please enter the valid email',
            'email.unique' => 'The email is already use',
            'mobile.required' => 'Please enter the mobile',
            'mobile.numeric' => 'Please enter the mobile is numeric value',
            'mobile.unique' => 'The mobile is already use',
            'role.required' => 'Please enter the role',
            'salary.required' => 'Please enter the salary',
            'salary.numeric' => 'Please enter the salary is numeric value',
            'city.required' => 'Please enter the city',
            'password.required' => 'Please enter the Password',
            'image.required' => 'Please upload the image',
            'image.image' => 'Please upload the image only jpeg, jpg, png format only',
            'image.max' => 'Please upload the image only 2048MB size'
        ];

        $validator = Validator::make($data, $rules, $message);

        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $data['image'] = $imageName;

        $employee->update($data);
        User::update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => $request->password,
            'role' => '1'
        ]);

        return redirect()->route('index')->with('flash_success','The Employee created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if($employee){
            $employee->delete();
            return response()->json(['message' => 'The Employee details deleted successfully'], 200);
        }else{
            return response()->json(['message' => 'There something issue delete the Employee details'], 404);
        }
    }
}
