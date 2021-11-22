<?php

namespace Tests\Unit;

use App\Services\SyncService;
use Illuminate\Support\Facades\Http;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\MockSyncService;

class SyncServiceTest extends TestCase
{
    /**
     *Test a 401 response from the api.
     *
     * @return void
     */
    public function test_call_api_with_401()
    {
        Http::fake([
            '*' => Http::response('Testing', 401),
        ]);

        $mock = Mockery::mock(SyncService::class)->makePartial();
        $mock->shouldReceive('callApi')
            ->once()
            ->with(1)
            ->willThrowException(new Exception('Unauthorized');

        $mockResult = $mock->callApi(1);

        $mock->shouldHaveReceived('callApi');
    }

    /**
     * Test a 404 response from the api.
     *
     * @return void
     */
    public function test_call_api_with_404()
    {
        Http::fake([
            '*' => Http::response('Testing', 404),
        ]);

        $mock = Mockery::mock(SyncService::class)->makePartial();
        $mock->shouldReceive('callApi')
            ->once()
            ->with(1)
            ->willThrowException(new Exception('No business found');

        $mockResult = $mock->callApi(1);

        $mock->shouldHaveReceived('callApi');
    }

    /**
     * Test a 200 response from the api.
     *
     * @return void
     */
    public function test_call_api_with_200()
    {
        Http::fake([
            '*' => Http::response(json_encode(['payItems' => []]), 200),
        ]);

        $mock = Mockery::mock(SyncService::class)->makePartial();
        $mock->shouldReceive('callApi')
            ->once()
            ->with(1);

        $mockResult = $mock->callApi(1);

        $mock->shouldHaveReceived('callApi');
    }
}
