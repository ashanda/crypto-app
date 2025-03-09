<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReferralCode;
use App\Models\Token;
use App\Models\Wallet;
use App\Models\UserPackage;

class UserController extends Controller
{
    public function index()
    {   $appUrl = env('APP_URL').'/register?ref=';
        $ref_code = ReferralCode::where('user_id', auth()->user()->id)->pluck('code')->first();
        $refLink = $appUrl.$ref_code;
        
        $myTokens = Token::where('user_id', auth()->user()->id)->where('status','active')->count();
        $myWallet = Wallet::where('user_id', auth()->user()->id)->first();

        $myPackage = UserPackage::where('user_id', auth()->user()->id)->where('status','active')->with('userpackage')->first();
    
    if ($myPackage) {
        $packageValue = $myPackage->package;
        
        // Get the corresponding fee percentage, default to 0 if not found
        $feePercentage = $myPackage->userpackage->commission ?? 0;
        
    }
    
    
        $activations = UserPackage::where('ref_id',auth()->user()->id)->with(['user','userpackage'])->where('status','pending')->paginate(10);
        return view('user.dashboard',compact('refLink','myTokens','myWallet','activations','feePercentage'));
        
    }
}

