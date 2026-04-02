{{--
  resources/views/emails/viagem/layout.blade.php
  Layout base compartilhado pelos e-mails de viagem.
  Uso: @extends('emails.viagem.layout')
--}}
<!DOCTYPE html>
<html lang="pt-BR" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="x-apple-disable-message-reformatting">
  <title>@yield('email-title', 'Travel Desk')</title>
  <!--[if mso]>
  <noscript>
    <xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml>
  </noscript>
  <![endif]-->
  <style>
    /* Reset */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; }
    img { border: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }

    /* Base */
    body {
      width: 100% !important;
      min-width: 100%;
      background-color: #f1f5f9;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      font-size: 15px;
      line-height: 1.6;
      color: #334155;
    }

    /* Container */
    .email-wrapper  { width: 100%; background-color: #f1f5f9; padding: 32px 16px; }
    .email-container{ max-width: 580px; margin: 0 auto; }

    /* Header */
    .email-header {
      background-color: #0f172a;
      border-radius: 16px 16px 0 0;
      padding: 28px 36px;
      text-align: left;
    }
    .brand-row { display: flex; align-items: center; gap: 10px; }
    .brand-icon {
      display: inline-block;
      width: 36px; height: 36px;
      background-color: #0ea5e9;
      border-radius: 10px;
      text-align: center;
      line-height: 36px;
      font-size: 18px;
      vertical-align: middle;
    }
    .brand-name {
      display: inline-block;
      vertical-align: middle;
      font-size: 15px;
      font-weight: 700;
      color: #ffffff;
      letter-spacing: -0.2px;
    }
    .brand-sub {
      display: block;
      font-size: 11px;
      color: #475569;
      margin-top: 1px;
    }

    /* Status hero */
    .status-hero {
      padding: 32px 36px 28px;
      text-align: center;
    }
    .status-icon-wrap {
      display: inline-block;
      width: 64px; height: 64px;
      border-radius: 50%;
      margin-bottom: 16px;
      line-height: 64px;
      font-size: 28px;
      text-align: center;
    }
    .status-icon-wrap.aprovado  { background-color: #dcfce7; }
    .status-icon-wrap.cancelado { background-color: #fee2e2; }
    .status-title {
      font-size: 22px;
      font-weight: 800;
      letter-spacing: -0.4px;
      margin-bottom: 6px;
    }
    .status-title.aprovado  { color: #15803d; }
    .status-title.cancelado { color: #dc2626; }
    .status-subtitle {
      font-size: 14px;
      color: #64748b;
      max-width: 380px;
      margin: 0 auto;
      line-height: 1.5;
    }

    /* Card corpo */
    .email-body {
      background-color: #ffffff;
      padding: 0 36px 28px;
    }
    .divider {
      height: 1px;
      background-color: #f1f5f9;
      margin: 0 0 24px;
    }

    /* Greeting */
    .greeting {
      font-size: 15px;
      color: #334155;
      margin-bottom: 16px;
    }
    .greeting strong { color: #0f172a; }

    /* Info card */
    .info-card {
      background-color: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 20px 20px 4px;
      margin-bottom: 20px;
    }
    .info-row {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding-bottom: 14px;
      border-bottom: 1px solid #f1f5f9;
      margin-bottom: 14px;
      font-size: 13px;
    }
    .info-row:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }
    .info-label {
      color: #64748b;
      font-weight: 500;
      flex-shrink: 0;
      margin-right: 12px;
    }
    .info-value {
      color: #0f172a;
      font-weight: 600;
      text-align: right;
    }

    /* Status badge */
    .status-badge {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.02em;
    }
    .status-badge.aprovado  { background: #dcfce7; color: #15803d; }
    .status-badge.cancelado { background: #fee2e2; color: #dc2626; }

    /* Rota visual */
    .route-row {
      display: flex;
      align-items: center;
      gap: 8px;
      background: #f0f9ff;
      border: 1px solid #bae6fd;
      border-radius: 10px;
      padding: 14px 16px;
      margin-bottom: 20px;
      font-size: 13px;
    }
    .route-city {
      flex: 1;
      text-align: center;
    }
    .route-city-label { font-size: 10px; color: #64748b; text-transform: uppercase; letter-spacing: 0.08em; font-weight: 600; }
    .route-city-name  { font-size: 15px; font-weight: 800; color: #0f172a; margin-top: 2px; }
    .route-arrow      { color: #0ea5e9; font-size: 16px; flex-shrink: 0; }

    /* Alerta */
    .alert-box {
      border-radius: 10px;
      padding: 14px 16px;
      font-size: 13px;
      margin-bottom: 20px;
      line-height: 1.5;
    }
    .alert-box.aprovado  { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .alert-box.cancelado { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

    /* CTA */
    .cta-wrap { text-align: center; margin: 24px 0 8px; }
    .cta-btn {
      display: inline-block;
      padding: 13px 32px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 700;
      text-decoration: none;
      letter-spacing: -0.1px;
    }
    .cta-btn.aprovado  { background-color: #0ea5e9; color: #ffffff; }
    .cta-btn.cancelado { background-color: #334155; color: #ffffff; }

    /* Footer */
    .email-footer {
      background-color: #f8fafc;
      border-top: 1px solid #e2e8f0;
      border-radius: 0 0 16px 16px;
      padding: 20px 36px;
      text-align: center;
      font-size: 12px;
      color: #94a3b8;
      line-height: 1.7;
    }
    .footer-link { color: #64748b; text-decoration: none; }
    .footer-link:hover { text-decoration: underline; }

    /* Responsive */
    @media only screen and (max-width: 600px) {
      .email-header,
      .status-hero,
      .email-body { padding-left: 20px !important; padding-right: 20px !important; }
      .email-footer { padding-left: 20px !important; padding-right: 20px !important; }
      .status-title { font-size: 19px !important; }
      .route-city-name { font-size: 14px !important; }
    }
  </style>
</head>
<body>
<div class="email-wrapper">
  <table class="email-container" role="presentation" cellpadding="0" cellspacing="0" width="100%">

    {{-- HEADER --}}
    <tr>
      <td class="email-header">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td>
              <table role="presentation" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="vertical-align:middle;padding-right:10px;">
                    <img
                      src="{{ config('app.url') }}/images/email-logo-icon.png"
                      width="36" height="36"
                      alt="✈"
                      style="border-radius:10px;display:block;"
                      onerror="this.style.display='none'"
                    >
                  </td>
                  <td style="vertical-align:middle;">
                    <span style="font-size:15px;font-weight:700;color:#ffffff;">Travel Desk</span><br>
                    <span style="font-size:11px;color:#475569;">Gestão de Viagens</span>
                  </td>
                </tr>
              </table>
            </td>
            <td align="right" style="vertical-align:middle;">
              <span style="font-size:11px;color:#475569;">{{ now()->format('d/m/Y') }}</span>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    {{-- STATUS HERO --}}
    @yield('status-hero')

    {{-- BODY --}}
    <tr>
      <td class="email-body">
        <div class="divider"></div>
        @yield('body')
      </td>
    </tr>

    {{-- FOOTER --}}
    <tr>
      <td class="email-footer">
        <p>Este e-mail foi enviado automaticamente pelo sistema <strong>Travel Desk</strong>.</p>
        <p style="margin-top:4px;">
          Dúvidas? Entre em contato:
          <a href="mailto:{{ config('mail.from.address') }}" class="footer-link">{{ config('mail.from.address') }}</a>
        </p>
        <p style="margin-top:12px;font-size:11px;color:#cbd5e1;">
          &copy; {{ now()->year }} {{ config('app.name') }} &middot;
          <a href="{{ config('app.url') }}" class="footer-link">{{ config('app.url') }}</a>
        </p>
      </td>
    </tr>

  </table>
</div>
</body>
</html>
