<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use App\Models\Viagens;
use Illuminate\Http\Request;
use App\Services\ViagensService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViagensServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_comum_so_pode_ver_as_suas_proprias_viagens()
    {
        $user = User::factory()->create(['role' => 'user']);
        Viagens::factory()->create(); // Viagem de outro user
        $minhaViagem = Viagens::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $service = new ViagensService();
        
        $resultado = $service->listarComFiltros(new Request());

        $this->assertCount(1, $resultado->items());
        $this->assertEquals($minhaViagem->id, $resultado->first()->id);
    }

    public function test_nao_e_possivel_cancelar_uma_viagem_que_ja_foi_aprovada()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $viagem = Viagens::factory()->create(['status' => 'aprovado']);
        
        $this->actingAs($admin);
        $service = new ViagensService();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Não é possível cancelar um pedido já aprovado.');

        $service->atualizarStatus($viagem->id, 'cancelado');
    }
}