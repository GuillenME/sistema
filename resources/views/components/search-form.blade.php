@props(['action', 'placeholder' => 'Buscar...'])

<div class="search-panel">
    <form method="GET" action="{{ $action }}" class="search-form" role="search">
        <input type="search" name="buscar" value="{{ request('buscar') }}" placeholder="{{ $placeholder }}"
            class="search-input" aria-label="{{ $placeholder }}">
        <button type="submit" class="btn-primary">Buscar</button>
        @if (request()->filled('buscar'))
            <a href="{{ $action }}" class="btn-secondary">Limpiar</a>
        @endif
    </form>
</div>
