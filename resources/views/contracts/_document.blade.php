<article class="contract-document">
    <header class="contract-header">
        <h1>{{ $document['title'] }}</h1>
        <p><strong>Contrato n&ordm;:</strong> {{ $document['contract_number'] }}</p>
        <p><strong>Data:</strong> {{ $document['contract_date_full'] }}</p>
    </header>

    <section class="contract-section">
        <h2>1. DAS PARTES</h2>

        <p><strong>VENDEDORA:</strong></p>
        <p>{{ $document['seller_description'] }}</p>

        <p><strong>COMPRADOR:</strong></p>
        <p>{{ $document['buyer_description'] }}</p>
    </section>

    <hr>

    <section class="contract-section">
        <h2>2. DO EMPREENDIMENTO</h2>

        <p>O presente contrato refere-se &agrave; aquisi&ccedil;&atilde;o de unidade no seguinte empreendimento:</p>

        <p><strong>Empreendimento:</strong> {{ $document['development_name'] }}</p>
        <p><strong>Tipo:</strong> {{ $document['development_type'] }}</p>
        <p><strong>Endere&ccedil;o:</strong> {{ $document['development_address'] }}</p>
        <p><strong>Cidade:</strong> {{ $document['development_city'] }}</p>
        <p><strong>Estado:</strong> {{ $document['development_state'] }}</p>
        <p><strong>Construtora respons&aacute;vel:</strong> {{ $document['builder_name'] }}</p>
    </section>

    <hr>

    <section class="contract-section">
        <h2>3. DA UNIDADE</h2>

        <p>O COMPRADOR adquire a seguinte unidade:</p>

        <p><strong>Unidade:</strong> {{ $document['unit_identifier'] }}</p>
        <p><strong>Andar:</strong> {{ $document['unit_floor'] }}</p>
        <p><strong>Tipo da unidade:</strong> {{ $document['unit_type'] }}</p>
        <p><strong>Situa&ccedil;&atilde;o da unidade:</strong> {{ $document['unit_status'] }}</p>
    </section>

    <hr>

    <section class="contract-section">
        <h2>4. DO VALOR</h2>

        <p>O valor total da presente negocia&ccedil;&atilde;o &eacute; de:</p>

        <p>
            <strong>Valor do im&oacute;vel:</strong>
            {{ $document['negotiated_value'] }} ({{ $document['negotiated_value_words'] }})
        </p>

        <p>{{ $document['payment_terms'] }}</p>
    </section>

    <hr>

    <section class="contract-section">
        <h2>5. DAS CONDICOES</h2>

        <ol>
            <li>A unidade adquirida faz parte do empreendimento descrito neste contrato.</li>
            <li>O comprador declara estar ciente das condicoes do imovel e do empreendimento.</li>
            <li>A construtora compromete-se a entregar o imovel conforme especificacoes do projeto aprovado.</li>
        </ol>
    </section>

    <hr>

    <section class="contract-section">
        <h2>6. DO REGISTRO</h2>

        <p>
            Este contrato ser&aacute; registrado no sistema interno de gest&atilde;o imobili&aacute;ria da construtora
            <strong>OBRYN</strong>, vinculando:
        </p>

        <ul>
            <li>Cliente: {{ $document['client_reference'] }}</li>
            <li>Unidade: {{ $document['unit_reference'] }}</li>
            <li>Empreendimento: {{ $document['development_reference'] }}</li>
            <li>Valor negociado: {{ $document['negotiated_value'] }}</li>
            <li>Situa&ccedil;&atilde;o do contrato: {{ $document['contract_status'] }}</li>
        </ul>
    </section>

    <hr>

    <section class="contract-section">
        <h2>7. DISPOSICOES FINAIS</h2>

        <p>
            As partes elegem o foro da comarca de <strong>{{ $document['forum_city_state'] }}</strong> para dirimir
            quaisquer duvidas oriundas deste contrato.
        </p>
    </section>

    <hr>

    <section class="signature-section">
        <div class="signature-box">
            <p class="signature-role">VENDEDORA</p>
            <p class="signature-name">{{ $document['seller_name'] }}</p>
        </div>

        <div class="signature-box">
            <p class="signature-role">COMPRADOR</p>
            <p class="signature-name">{{ $document['buyer_name'] }}</p>
        </div>
    </section>
</article>
