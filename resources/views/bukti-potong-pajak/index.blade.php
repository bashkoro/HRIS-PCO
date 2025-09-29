@extends('layouts.hris')

@section('title', 'Bukti Potong Pajak - HRIS')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-primary fw-bold">Bukti Potong Pajak</h1>
            <p class="text-muted-custom mb-0">Kelola dan unduh bukti potong pajak Anda</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Bukti Potong Pajak</li>
            </ol>
        </nav>
    </div>

    <!-- Bukti Potong Pajak Card -->
    <div class="card card-custom">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0 text-white">
                <i class="bi bi-receipt me-2"></i>Bukti Potong Pajak
            </h5>
        </div>
        <div class="card-body">
            <!-- Filter and Search Section -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <form method="GET" action="{{ route('bukti-potong-pajak.index') }}" id="filterForm">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-calendar3"></i>
                            </span>
                            <select class="form-select" name="periode" onchange="document.getElementById('filterForm').submit();">
                                <option value="">Semua Periode</option>
                                @foreach($periods as $period)
                                    <option value="{{ $period }}" {{ request('periode') == $period ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromFormat('Y-m', $period)->format('F Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    </form>
                </div>
                <div class="col-md-4 offset-md-4">
                    <form method="GET" action="{{ route('bukti-potong-pajak.index') }}">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                   class="form-control"
                                   name="search"
                                   placeholder="Cari keterangan..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <input type="hidden" name="periode" value="{{ request('periode') }}">
                    </form>
                </div>
            </div>

            <!-- Data Table -->
            @if($buktiPotongPajak->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="20%">Periode</th>
                                <th width="15%">Lihat</th>
                                <th width="15%">Unduh</th>
                                <th width="50%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buktiPotongPajak as $item)
                                <tr>
                                    <td>
                                        <span class="text-muted fw-medium">
                                            {{ $item->formatted_periode }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->is_available && $item->file_path)
                                            <button class="btn btn-outline-primary btn-sm"
                                                    onclick="viewDocument({{ $item->id }})"
                                                    data-bs-toggle="tooltip"
                                                    title="Lihat Dokumen">
                                                <i class="bi bi-eye me-1"></i>Lihat
                                            </button>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-x-circle me-1"></i>Tidak Tersedia
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_available && $item->file_path)
                                            <a href="{{ route('bukti-potong-pajak.download', $item->id) }}"
                                               class="btn btn-outline-success btn-sm"
                                               data-bs-toggle="tooltip"
                                               title="Unduh Dokumen">
                                                <i class="bi bi-download me-1"></i>Unduh
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-x-circle me-1"></i>Tidak Tersedia
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $item->keterangan }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                {{ $buktiPotongPajak->appends(request()->query())->links('custom.pagination') }}
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-folder2-open display-1 text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-2">Belum Ada Bukti Potong Pajak</h5>
                    <p class="text-muted mb-0">
                        @if(request('search') || request('periode'))
                            Tidak ada data yang sesuai dengan filter yang dipilih.
                            <br>
                            <a href="{{ route('bukti-potong-pajak.index') }}" class="btn btn-link p-0">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                            </a>
                        @else
                            Bukti potong pajak belum tersedia.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- View Document Modal -->
<div class="modal fade" id="viewDocumentModal" tabindex="-1" aria-labelledby="viewDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="viewDocumentModalLabel">
                    <i class="bi bi-file-text me-2"></i>Lihat Bukti Potong Pajak
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-5">
                    <i class="bi bi-file-earmark-pdf display-1 text-danger"></i>
                    <h5 class="mt-3">Preview Dokumen</h5>
                    <p class="text-muted">Dalam implementasi nyata, dokumen PDF akan ditampilkan di sini.</p>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Fitur preview dokumen akan tersedia setelah integrasi dengan sistem penyimpanan file.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="downloadFromModal()">
                    <i class="bi bi-download me-1"></i>Unduh Dokumen
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-submit search form on Enter key
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.closest('form').submit();
            }
        });
    }

    // Highlight search terms
    const searchTerm = '{{ request("search") }}';
    if (searchTerm) {
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        document.querySelectorAll('tbody td').forEach(function(cell) {
            if (cell.textContent.toLowerCase().includes(searchTerm.toLowerCase())) {
                cell.innerHTML = cell.innerHTML.replace(regex, '<mark>$1</mark>');
            }
        });
    }
});

let currentDocumentId = null;

function viewDocument(id) {
    currentDocumentId = id;
    const modal = new bootstrap.Modal(document.getElementById('viewDocumentModal'));
    modal.show();
}

function downloadFromModal() {
    if (currentDocumentId) {
        window.location.href = `/bukti-potong-pajak/${currentDocumentId}/download`;
    }
}
</script>
@endpush