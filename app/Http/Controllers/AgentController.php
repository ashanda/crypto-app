<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReferralCode;
use App\Models\Token;
use App\Models\Wallet;
use App\Models\UserPackage;

class AgentController extends Controller
{
    public function index()
    {
        $appUrl = env('APP_URL').'/register?ref=';
        $ref_code = ReferralCode::where('user_id', auth()->user()->id)->pluck('code')->first();
        $refLink = $appUrl.$ref_code;
        
        $myTokens = Token::where('user_id', auth()->user()->id)->where('status','active')->count();
        $myWallet = Wallet::where('user_id', auth()->user()->id)->first();

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

        $activations = UserPackage::where('ref_id',auth()->user()->id)->with('user')->where('status','pending')->paginate(10);
        return view('agent.dashboard',compact('refLink','myTokens','myWallet','activations','feePercentage'));

        
        //return response()->json(['message' => 'Welcome to Admin Dashboard']);
    }
}
