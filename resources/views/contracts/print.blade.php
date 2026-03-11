<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contrato {{ $contract->contract_number }}</title>
        <style>
            :root {
                color-scheme: light;
                --ink: #111827;
                --muted: #6b7280;
                --line: #e5e7eb;
                --panel: #ffffff;
                --soft: #f8fafc;
                --brand: #1d4ed8;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                font-family: "Instrument Sans", "Segoe UI", sans-serif;
                background: #eef2f7;
                color: var(--ink);
            }

            .print-shell {
                max-width: 960px;
                margin: 32px auto;
                padding: 0 20px 40px;
            }

            .toolbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 16px;
                gap: 12px;
            }

            .toolbar__actions {
                display: flex;
                gap: 10px;
            }

            .toolbar-button {
                border: 0;
                border-radius: 14px;
                padding: 12px 18px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
            }

            .toolbar-button--primary {
                background: var(--brand);
                color: #fff;
            }

            .toolbar-button--ghost {
                background: #fff;
                color: var(--ink);
                border: 1px solid var(--line);
            }

            .document {
                background: var(--panel);
                border: 1px solid #dbe3ee;
                border-radius: 28px;
                overflow: hidden;
                box-shadow: 0 30px 80px rgba(15, 23, 42, 0.12);
            }

            .document__header {
                padding: 40px 48px 32px;
                background: linear-gradient(135deg, #eff6ff 0%, #ffffff 45%, #f8fafc 100%);
                border-bottom: 1px solid var(--line);
            }

            .eyebrow {
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.18em;
                color: var(--brand);
                margin: 0 0 10px;
            }

            .title-row {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 20px;
            }

            h1 {
                margin: 0;
                font-size: 30px;
                line-height: 1.15;
            }

            .subtitle {
                margin: 10px 0 0;
                font-size: 15px;
                line-height: 1.7;
                color: var(--muted);
                max-width: 600px;
            }

            .status-badge {
                display: inline-flex;
                align-items: center;
                border-radius: 999px;
                padding: 10px 16px;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                background: #dbeafe;
                color: #1d4ed8;
                white-space: nowrap;
            }

            .document__body {
                padding: 36px 48px 20px;
            }

            .section {
                margin-bottom: 28px;
            }

            .section h2 {
                margin: 0 0 14px;
                font-size: 16px;
                font-weight: 700;
            }

            .section-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
            }

            .info-card {
                border: 1px solid var(--line);
                border-radius: 18px;
                padding: 16px 18px;
                background: var(--soft);
            }

            .info-label {
                margin: 0 0 8px;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: var(--muted);
            }

            .info-value {
                margin: 0;
                font-size: 16px;
                font-weight: 600;
                line-height: 1.5;
            }

            .info-value--subtle {
                font-size: 14px;
                font-weight: 500;
                color: var(--muted);
            }

            .summary-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 14px;
            }

            .summary-card {
                border: 1px solid var(--line);
                border-radius: 20px;
                padding: 18px;
                background: #fff;
            }

            .summary-card__label {
                margin: 0;
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: var(--muted);
            }

            .summary-card__value {
                margin: 10px 0 0;
                font-size: 20px;
                font-weight: 700;
            }

            .notes-box {
                min-height: 120px;
                border: 1px solid var(--line);
                border-radius: 20px;
                padding: 18px;
                background: var(--soft);
                font-size: 15px;
                line-height: 1.7;
                color: #374151;
                white-space: pre-line;
            }

            .signature-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 28px;
                margin-top: 42px;
            }

            .signature-line {
                padding-top: 42px;
                border-top: 1px solid #9ca3af;
                text-align: center;
                font-size: 14px;
                color: var(--muted);
            }

            .document__footer {
                padding: 0 48px 40px;
                color: var(--muted);
                font-size: 12px;
                line-height: 1.7;
            }

            @media print {
                @page {
                    size: A4;
                    margin: 14mm;
                }

                body {
                    background: #fff;
                }

                .print-shell {
                    max-width: none;
                    margin: 0;
                    padding: 0;
                }

                .toolbar {
                    display: none;
                }

                .document {
                    border: 0;
                    border-radius: 0;
                    box-shadow: none;
                }
            }

            @media (max-width: 800px) {
                .title-row,
                .section-grid,
                .summary-grid,
                .signature-grid {
                    grid-template-columns: 1fr;
                }

                .document__header,
                .document__body,
                .document__footer {
                    padding-left: 24px;
                    padding-right: 24px;
                }
            }
        </style>
    </head>
    <body>
        @php
            $statusLabel = ucfirst($contract->status);
            $formatMoney = fn ($value) => 'R$ '.number_format((float) $value, 2, ',', '.');
        @endphp

        <div class="print-shell">
            <div class="toolbar">
                <div>
                    <strong>Contrato {{ $contract->contract_number }}</strong>
                </div>
                <div class="toolbar__actions">
                    <a href="{{ route('contracts.edit', $contract) }}" class="toolbar-button toolbar-button--ghost">Voltar para edição</a>
                    <button type="button" class="toolbar-button toolbar-button--primary" onclick="window.print()">Imprimir contrato</button>
                </div>
            </div>

            <article class="document">
                <header class="document__header">
                    <p class="eyebrow">OBRYN | Contrato de venda</p>
                    <div class="title-row">
                        <div>
                            <h1>Instrumento particular de compra e venda de unidade imobiliária</h1>
                            <p class="subtitle">
                                Documento de formalização da negociação entre cliente, unidade e empreendimento, com apresentação pronta para impressão e assinatura.
                            </p>
                        </div>
                        <span class="status-badge">{{ $statusLabel }}</span>
                    </div>
                </header>

                <section class="document__body">
                    <section class="section">
                        <h2>Identificação do contrato</h2>
                        <div class="section-grid">
                            <div class="info-card">
                                <p class="info-label">Número do contrato</p>
                                <p class="info-value">{{ $contract->contract_number }}</p>
                            </div>
                            <div class="info-card">
                                <p class="info-label">Data do contrato</p>
                                <p class="info-value">{{ $contract->contract_date?->format('d/m/Y') }}</p>
                            </div>
                            <div class="info-card">
                                <p class="info-label">Data da venda</p>
                                <p class="info-value">{{ $contract->sale_date?->format('d/m/Y') }}</p>
                            </div>
                            <div class="info-card">
                                <p class="info-label">Parcelas previstas</p>
                                <p class="info-value">{{ $contract->installments_count ?: 0 }}</p>
                            </div>
                        </div>
                    </section>

                    <section class="section">
                        <h2>Partes envolvidas</h2>
                        <div class="section-grid">
                            <div class="info-card">
                                <p class="info-label">Cliente</p>
                                <p class="info-value">{{ $contract->client->name }}</p>
                                <p class="info-value info-value--subtle">CPF: {{ $contract->client->cpf ?: 'Nao informado' }}</p>
                                <p class="info-value info-value--subtle">Telefone: {{ $contract->client->phone ?: 'Nao informado' }}</p>
                                <p class="info-value info-value--subtle">E-mail: {{ $contract->client->email ?: 'Nao informado' }}</p>
                            </div>
                            <div class="info-card">
                                <p class="info-label">Empreendimento e unidade</p>
                                <p class="info-value">{{ $contract->development->name }}</p>
                                <p class="info-value info-value--subtle">Unidade: {{ $contract->unit->identifier }}</p>
                                <p class="info-value info-value--subtle">Bloco: {{ $contract->unit->block ?: '-' }} | Andar: {{ $contract->unit->floor ?: '-' }}</p>
                                <p class="info-value info-value--subtle">Tipologia: {{ $contract->unit->type ?: 'Nao informado' }}</p>
                            </div>
                        </div>
                    </section>

                    <section class="section">
                        <h2>Resumo financeiro</h2>
                        <div class="summary-grid">
                            <div class="summary-card">
                                <p class="summary-card__label">Valor da unidade</p>
                                <p class="summary-card__value">{{ $formatMoney($contract->unit_price) }}</p>
                            </div>
                            <div class="summary-card">
                                <p class="summary-card__label">Desconto</p>
                                <p class="summary-card__value">{{ $formatMoney($contract->discount) }}</p>
                            </div>
                            <div class="summary-card">
                                <p class="summary-card__label">Valor negociado</p>
                                <p class="summary-card__value">{{ $formatMoney($contract->negotiated_value) }}</p>
                            </div>
                            <div class="summary-card">
                                <p class="summary-card__label">Entrada</p>
                                <p class="summary-card__value">{{ $formatMoney($contract->down_payment) }}</p>
                            </div>
                            <div class="summary-card">
                                <p class="summary-card__label">Financiamento</p>
                                <p class="summary-card__value">{{ $formatMoney($contract->financed_amount) }}</p>
                            </div>
                        </div>
                    </section>

                    <section class="section">
                        <h2>Observações contratuais</h2>
                        <div class="notes-box">{{ $contract->notes ?: 'Sem observações registradas até o momento.' }}</div>
                    </section>

                    <section class="signature-grid">
                        <div class="signature-line">
                            Assinatura do cliente
                        </div>
                        <div class="signature-line">
                            Assinatura da incorporadora / responsável
                        </div>
                    </section>
                </section>

                <footer class="document__footer">
                    Documento emitido em {{ now()->format('d/m/Y H:i') }}. Este layout foi preparado para impressão profissional e pode evoluir futuramente para geração de PDF e cláusulas completas.
                </footer>
            </article>
        </div>
    </body>
</html>