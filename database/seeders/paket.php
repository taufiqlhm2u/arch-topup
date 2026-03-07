<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class paket extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $packages = [

        // Mobile Legends
        ['game_id'=>1,'image'=>'packages/diamond.webp','type'=>'Diamond','quantity'=>86,'price'=>22000],
        ['game_id'=>1,'image'=>'packages/diamond.webp','type'=>'Diamond','quantity'=>172,'price'=>44000],
        ['game_id'=>1,'image'=>'packages/diamond.webp','type'=>'Diamond','quantity'=>257,'price'=>66000],
        ['game_id'=>1,'image'=>'packages/diamond.webp','type'=>'Diamond','quantity'=>514,'price'=>128000],
        ['game_id'=>1,'image'=>'packages/ml-pass.webp','type'=>'Weekly Pass','quantity'=>1,'price'=>30000],

        // Free Fire
        ['game_id'=>2,'image'=>'packages/diamond.webp','type'=>'Diamond','quantity'=>70,'price'=>10000],
        ['game_id'=>2,'image'=>'packages/diamond.webp','type'=>'Diamond','quantity'=>140,'price'=>19000],
        ['game_id'=>2,'image'=>'packages/diamond.webp','type'=>'Diamond','quantity'=>355,'price'=>47000],
        ['game_id'=>2,'image'=>'packages/ff-minggu.webp','type'=>'Membership Mingguan','quantity'=>1,'price'=>30000],
        ['game_id'=>2,'image'=>'packages/ff-bulan.webp','type'=>'Membership Bulanan','quantity'=>1,'price'=>80000],

        // PUBG Mobile
        ['game_id'=>3,'image'=>'packages/uc.webp','type'=>'UC','quantity'=>60,'price'=>15000],
        ['game_id'=>3,'image'=>'packages/uc.webp','type'=>'UC','quantity'=>180,'price'=>42000],
        ['game_id'=>3,'image'=>'packages/uc.webp','type'=>'UC','quantity'=>325,'price'=>74000],
        ['game_id'=>3,'image'=>'packages/uc.webp','type'=>'UC','quantity'=>660,'price'=>148000],
        ['game_id'=>3,'image'=>'packages/uc.webp','type'=>'UC','quantity'=>1800,'price'=>360000],

        // CODM
        ['game_id'=>4,'image'=>'packages/cp.png','type'=>'CP','quantity'=>80,'price'=>15000],
        ['game_id'=>4,'image'=>'packages/cp.png','type'=>'CP','quantity'=>420,'price'=>75000],
        ['game_id'=>4,'image'=>'packages/cp.png','type'=>'CP','quantity'=>880,'price'=>149000],
        ['game_id'=>4,'image'=>'packages/cp.png','type'=>'CP','quantity'=>2400,'price'=>360000],
        ['game_id'=>4,'image'=>'packages/cp.png','type'=>'CP','quantity'=>5000,'price'=>720000],
    ];

    foreach ($packages as $package) {
        Package::create($package);
    }

    }
}
