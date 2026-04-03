<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Viagens;
use App\Mail\StatusViagemAlterado;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViagemControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se a home redireciona corretamente
     */
    public function test_home_redireciona_para_dashboard(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('admin.dashboard'));
    }

    /**
     * Testa se o dashboard exige autenticação
     */
    public function test_dashboard_exige_login(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Testa se usuário autenticado acessa dashboard
     */
    public function test_usuario_logado_acessa_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Testa se o e-mail é disparado corretamente ao aprovar uma viagem.
     */
    public function test_deve_enviar_email_ao_aprovar_uma_viagem(): void
    {
        Mail::fake();
        
        $admin = User::factory()->create(['role' => 'admin']);
        $usuario = User::factory()->create();

        $viagem = Viagens::factory()->create([
            'user_id' => $usuario->id,
            'status' => 'solicitado'
        ]);

        $response = $this->actingAs($admin)
            ->patchJson(route('viagens.status', $viagem->id), [
                'status' => 'aprovado',
                'observacao' => 'Aprovado pelo sistema Jamino.'
            ]);

        $response->assertStatus(200)
                 ->assertJsonPath('message', 'Status atualizado com sucesso!');

        Mail::assertSent(StatusViagemAlterado::class, function ($mail) use ($usuario) {
            return $mail->hasTo($usuario->email);
        });
    }

    /**
     * Testa se usuários comuns são bloqueados ao tentar alterar status.
     */
    public function test_usuario_comum_nao_pode_alterar_status(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $viagem = Viagens::factory()->create();

        $response = $this->actingAs($user)
            ->patchJson(route('viagens.status', $viagem->id), [
                'status' => 'aprovado'
            ]);

        $response->assertStatus(403);
    }

    public function test_nao_deve_enviar_email_se_o_status_for_o_mesmo()
    {
        Mail::fake();
        
        $admin = User::factory()->create(['role' => 'admin']);
        // Criamos a viagem como 'aprovado'
        $viagem = Viagens::factory()->create(['status' => 'aprovado']);

        // Tentamos dar um patch para 'aprovado' de novo
        $response = $this->actingAs($admin)->patchJson(route('viagens.status', $viagem->id), [
            'status' => 'aprovado',
            'observacao' => 'Teste'
        ]);

        $response->assertStatus(200);
        Mail::assertNothingSent(); // Agora não tem como falhar!
    }

}