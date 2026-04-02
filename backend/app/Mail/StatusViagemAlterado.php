<?php
namespace App\Mail;

use App\Models\Viagens;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusViagemAlterado extends Mailable
{
    use Queueable, SerializesModels;

    public $viagem;
    public $motivo;

    public function __construct(Viagens $viagem, $observacao = null)
    {
        $this->viagem = $viagem;
        $this->motivo = $observacao;
    }

    public function build()
    {
        // Define o template com base no status (ajustado para a sua subpasta)
        $view = $this->viagem->status === 'aprovado' 
                ? 'emails.viagem.aprovada' 
                : 'emails.viagem.cancelada';

        $assunto = $this->viagem->status === 'aprovado'
                ? "✅ Pedido de Viagem Aprovado (#VGM-{$this->viagem->id})"
                : "❌ Pedido de Viagem Cancelado (#VGM-{$this->viagem->id})";

        return $this->subject($assunto)
                    ->view($view)
                    ->with([
                        'viagem'  => $this->viagem,
                        'usuario' => $this->viagem->user,
                        'motivo'  => $this->motivo,
                    ]);
    }
}