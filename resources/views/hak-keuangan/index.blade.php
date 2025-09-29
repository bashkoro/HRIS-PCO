@extends('layouts.hris')

@section('title', 'Hak Keuangan - HRIS')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-primary fw-bold">Hak Keuangan</h1>
            <p class="text-muted-custom mb-0">Kelola informasi hak keuangan dan slip gaji Anda</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Hak Keuangan</li>
            </ol>
        </nav>
    </div>

    <!-- Informasi Hak Keuangan Card -->
    <div class="card card-custom">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0 text-white">
                <i class="bi bi-currency-dollar me-2"></i>Informasi Hak Keuangan
            </h5>
        </div>
        <div class="card-body">
            <!-- Filter and Search Section -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <form method="GET" action="{{ route('hak-keuangan.index') }}" id="filterForm">
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
                    <form method="GET" action="{{ route('hak-keuangan.index') }}">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                   class="form-control"
                                   name="search"
                                   placeholder="Cari slip gaji atau status..."
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
            @if($hakKeuangan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Slip Gaji</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Hak Keuangan</th>
                                <th>PPH 21</th>
                                <th>Iuran BPJS</th>
                                <th>Penghasilan Bersih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hakKeuangan as $item)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $item->slip_gaji }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            {{ \Carbon\Carbon::createFromFormat('Y-m', $item->periode)->format('F Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->status == 'pending')
                                            <span class="badge bg-warning">
                                                <i class="bi bi-clock me-1"></i>Pending
                                            </span>
                                        @elseif($item->status == 'approved')
                                            <span class="badge bg-info">
                                                <i class="bi bi-check-circle me-1"></i>Approved
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle-fill me-1"></i>Paid
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">{{ $item->formatted_hak_keuangan }}</span>
                                    </td>
                                    <td>
                                        <span class="text-danger">{{ $item->formatted_pph_21 }}</span>
                                    </td>
                                    <td>
                                        <span class="text-info">{{ $item->formatted_iuran_bpjs }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">{{ $item->formatted_penghasilan_bersih }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                {{ $hakKeuangan->appends(request()->query())->links('custom.pagination') }}
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-folder2-open display-1 text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-2">Belum Ada Data Hak Keuangan</h5>
                    <p class="text-muted mb-0">
                        @if(request('search') || request('periode'))
                            Tidak ada data yang sesuai dengan filter yang dipilih.
                            <br>
                            <a href="{{ route('hak-keuangan.index') }}" class="btn btn-link p-0">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                            </a>
                        @else
                            Data hak keuangan belum tersedia.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
</script>
@endpush