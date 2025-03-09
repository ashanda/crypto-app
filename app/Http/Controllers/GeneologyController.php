<?php

namespace App\Http\Controllers;

use App\Models\UserParent;
use Illuminate\Http\Request;

class GeneologyController extends Controller
{
    public function index()
    {
        $childerns= UserParent::where('virtual_id', Auth()->user()->id)->with('user')->get();
        return view('geneology.index', compact('childerns'));
    }
}
