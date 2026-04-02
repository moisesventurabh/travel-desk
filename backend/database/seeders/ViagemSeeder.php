<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Viagens;
use Illuminate\Database\Seeder;

class ViagemSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Garantindo que os usuários existam para o relacionamento
        $moises = User::firstOrCreate(
            ['email' => 'moises@jamino.com'],
            ['name' => 'Moisés Ventura', 'password' => bcrypt('password')]
        );

        $camilla = User::firstOrCreate(
            ['email' => 'camilla@jamino.com'],
            ['name' => 'Camilla Nicolau', 'password' => bcrypt('password')]
        );

        // 2. Criando viagens com diferentes status para testar os filtros
        
        // Viagem Aprovada (Moisés)
        Viagens::create([
            'user_id'     => $moises->id,
            'solicitante' => $moises->name,
            'destino'     => 'Lisboa, Portugal',
            'data_ida'    => Carbon::now()->addDays(15),
            'data_volta'  => Carbon::now()->addDays(25),
            'status'      => 'aprovado',
        ]);

        // Viagem Pendente (Camilla)
        Viagens::create([
            'user_id'     => $camilla->id,
            'solicitante' => $camilla->name,
            'destino'     => 'Buenos Aires, Argentina',
            'data_ida'    => Carbon::now()->addDays(5),
            'data_volta'  => Carbon::now()->addDays(10),
            'status'      => 'solicitado',
        ]);

        // Viagem Cancelada (Moisés)
        Viagens::create([
            'user_id'     => $moises->id,
            'solicitante' => $moises->name,
            'destino'     => 'Tóquio, Japão',
            'data_ida'    => Carbon::now()->subDays(10),
            'data_volta'  => Carbon::now()->subDays(2),
            'status'      => 'cancelado',
        ]);
    }
}