<?php

namespace App\Contracts;

use App\Models\Business;

interface SyncServiceInterface
{
    public function sync(Business $business);

    public function callApi(int $page);
}
