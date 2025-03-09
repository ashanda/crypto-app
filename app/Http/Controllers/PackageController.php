<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use App\Models\UserPackage;
use App\Models\UserParent;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class PackageController extends Controller
{
    public function buyPackageHistory(){
        $packages =  UserPackage::where("user_id", auth()->user()->id)->with('user')->paginate(10);
        $activePackage = UserPackage::where("user_id", auth()->user()->id)->where("status", "active")->first(); 
        return view('packages.buy-packageHistory',compact('packages','activePackage'));
    }

    public function buyPackage(Request $request){
        
        
        $parentData = UserParent::where('user_id', auth()->user()->id)->where('node','active')->with('user')->first();
        $id = $parentData->parent_id;
        $package = Package::get();
        return view('packages.buy-package', compact('id','parentData','package'));  
    }

    public function buyPackages(Request $request){
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
            return redirect()->back();
        }
    
        $UserBuyPackage = Package::where('price',$request->package)->first();
        // Ensure the user can only have one package at a time
        // Create or update the user's package
        $userPackage = UserPackage::firstOrNew(['user_id' => $user]);
        $userPackage->package = $UserBuyPackage->id;
        $userPackage->status = 'pending';  // Mark the new package as active
        $userPackage->ref_id = $parentData->referred_by;
        $userPackage->sale = 'other';
        $userPackage->save();

        Alert::error('Success', 'Package bought successfully..wait for activation');
        return redirect()->back();
    }
}
