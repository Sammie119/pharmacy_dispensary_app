<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DrugTransactionHistory;

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
                                                ->whereBetween(DB::raw('created_at'), [$request->report_from, $request->report_to])
                                                ->groupBy('updated_by')->get();
                // return 'Users Report';
                // dd($query);
                
                break;

            case 'drugs':
                // return 'Drugs Report';
                $query = DrugTransactionHistory::selectRaw("drug_name, sum(quantity) as quantity, sum(unit_price * quantity) as amount")
                                                ->whereBetween(DB::raw('created_at'), [$request->report_from, $request->report_to])
                                                ->groupBy('drug_name')->get();
                // dd($query);
                break;
            
            default:
                return 'No report Selected';
                break;
        }

        return view('print_report', ['report' => $report, 'query' => $query]);
    }
}
