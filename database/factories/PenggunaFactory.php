<?php

namespace Database\Factories;

use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Pengguna>
 */
class PenggunaFactory extends Factory
{
    protected static ?string $kataSandi;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'nomor_wa' => '62812'.fake()->numerify('########'),
            'kata_sandi' => static::$kataSandi ??= Hash::make('password'),
            'peran' => 'client',
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $atribut): array => [
            'peran' => 'admin',
        ]);
    }
}
