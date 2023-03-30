<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DrugTransaction;
use App\Models\Refund;

class BillsController extends Controller
{
    public function index() 
    {
        $trans = DrugTransaction::orderByDesc('id')->where('paid', 0)->limit(500)->get();
        return view('bills', ['transactions' => $trans]);
    }

    public function receivePayment($receipt_no)
    {
        DrugTransaction::where('receipt_no', $receipt_no)->update(
            [
                'paid' => 1, 
                'updated_by' => Auth()->user()->id
            ]);
        return redirect('payments')->with('success', 'Payment Received Successfully!!!'); 
    }

    public function payment_list() 
    {
        $trans = DrugTransaction::orderByDesc('id')->where('paid', 1)->limit(500)->get();
        return view('bills_payment_list', ['transactions' => $trans]);
    }

    public function refundBill(Request $request)
    {
        $refund = new Refund;
        $refund->receipt_no = $request->receipt_no;
        $refund->amount = $request->amount;
        $refund->created_by = Auth()->user()->id;
        $refund->updated_by = Auth()->user()->id;

        $refund->save();
        return redirect('payment_list')->with('success', 'Refund Entered Successfully!!!'); 
    }
}
