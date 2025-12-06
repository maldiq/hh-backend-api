<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\NotifyPopularPeople;

class RunPopularPeopleNotification extends Command
{
    protected $signature = 'notify:popular';
    protected $description = 'Run notify popular people';

    public function handle()
    {
        NotifyPopularPeople::dispatch();
        $this->info("Job NotifyPopularPeople dispatched.");
    }
}