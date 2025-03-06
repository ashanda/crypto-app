<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReferralCode;
use App\Models\Token;
use App\Models\Wallet;

class AdminController extends Controller
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
        return view('admin.dashboard',compact('refLink', 'tokenCounts','myTokens','myWallet'));
        //return response()->json(['message' => 'Welcome to Admin Dashboard']);
    }

    public function activateUser(User $user)
    {
        $user->status = 'active';
        $user->save();
        // Send an email or notification if needed
        return redirect()->route('admin.dashboard');
    }
}
