<?php

namespace App\Http\Controllers;

use App\Models\Drug;
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
                
            default:
                return "No Form Selected";
                break;
        }
    }

    public function getViewModalData($data, $id)
    {
        switch ($data) {
            
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
            
            default:
                return "No Form Selected";
                break;
        }
    }
}
