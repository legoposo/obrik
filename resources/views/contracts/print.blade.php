<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contrato {{ $contract->contract_number }}</title>
        <style>
            :root {
                color-scheme: light;
                --paper: #ffffff;
                --ink: #111827;
                --line: #d1d5db;
                --surface: #eef2f7;
                --brand: #0f172a;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                background: var(--surface);
                color: var(--ink);
                font-family: Georgia, "Times New Roman", serif;
            }

            .print-shell {
                max-width: 960px;
                margin: 24px auto;
                padding: 0 20px 40px;
            }

            .toolbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 16px;
                margin-bottom: 16px;
            }

            .toolbar__title {
                font-size: 14px;
                font-weight: 700;
            }

            .toolbar__actions {
                display: flex;
                gap: 10px;
            }

            .toolbar-button {
                border: 1px solid var(--line);
                border-radius: 12px;
                padding: 11px 16px;
                background: #fff;
                color: var(--ink);
                font-size: 14px;
                font-weight: 600;
                text-decoration: none;
                cursor: pointer;
            }

            .toolbar-button--primary {
                background: var(--brand);
                border-color: var(--brand);
                color: #fff;
            }

            .document-card {
                background: var(--paper);
                border: 1px solid #dbe3ee;
                border-radius: 20px;
                padding: 38px 44px;
                box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            }

            .contract-document h1 {
                margin: 0 0 18px;
                text-align: center;
                font-size: 28px;
                line-height: 1.35;
            }

            .contract-document h2 {
                margin: 0 0 12px;
                font-size: 18px;
            }

            .contract-document p,
            .contract-document li {
                margin: 0 0 10px;
                font-size: 16px;
                line-height: 1.7;
            }

            .contract-header {
                margin-bottom: 24px;
            }

            .contract-section {
                margin: 22px 0;
            }

            .contract-document ol,
            .contract-document ul {
                margin: 10px 0 0 24px;
                padding: 0;
            }

            .contract-document hr {
                border: 0;
                border-top: 1px solid var(--line);
                margin: 20px 0;
            }

            .signature-section {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 24px;
                margin-top: 34px;
            }

            .signature-box {
                text-align: center;
            }

            .signature-role {
                margin-bottom: 54px;
                font-weight: 700;
            }

            .signature-name {
                border-top: 1px solid #9ca3af;
                padding-top: 12px;
            }

            .footer-note {
                margin-top: 26px;
                text-align: center;
                font-size: 13px;
                color: #4b5563;
            }

            @media print {
                @page {
                    size: A4;
                    margin: 16mm;
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

                .document-card {
                    border: 0;
                    border-radius: 0;
                    box-shadow: none;
                    padding: 0;
                }
            }

            @media (max-width: 720px) {
                .toolbar {
                    flex-direction: column;
                    align-items: stretch;
                }

                .toolbar__actions {
                    flex-direction: column;
                }

                .signature-section {
                    grid-template-columns: 1fr;
                }

                .document-card {
                    padding: 28px 22px;
                }

                .contract-document h1 {
                    font-size: 22px;
                }

                .contract-document p,
                .contract-document li {
                    font-size: 15px;
                }
            }
        </style>
    </head>
    <body>
        @php
            $document ??= \App\Support\ContractPrintData::from($contract);
        @endphp

        <div class="print-shell">
            <div class="toolbar">
                <div class="toolbar__title">Contrato {{ $document['contract_number'] }}</div>

                <div class="toolbar__actions">
                    <a href="{{ route('contracts.edit', $contract) }}" class="toolbar-button">Voltar para edicao</a>
                    <button type="button" class="toolbar-button toolbar-button--primary" onclick="window.print()">
                        Imprimir contrato
                    </button>
                </div>
            </div>

            <div class="document-card">
                @include('contracts._document', ['document' => $document])

                <p class="footer-note">
                    Documento emitido em {{ $document['issued_at'] }} pela plataforma OBRYN.
                </p>
            </div>
        </div>
    </body>
</html>
