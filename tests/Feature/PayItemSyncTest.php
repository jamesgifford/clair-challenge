<?php

namespace Tests\Feature;

use App\Jobs\PayItemSync;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PayItemSyncTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_job_with_existing_business()
    {
        $this->withoutExceptionHandling();

        Bus::fake();

        $this->artisan('pay-item:sync 1')
            ->assertExitCode(0);

        Bus::assertDispatched(PayItemSync::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_job_with_non_existing_business()
    {
        $this->withoutExceptionHandling();

        Bus::fake();

        $this->artisan('pay-item:sync 1000')
            ->assertExitCode(0);

        Bus::assertNotDispatched(PayItemSync::class);
    }
}
