<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Picture;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $people = [
            [
                'name' => 'Budi Doe',
                'age' => 25,
                'location' => 'Jakarta',
                'pictures' => [
                    'https://picsum.photos/300?random=1',
                    'https://picsum.photos/300?random=2',
                ],
            ],
            [
                'name' => 'Michael Lee',
                'age' => 29,
                'location' => 'Bandung',
                'pictures' => [
                    'https://picsum.photos/300?random=3',
                    'https://picsum.photos/300?random=4',
                ],
            ],
            [
                'name' => 'Sarah Kim',
                'age' => 22,
                'location' => 'Surabaya',
                'pictures' => [
                    'https://picsum.photos/300?random=5',
                    'https://picsum.photos/300?random=6',
                ],
            ],
            [
                'name' => 'David Park',
                'age' => 31,
                'location' => 'Bali',
                'pictures' => [
                    'https://picsum.photos/300?random=7',
                    'https://picsum.photos/300?random=8',
                ],
            ],
            [
                'name' => 'Rachel Tan',
                'age' => 27,
                'location' => 'Medan',
                'pictures' => [
                    'https://picsum.photos/300?random=9',
                    'https://picsum.photos/300?random=10',
                ],
            ],
        ];

        foreach ($people as $p) {
            $person = Person::create([
                'name' => $p['name'],
                'age' => $p['age'],
                'location' => $p['location'],
            ]);

            foreach ($p['pictures'] as $pic) {
                Picture::create([
                    'person_id' => $person->id,
                    'url' => $pic,
                ]);
            }
        }
    }
}
