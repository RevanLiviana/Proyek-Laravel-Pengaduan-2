@if ($paginator->hasPages())
<nav>
    <ul class="pagination pagination-sm mb-0" style="gap:2px;">

        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link" style="border-radius:7px;border-color:#E2E8F0;">
                    <i class="bi bi-chevron-left" style="font-size:11px;"></i>
                </span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                   style="border-radius:7px;border-color:#E2E8F0;color:#64748B;">
                    <i class="bi bi-chevron-left" style="font-size:11px;"></i>
                </a>
            </li>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="page-link" style="border-radius:7px;border-color:#E2E8F0;">{{ $element }}</span>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link"
                                  style="border-radius:7px;background:#3B5BDB;border-color:#3B5BDB;">
                                {{ $page }}
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}"
                               style="border-radius:7px;border-color:#E2E8F0;color:#64748B;">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}"
                   style="border-radius:7px;border-color:#E2E8F0;color:#64748B;">
                    <i class="bi bi-chevron-right" style="font-size:11px;"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link" style="border-radius:7px;border-color:#E2E8F0;">
                    <i class="bi bi-chevron-right" style="font-size:11px;"></i>
                </span>
            </li>
        @endif

    </ul>
</nav>
@endif