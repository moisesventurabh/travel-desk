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
            'origem'      => $this->faker->city,
            'destino'     => $this->faker->city,
            'data_ida'    => $this->faker->dateTimeBetween('now', '+1 month'),
            'data_volta'  => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'status'      => $this->faker->randomElement(['solicitado', 'aprovado', 'cancelado']),
            'user_id'     => User::factory(),
            'enabled'     => 1,
        ];
    }
}