<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $user=User::factory()->create([
            'name'=>'john doe',
            'email'=>'admin@test.com'
        ]);
        Listing::factory(6)->create([
            'user_id'=>$user->id
        ]);
        // Listing::create([
        //     'title'=> 'listing one',
        //     'tags'=> 'laravel, java',
        //     'company'=> 'acme corp',
        //     'location'=>'what so ever',
        //     'email'=> 'email1@email.com',
        //     'website'=> 'http://www.google.com',
        //     'description'=>'Lorem, ipsum dolor sit amet consectetur adipisicing 
        //     elit. Ipsa dolore iure, modi sint quibusdam consequatur soluta vel 
        //     necessitatibus odio itaque earum sit? Deserunt earum asperiores 
        //     ducimus consequuntur odio dolorem nihil.'
        // ]);
        // Listing::create([
        //     'title'=> 'listing one',
        //     'tags'=> 'laravel, java',
        //     'company'=> 'acme corp',
        //     'location'=>'what so ever',
        //     'email'=> 'email1@email.com',
        //     'website'=> 'http://www.google.com',
        //     'description'=>'Lorem, ipsum dolor sit amet consectetur adipisicing 
        //     elit. Ipsa dolore iure, modi sint quibusdam consequatur soluta vel 
        //     necessitatibus odio itaque earum sit? Deserunt earum asperiores 
        //     ducimus consequuntur odio dolorem nihil.'
        // ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
