<?php

namespace Tests\Unit;

use App\Exceptions\BudgetAuthorizationException;
use App\Exceptions\BudgetConnectionException;
use App\Exceptions\BudgetRateLimitException;
use App\Factories\BudgetAccountFactory;
use App\Factories\BudgetCategoryFactory;
use App\Factories\BudgetFactory;
use App\Factories\BudgetPayeeFactory;
use App\Repositories\YnabBudgetRepository;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class YnabBudgetRepositoryTest extends TestCase
{
    private BudgetAccountFactory $accountFactory;
    private BudgetFactory $budgetFactory;
    private BudgetCategoryFactory $categoryFactory;
    private BudgetPayeeFactory $payeeFactory;


    public function setUp(): void
    {
        parent::setUp();
        Http::preventStrayRequests();
        $this->accountFactory  = $this->app->make(BudgetAccountFactory::class);
        $this->budgetFactory   = $this->app->make(BudgetFactory::class);
        $this->categoryFactory = $this->app->make(BudgetCategoryFactory::class);
        $this->payeeFactory    = $this->app->make(BudgetPayeeFactory::class);
    }

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
        $response = $repository->fetchAccounts();

        $this->assertIsArray($response);
        $this->assertCount($count, $response);
    }

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
        $response = $repository->fetchBudgets();

        $this->assertIsArray($response);
        $this->assertCount($count, $response);
    }

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
        $response = $repository->fetchCategories();

        $this->assertIsArray($response);
        $this->assertCount($count, $response);
    }

    /**
     * @throws BudgetConnectionException
     */
    public function testFetchPayees(): void
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
        $response = $repository->fetchPayees();

        $this->assertIsArray($response);
        $this->assertCount($count, $response);
    }

    public function testHandlesHttp500Error(): void
    {
        Http::fake([
            'https://api.ynab.com/v1/budgets*' => Http::response(null, 500)
        ]);

        $repository = new YnabBudgetRepository();

        $this->expectException(BudgetConnectionException::class);
        $repository->fetchBudgets();
    }

    public function testHandlesHttp401UnauthorizedRequest(): void
    {
        Http::fake([
            'https://api.ynab.com/v1/budgets*' => Http::response([], 401)
        ]);

        $repository = new YnabBudgetRepository();

        $this->expectException(BudgetAuthorizationException::class);
        $repository->fetchBudgets();
    }

    public function testHandlesHttp403SubscriptionIssue(): void
    {
        Http::fake([
            'https://api.ynab.com/v1/budgets*' => Http::response([], 403)
        ]);

        $repository = new YnabBudgetRepository();

        $this->expectException(BudgetAuthorizationException::class);
        $repository->fetchBudgets();
    }

    public function testHandlesHttp429RateLimitingError(): void
    {
        Http::fake([
            'https://api.ynab.com/v1/budgets*' => Http::response(
                [
                    'error' => [
                        'id' => fake()->word(),
                        'name' => 'Rate limit exceeded',
                        'detail' => 'Rate limit exceeded',
                    ]
                ],
                429
            )
        ]);

        $repository = new YnabBudgetRepository();

        $this->expectException(BudgetRateLimitException::class);
        $repository->fetchBudgets();
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
