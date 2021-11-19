<?php

namespace App\Jobs;

use Carbon\CarbonInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchChargesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var CarbonInterface
     */
    private $date;
    /**
     * @var int
     */
    private $perPage;

    public function __construct(CarbonInterface $date, int $perPage = 10)
    {
        $this->date = $date;
        $this->perPage = $perPage;
    }

    public function handle()
    {
        dump('Starting fetching charges for ' . $this->date->format('Y-m-d'));
        $this->fetchCharges();
        dump('Finished fetching charges for ' . $this->date->format('Y-m-d'));
    }

    private function fetchCharges()
    {
        $stripe = new \Stripe\StripeClient(
            config('stripe.secret_key')
        );

        $startDateTime = $this->date->unix();
        $endDateTime = $this->date->addDay()->unix();

        $params = [
            'limit' => $this->perPage,
            'created' => ['gte' => $startDateTime, 'lt' => $endDateTime]
        ];
        $charges = $stripe->charges->all($params);
        $i = 1;

        dump('Iteration #' . $i);
        dump($charges);

        while($charges->has_more) {
            $params['starting_after'] = $charges->data[$this->perPage - 1]->id;

            $charges = $stripe->charges->all($params);
            $i++;
            dump('Iteration #' . $i);
            dump($charges);
        }
    }
}
