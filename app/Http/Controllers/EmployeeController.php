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
use Illuminate\Validation\Rule;

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
            'image.*' => 'required|image|mimes:jpeg,jpg,png,svg,gif|max:2048'
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
            'image.*.required' => 'Please upload the image',
            'image.*.image' => 'Please upload the image only jpeg, jpg, png format only',
            'image.*.max' => 'Please upload the image only 2048MB size'
        ];

        $validator = Validator::make($data, $rules, $message);

        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // $imageName = time().'.'.$request->image->extension();
        // $request->image->move(public_path('images'), $imageName);
        // $data['image'] = $imageName;
        $imageData = [];
        if($files = $request->file('image')){
            foreach($files as $key => $file){
                $ext = $file->getClientOriginalExtension();
                $fileName = $key.'-'.time().'.'.$ext;
                $path = public_path('images');
                $file->move($path, $fileName);
                $imageData[] = [
                    'image' => 'images/'.$fileName
                ];
            }
        }
// dd(json_encode($imageData));
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
                'image' => json_encode($imageData)
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
        $employee->image = json_decode($employee->image, true);
        return view('view',['employee' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $employee->image = json_decode($employee->image, true); // decode to array
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
        'email' => ['required', 'email', Rule::unique('users')->ignore($employee->email, 'email')],
        'mobile' => ['required', 'numeric', Rule::unique('users')->ignore($employee->mobile, 'mobile')],
        'role' => 'required',
        'salary' => 'required|numeric',
        'city' => 'required',
        'password' => 'nullable',
        'image.*' => 'nullable|image|mimes:jpeg,jpg,png,svg,gif|max:2048'
    ];

    $validator = Validator::make($data, $rules);

    if($validator->fails()){
        return redirect()->back()->withInput()->withErrors($validator);
    }

    // Handle image merging
    $imageData = json_decode($employee->image ?? '[]', true);
    if($request->hasFile('image')){
        foreach($request->file('image') as $key => $file){
            $ext = $file->getClientOriginalExtension();
            $fileName = $key.'-'.time().'.'.$ext;
            $file->move(public_path('images'), $fileName);
            $imageData[] = ['image' => 'images/'.$fileName];
        }
    }
    $data['image'] = json_encode($imageData);

    $employee->update($data);

    // Update user based on email fallback if user_id doesn't exist
    $user = User::find($employee->user_id) ?? User::where('email', $employee->email)->first();

    if ($user) {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => '1',
        ]);
    }

    return redirect()->route('index')->with('flash_success','The Employee updated successfully');
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

    public function deleteImage(Employee $employee, $index)
{ 
    $images = json_decode($employee->image, true);

    if (isset($images[$index])) {
        $imagePath = public_path($images[$index]['image']);

        // Delete the file if it exists
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Remove the image from array
        array_splice($images, $index, 1); // better than unset (reindexes array)

        // Save updated images
        $employee->image = json_encode($images);
        $employee->save();

        return back()->with('flash_success', 'Image deleted successfully.');
    }

    return back()->with('flash_error', 'Image not found.');
}

}
