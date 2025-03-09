<?php

namespace App\Http\Controllers;

use App\Models\ReferralCode;
use App\Models\Token;
use App\Models\User;
use App\Models\UserPackage;
use App\Models\Wallet;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $appUrl = env('APP_URL').'/register?ref=';
        $ref_code = ReferralCode::where('user_id', auth()->user()->id)->pluck('code')->first();
        $refLink = $appUrl.$ref_code;
        $tokenCounts = Token::selectRaw('
                user_id, 
                COUNT(*) as total_tokens, 
                SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active_tokens,
                SUM(CASE WHEN status = "deactive" THEN 1 ELSE 0 END) as deactive_tokens
            ')
            ->groupBy('user_id')
            ->with('user') // Load user details
            ->paginate(10); // Paginate with 10 records per page
        $myTokens = Token::where('user_id', auth()->user()->id)->where('status','active')->count();
        $myWallet = Wallet::where('user_id', auth()->user()->id)->first();
        return view('company.dashboard',compact('refLink', 'tokenCounts','myTokens','myWallet'));
        //return response()->json(['message' => 'Welcome to Admin Dashboard']);
    }

    public function activateUser(User $user)
    {
        $user->status = 'active';
        $user->save();
        // Send an email or notification if needed
        return redirect()->route('company.dashboard');
    }

    public function pendingActivation(){
        $packageFees = [
            10 => 20,
            100 => 40,
            1000 => 60,
            5000 => 70,
            10000 => 80,
            100000 => 90,
            1000000 => 90,
            5000000 => 90,
            10000000=>90
        ];
        
        $myPackage = UserPackage::where('user_id', auth()->user()->id)->where('status','active')->first();
        
        if ($myPackage) {
            $packageValue = $myPackage->package;
            
            // Get the corresponding fee percentage, default to 0 if not found
            $feePercentage = $packageFees[$packageValue] ?? 0;
            
        }
        
        $myPackage = UserPackage::where('user_id',auth()->user()->id)->first();
        $activations = UserPackage::where('status','pending')->paginate(10);
        return view('company.pending-activation',compact('activations','feePercentage'));
       }
}
