<?php

namespace App\Jobs;

use App\Models\Business;
use App\Contracts\SyncServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayItemSync implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The business instance.
     *
     * @var \App\Models\Business
     */
    protected $business;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Business $business)
    {
        $this->business = $business;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SyncServiceInterface $syncService)
    {
        DB::beginTransaction();

        try {
            $syncService->sync($this->business);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->fail();
        }

        DB::commit();
    }
}
