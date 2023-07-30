<?php

namespace App\Console\Commands;

use App\Budget\ExportCriteria;
use App\Budget\TransactionExporter;
use App\Exceptions\BudgetServiceConnectionException;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FetchTransactionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:fetch {startDate?}';


    protected $description = 'Fetch transactions from remote API';

    public function handle(
        TransactionExporter $exporter,
        ExportCriteria $criteria
    ): void {
        $token = config('budget.ynab_api_key'); // @todo update this with oauth token
        $exporter->setToken($token);
        $startDate = $this->argument('startDate') ?? now()->format('Y-m-01');
        $criteria->setStartDate($startDate);

        $table_header = [
            'Date',
            'Payee Name',
            'Amount',
            'Account Name',
            'Category Name',
            'Flag Color',
            'Approved?',
            'Cleared?',
            //'Memo',
        ];
        $this->info(sprintf(
            'Fetching transactions from %s beginning on %s ...',
            $exporter->getExportServiceName(),
            $startDate
        ));
        try {
            $transactions = $exporter->export($criteria)->flattenTransactions();
            $results = [];
            foreach ($transactions as $transaction) {
                $results[] = [
                    $transaction['date'],
                    $transaction['payee_name'],
                    $transaction['amount'],
                    $transaction['account_name'],
                    $transaction['category_name'],
                    $transaction['flag_color'],
                    $transaction['approved'],
                    $transaction['cleared'],
                    //$transaction['memo'],
                ];
            }
            $this->table(
                $table_header,
                $results,
                'box'
            );
            $this->info('Fetched ' . $transactions->count() . ' transactions from the API.');
        } catch (BudgetServiceConnectionException $e) {
            $this->error($e->getMessage());

            return;
        }
    }
}
