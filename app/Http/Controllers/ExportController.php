<?php

namespace App\Http\Controllers;

use App\Budget\TransactionExporter;
use App\Budget\ExportCriteria;
use App\Budget\Services\YnabBudgetExportService;
use App\Http\Requests\TransactionExportRequest;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function preview(
        TransactionExportRequest $request,
        TransactionExporter $exporter,
        ExportCriteria $criteria,
    ) {
        $token = env('YNAB_API_TOKEN', ''); // @todo update this with oauth token
        $criteria->fromRequestArray($request->validated());
        $exporter->setToken($token);
        $collection = $exporter->export($criteria);

        $transactions = $collection->flattenTransactions()->toArray();
        //$transactions = $transactionCollection->toArray();

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
