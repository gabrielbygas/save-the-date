<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('themes')->insert([
            ['name' => 'Boho Chic', 'style' => 'Nature, beige, fleurs'],
            ['name' => 'Minimaliste Moderne', 'style' => 'Noir et blanc, sobre'],
            ['name' => 'Rustique', 'style' => 'Bois, rétro, vintage'],
            ['name' => 'Tropical Paradise', 'style' => 'Palmiers, couleurs vives'],
            ['name' => 'Pastel Romantique', 'style' => 'Rose, lavande, doux'],
            ['name' => 'Luxe Glam', 'style' => 'Doré, noir, élégant'],
            ['name' => 'Méditerranéen', 'style' => 'Bleu, blanc, Grèce vibes'],
            ['name' => 'Classique intemporel', 'style' => 'Blanc, argent, perle'],
            ['name' => 'Industriel Urbain', 'style' => 'Béton, métal, moderne'],
            ['name' => 'Cinématique', 'style' => 'Inspiré film & affiche 🎬'],
        ]);

    }
}