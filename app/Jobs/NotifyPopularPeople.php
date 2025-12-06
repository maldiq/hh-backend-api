<?php

namespace App\Jobs;

use App\Models\Person;
use App\Mail\PopularPersonNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyPopularPeople implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $popularPeople = Person::withCount([
            'likes as likes_count' => function ($q) {
                $q->where('is_like', true);
            }
        ])->get()->filter(function ($p) {
            return $p->likes_count > 50;
        });

        if ($popularPeople->isEmpty()) {
            return;
        }

        foreach ($popularPeople as $person) {
            Mail::to("datasementarafelix@gmail.com")
                ->send(new PopularPersonNotification($person));
        }
    }
}
