<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password', 'id');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            return response()->json([
                'user'=>$user,
                
            ]);
        }

        return response()->json([
            'error', 'Invalid Credentials'
        ]);
    }
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'nin' => '',
            'phoneno' => 'required',
            'voters_card' => '',
            'identification_type' => '',
            'identification_type2' => '',
            'identification_number1' => '',
            'identification_number2' => '',
            'identification_file1' => '',
            'identification_file2' => '',
            'employer_phoneno'=>'',
            'passport'=>'',
            
        ]);
        

        // Create a new user instance
        $user = User::create($validate);

        // Save the user to the database
        $user->save();

        // You can also log in the user if needed
        // auth()->login($user);
        // Redirect to a success page or return a response
        return response()->json([
            'user'=>User::with('loans')->get(),

        ]);
    } 

    public function register2(Request $request, string $id){
        $validate = $request->validate([
            'installment_period'=> '',
            'has_loan'=>'',
            'loan_amount'=>'',
            'guarantor1_name'=>'',
            'guarantor1_address'=>'',
            'guarantor1_phoneno'=>'',
            'guarantor1_identification1'=>'',
            'guarantor1_identification_file1'=>'',
            'guarantor1_identification_type1'=>'',
            'guarantor1_identification2'=>'',
            'guarantor1_identification_file2'=>'',
            'guarantor1_identification_type2'=>'',
            'guarantor2_name'=>'',
            'active'=>'',
            'guarantor2_address'=>'',
            'guarantor2_phoneno'=>'',
            'guarantor2_identification1'=>'',
            'guarantor2_identification_file1'=>'',
            'guarantor2_identification_type1'=>'',
            'guarantor2_identification2'=>'',
            'guarantor2_identification_file2'=>'',
            'guarantor2_identification_type2'=>'',
            

        ]);
        $user = User::find($id);
        $user->update($validate);
       
    }

    public function activate(Request $request, String $id){
        $request->validate([
            'active'=>''
        ]);
        $user = User::findorfail($id);
        
        $user->update([
            'active' => $request->active,
        ]);
        
    }
    public function reject(String $id){
        
        $user = User::findorfail($id);
        
        $user->update([
            'reject' => 'reject',
        ]);
        
    }
    public function account(Request $request, String $id){
       $request->validate([
            'account_number'=>'',
            'account_name'=>'',
            'bank'=>'',
        ]);
        $user = User::findorfail($id);
        $user->update([
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'bank' => $request->bank,
        ]);

    return response()->json(['success' => 'Operation Successful']);

        
    }

    public function show()
    {
    $users = User::with('loans')->get();
    $activetotal = User::where('active','activate')->sum('loan_amount');
    $loaninterest = Loan::sum('interest');
    $loanpaid = Loan::sum('amount_paid_so_far');
    
    return response()->json([
        'users' => $users, 
        'loaned'=>$activetotal, 
        'loaninterest'=>$loaninterest,
        'loanpaid'=>$loanpaid
    ]);
    }
    public function showuser(string $id){
      $user = User::with('loans')->findOrfail($id);;
        return response()->json([
            'user'=>$user
        ]);
    }
    public function showunapproved(string $id)
    {
    $users = User::find($id);
    return response()->json(['users' => $users]);
    }



    public function approve(string $id){
        $user= User::findorfail($id);
        Log::alert('user', [$user]);
        $user->approved = 'approved';
        $user->save();

        return response()->json([
            'Approved'=>'Your application has been approved'
        ]);
    }
}
