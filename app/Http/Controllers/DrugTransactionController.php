<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;
use App\Models\DrugTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DrugTransactionHistory;

class DrugTransactionController extends Controller
{
    protected function receiptNo()
    {
        if(DrugTransaction::count() === 0){
            return 1;
        } else {
            return DrugTransaction::select('receipt_no')->orderByDesc('id')->first()->receipt_no + 1;
        }
        
    }

    public function index()
    {
        $trans = DrugTransaction::orderByDesc('id')->limit(500)->get();
        return view('drugs_transaction', ['transactions' => $trans]);
    }

    // Ajax Call
    public function getDrugInfo(Request $request)
    {
        $drug = Drug::where("description", 'LIKE', $request->drug)->first();

        if($drug){
            $results = [
                'drug_name' => $drug->description,
                'drug_id' => $drug->id, 
                'insured_price' => $drug->insurance_price,
                'non_insured_price' => $drug->non_insurance_price,
            ];
        }
        else{
            $results = [
                'drug_name' => 'No_data'
            ];
        }

        return response()->json($results);
    }

    public function store(Request $request)
    {
        request()->validate([
            'drug_name.*' => 'required|distinct',
            'unit_price.*' => 'required|numeric',
            'quantity.*' => 'required|numeric|min:1',
            'ammount.*' => 'required|numeric',
        ]);

        if($request->has('id')){
            $trans = DrugTransaction::find($request->id);

            $receit = $trans->receipt_no;

            DB::table('drug_transaction_histories')->where('drug_trans_id', $request->id)->delete();

        } else {
            $receit = $this->receiptNo();

            $trans = new DrugTransaction;
        }

        $trans->drug_name = $request->drug_name;
        $trans->quantity = $request->quantity;
        $trans->unit_price = $request->unit_price;
        $trans->amount = array_sum($request->amount);
        $trans->receipt_no = $receit;
        

        if($request->has('id')){
            $trans->updated_by = Auth::user()->id;

            $trans->update();
        } else {
            $trans->created_by = Auth::user()->id;
            $trans->updated_by = Auth::user()->id;

            $trans->save();
        }

        foreach ($request->drug_name as $key => $drug_name) {
            $tran_his = new DrugTransactionHistory;

            $tran_his->drug_trans_id = $trans->id;
            $tran_his->drug_name = $drug_name;
            $tran_his->quantity = $request->quantity[$key];
            $tran_his->unit_price = $request->unit_price[$key];
            $tran_his->receipt_no = $receit;
            $tran_his->created_by = Auth::user()->id;
            $tran_his->updated_by = Auth::user()->id;

            $tran_his->save();
        }

        return "<script>
                window.open('print_receipt/$receit','','left=0,top=0,width=500,height=477,toolbar=0,scrollbars=0,status =0');
                window.location = 'drugs_transaction';
            </script>";
        // return back()->with('success', 'Transaction Entered Successfully!!');
        
        // dd($request->all());
    }

    public function receiptDispensary($receipt_no){
        $trans = DrugTransactionHistory::where('receipt_no', $receipt_no)->get();
        return view('print_receit', ['transaction' => $trans]);
    }

    public function destroy($id)
    {
        
        $drug = DrugTransaction::find($id);

        $drug->delete();

        DB::table('drug_transaction_histories')->where('drug_trans_id', $id)->delete();

        return back()->with('success', 'Transaction Deleted Successfully!!');
        
    }
}
