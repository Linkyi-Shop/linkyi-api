<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition()
    {
        return [
            'id' => (string) Str::uuid(), // Menggunakan UUID untuk 'id'
            'user_id' => \App\Models\User::factory(), // Relasi dengan User
            'name' => $this->faker->company, // Nama toko (random company name)
            'slug' => $this->faker->slug, // Slug toko (slug random)
            'logo' => $this->faker->imageUrl(100, 100, 'business', true, 'Faker'), // Gambar logo (random URL image)
            'description' => $this->faker->sentence, // Deskripsi toko (random sentence)
        ];
    }
}
