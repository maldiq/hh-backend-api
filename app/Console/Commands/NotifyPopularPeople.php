<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Person;
use App\Mail\PopularPersonNotification;
use Illuminate\Support\Facades\Mail;

class NotifyPopularPeople extends Command
{    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'likes:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify admin if someone got liked more than 50 times';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = 50;
        $people = Person::withCount(['likes as likes_count' => function($q){
            $q->where('is_like', true);
        }])->having('likes_count','>',$threshold)->get();

        if ($people->isEmpty()) {
            $this->info('No popular people found.');
            return 0;
        }

        foreach ($people as $p) {
            Mail::to(config('mail.admin_email','datasementarafelix@gmail.com'))->send(new PopularPersonNotification($p));
            $this->info("Notified admin about person id {$p->id} ({$p->name}) count {$p->likes_count}");
        }
        return 0;
    }
}
