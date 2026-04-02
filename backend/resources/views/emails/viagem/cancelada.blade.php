{{--
  resources/views/emails/viagem/cancelada.blade.php

  Variáveis esperadas (injetadas pela Notification):
    $viagem   – App\Models\Viagem
    $usuario  – App\Models\User  (quem recebe)
    $motivo   – string|null       (motivo opcional do cancelamento)

  Uso na Notification:
    return (new MailMessage)
        ->subject("❌ Viagem cancelada – {$this->viagem->destino}")
        ->view('emails.viagem.cancelada', [
            'viagem'  => $this->viagem,
            'usuario' => $notifiable,
            'motivo'  => $this->motivo ?? null,
        ]);
--}}
@extends('emails.viagem.layout')

@section('email-title', 'Viagem Cancelada – Travel Desk')

{{-- ── HERO ─────────────────────────────────────────────── --}}
@section('status-hero')
<tr>
  <td style="background:#ffffff;padding:32px 36px 24px;text-align:center;border-left:1px solid #e2e8f0;border-right:1px solid #e2e8f0;">

    {{-- Ícone --}}
    <div style="display:inline-block;width:64px;height:64px;background:#fee2e2;border-radius:50%;line-height:64px;font-size:26px;margin-bottom:16px;">
      ❌
    </div>

    {{-- Título --}}
    <h1 style="font-size:22px;font-weight:800;color:#dc2626;letter-spacing:-0.4px;margin:0 0 8px;">
      Viagem Cancelada
    </h1>

    {{-- Sub --}}
    <p style="font-size:14px;color:#64748b;margin:0;line-height:1.5;max-width:380px;display:inline-block;">
      Olá, <strong style="color:#0f172a;">{{ $usuario->name }}</strong>.
      Informamos que seu pedido de viagem foi <strong style="color:#dc2626;">cancelado</strong>.
    </p>

    {{-- Badge ID --}}
    <div style="margin-top:16px;">
      <span style="display:inline-block;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;font-size:11px;font-weight:700;padding:4px 12px;border-radius:20px;letter-spacing:0.04em;">
        #VGM-{{ str_pad($viagem->id, 4, '0', STR_PAD_LEFT) }} &middot; CANCELADO
      </span>
    </div>
  </td>
</tr>
@endsection

{{-- ── BODY ─────────────────────────────────────────────── --}}
@section('body')

{{-- Saudação --}}
<p class="greeting">
  Olá, <strong>{{ $usuario->name }}</strong>!
</p>
<p style="font-size:14px;color:#475569;margin-bottom:20px;line-height:1.6;">
  Lamentamos informar que seu pedido de viagem foi
  <strong style="color:#dc2626;">cancelado</strong>.
  Confira os detalhes da solicitação abaixo.
</p>

{{-- Rota visual --}}
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:20px;">
  <tr>
    <td style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:14px 16px;">
      <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td style="text-align:center;width:45%;">
            <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;font-weight:600;">Origem</div>
            <div style="font-size:16px;font-weight:800;color:#991b1b;margin-top:3px;text-decoration:line-through;opacity:.7;">{{ $viagem->origem }}</div>
          </td>
          <td style="text-align:center;width:10%;font-size:20px;color:#fca5a5;font-weight:300;">→</td>
          <td style="text-align:center;width:45%;">
            <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;font-weight:600;">Destino</div>
            <div style="font-size:16px;font-weight:800;color:#991b1b;margin-top:3px;text-decoration:line-through;opacity:.7;">{{ $viagem->destino }}</div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

{{-- Info card --}}
<div class="info-card">

  <div class="info-row">
    <span class="info-label">Número do pedido</span>
    <span class="info-value" style="font-family:monospace;">#VGM-{{ str_pad($viagem->id, 4, '0', STR_PAD_LEFT) }}</span>
  </div>

  <div class="info-row">
    <span class="info-label">Solicitante</span>
    <span class="info-value">{{ $viagem->solicitante }}</span>
  </div>

  <div class="info-row">
    <span class="info-label">Data de ida</span>
    <span class="info-value" style="color:#94a3b8;text-decoration:line-through;">
      {{ \Carbon\Carbon::parse($viagem->data_ida)->format('d/m/Y') }}
    </span>
  </div>

  <div class="info-row">
    <span class="info-label">Data de volta</span>
    <span class="info-value" style="color:#94a3b8;text-decoration:line-through;">
      {{ \Carbon\Carbon::parse($viagem->data_volta)->format('d/m/Y') }}
    </span>
  </div>

  <div class="info-row">
    <span class="info-label">Status</span>
    <span class="status-badge cancelado">✕ Cancelado</span>
  </div>

  <div class="info-row">
    <span class="info-label">Cancelado em</span>
    <span class="info-value">{{ now()->format('d/m/Y \à\s H:i') }}</span>
  </div>

</div>

{{-- Motivo (opcional) --}}
@if (!empty($motivo))
<div class="alert-box cancelado" style="margin-bottom:20px;">
  <strong>Motivo do cancelamento:</strong><br>
  {{ $motivo }}
</div>
@endif
<div class="alert-box cancelado" style="margin-bottom:20px;">
  <strong>O que acontece agora?</strong><br>
  Caso este cancelamento tenha sido um erro ou você precise abrir uma nova solicitação,
  acesse o painel Travel Desk. Se tiver dúvidas, entre em contato com o administrador.
</div>


{{-- CTA --}}
<div class="cta-wrap">
  <a href="{{ config('app.url') }}/viagens/nova" class="cta-btn cancelado">
    Abrir novo pedido de viagem
  </a>
</div>

<p style="font-size:13px;color:#94a3b8;text-align:center;margin-top:12px;">
  Ou acesse <a href="{{ config('app.url') }}" style="color:#0ea5e9;text-decoration:none;">{{ config('app.url') }}</a>
  para consultar seu histórico.
</p>

@endsection
