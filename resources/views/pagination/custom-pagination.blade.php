@if ($paginator->hasPages())
    <div class="pagination-container">
        <ul class="pagination">
            {{-- Botón de "Primera" --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Primera</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}">Primera</a>
                </li>
            @endif

            {{-- Botones anteriores --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Botón de "Última" --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">Última</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Última</span>
                </li>
            @endif
        </ul>
    </div>
@endif
<style>
.pagination-container {
    margin-top: 30px;
    margin-bottom: 40px;
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    list-style: none;
    gap: 15px;
}

.page-item {
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #3498db;
}

.page-link {
    color: #3498db;
    background-color: #ffffff;
    padding: 12px 24px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    transition: background-color 0.3s ease, transform 0.2s ease;
    text-decoration: none;
}

.page-link:hover {
    background-color: #3498db;
    color: white;
    transform: scale(1.1);
}

.page-item.active .page-link {
    background-color: #3498db;
    color: white;
    border: 2px solid #3498db;
}

.page-item.disabled .page-link {
    background-color: #f1f1f1;
    color: #ccc;
    pointer-events: none;
}

.page-item.disabled .page-link:hover {
    background-color: #f1f1f1;
    color: #ccc; /* Color gris */
    transform: none;
}


</style>