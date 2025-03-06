<?php
use App\Models\UserPackage;
use App\Models\UserParent;
use App\Models\User;
function ParentFind($id) {
    if($id != 1){
        $activeOrderCount = UserParent::where('virtual_id', $id)->where('node','active')->count();
        
        $predefinedValues = [1, 4, 9, 14, 19, 29, 39, 49, 74, 99];

        if (in_array($activeOrderCount, $predefinedValues)) {
            $parent = UserParent::where('user_id', $id)->first();
            
            if ($parent) {
                return superParentFind($parent->parent_id);
            }
        } elseif ($activeOrderCount > 100) {
            $nextMultipleOf10 = (ceil($activeOrderCount / 10) * 10) - 1;

            if ($activeOrderCount == $nextMultipleOf10) {
                return superParentFind($id);
            } else {
                $parent = User::where('id', $id)->first();
                return $parent ? $parent->id : null;
            }
        }

        // If no conditions match, return the direct parent
        $parent = User::where('id', $id)->first();
        return $parent ? $parent->id : null;
    }else{
        $parent = User::where('id', $id)->first();
        return $parent ? $parent->id : null;
    }
    
}

function superParentFind($virtualParent) {
    $activeOrderCount = UserParent::where('virtual_id', $virtualParent)->where('node','active')->count();
    $predefinedValues = [1, 4, 9, 14, 19, 29, 39, 49, 74, 99];

    if (in_array($activeOrderCount, $predefinedValues)) {
        return ParentFind($virtualParent);
    } elseif ($activeOrderCount > 100) {
        $nextMultipleOf10 = (ceil($activeOrderCount / 10) * 10) - 1;

        if ($activeOrderCount == $nextMultipleOf10) {
            return ParentFind($virtualParent);
        } else {
            $parent = User::where('id', $virtualParent)->first();
            return $parent ? $parent->id : null;
        }
    }

    // Return the final resolved parent ID
    $parent = User::where('id', $virtualParent)->first();
    return $parent ? $parent->id : null;
}

