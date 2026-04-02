<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Viagens;
use App\Mail\StatusViagemAlterado;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusViagemAlteradoTest extends TestCase
{
    use RefreshDatabase;

    public function test_mailable_escolhe_o_template_de_aprovacao_corretamente()
    {
        $viagem = Viagens::factory()->make(['status' => 'aprovado']);
        $mailable = new StatusViagemAlterado($viagem);

        $this->assertEquals('emails.viagem.aprovada', $mailable->build()->view);
        $this->assertStringContainsString('Aprovado', $mailable->build()->subject);
    }
}