<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $persons = Person::all();

        foreach ($persons as $index => $person) {

            // Person pertama dibuat popular (>= 50 likes)
            $likesToCreate = ($index == 0) ? 55 : rand(5, 20);

            for ($i = 1; $i <= $likesToCreate; $i++) {
                Like::create([
                    'person_id' => $person->id,
                    'user_id'   => $i,
                    'is_like'   => true,
                ]);
            }
        }
    }
}
