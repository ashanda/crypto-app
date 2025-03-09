<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Token;
use App\Models\User;
use App\Models\UserPackage;
use App\Models\UserParent;
use App\Models\Wallet;
use RealRashid\SweetAlert\Facades\Alert;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
class TokenController extends Controller
{
    // Generate a custom number of tokens for a user
    public function generateTokens(Request $request, $userId)
{
    $user = User::find($userId);

    if (!$user) {
        return back()->with('error', 'User not found');
    }

    // Validate token_count input
    $request->validate([
        'token_count' => 'required|integer|min:1|max:500',
    ]);

    // Validate Google Authenticator code
    $request->validate([
        'google_auth_code' => 'required|numeric',
    ]);

    // Retrieve Google Authenticator secret for the user
    $secret = $user->google_authenticator_secret;

    if (!$secret) {
        return back()->with('error', 'Google Authenticator secret not set for the user');
    }

    // Verify the Google Authenticator code
    $gAuth = new GoogleAuthenticator();
    $isValid = $gAuth->checkCode($secret, $request->input('google_auth_code'));

    if (!$isValid) {
        return back()->with('error', 'Invalid Google Authenticator code');
    }

    // Proceed to token generation
    $count = $request->input('token_count');
    $tokens = [];

    for ($i = 0; $i < $count; $i++) {
        $tokens[] = [
            'user_id' => $user->id,
            'token' => bin2hex(random_bytes(32)),
            'status' => 'active', // Default status when creating tokens
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Insert tokens into the database
    Token::insert($tokens);

    // Redirect with success message
    return redirect()->route('view.tokens', $userId)->with('success', "$count tokens generated successfully");
}

    // Fetch and display user tokens
    public function viewTokens($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        // Paginate tokens, 10 per page (or adjust the number as needed)
        $tokens = Token::where('user_id', $userId)->paginate(10);

        return view('tokens.index', compact('user', 'tokens'));
    }

    public function activePackage(Request $request)
    {
        
        $packageId = $request->input('package_id');
        $package = UserPackage::where('id',$packageId)->with('userpackage')->first();
        if($package->sale == 'first'){

        // Get the current active package for the authenticated user
        $myPackage = UserPackage::where('user_id', auth()->user()->id)->where('status', 'active')->with('userpackage')->first();
       
        if ($myPackage) {
            $packageValue = $myPackage->package;

            // Get the corresponding fee percentage, default to 0 if not found
            $feePercentage = $myPackage->userpackage->commission ?? 0;
           
        } else {
            return response()->json(['message' => 'No active package found for the user.'], 404);
        }
       
        // Retrieve the package to be updated
        
        if (!$package) {
            return response()->json(['message' => 'Package not found.'], 404);
        }
        
        // Check if the user has enough active tokens
        $checkToken = Token::where('user_id', auth()->user()->id)->where('status', 'active')->count();
        $needTokens = $package->userpackage->price - ($package->userpackage->price * ($feePercentage / 100));

        if ($checkToken >= $needTokens) {
            // Proceed to update the parent information
            $parent = ParentFind($package->ref_id);  // Ensure this function returns a valid parent ID
       
            $findUser = UserParent::where('user_id', $package->user_id)->first();
           
            if ($findUser) {
                $findUser->parent_id = $parent;
                $findUser->node = 'active';
                $findUser->save();  // Save the updated user-parent relationship
            } else {
                return response()->json(['message' => 'User-parent relationship not found.'], 404);
            }

            // Update the package status to 'active'
            $package->status = 'active';
            $package->save();

            $packageUser = User::where('id',$package->user_id)->first();

            if ($packageUser) {
                $packageUser->status = 'active';
                $packageUser->save();  // Save the updated user-parent relationship
            } else {
                return response()->json(['message' => 'User-parent relationship not found.'], 404);
            }
            // Calculate the wallet amount based on the package value and fee percentage
            $walletAmount = $package->userpackage->price * ($feePercentage / 100);

            // Create or update the user's wallet
            $wallet = Wallet::where('user_id',  $parent)->first();
            $checkUserPackage = UserPackage::where('user_id', $parent)->with('userpackage')->first();
            if ($checkUserPackage->earn <= ($checkUserPackage->userpackage->price * 4)) {
                if ($wallet) {
                    // If wallet exists, update the balance
                    $wallet->balance += $walletAmount;
                    $wallet->save();
                    
                } else {
                    // If wallet doesn't exist, create a new one
                    Wallet::create([
                        'user_id' => auth()->user()->id,
                        'balance' => $walletAmount
                    ]);
                }
                $checkUserPackage->earn +=$walletAmount;
                $checkUserPackage->save();
            } else {
                $companyWallet = Wallet::where('user_id', 1)->first();
                $companyWallet->balance += $walletAmount;
                $companyWallet->save();
            }
            
            
            
            // Deactivate the tokens after they are used
                $tokensToDeactivate = Token::where('user_id', auth()->user()->id)
                ->where('status', 'active')
                ->limit($needTokens)  // Limit the number of tokens to deactivate
                ->get();

            foreach ($tokensToDeactivate as $token) {
                $token->status = 'deactive';
                $token->save();
            }

            // Return a success message
            return response()->json(['message' => 'Package and wallet updated successfully.']);
        } else {

            return response()->json(['message' => 'Not enough tokens.'], 400);
        }
    } else {
        $findParent = UserParent::where('user_id', $package->user_id)->where('node','active')->first();
        if($findParent){
            $findParnetPackage = UserPackage::where('user_id', $findParent->parent_id)->where('status','active')->first();
            $package = Package::where('id',$findParnetPackage->package)->first();
            $walletAmount = $package->price * ($package->commission / 100);
            if($findParnetPackage->earn <= $package->price * 4){
                $wallet = Wallet::where('user_id',  $findParent->parent_id)->first();
                if ($wallet) {
                    // If wallet exists, update the balance
                    $wallet->balance += $walletAmount;
                    $wallet->save();
                    
                } else {
                    // If wallet doesn't exist, create a new one
                    Wallet::create([
                        'user_id' => auth()->user()->id,
                        'balance' => $walletAmount
                    ]);
                }
                $findParnetPackage->earn +=$walletAmount;
                $findParnetPackage->save();
            }else{
                $companyWallet = Wallet::where('user_id', 1)->first();
                $companyWallet->balance += $walletAmount;
                $companyWallet->save();
            }
        }
    }
    }

    public function shareToken(){
        $tokens = Token::where('user_id', auth()->user()->id)->where('status', 'active')->count();
        
        return view('tokens.share', compact('tokens'));
    }

    public function shareTokens(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'tokenValue' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
        ]);

        // Get the current authenticated user
        $currentUser = Auth::user();
        $tokenCount = Token::where('user_id', $currentUser->id)->where('status', 'active')->count();
        
        // Check if the user has enough tokens to share
        

        // Find the user to share tokens with
        $recipient = User::findOrFail($validatedData['user_id']);

        $tokenValue = (int) $validatedData['tokenValue'];

        // Fetch the active tokens of the current user
        $tokensToUpdate = Token::where('user_id', $currentUser->id)
                        ->where('status', 'active')
                        ->limit($tokenValue)  // Limit the number of tokens to update
                        ->get();

        // Check if the current user has enough active tokens to share
        if ($tokensToUpdate->count() < $tokenValue) {
            // If the user doesn't have enough tokens
            Alert::error('Error', 'You do not have enough active tokens to share.');
            return redirect()->back();
        }

        // Update tokens from the current user (you may want to transfer some properties like status, value, etc.)
        foreach ($tokensToUpdate as $token) {
            // Update the necessary fields (for example, transfer the token to the recipient)
            $token->user_id = $recipient->id;
            $token->save();
        }
        // Deduct tokens from the current user (assuming your tokens table has a 'value' column)
        

        // Return a success message or redirect to the desired page
        Alert::success('Success', 'Tokens sent successfully!');
        return redirect()->back();
    }




}

