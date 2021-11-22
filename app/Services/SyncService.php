<?php

namespace App\Services;

use App\Contracts\SyncServiceInterface;
use App\Models\Business;
use App\Models\Employment;
use App\Models\PayItem;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncService implements SyncServiceInterface
{
    /**
     * The business model
     */
    protected $business;

    /**
     * Sync pay items for a business
     */
    public function sync(Business $business)
    {
        $this->business = $business;

        $page = 1;
        $payItemIds = [];

        do {
            $response = $this->callApi($page++);
            $json = $response->json();
            $data = json_decode($json);

            foreach ($data->payItems as $item) {
                try {
                    $employment = Employment::where('external_id', $item->employeeId)->firstOrFail();
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    continue;
                }

                $payItem = PayItem::where('user_id', $employment->user_id)
                    ->where('business_id', $employment->business_id)
                    ->where('external_id', $item->id)
                    ->firstOrNew();

                $deductionPercentage = ($employment->business->deduction ?: 30) / 100;

                $payItem->pay_rate = $item->payRate;
                $payItem->hours = $item->hoursWorked;
                $payItem->paid_at = $item->date;
                $payItem->amount = round($item->hoursWorked * $item->payRate * $deductionPercentage, 2);
                $payItem->save();

                $payItemIds[] = $payItem->id;
            }
        } while ($data->isLastPage == false);

        // Delete any pay items for the business that weren't updated/created
        PayItem::whereNotIn('id', $payItemIds)
            ->where('business_id', $this->business->id)
            ->delete();
    }

    /**
     * Call the api
     */
    public function callApi(int $page)
    {
        try {
            $response = Http::acceptJson()->withHeaders([
                'x-api-key' => env("SYNC_API_KEY"),
            ])->get(env("SYNC_API_ENDPOINT") . $this->business->external_id, [
                'page' => $page,
            ]);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::alert('Invalid url');
            throw new \Exception('Invalid url');
        }

        if ($response->status() == 401) {
            Log::alert('Unauthorized');
            throw new \Exception('Unauthorized');
        }

        if ($response->status() == 404) {
            Log::critical('No business found');
            throw new \Exception('No business found');
        }

        if (!$response->successful()) {
            Log::critical('Unsuccessful');
            throw new \Exception('Unsuccessful');
        }

        return $response;
    }
}
