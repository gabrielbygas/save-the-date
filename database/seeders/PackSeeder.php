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
            ['name' => '1 affiche', 'price' => 15],
            ['name' => '1 video', 'price' => 25],
            ['name' => '1 site web (QR CODE)', 'price' => 50],
            ['name' => 'TOUT INCLUS', 'price' => 80],
        ]);

    }
}