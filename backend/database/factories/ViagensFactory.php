<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Viagens;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViagensFactory extends Factory
{
    protected $model = Viagens::class;

    public function definition(): array
    {
        return [
            'solicitante' => $this->faker->name,
            'origem' => $this->faker->city,
            'destino' => $this->faker->city,
            'data_ida' => now()->addDays(5),
            'data_volta' => now()->addDays(10),
            'status' => 'solicitado',
            'user_id' => User::factory(),
            'enabled' => true,
        ];
    }
}