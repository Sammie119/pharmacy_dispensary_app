<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\DrugTransaction;
use App\Models\DrugTransactionHistory;
use App\Models\User;
use Illuminate\Http\Request;

class FormRequestController extends Controller
{
    public function getCreateModalData($data)
    {
        switch ($data) {
            case 'new_user':
                return view('forms.input.user_form');
                break;

            case 'new_drug':
                return view('forms.input.drug_form');
                break;

            case 'drug_transaction':
                return view('forms.input.drug_transaction_form');
                break;

            default:
                return "No Form Selected";
                break;
        }
    }

    public function getEditModalData($data, $id)
    {
        switch ($data) {
            case 'edit_user':
                $user = User::find($id);
                return view('forms.input.user_form', ['user' => $user]);
                break;

            case 'edit_drug':
                $drug = Drug::find($id);
                return view('forms.input.drug_form', ['drug' => $drug]);
                break;

            case 'edit_drug_transaction':
                if(DrugTransaction::find($id)->paid === 0){
                    $drugs = DrugTransactionHistory::where('drug_trans_id', $id)->get();
                    return view('forms.input.drug_transaction_form', ['drugs' => $drugs]);
                } else {
                    return "<h3>Patient has made payment. So, editting can't be done!!!!</h3>";
                }
                
                break;
                
            default:
                return "No Form Selected";
                break;
        }
    }

    public function getViewModalData($data, $id)
    {
        switch ($data) {
            case 'view_drug_transaction':
                $drugs = DrugTransactionHistory::where('drug_trans_id', $id)->get();
                return view('forms.view.view_drug_transaction_form', ['drugs' => $drugs]);
            default:
                return "No Form Selected";
                break;
        }
    }

    public function getDeleteModalData($data, $id)
    {
        switch ($data) {
            case 'delete_user':
                return view('forms.delete.delete-user', ['id' => $id]);
                break;

            case 'delete_drug':
                return view('forms.delete.delete-drug', ['id' => $id]);
                break;

            case 'delete_drug_transaction':
                if(DrugTransaction::find($id)->paid === 0){
                    return view('forms.delete.delete-drug_transaction', ['id' => $id]);
                } else {
                    return "<h3>Patient has made payment. So, Record can't be deleted!!!!</h3>";
                }
                
                break;
            
            default:
                return "No Form Selected";
                break;
        }
    }

    public function getPaymentModalData($data, $receipt_no)
    {
        switch ($data) {
            case 'bill_payment':
                return view('forms.payments.bill_payment', ['receipt_no' => $receipt_no]);
                break;

            case 'refund_bill':
                return view('forms.payments.refund_bill', ['receipt_no' => $receipt_no]);
                break;
            
            default:
                return "No Form Selected";
                break;
        }
    }
}
