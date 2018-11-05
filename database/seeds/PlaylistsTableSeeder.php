<?php

use Illuminate\Database\Seeder;

use App\Playlist;
use App\Song;
use App\User;

class PlaylistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 5; $i++) { 
           $user = User::inRandomOrder()->first();
           $playlist = Playlist::create([
                'name' => "Playlist $i",
                'user_id' => $user->id,
                'cover' => '/images/default_icon.png',
            ]);
        }
    }
}
