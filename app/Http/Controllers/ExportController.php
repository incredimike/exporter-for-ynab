<?php

namespace App\Http\Controllers;

use App\Budget\ExportCriteria;
use App\Budget\Services\YnabBudgetExportService;
use App\Http\Requests\TransactionExportRequest;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function preview(TransactionExportRequest $request, ExportCriteria $criteria, YnabBudgetExportService $exporter )
    {
        // Populate the ExportCriteria object from $request
        // Create new BudgetExporter object with YnabApiService and Criteria object
        // Call export() method on the BudgetExporter object
        // Return a TransactionCollection with all transactions
        // Flatten subtranactions in TransactionCollection into an array of transactions.

        $startDate = $request->validated( 'start_date' );
        $exporter->setStartDate( $startDate );
        $exporter->setToken( env( 'YNAB_API_TOKEN', '' ) );
        $transactions = $exporter->execute();

        $data = [
            'transactions' => $transactions
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function download(Request $request)
    {
        // Populate the ExportCriteria object from $request
        // Create new BudgetExporter object with YnabApiService and Criteria object
        // Call export() method on the BudgetExporter object
        // Return a TransactionCollection with all transactions
        // Flatten subtranactions in TransactionCollection into an array of transactions.
        // Generate a CSV file from the array of transactions.
        // Send download back to the browser


//        return response()->streamDownload(function () {
//
//        }, 'laravel-readme.md');
        //echo "hello";
    }
}
