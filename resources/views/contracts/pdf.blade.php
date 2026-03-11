<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Contrato {{ $contract->contract_number }}</title>
        <style>
            @page {
                margin: 22mm 18mm;
            }

            body {
                margin: 0;
                font-family: DejaVu Sans, sans-serif;
                color: #111827;
                font-size: 12px;
                line-height: 1.65;
            }

            .contract-document h1 {
                margin: 0 0 18px;
                text-align: center;
                font-size: 17px;
                line-height: 1.4;
            }

            .contract-document h2 {
                margin: 0 0 12px;
                font-size: 12px;
            }

            .contract-document p,
            .contract-document li {
                margin: 0 0 8px;
            }

            .contract-header {
                margin-bottom: 24px;
            }

            .contract-section {
                margin: 18px 0;
            }

            .contract-document ol,
            .contract-document ul {
                margin: 10px 0 0 20px;
                padding: 0;
            }

            hr {
                border: 0;
                border-top: 1px solid #d1d5db;
                margin: 18px 0;
            }

            .signature-section {
                width: 100%;
                margin-top: 32px;
                display: table;
                table-layout: fixed;
            }

            .signature-box {
                display: table-cell;
                width: 50%;
                padding-top: 42px;
                text-align: center;
                vertical-align: top;
            }

            .signature-role {
                margin-bottom: 48px;
                font-weight: bold;
            }

            .signature-name {
                border-top: 1px solid #9ca3af;
                padding-top: 10px;
                margin: 0 24px;
            }

            .footer-note {
                margin-top: 28px;
                font-size: 10px;
                color: #6b7280;
                text-align: center;
            }
        </style>
    </head>
    <body>
        @php
            $document ??= \App\Support\ContractPrintData::from($contract);
        @endphp

        @include('contracts._document', ['document' => $document])

        <p class="footer-note">
            Documento emitido em {{ $document['issued_at'] }} pela plataforma OBRYN.
        </p>
    </body>
</html>
