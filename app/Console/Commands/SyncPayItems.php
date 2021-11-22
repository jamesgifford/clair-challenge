<?php

namespace App\Console\Commands;

use App\Jobs\PayItemSync;
use App\Models\Business;
use Illuminate\Console\Command;

class SyncPayItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pay-item:sync {business}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs pay items for a specified business';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $business = Business::findOrFail($this->argument('business'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error("Business not found");
        } catch (\Exception $e) {
            return $this->error("An error occurred");
        }

        PayItemSync::dispatch($business);
        $this->info("Pay items synced");

        return Command::SUCCESS;
    }
}
