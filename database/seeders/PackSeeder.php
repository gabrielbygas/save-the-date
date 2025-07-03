<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;  
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // database/seeders/PackSeeder.php
        DB::table('packs')->insert([
            ['name' => '1 affiche', 'price' => 25],
            ['name' => '2 affiches', 'price' => 35],
            ['name' => '4 affiches + vidéo', 'price' => 50],
        ]);

    }
}