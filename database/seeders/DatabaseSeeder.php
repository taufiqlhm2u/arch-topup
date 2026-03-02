<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Arch',
            'email' => 'arch@topup.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // game
        Game::create([
            'name' => 'Mobile Legend',
            'image' => 'games/mobile-legend.webp',
            'publisher' => 'Montoon',
            'server_id' => true,
            'badge' => 'populer'
        ]);

        Game::create([
            'name' => 'Free Fire',
            'image' => 'games/ff.png',
            'publisher' => 'Garena',
            'server_id' => false,
            'badge' => 'populer'
        ]);

        Game::create([
            'name' => 'PUBG Mobile',
            'image' => 'games/pubg.png',
            'publisher' => 'Tencent',
            'server_id' => false,
        ]);

        Game::create([
            'name' => 'Call Of Duty Mobile',
            'image' => 'games/codm.jpg',
            'publisher' => 'Garena',
            'server_id' => false,
        ]);

        // Game::create([
        //     'name' => 'Valorant',
        //     'image' => 'games/valorant.webp',
        //     'publisher' => 'Riot Games',
        //     'server_id' => false,
        // ]);

        // Game::create([
        //     'name' => 'Genshin Impact',
        //     'image' => 'games/genshin-impact.webp',
        //     'publisher' => 'miHoYo',
        //     'server_id' => false,
        //     'badge' => 'flash sale'
        // ]);
    }
}
