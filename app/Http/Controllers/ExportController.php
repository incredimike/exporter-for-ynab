<?php

namespace App\Http\Controllers;

use App\Budget\TransactionExporter;
use App\Budget\ExportCriteria;
use App\Budget\Services\YnabTransactionsExportService;
use App\Http\Requests\TransactionExportRequest;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function preview(
        TransactionExportRequest $request,
        TransactionExporter $exporter,
        ExportCriteria $criteria,
    ) {
        $token = config('budget.ynab_api_key'); // @todo update this with oauth token
        $criteria->fromRequestArray($request->validated());
        $exporter->setToken($token);
        $collection = $exporter->export($criteria);

        $transactions = $collection->flatten();

        return response()->json([
            'success' => true,
            'data' => [
                'transactions' => $transactions
            ]
        ]);
    }

    public function download(Request $request)
    {
        //
    }
}
