<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Contrato {{ $contract->contract_number }}</title>
        <style>
            @page {
                margin: 24mm 16mm 22mm;
            }

            body {
                font-family: DejaVu Sans, sans-serif;
                color: #1f2937;
                font-size: 12px;
                line-height: 1.55;
            }

            .header {
                border-bottom: 1px solid #dbe4f0;
                padding-bottom: 18px;
                margin-bottom: 24px;
            }

            .brand-row {
                width: 100%;
                margin-bottom: 14px;
                border-collapse: collapse;
            }

            .brand-row td {
                vertical-align: middle;
            }

            .brand-lockup {
                width: 100%;
            }

            .brand-mark {
                width: 34px;
                height: 34px;
                vertical-align: middle;
            }

            .brand-name {
                display: inline-block;
                margin-left: 10px;
                vertical-align: middle;
                font-size: 24px;
                font-weight: bold;
                letter-spacing: 1px;
                color: #111827;
            }

            .brand-meta {
                text-align: right;
                font-size: 10px;
                color: #6b7280;
            }

            .eyebrow {
                margin: 0 0 8px;
                font-size: 10px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: #1d4ed8;
            }

            h1 {
                margin: 0;
                font-size: 22px;
                line-height: 1.3;
            }

            .subtitle {
                margin: 8px 0 0;
                color: #6b7280;
            }

            .status {
                margin-top: 12px;
                display: inline-block;
                padding: 7px 12px;
                border-radius: 999px;
                background: #dbeafe;
                color: #1d4ed8;
                font-size: 10px;
                font-weight: bold;
                text-transform: uppercase;
            }

            .section {
                margin-bottom: 22px;
            }

            .section-title {
                margin: 0 0 12px;
                font-size: 13px;
                font-weight: bold;
                text-transform: uppercase;
                color: #374151;
            }

            .grid {
                width: 100%;
                border-collapse: separate;
                border-spacing: 10px;
                margin: -10px;
            }

            .card {
                border: 1px solid #e5e7eb;
                border-radius: 14px;
                padding: 14px;
                background: #f8fafc;
                vertical-align: top;
            }

            .label {
                margin: 0 0 6px;
                font-size: 10px;
                font-weight: bold;
                text-transform: uppercase;
                color: #6b7280;
            }

            .value {
                margin: 0;
                font-size: 13px;
                font-weight: bold;
                color: #111827;
            }

            .value-subtle {
                margin: 5px 0 0;
                color: #4b5563;
            }

            .summary-table {
                width: 100%;
                border-collapse: collapse;
            }

            .summary-table th,
            .summary-table td {
                border: 1px solid #e5e7eb;
                padding: 10px 12px;
                text-align: left;
            }

            .summary-table th {
                background: #f8fafc;
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: #6b7280;
            }

            .summary-table td {
                font-weight: bold;
            }

            .notes {
                min-height: 90px;
                border: 1px solid #e5e7eb;
                border-radius: 14px;
                padding: 14px;
                background: #f8fafc;
                white-space: pre-line;
            }

            .signatures {
                width: 100%;
                margin-top: 42px;
                border-collapse: separate;
                border-spacing: 24px 0;
            }

            .signature-box {
                padding-top: 42px;
                border-top: 1px solid #9ca3af;
                text-align: center;
                color: #6b7280;
            }

            .footer {
                margin-top: 28px;
                font-size: 10px;
                color: #6b7280;
                text-align: center;
            }
        </style>
    </head>
    <body>
        @php
            $formatMoney = fn ($value) => 'R$ '.number_format((float) $value, 2, ',', '.');
            $brandMark = file_exists(public_path('favicon.svg')) ? file_get_contents(public_path('favicon.svg')) : null;
        @endphp

        <div class="header">
            <table class="brand-row">
                <tr>
                    <td>
                        <div class="brand-lockup">
                            @if ($brandMark)
                                <span class="brand-mark">{!! $brandMark !!}</span>
                            @endif
                            <span class="brand-name">OBRYN</span>
                        </div>
                    </td>
                    <td class="brand-meta">
                        Documento emitido em {{ now()->format('d/m/Y H:i') }}<br>
                        Plataforma OBRYN
                    </td>
                </tr>
            </table>

            <p class="eyebrow">OBRYN | Contrato de venda</p>
            <h1>Instrumento particular de compra e venda de unidade imobiliária</h1>
            <p class="subtitle">Documento gerado em PDF a partir do contrato cadastrado no sistema OBRYN.</p>
            <span class="status">{{ ucfirst($contract->status) }}</span>
        </div>

        <div class="section">
            <h2 class="section-title">Identificação do contrato</h2>
            <table class="grid">
                <tr>
                    <td class="card" width="50%">
                        <p class="label">Número do contrato</p>
                        <p class="value">{{ $contract->contract_number }}</p>
                    </td>
                    <td class="card" width="50%">
                        <p class="label">Data do contrato</p>
                        <p class="value">{{ $contract->contract_date?->format('d/m/Y') }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="card" width="50%">
                        <p class="label">Data da venda</p>
                        <p class="value">{{ $contract->sale_date?->format('d/m/Y') }}</p>
                    </td>
                    <td class="card" width="50%">
                        <p class="label">Parcelas previstas</p>
                        <p class="value">{{ $contract->installments_count ?: 0 }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2 class="section-title">Partes envolvidas</h2>
            <table class="grid">
                <tr>
                    <td class="card" width="50%">
                        <p class="label">Cliente</p>
                        <p class="value">{{ $contract->client->name }}</p>
                        <p class="value-subtle">CPF: {{ $contract->client->cpf ?: 'Nao informado' }}</p>
                        <p class="value-subtle">Telefone: {{ $contract->client->phone ?: 'Nao informado' }}</p>
                        <p class="value-subtle">E-mail: {{ $contract->client->email ?: 'Nao informado' }}</p>
                    </td>
                    <td class="card" width="50%">
                        <p class="label">Empreendimento e unidade</p>
                        <p class="value">{{ $contract->development->name }}</p>
                        <p class="value-subtle">Unidade: {{ $contract->unit->identifier }}</p>
                        <p class="value-subtle">Bloco: {{ $contract->unit->block ?: '-' }} | Andar: {{ $contract->unit->floor ?: '-' }}</p>
                        <p class="value-subtle">Tipologia: {{ $contract->unit->type ?: 'Nao informado' }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2 class="section-title">Resumo financeiro</h2>
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>Valor da unidade</th>
                        <th>Desconto</th>
                        <th>Valor negociado</th>
                        <th>Entrada</th>
                        <th>Financiamento</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $formatMoney($contract->unit_price) }}</td>
                        <td>{{ $formatMoney($contract->discount) }}</td>
                        <td>{{ $formatMoney($contract->negotiated_value) }}</td>
                        <td>{{ $formatMoney($contract->down_payment) }}</td>
                        <td>{{ $formatMoney($contract->financed_amount) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2 class="section-title">Observações contratuais</h2>
            <div class="notes">{{ $contract->notes ?: 'Sem observacoes registradas ate o momento.' }}</div>
        </div>

        <table class="signatures">
            <tr>
                <td class="signature-box" width="50%">Assinatura do cliente</td>
                <td class="signature-box" width="50%">Assinatura da incorporadora / responsável</td>
            </tr>
        </table>

        <div class="footer">
            Documento emitido pela plataforma OBRYN.
        </div>
    </body>
</html>