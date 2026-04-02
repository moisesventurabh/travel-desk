<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TravelOrderFactory extends Factory
{
    /**
     * Define o estado padrão do modelo.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Cria um usuário automaticamente se não for fornecido
            'requester_name' => $this->faker->name(),
            'destination' => $this->faker->city(),
            'departure_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'return_date' => $this->faker->dateTimeBetween('+1 month', '+2 months')->format('Y-m-d'),
            'status' => 'solicitado', // Valor padrão conforme o seu ENUM em português
        ];
    }
}