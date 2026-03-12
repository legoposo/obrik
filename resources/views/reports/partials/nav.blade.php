@php
    $reportNavItems = [
        [
            'label' => 'Visao geral',
            'route' => route('reports.index'),
            'active' => request()->routeIs('reports.index'),
        ],
        [
            'label' => 'Obras',
            'route' => route('reports.works'),
            'active' => request()->routeIs('reports.works'),
        ],
        [
            'label' => 'Financeiro',
            'route' => route('reports.financial'),
            'active' => request()->routeIs('reports.financial'),
        ],
        [
            'label' => 'Clientes',
            'route' => route('reports.clients'),
            'active' => request()->routeIs('reports.clients'),
        ],
        [
            'label' => 'Empreendimentos',
            'route' => route('reports.developments'),
            'active' => request()->routeIs('reports.developments'),
        ],
    ];
@endphp

<div class="report-nav">
    @foreach ($reportNavItems as $item)
        <a
            href="{{ $item['route'] }}"
            class="report-nav__link {{ $item['active'] ? 'report-nav__link--active' : '' }}"
        >
            {{ $item['label'] }}
        </a>
    @endforeach
</div>
