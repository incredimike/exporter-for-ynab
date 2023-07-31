<?php

namespace Tests\Unit;

use App\Exceptions\BudgetConnectionException;
use App\Factories\BudgetAccountFactory;
use App\Factories\BudgetCategoryFactory;
use App\Factories\BudgetFactory;
use App\Factories\BudgetPayeeFactory;
use App\Factories\TransactionFactory;
use App\Repositories\YnabBudgetRepository;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class YnabBudgetRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    private TransactionFactory $transactionFactory;

    public function setUp(): void
    {
        parent::setUp();
        $this->accountFactory  = $this->app->make(BudgetAccountFactory::class);
        $this->budgetFactory   = $this->app->make(BudgetFactory::class);
        $this->categoryFactory = $this->app->make(BudgetCategoryFactory::class);
        $this->payeeFactory    = $this->app->make(BudgetPayeeFactory::class);

        Http::preventStrayRequests();
    }

    /**
     * @throws BudgetConnectionException
     */
    public function testCanFetchAccounts(): void
    {
        $budgetId = 'last-used';
        $count = 5;
        Http::fake([
            "https://api.ynab.com/v1/budgets/{$budgetId}/accounts" => Http::response($this->generateResponseArray(
                'accounts',
                $this->accountFactory->count($count)->make()
            ))
        ]);
        $repository = new YnabBudgetRepository();
        $repository->setBudgetId($budgetId);
        $response = $repository->getAccounts();

        $this->assertIsArray($response);
        $this->assertCount($count, $response);
    }

    /**
     * @throws BudgetConnectionException
     */
    public function testCanFetchBudgets(): void
    {
        $count = 3;
        Http::fake([
            "https://api.ynab.com/v1/budgets*" => Http::response($this->generateResponseArray(
                'budgets',
                $this->budgetFactory->count($count)->make()
            ))
        ]);
        $repository = new YnabBudgetRepository();
        $response = $repository->getBudgets();

        $this->assertIsArray($response);
        $this->assertCount($count, $response);
    }

    /**
     * @throws BudgetConnectionException
     */
    public function testCanFetchCategories(): void
    {
        $budgetId = 'last-used';
        $count = 10;
        Http::fake([
            "https://api.ynab.com/v1/budgets/{$budgetId}/categories" => Http::response($this->generateResponseArray(
                'categories',
                $this->categoryFactory->count($count)->make()
            ))
        ]);
        $repository = new YnabBudgetRepository();
        $repository->setBudgetId($budgetId);
        $response = $repository->getCategories();

        $this->assertIsArray($response);
        $this->assertCount($count, $response);
    }

    /**
     * @throws BudgetConnectionException
     */
    public function testCanFetchPayees(): void
    {
        $budgetId = 'last-used';
        $count = 10;
        Http::fake([
            "https://api.ynab.com/v1/budgets/{$budgetId}/payees" => Http::response($this->generateResponseArray(
                'payees',
                $this->payeeFactory->count($count)->make()
            ))
        ]);
        $repository = new YnabBudgetRepository();
        $repository->setBudgetId($budgetId);
        $response = $repository->getPayees();

        $this->assertIsArray($response);
        $this->assertCount($count, $response);
    }

    protected function generateResponseArray(string $key, array $data): array
    {
        return [
            'data' => [
                $key => $data,
                'server_knowledge' => fake()->numberBetween(10000, 99999)
            ]
        ];
    }
}
