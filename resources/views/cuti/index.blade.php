@extends('layouts.hris')

@section('title', 'Informasi Cuti - HRIS')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-primary fw-bold">Informasi Cuti</h1>
            <p class="text-muted-custom mb-0">Kelola dan pantau cuti Anda</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cutiModal">
            <i class="bi bi-plus-circle me-1"></i>Ajukan Cuti
        </button>
    </div>

    <!-- Cuti Summary Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card dashboard-card fade-in">
                <div class="card-body text-center">
                    <div class="dashboard-card-icon text-success">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h6 class="dashboard-card-title">Sisa Cuti</h6>
                    <div class="dashboard-card-value text-success">{{ $user->sisa_cuti }}</div>
                    <small class="text-muted-custom">hari</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card dashboard-card fade-in">
                <div class="card-body text-center">
                    <div class="dashboard-card-icon text-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <h6 class="dashboard-card-title">Menunggu Persetujuan</h6>
                    <div class="dashboard-card-value text-warning">
                        {{ $cutiHistory->where('status', 'pending')->count() }}
                    </div>
                    <small class="text-muted-custom">pengajuan</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card dashboard-card fade-in">
                <div class="card-body text-center">
                    <div class="dashboard-card-icon text-primary">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h6 class="dashboard-card-title">Disetujui</h6>
                    <div class="dashboard-card-value text-primary">
                        {{ $cutiHistory->where('status', 'approved')->count() }}
                    </div>
                    <small class="text-muted-custom">pengajuan</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card dashboard-card fade-in">
                <div class="card-body text-center">
                    <div class="dashboard-card-icon text-danger">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <h6 class="dashboard-card-title">Ditolak</h6>
                    <div class="dashboard-card-value text-danger">
                        {{ $cutiHistory->where('status', 'rejected')->count() }}
                    </div>
                    <small class="text-muted-custom">pengajuan</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pengajuan Cuti -->
    <div class="row">
        <div class="col-12">
            <div class="card card-custom fade-in">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-clock-history me-2"></i>Riwayat Pengajuan Cuti
                    </h5>

                    <!-- Filter Controls -->
                    <div class="d-flex justify-content-between mb-3 flex-wrap">
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                        </div>
                        <button class="btn btn-success mt-2 mt-md-0">
                            <i class="bi bi-download"></i> Download Riwayat
                        </button>
                    </div>

                    <!-- Advanced Filter Section -->
                    <div class="collapse" id="filterCollapse">
                        <div class="card mb-3">
                            <div class="card-body">
                                <form id="filterForm">
                                    <div class="row">
                                        <!-- Jenis Cuti Filter -->
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-tag me-1"></i>Jenis Cuti
                                            </label>
                                            <select class="form-select form-select-sm" id="filter_jenis_cuti" name="jenis_cuti">
                                                <option value="">Semua Jenis</option>
                                                <option value="CT">CT - Cuti Tahunan</option>
                                                <option value="CM">CM - Cuti Melahirkan</option>
                                                <option value="CS">CS - Cuti Sakit</option>
                                            </select>
                                        </div>

                                        <!-- Status Proses Filter -->
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-gear me-1"></i>Status Proses
                                            </label>
                                            <div class="border rounded p-2" style="height: 120px; overflow-y: auto;">
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="draft" id="status_draft" name="status_proses[]">
                                                    <label class="form-check-label small" for="status_draft">Draft</label>
                                                </div>
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="diajukan" id="status_diajukan" name="status_proses[]">
                                                    <label class="form-check-label small" for="status_diajukan">Diajukan</label>
                                                </div>
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="menunggu_verifikasi" id="status_menunggu_verifikasi" name="status_proses[]">
                                                    <label class="form-check-label small" for="status_menunggu_verifikasi">Menunggu Verifikasi</label>
                                                </div>
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="verifikasi" id="status_verifikasi" name="status_proses[]">
                                                    <label class="form-check-label small" for="status_verifikasi">Verifikasi</label>
                                                </div>
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="menunggu_persetujuan" id="status_menunggu_persetujuan" name="status_proses[]">
                                                    <label class="form-check-label small" for="status_menunggu_persetujuan">Menunggu Persetujuan Pimpinan</label>
                                                </div>
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="persetujuan_pimpinan" id="status_persetujuan_pimpinan" name="status_proses[]">
                                                    <label class="form-check-label small" for="status_persetujuan_pimpinan">Persetujuan Pimpinan</label>
                                                </div>
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="menunggu_proses" id="status_menunggu_proses" name="status_proses[]">
                                                    <label class="form-check-label small" for="status_menunggu_proses">Menunggu Proses</label>
                                                </div>
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="proses" id="status_proses" name="status_proses[]">
                                                    <label class="form-check-label small" for="status_proses">Proses</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Status Persetujuan Filter -->
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-check-circle me-1"></i>Status Persetujuan
                                            </label>
                                            <div class="border rounded p-2" style="height: 120px; overflow-y: auto;">
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="belum_disetujui" id="persetujuan_belum" name="status_persetujuan[]">
                                                    <label class="form-check-label small" for="persetujuan_belum">Belum Disetujui</label>
                                                </div>
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="disetujui" id="persetujuan_disetujui" name="status_persetujuan[]">
                                                    <label class="form-check-label small" for="persetujuan_disetujui">Disetujui</label>
                                                </div>
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="perubahan" id="persetujuan_perubahan" name="status_persetujuan[]">
                                                    <label class="form-check-label small" for="persetujuan_perubahan">Perubahan</label>
                                                </div>
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="ditangguhkan" id="persetujuan_ditangguhkan" name="status_persetujuan[]">
                                                    <label class="form-check-label small" for="persetujuan_ditangguhkan">Ditangguhkan</label>
                                                </div>
                                                <div class="form-check form-check-sm">
                                                    <input class="form-check-input" type="checkbox" value="tidak_disetujui" id="persetujuan_tidak" name="status_persetujuan[]">
                                                    <label class="form-check-label small" for="persetujuan_tidak">Tidak Disetujui</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Periode Filter -->
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label fw-medium">
                                                <i class="bi bi-calendar-range me-1"></i>Periode
                                            </label>
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <input type="date" class="form-control form-control-sm" id="filter_tanggal_dari" name="tanggal_dari" placeholder="Dari Tanggal">
                                                </div>
                                                <div class="col-12">
                                                    <input type="date" class="form-control form-control-sm" id="filter_tanggal_sampai" name="tanggal_sampai" placeholder="Sampai Tanggal">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-primary btn-sm" id="applyFilter">
                                                    <i class="bi bi-search me-1"></i>Terapkan Filter
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary btn-sm" id="resetFilter">
                                                    <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Jenis Cuti</th>
                                    <th>Jumlah Hari</th>
                                    <th>Status Proses</th>
                                    <th>Status Persetujuan</th>
                                    <th>Alasan/Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cutiHistory as $cuti)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary me-2">{{ $cuti->jenis_cuti }}</span>
                                                @switch($cuti->jenis_cuti)
                                                    @case('CT')
                                                        <small class="text-muted">Cuti Tahunan</small>
                                                        @break
                                                    @case('CM')
                                                        <small class="text-muted">Cuti Melahirkan</small>
                                                        @break
                                                    @case('CS')
                                                        <small class="text-muted">Cuti Sakit</small>
                                                        @break
                                                @endswitch
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <span class="fw-bold text-primary">{{ $cuti->tanggal_mulai->diffInDays($cuti->tanggal_selesai) + 1 }}</span>
                                                <small class="text-muted d-block">hari</small>
                                            </div>
                                        </td>
                                        <td>
                                            @switch($cuti->status)
                                                @case('pending')
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="bi bi-hourglass-split me-1"></i>Menunggu
                                                    </span>
                                                    @break
                                                @case('approved')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Disetujui
                                                    </span>
                                                    @break
                                                @case('rejected')
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle me-1"></i>Ditolak
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">
                                                        <i class="bi bi-question-circle me-1"></i>{{ ucfirst($cuti->status) }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @switch($cuti->status_persetujuan ?? 'belum_disetujui')
                                                @case('disetujui')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Disetujui
                                                    </span>
                                                    @break
                                                @case('tidak_disetujui')
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle me-1"></i>Tidak Disetujui
                                                    </span>
                                                    @break
                                                @case('ditangguhkan')
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="bi bi-pause-circle me-1"></i>Ditangguhkan
                                                    </span>
                                                    @break
                                                @case('perubahan')
                                                    <span class="badge bg-info">
                                                        <i class="bi bi-arrow-repeat me-1"></i>Perubahan
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark">
                                                        <i class="bi bi-clock me-1"></i>Belum Disetujui
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 200px;" title="{{ $cuti->alasan }}">
                                                {{ $cuti->alasan }}
                                            </div>
                                            <small class="text-muted">{{ $cuti->tanggal_mulai->format('d/m/Y') }} - {{ $cuti->tanggal_selesai->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-outline-primary btn-sm" title="Lihat Detail"
                                                        onclick="viewCutiDetail({{ $cuti->id }})">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @if($cuti->status === 'pending')
                                                    <button class="btn btn-outline-warning btn-sm" title="Edit"
                                                            onclick="editCuti({{ $cuti->id }})">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" title="Batalkan"
                                                            onclick="cancelCuti({{ $cuti->id }})">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                                <h6>Belum ada pengajuan cuti</h6>
                                                <p class="mb-3">Mulai ajukan cuti pertama Anda untuk melihat riwayat di sini</p>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cutiModal">
                                                    <i class="bi bi-plus-circle me-1"></i>Ajukan Cuti Pertama
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    {{ $cutiHistory->links('custom.pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajukan Cuti -->
<div class="modal fade" id="cutiModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-plus me-2"></i>Ajukan Cuti
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('cuti.store') }}" enctype="multipart/form-data" id="cutiForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Jenis Cuti -->
                            <div class="mb-3">
                                <label for="jenis_cuti" class="form-label fw-medium">
                                    <i class="bi bi-tag me-1"></i>Jenis Cuti
                                </label>
                                <select class="form-select" id="jenis_cuti" name="jenis_cuti" required>
                                    <option value="">Pilih Jenis Cuti</option>
                                    <option value="CT">CT - Cuti Tahunan</option>
                                    <option value="CM">CM - Cuti Melahirkan</option>
                                    <option value="CS">CS - Cuti Sakit</option>
                                </select>
                            </div>

                            <!-- Alasan Cuti -->
                            <div class="mb-3">
                                <label for="alasan" class="form-label fw-medium">
                                    <i class="bi bi-chat-text me-1"></i>Alasan Cuti
                                </label>
                                <textarea class="form-control" id="alasan" name="alasan" rows="4"
                                          placeholder="Jelaskan alasan pengajuan cuti..." required maxlength="1000"></textarea>
                                <small class="form-text text-muted">Sisa karakter: <span id="charCount">1000</span></small>
                            </div>

                            <!-- Alamat Selama Cuti -->
                            <div class="mb-3">
                                <label for="alamat_cuti" class="form-label fw-medium">
                                    <i class="bi bi-geo-alt me-1"></i>Alamat Selama Cuti
                                </label>
                                <textarea class="form-control" id="alamat_cuti" name="alamat_cuti" rows="3"
                                          placeholder="Masukkan alamat lengkap selama cuti..." required></textarea>
                            </div>

                            <!-- Telepon -->
                            <div class="mb-3">
                                <label for="telepon_cuti" class="form-label fw-medium">
                                    <i class="bi bi-telephone me-1"></i>Nomor Telepon
                                </label>
                                <input type="text" class="form-control" id="telepon_cuti" name="telepon_cuti"
                                       placeholder="Nomor telepon yang bisa dihubungi" required>
                                <small class="form-text text-muted">Nomor telepon yang dapat dihubungi selama cuti</small>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <!-- Tanggal Cuti -->
                            <div class="mb-3">
                                <label class="form-label fw-medium">
                                    <i class="bi bi-calendar-event me-1"></i>Tanggal Cuti
                                </label>
                                <div class="card border-light">
                                    <div class="card-body p-3">
                                        <div class="mb-3">
                                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                                   min="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                                   min="{{ date('Y-m-d') }}" required>
                                        </div>

                                        <!-- Multiple Date Picker -->
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="multipleDates">
                                                <label class="form-check-label" for="multipleDates">
                                                    Pilih tanggal terpisah (tidak berturut-turut)
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Selected Dates Display -->
                                        <div id="selectedDatesContainer" style="display: none;">
                                            <label class="form-label">Tanggal yang Dipilih:</label>
                                            <div id="selectedDatesList" class="mb-2"></div>
                                            <button type="button" class="btn btn-outline-primary btn-sm" id="addDateBtn">
                                                <i class="bi bi-plus me-1"></i>Tambah Tanggal
                                            </button>
                                        </div>

                                        <!-- Total Days Counter -->
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="card border-primary">
                                                    <div class="card-body py-2 px-3">
                                                        <small class="text-muted">Hari yang diambil</small>
                                                        <div class="fw-bold text-primary"><span id="totalDays">0</span> hari</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card border-success">
                                                    <div class="card-body py-2 px-3">
                                                        <small class="text-muted">Sisa cuti Anda</small>
                                                        <div class="fw-bold text-success">{{ $user->sisa_cuti }} hari</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pejabat Pemberi Cuti -->
                            <div class="mb-3">
                                <label for="pejabat_pemberi_cuti" class="form-label fw-medium">
                                    <i class="bi bi-person-badge me-1"></i>Pejabat Pemberi Cuti
                                </label>
                                <select class="form-select" id="pejabat_pemberi_cuti" name="pejabat_pemberi_cuti" required>
                                    <option value="">Pilih Pejabat yang Akan Menyetujui</option>
                                    <option value="kepala_bagian">Kepala Bagian</option>
                                    <option value="kepala_divisi">Kepala Divisi</option>
                                    <option value="direktur">Direktur</option>
                                    <option value="kepala_kantor">Kepala Kantor Komunikasi Kepresidenan</option>
                                </select>
                            </div>

                            <!-- Lampiran -->
                            <div class="mb-3">
                                <label for="lampiran" class="form-label fw-medium">
                                    <i class="bi bi-paperclip me-1"></i>Lampiran <small class="text-muted">(Opsional)</small>
                                </label>
                                <input type="file" class="form-control" id="lampiran" name="lampiran"
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple>
                                <small class="form-text text-muted">
                                    Format yang didukung: PDF, DOC, DOCX, JPG, PNG (Max: 5MB per file)
                                </small>
                                <div id="fileList" class="mt-2"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden input for selected dates -->
                    <input type="hidden" id="selected_dates" name="selected_dates">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitCuti" disabled>
                        <i class="bi bi-send me-1"></i>Ajukan Cuti
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Cuti -->
<div class="modal fade" id="cutiDetailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle me-2"></i>Detail Pengajuan Cuti
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="cutiDetailContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form elements
    const tanggalMulai = document.getElementById('tanggal_mulai');
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    const multipleDatesCheckbox = document.getElementById('multipleDates');
    const selectedDatesContainer = document.getElementById('selectedDatesContainer');
    const selectedDatesList = document.getElementById('selectedDatesList');
    const addDateBtn = document.getElementById('addDateBtn');
    const totalDaysSpan = document.getElementById('totalDays');
    const selectedDatesInput = document.getElementById('selected_dates');
    const submitBtn = document.getElementById('submitCuti');
    const alasan = document.getElementById('alasan');
    const charCount = document.getElementById('charCount');
    const lampiranInput = document.getElementById('lampiran');
    const fileList = document.getElementById('fileList');

    let selectedDates = [];
    const sisaCuti = {{ $user->sisa_cuti }};

    // Character counter for alasan
    alasan.addEventListener('input', function() {
        const remaining = 1000 - this.value.length;
        charCount.textContent = remaining;
        charCount.className = remaining < 100 ? 'text-danger' : remaining < 200 ? 'text-warning' : 'text-muted';
    });

    // Toggle between continuous and multiple dates
    multipleDatesCheckbox.addEventListener('change', function() {
        if (this.checked) {
            // Show multiple dates selector
            selectedDatesContainer.style.display = 'block';
            tanggalMulai.style.display = 'none';
            tanggalSelesai.style.display = 'none';
            tanggalMulai.parentElement.style.display = 'none';
            tanggalSelesai.parentElement.style.display = 'none';

            // Clear existing dates
            selectedDates = [];
            updateSelectedDatesList();
            calculateTotalDays();
        } else {
            // Show continuous date range
            selectedDatesContainer.style.display = 'none';
            tanggalMulai.style.display = 'block';
            tanggalSelesai.style.display = 'block';
            tanggalMulai.parentElement.style.display = 'block';
            tanggalSelesai.parentElement.style.display = 'block';

            // Clear selected dates
            selectedDates = [];
            calculateTotalDays();
        }
    });

    // Add date button functionality
    addDateBtn.addEventListener('click', function() {
        const today = new Date().toISOString().split('T')[0];
        const dateInput = document.createElement('input');
        dateInput.type = 'date';
        dateInput.className = 'form-control form-control-sm mb-2';
        dateInput.min = today;

        dateInput.addEventListener('change', function() {
            const selectedDate = this.value;
            if (selectedDate && !selectedDates.includes(selectedDate)) {
                selectedDates.push(selectedDate);
                selectedDates.sort();
                updateSelectedDatesList();
                calculateTotalDays();
                this.remove();
            }
        });

        addDateBtn.parentNode.insertBefore(dateInput, addDateBtn);
        dateInput.focus();
    });

    // Calculate duration for continuous dates
    function calculateContinuousDuration() {
        if (tanggalMulai.value && tanggalSelesai.value) {
            const start = new Date(tanggalMulai.value);
            const end = new Date(tanggalSelesai.value);

            if (end < start) {
                tanggalSelesai.value = tanggalMulai.value;
                return 1;
            }

            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            return diffDays;
        }
        return 0;
    }

    // Calculate total days
    function calculateTotalDays() {
        let totalDays = 0;

        if (multipleDatesCheckbox.checked) {
            totalDays = selectedDates.length;
            selectedDatesInput.value = JSON.stringify(selectedDates);
        } else {
            totalDays = calculateContinuousDuration();
            if (tanggalMulai.value && tanggalSelesai.value) {
                selectedDatesInput.value = JSON.stringify({
                    start: tanggalMulai.value,
                    end: tanggalSelesai.value,
                    continuous: true
                });
            }
        }

        totalDaysSpan.textContent = totalDays;

        // Validate against remaining leave
        if (totalDays > sisaCuti || totalDays <= 0) {
            totalDaysSpan.parentElement.className = 'alert alert-danger mb-0 mt-3';
            submitBtn.disabled = true;
        } else {
            totalDaysSpan.parentElement.className = 'alert alert-info mb-0 mt-3';
            validateForm();
        }
    }

    // Update selected dates list display
    function updateSelectedDatesList() {
        selectedDatesList.innerHTML = '';
        selectedDates.forEach(function(date, index) {
            const dateSpan = document.createElement('span');
            dateSpan.className = 'badge bg-primary me-2 mb-2';
            dateSpan.innerHTML = `
                ${formatDate(date)}
                <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 0.7em;"
                        onclick="removeDate(${index})"></button>
            `;
            selectedDatesList.appendChild(dateSpan);
        });
    }

    // Remove date from selected dates
    window.removeDate = function(index) {
        selectedDates.splice(index, 1);
        updateSelectedDatesList();
        calculateTotalDays();
    };

    // Format date for display
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID');
    }

    // Date change event listeners
    tanggalMulai.addEventListener('change', function() {
        tanggalSelesai.min = this.value;
        if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
            tanggalSelesai.value = this.value;
        }
        calculateTotalDays();
    });

    tanggalSelesai.addEventListener('change', calculateTotalDays);

    // File upload handling
    lampiranInput.addEventListener('change', function() {
        const files = this.files;
        let fileListHTML = '';
        let totalSize = 0;
        let hasError = false;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileSize = file.size / (1024 * 1024); // Convert to MB
            totalSize += fileSize;

            let statusClass = 'text-success';
            let statusIcon = 'bi-check-circle';

            if (fileSize > 5) {
                statusClass = 'text-danger';
                statusIcon = 'bi-x-circle';
                hasError = true;
            }

            fileListHTML += `
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <i class="bi bi-file-earmark me-2"></i>
                        <strong>${file.name}</strong>
                        <small class="text-muted d-block">${fileSize.toFixed(2)} MB</small>
                    </div>
                    <i class="bi ${statusIcon} ${statusClass}"></i>
                </div>
            `;
        }

        if (hasError) {
            fileListHTML += '<div class="alert alert-danger mt-2"><small>Beberapa file melebihi ukuran maksimum (5MB)</small></div>';
        }

        fileList.innerHTML = fileListHTML;
    });

    // Form validation
    function validateForm() {
        const jenisCuti = document.getElementById('jenis_cuti').value;
        const alasanValue = alasan.value.trim();
        const alamatCuti = document.getElementById('alamat_cuti').value.trim();
        const teleponCuti = document.getElementById('telepon_cuti').value.trim();
        const pejabatPemberiCuti = document.getElementById('pejabat_pemberi_cuti').value;

        const totalDays = parseInt(totalDaysSpan.textContent);
        const hasValidDates = multipleDatesCheckbox.checked ?
            selectedDates.length > 0 :
            (tanggalMulai.value && tanggalSelesai.value);

        const isValid = jenisCuti && alasanValue && alamatCuti && teleponCuti &&
                       pejabatPemberiCuti && hasValidDates &&
                       totalDays > 0 && totalDays <= sisaCuti;

        submitBtn.disabled = !isValid;
    }

    // Add validation listeners
    document.getElementById('jenis_cuti').addEventListener('change', validateForm);
    alasan.addEventListener('input', validateForm);
    document.getElementById('alamat_cuti').addEventListener('input', validateForm);
    document.getElementById('telepon_cuti').addEventListener('input', validateForm);
    document.getElementById('pejabat_pemberi_cuti').addEventListener('change', validateForm);

    // Form submission
    document.getElementById('cutiForm').addEventListener('submit', function(e) {
        // Final validation
        if (submitBtn.disabled) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi dan pastikan jumlah hari cuti tidak melebihi sisa cuti Anda.');
        }
    });

    // Initialize
    calculateTotalDays();
});

function viewCutiDetail(id) {
    document.getElementById('cutiDetailContent').innerHTML = `
        <div class="text-center">
            <div class="spinner-custom mb-3"></div>
            <p>Memuat detail cuti...</p>
        </div>
    `;

    const modal = new bootstrap.Modal(document.getElementById('cutiDetailModal'));
    modal.show();

    // Simulate API call
    setTimeout(() => {
        document.getElementById('cutiDetailContent').innerHTML = `
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Fitur detail cuti akan tersedia setelah implementasi lengkap.
            </div>
        `;
    }, 1000);
}

function cancelCuti(id) {
    if (confirm('Apakah Anda yakin ingin membatalkan pengajuan cuti ini?')) {
        alert('Fitur batalkan cuti akan tersedia setelah implementasi lengkap.');
    }
}

function editCuti(id) {
    alert('Fitur edit cuti akan tersedia setelah implementasi lengkap.');
}

// Advanced filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const applyFilterBtn = document.getElementById('applyFilter');
    const resetFilterBtn = document.getElementById('resetFilter');

    // Apply filter functionality
    if (applyFilterBtn) {
        applyFilterBtn.addEventListener('click', function() {
            const formData = new FormData(document.getElementById('filterForm'));
            const params = new URLSearchParams();

            // Get jenis cuti filter
            const jenisCuti = formData.get('jenis_cuti');
            if (jenisCuti) params.append('jenis_cuti', jenisCuti);

            // Get status proses filters
            const statusProses = formData.getAll('status_proses[]');
            statusProses.forEach(status => params.append('status_proses[]', status));

            // Get status persetujuan filters
            const statusPersetujuan = formData.getAll('status_persetujuan[]');
            statusPersetujuan.forEach(status => params.append('status_persetujuan[]', status));

            // Get date filters
            const tanggalDari = formData.get('tanggal_dari');
            const tanggalSampai = formData.get('tanggal_sampai');
            if (tanggalDari) params.append('tanggal_dari', tanggalDari);
            if (tanggalSampai) params.append('tanggal_sampai', tanggalSampai);

            // Reload page with filter parameters
            const url = new URL(window.location);
            url.search = params.toString();
            window.location.href = url.toString();
        });
    }

    // Reset filter functionality
    if (resetFilterBtn) {
        resetFilterBtn.addEventListener('click', function() {
            document.getElementById('filterForm').reset();
            // Remove filter parameters and reload
            window.location.href = window.location.pathname;
        });
    }

    // Auto-expand filter if there are existing filter parameters
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.toString()) {
        const filterCollapseElement = document.getElementById('filterCollapse');
        if (filterCollapseElement) {
            const filterCollapse = new bootstrap.Collapse(filterCollapseElement, {
                show: true
            });

            // Restore filter values from URL
            if (urlParams.get('jenis_cuti')) {
                const jenisSelect = document.getElementById('filter_jenis_cuti');
                if (jenisSelect) jenisSelect.value = urlParams.get('jenis_cuti');
            }

            if (urlParams.get('tanggal_dari')) {
                const tanggalDari = document.getElementById('filter_tanggal_dari');
                if (tanggalDari) tanggalDari.value = urlParams.get('tanggal_dari');
            }

            if (urlParams.get('tanggal_sampai')) {
                const tanggalSampai = document.getElementById('filter_tanggal_sampai');
                if (tanggalSampai) tanggalSampai.value = urlParams.get('tanggal_sampai');
            }

            // Restore checkbox values
            urlParams.getAll('status_proses[]').forEach(value => {
                const checkbox = document.querySelector(`input[name="status_proses[]"][value="${value}"]`);
                if (checkbox) checkbox.checked = true;
            });

            urlParams.getAll('status_persetujuan[]').forEach(value => {
                const checkbox = document.querySelector(`input[name="status_persetujuan[]"][value="${value}"]`);
                if (checkbox) checkbox.checked = true;
            });
        }
    }
});
</script>
@endpush