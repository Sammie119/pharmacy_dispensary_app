<?php

namespace App\Http\Controllers;

use App\Models\DrugTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DrugTransactionHistory;
use App\Models\Refund;

class ReportController extends Controller
{
    public function index()
    {
        return view('report');
    }

    public function getReport(Request $request)
    {
        $report = [
            'report_type' => $request->report_type,
            'date_from' => $request->report_from,
            'date_to' => $request->report_to,
        ];
        switch ($request->report_type) {
            case 'users':
                $query = DrugTransactionHistory::selectRaw("updated_by, sum(unit_price * quantity) as amount")
                                                ->whereRaw("DATE(created_at) BETWEEN '$request->report_from' AND '$request->report_to'")
                                                // ->whereRaw('created_at', [$request->report_from, $request->report_to])
                                                ->groupBy('updated_by')->get();
                // return 'Users Report';
                // dd($query);
                
                break;

            case 'drugs':
                // return 'Drugs Report';
                $query = DrugTransactionHistory::selectRaw("drug_name, sum(quantity) as quantity, sum(unit_price * quantity) as amount")
                                                ->whereRaw("DATE(created_at) BETWEEN '$request->report_from' AND '$request->report_to'")
                                                // ->whereRaw('created_at', [$request->report_from, $request->report_to])
                                                ->groupBy('drug_name')->get();
                // dd($query);
                break;

            case 'accounts':
                // return 'Accounts Report';
                $query_1 = DrugTransaction::selectRaw("sum(amount) as amount, updated_by")
                                                ->whereRaw("DATE(created_at) BETWEEN '$request->report_from' AND '$request->report_to'")
                                                // ->whereRaw('created_at', [$request->report_from, $request->report_to])
                                                ->groupBy('updated_by')->get();

                $refund = Refund::selectRaw("sum(amount) as amount, receipt_no, updated_by")
                                        ->whereRaw("DATE(created_at) BETWEEN '$request->report_from' AND '$request->report_to'")
                                        // ->whereRaw('created_at', [$request->report_from, $request->report_to])
                                        ->groupBy('updated_by', 'receipt_no')->get();
                
                $query = ['query' => $query_1, 'refund' => $refund];
                    
                // dd($query);
                break;
            
            default:
                return 'No report Selected';
                break;
        }
        // dd($query);
        return view('print_report', ['report' => $report, 'query' => $query]);
    }
}
