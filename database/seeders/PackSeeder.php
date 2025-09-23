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
            ['name' => 'Affiche', 'price' => 15],
            ['name' => 'Vidéo', 'price' => 25],
            ['name' => 'Invitation', 'price' => 50],
            ['name' => 'Site web (QR CODE)', 'price' => 50],
            ['name' => 'TOUT INCLUS', 'price' => 120],
        ]);

    }
}