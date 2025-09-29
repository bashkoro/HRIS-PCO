@if ($paginator->hasPages())
<div class="d-flex justify-content-center align-items-center mt-4">
    <div class="d-flex align-items-center">
        <!-- Previous Page Link -->
        @if ($paginator->onFirstPage())
            <span class="btn btn-outline-secondary btn-sm me-2 disabled">
                <i class="bi bi-chevron-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-primary btn-sm me-2">
                <i class="bi bi-chevron-left"></i>
            </a>
        @endif

        <!-- Pagination Elements -->
        <div class="d-flex align-items-center">
            @foreach ($elements as $element)
                <!-- "Three Dots" Separator -->
                @if (is_string($element))
                    <span class="px-2 text-muted">{{ $element }}</span>
                @endif

                <!-- Array Of Links -->
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="btn btn-primary btn-sm mx-1 fw-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="btn btn-outline-light btn-sm mx-1 text-dark border-secondary">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        <!-- Next Page Link -->
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-primary btn-sm ms-2">
                <i class="bi bi-chevron-right"></i>
            </a>
        @else
            <span class="btn btn-outline-secondary btn-sm ms-2 disabled">
                <i class="bi bi-chevron-right"></i>
            </span>
        @endif
    </div>
</div>

<!-- Page Info -->
<div class="text-center mt-3">
    <small class="text-muted">
        Menampilkan {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        (Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }})
    </small>
</div>
@endif