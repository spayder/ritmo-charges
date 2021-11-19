<?php

namespace App\Services;

use App\Jobs\FetchChargesJob;
use Carbon\CarbonPeriod;

class ChargesService
{
    public function handle()
    {
        // those probably we will allow to be selected by user and passed from controller
        $startDate = now()->subYears(2)->startOfDay();
        $endDate = now()->subDay()->startOfDay();

        $this->loadCharges(CarbonPeriod::create($startDate, $endDate));
    }

    private function loadCharges(CarbonPeriod $period)
    {
        // Iterate over the period
        foreach ($period as $date) {
            // dispatch every job as a new worker and add to the queue
            dispatch(new FetchChargesJob($date));
            dump('The job for fetching charges for ' . $date->format('Y-m-d') . ' has been added to the queue');
        }
    }
}
