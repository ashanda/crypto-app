<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ReferralCode;
use App\Models\User;
use App\Models\UserPackage;
use App\Models\UserParent;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $checkUser = User::where('email', $request->email)->first();
            $checkPackage = UserPackage::where('user_id', $checkUser->id)->count();
            if($checkPackage > 1) {
    
                return redirect()->route(Auth::user()->role . '.dashboard'); // Redirect based on role
            }elseif($checkPackage == 1){
                $checkPackage = UserPackage::where('user_id', $checkUser->id)->where('status', 'pending')->first();
                if($checkPackage) {
                    Alert::error('Error', "You're package is pending");
                    return redirect()->back();
                }else{
                    return redirect()->route(Auth::user()->role . '.dashboard');
                }
                
            }
            else{
                Alert::error('Error', 'You do not have any package');
                return redirect()->back();
            }
            
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }


    public function showStep1(Request $request)
    {
        $referralCode = $request->query('ref'); // Get referral code from the URL
        $checkReferral = ReferralCode::where('code', $referralCode)->first();
        if(!$checkReferral) {
            Alert::error('Error', 'Invalid referral code');
            return redirect()->route('login');
        }
        return view('auth.register_step1', compact('referralCode'));
    }

    public function processStep1(Request $request)
    {
        //try{
        // Validate the input fields
                $request->validate([
                    'email' => 'required|email',
                    'password' => 'required|confirmed|min:6',
                    'whatsapp_number' => 'required',
                    'binance_pay_id' => 'required',
                    'referral_code' => 'required|exists:referral_codes,code', // Ensure the referral code exists
                ]);

                // Check if referral code is provided and exists
               
                $virtualParentUser = ReferralCode::where('code', $request->referral_code)->first();
                if(!$virtualParentUser) {
                    Alert::error('Error', 'Invalid referral code');
                    return redirect()->back();
                }

                $checkUser = User::where('email', $request->email)->first();
                if($checkUser) {
                    Alert::error('Error', 'Email already exists');
                    return redirect()->back();
                }else{
                    if ($checkUser && $checkUser->id) {
                        $checkPackage = UserPackage::where('user_id', $checkUser->id)->where('status', 'pending')->first();
                        if($checkPackage) {
                            Alert::error('Error', 'You already have a pending package');
                            return redirect()->route('register.step3');
                        }else{
                            return redirect()->route('register.step2');
                        }
                    }
                   
                    
                }

                // If a valid referral code was provided, use the referrer's user ID, else set it to null
                $referredBy = $virtualParentUser->user_id;

                // Create the new user
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'whatsapp_number' => $request->whatsapp_number,
                    'binance_pay_id' => $request->binance_pay_id,
                    'status' => 'pending',
                    'referred_by' => $referredBy, // Assign the referrer or null
                ]);

                // Auto-generate a referral code for the newly created user
                $referralCode = strtoupper(Str::random(6));
                $newUserID = $user->id;
                ReferralCode::create([
                    'user_id' => $user->id,
                    'code' => $referralCode,
                ]);

                // Redirect to the next step (step 2)
                return redirect()->route('register.step2', ['id' => $newUserID]);

                // catch(\Exception $e){
        //     return back()->with('error', $e->getMessage());
        // }
            }
        
    



    public function showStep2(Request $request, $id)
    {
        $userData = User::where('id',$id)->first();
        
        $parent_id = ParentFind($userData->referred_by);
        $userParent = UserParent::create([
            'user_id' => $id,
            'virtual_id' => $userData->referred_by,
            'parent_id' => $parent_id,
        ]);
        $parentData = User::where('id',$parent_id)->first();
      
        return view('auth.register_step2', compact('id','parentData'));
    }

    public function processStep2(Request $request)
    {
        // Validate the package selection
        $request->validate([
            'package' => 'required|in:10,20,50,100,500,1000,2500,5000', // Validate package selection
        ]);
        
        $user = $request->newUserID;
        $parentData = User::where('id',$user)->first();
    
        // Check if the user already has an active package
        $existingPackage = UserPackage::where('user_id', $user)
                                      ->where('status', 'active')
                                      ->first();
    
        if ($existingPackage) {
            // If the user already has an active package, deactivate it first
            Alert::error('Error', 'You already have an active package');
            return redirect()->route('login');
        }
    
        // Ensure the user can only have one package at a time
        // Create or update the user's package
        $userPackage = UserPackage::firstOrNew(['user_id' => $user]);
        $userPackage->package = $request->package;
        $userPackage->status = 'pending';  // Mark the new package as active
        $userPackage->ref_id = $parentData->referred_by;
        $userPackage->sale = 'first';
        $userPackage->save();
    
        return redirect()->route('register.step3', ['id' => $user]);
    }
    

    public function showStep3(Request $request)
    {

        $user_id = $request->id;
        $user = User::find($user_id);
       
        if ($user->status == 'active') {
            return redirect()->route('login'); // Redirect to the home/dashboard after activation
        }

        return view('auth.register_step3', compact('user'));
    }

}


