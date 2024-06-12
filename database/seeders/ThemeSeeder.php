<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Theme::create([
            'name' => "Orange Store",
            'link' => "linkyi.shop/orange-store",
            'price' => 0,
            'thumbnail' => 'nothing.jpg',
            'is_premium' => 0,
            'is_active' => 1
        ]);
    }
}
