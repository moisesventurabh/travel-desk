{{--
  resources/views/emails/viagem/aprovada.blade.php

  Variáveis esperadas (injetadas pela Notification):
    $viagem   – App\Models\Viagem
    $usuario  – App\Models\User  (quem recebe)

  Uso na Notification:
    return (new MailMessage)
        ->subject("✅ Viagem aprovada – {$this->viagem->destino}")
        ->view('emails.viagem.aprovada', [
            'viagem'  => $this->viagem,
            'usuario' => $notifiable,
        ]);
--}}
@extends('emails.viagem.layout')

@section('email-title', 'Viagem Aprovada – Travel Desk')

{{-- ── HERO ─────────────────────────────────────────────── --}}
@section('status-hero')
<tr>
  <td style="background:#ffffff;padding:32px 36px 24px;text-align:center;border-left:1px solid #e2e8f0;border-right:1px solid #e2e8f0;">

    {{-- Ícone --}}
    <div style="display:inline-block;width:64px;height:64px;background:#dcfce7;border-radius:50%;line-height:64px;font-size:26px;margin-bottom:16px;">
      ✅
    </div>

    {{-- Título --}}
    <h1 style="font-size:22px;font-weight:800;color:#15803d;letter-spacing:-0.4px;margin:0 0 8px;">
      Viagem Aprovada!
    </h1>

    {{-- Sub --}}
    <p style="font-size:14px;color:#64748b;margin:0;line-height:1.5;max-width:380px;display:inline-block;">
      Boa notícia, <strong style="color:#0f172a;">{{ $usuario->name }}</strong>!
      Seu pedido de viagem foi <strong style="color:#15803d;">aprovado</strong> e está confirmado.
    </p>

    {{-- Badge ID --}}
    <div style="margin-top:16px;">
      <span style="display:inline-block;background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;font-size:11px;font-weight:700;padding:4px 12px;border-radius:20px;letter-spacing:0.04em;">
        #VGM-{{ str_pad($viagem->id, 4, '0', STR_PAD_LEFT) }} &middot; APROVADO
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
  Seu pedido de viagem foi analisado e <strong style="color:#15803d;">aprovado</strong> pelo administrador.
  Confira os detalhes abaixo e organize-se para a viagem!
</p>

{{-- Rota visual --}}
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:20px;">
  <tr>
    <td style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:10px;padding:14px 16px;">
      <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td style="text-align:center;width:45%;">
            <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;font-weight:600;">Origem</div>
            <div style="font-size:16px;font-weight:800;color:#0f172a;margin-top:3px;">{{ $viagem->origem }}</div>
          </td>
          <td style="text-align:center;width:10%;font-size:20px;color:#0ea5e9;font-weight:300;">→</td>
          <td style="text-align:center;width:45%;">
            <div style="font-size:10px;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;font-weight:600;">Destino</div>
            <div style="font-size:16px;font-weight:800;color:#0f172a;margin-top:3px;">{{ $viagem->destino }}</div>
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
    <span class="info-value">
      {{ \Carbon\Carbon::parse($viagem->data_ida)->format('d/m/Y') }}
      <span style="font-size:11px;font-weight:400;color:#64748b;">
        ({{ \Carbon\Carbon::parse($viagem->data_ida)->translatedFormat('l') }})
      </span>
    </span>
  </div>

  <div class="info-row">
    <span class="info-label">Data de volta</span>
    <span class="info-value">
      {{ \Carbon\Carbon::parse($viagem->data_volta)->format('d/m/Y') }}
      <span style="font-size:11px;font-weight:400;color:#64748b;">
        ({{ \Carbon\Carbon::parse($viagem->data_volta)->translatedFormat('l') }})
      </span>
    </span>
  </div>

  <div class="info-row">
    <span class="info-label">Duração</span>
    <span class="info-value">
      @php
        $dias = \Carbon\Carbon::parse($viagem->data_ida)->diffInDays($viagem->data_volta);
      @endphp
      {{ $dias }} {{ $dias === 1 ? 'dia' : 'dias' }}
    </span>
  </div>

  <div class="info-row">
    <span class="info-label">Status</span>
    <span class="status-badge aprovado">✔ Aprovado</span>
  </div>

  <div class="info-row">
    <span class="info-label">Aprovado em</span>
    <span class="info-value">{{ now()->format('d/m/Y \à\s H:i') }}</span>
  </div>

</div>
{{-- Motivo (opcional) --}}
@if (!empty($motivo))
<div class="alert-box aprovado" style="margin-bottom:20px;">
  {{ $motivo }}
</div>
@endif
{{-- Alerta positivo --}}
<div class="alert-box aprovado">
  <strong>O que fazer agora?</strong><br>
  Com o pedido aprovado, você já pode providenciar passagens, hospedagem e demais
  preparativos. Em caso de dúvidas, contate o departamento responsável.
</div>

{{-- CTA --}}
<div class="cta-wrap">
  <a href="{{ config('app.url') }}/viagens/{{ $viagem->id }}" class="cta-btn aprovado">
    Ver detalhes da viagem
  </a>
</div>

<p style="font-size:13px;color:#94a3b8;text-align:center;margin-top:12px;">
  Ou acesse <a href="{{ config('app.url') }}" style="color:#0ea5e9;text-decoration:none;">{{ config('app.url') }}</a>
  e consulte seu painel.
</p>

@endsection
