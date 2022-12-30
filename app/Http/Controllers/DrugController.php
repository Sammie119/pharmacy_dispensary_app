<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DrugController extends Controller
{
    public function index()
    {
        $drugs = Drug::orderBy('description')->get();
        return view('drugs', ['drugs' => $drugs]);
    }

    public function store(Request $request)
    {
        request()->validate([
            'description' => 'required',
            'insurance_price' => 'required|numeric',
            'non_insurance_price' => 'required|numeric',
        ]);

        if($request->has('id')){
            Drug::find($request->id)->update(
                [
                    'description' => $request['description'],
                    'insurance_price' => $request['insurance_price'],
                    'non_insurance_price' => $request['non_insurance_price'],
                    'updated_by' => Auth::user()->id
                ]
            );

            return back()->with('success', 'Drug Successfully Updated!!');
        } else {
            Drug::updateOrCreate(
                [
                    'description' => $request['description'],
                ],
                [
                    'insurance_price' => $request['insurance_price'],
                    'non_insurance_price' => $request['non_insurance_price'],
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]
            );

            return back()->with('success', 'New Drug Successfully Created!!');
        }
    }

    public function destroy($id)
    {
        
        $user = Drug::find($id);

        $user->delete();
        return back()->with('success', 'Drug Deleted Successfully!!');
        
    }
}
