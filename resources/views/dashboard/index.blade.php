@extends('layouts.hris')

@section('title', 'Dashboard - HRIS')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-primary fw-bold">Dashboard</h1>
            <p class="text-muted-custom mb-0">Selamat datang, {{ $user->name }}</p>
        </div>
        <div class="text-end">
            <small class="text-muted-custom">{{ date('d F Y, H:i') }}</small>
        </div>
    </div>

    <!-- Dashboard Cards Row -->
    <div class="row mb-5">
        <!-- Presensi Card -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card dashboard-card fade-in">
                <div class="card-body text-center">
                    <div class="dashboard-card-icon text-primary">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h5 class="dashboard-card-title">Presensi Hari Ini</h5>
                    @if($todaysAttendance)
                        @if($todaysAttendance->waktu_masuk && $todaysAttendance->waktu_pulang)
                            <div class="badge bg-success mb-3">Selesai</div>
                            <p class="mb-2"><strong>Masuk:</strong> {{ $todaysAttendance->waktu_masuk }}</p>
                            <p class="mb-3"><strong>Pulang:</strong> {{ $todaysAttendance->waktu_pulang }}</p>
                        @elseif($todaysAttendance->waktu_masuk)
                            <div class="badge bg-warning mb-3">Sudah Masuk</div>
                            <p class="mb-3"><strong>Masuk:</strong> {{ $todaysAttendance->waktu_masuk }}</p>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#presensiModal" data-type="pulang">
                                <i class="bi bi-box-arrow-right me-1"></i>Presensi Pulang
                            </button>
                        @endif
                    @else
                        <div class="badge bg-secondary mb-3">Belum Presensi</div>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#presensiModal" data-type="masuk">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Presensi Masuk
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Cuti Card -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card dashboard-card fade-in">
                <div class="card-body text-center">
                    <div class="dashboard-card-icon text-warning">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h5 class="dashboard-card-title">Sisa Cuti</h5>
                    <div class="dashboard-card-value text-warning">{{ $user->sisa_cuti }}</div>
                    <p class="text-muted-custom mb-3">hari tersisa</p>
                    <a href="{{ route('cuti.index') }}" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-info-circle me-1"></i>Informasi Cuti
                    </a>
                </div>
            </div>
        </div>

        <!-- Employee Info Card -->
        <div class="col-lg-6 mb-4">
            <div class="card dashboard-card fade-in">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-person-badge fs-2 text-primary me-3"></i>
                        <h5 class="card-title mb-0">Informasi Pegawai</h5>
                    </div>
                    <ul class="list-group list-group-flush flex-grow-1">
                        <li class="list-group-item border-0 px-0"><strong>Nama:</strong> {{ $user->name }}</li>
                        <li class="list-group-item border-0 px-0"><strong>Unit Kerja:</strong> {{ $user->unit_kerja ?? 'Belum diatur' }}</li>
                        <li class="list-group-item border-0 px-0">
                            <strong>Status PNS:</strong>
                            <span class="badge {{ $user->status_pns === 'PNS' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $user->status_pns }}
                            </span>
                        </li>
                        <li class="list-group-item border-0 px-0"><strong>Status Kepegawaian:</strong> {{ $user->status_kepegawaian ?? 'Belum diatur' }}</li>
                    </ul>
                    <a href="{{ route('profile.show') }}" class="btn btn-primary mt-3 w-100">
                        <i class="bi bi-person-fill me-1"></i>Profil Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance History Card -->
    <div class="row">
        <div class="col-12">
            <div class="card card-custom fade-in">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-clock-history me-2"></i>Riwayat Presensi
                    </h5>

                    <!-- Filter Controls -->
                    <div class="d-flex justify-content-between mb-3 flex-wrap">
                        <div class="d-flex flex-nowrap">
                            <form method="GET" action="{{ route('dashboard') }}" class="d-flex gap-2">
                                <select name="month" class="form-select d-inline-block w-auto me-2" onchange="this.form.submit()">
                                    <option value="">Bulan</option>
                                    @php
                                        $months = [
                                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                        ];
                                    @endphp
                                    @foreach($months as $value => $name)
                                        <option value="{{ $value }}" {{ $month == $value ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="year" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                                    <option value="">Tahun</option>
                                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </form>
                        </div>
                        <button class="btn btn-success mt-2 mt-md-0">
                            <i class="bi bi-download"></i> Download Riwayat
                        </button>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Waktu Masuk</th>
                                    <th>Flexi</th>
                                    <th>Terlambat</th>
                                    <th>Pulang</th>
                                    <th>Cepat Pulang</th>
                                    <th>Total Jam Kerja</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendanceHistory as $attendance)
                                    <tr>
                                        <td>{{ $attendance->tanggal->format('Y-m-d') }}</td>
                                        <td>
                                            @if($attendance->waktu_masuk)
                                                {{ is_string($attendance->waktu_masuk) ? substr($attendance->waktu_masuk, 0, 5) : $attendance->waktu_masuk }}
                                                @if($attendance->is_outside_office)
                                                    <small class="text-muted">(Luar Kantor)</small>
                                                @elseif($attendance->office_building)
                                                    <small class="text-muted">({{ $attendance->office_building }})</small>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->waktu_masuk && $attendance->waktu_masuk <= '08:30:00')
                                                <span class="text-muted">-</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->is_late)
                                                <span class="badge bg-warning text-dark">Ya</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->waktu_pulang)
                                                {{ is_string($attendance->waktu_pulang) ? substr($attendance->waktu_pulang, 0, 5) : $attendance->waktu_pulang }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->is_early_leave)
                                                <span class="badge bg-danger">Ya</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->total_jam_kerja)
                                                {{ number_format($attendance->total_jam_kerja, 2) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->keterangan)
                                                <span class="badge bg-info">{{ $attendance->keterangan }}</span>
                                            @else
                                                <span class="badge bg-success">Hadir</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox display-4"></i>
                                                <p class="mt-2">Tidak ada data presensi untuk bulan ini</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    {{ $attendanceHistory->appends(request()->query())->links('custom.pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Presensi Modal -->
<div class="modal fade" id="presensiModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-geo-alt me-2"></i>Presensi <span id="presensiType">Masuk</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="locationStatus" class="alert alert-info">
                    <div class="d-flex align-items-center">
                        <div class="spinner-custom me-3"></div>
                        <span>Mendapatkan lokasi Anda...</span>
                    </div>
                </div>

                <div id="mapContainer" class="map-container mb-3" style="height: 300px; border-radius: .5rem; position: relative; display: none;">
                    <button id="recenterBtn" class="btn btn-light" style="position: absolute; top: 10px; right: 10px; z-index: 1000; display: none;" title="Center to my location">
                        <i class="bi bi-geo-alt-fill"></i>
                    </button>
                    <!-- Map will be loaded here -->
                </div>

                <div id="locationInfo" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Latitude:</strong> <span id="currentLat">-</span></p>
                            <p><strong>Longitude:</strong> <span id="currentLng">-</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong> <span id="officeStatus" class="badge">-</span></p>
                            <p><strong>Waktu:</strong> <span id="currentTime">-</span></p>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning" id="outsideOfficeWarning" style="display: none;">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Anda berada di luar area kantor. Silakan ambil foto sebagai bukti kehadiran.
                    <div class="mt-3">
                        <button type="button" class="btn btn-warning btn-sm" id="cameraBtn">
                            <i class="bi bi-camera-fill me-1"></i>Ambil Foto
                        </button>
                    </div>
                </div>

                <!-- Camera Section -->
                <div id="cameraSection" style="display: none;">
                    <div class="mb-3">
                        <video id="cameraVideo" class="w-100" style="max-height: 200px; border-radius: .5rem;" autoplay playsinline></video>
                        <canvas id="cameraCanvas" style="display: none;"></canvas>
                    </div>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-success btn-sm" id="captureBtn">
                            <i class="bi bi-camera me-1"></i>Ambil
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" id="cancelCameraBtn">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </button>
                    </div>
                </div>

                <!-- Photo Preview -->
                <div id="photoPreview" style="display: none;">
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>Foto berhasil diambil
                    </div>
                    <div class="text-center mb-3">
                        <img id="previewImage" class="img-fluid" style="max-height: 200px; border-radius: .5rem;" alt="Preview foto">
                    </div>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-warning btn-sm" id="retakeBtn">
                            <i class="bi bi-arrow-clockwise me-1"></i>Ambil Ulang
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmPresensi" disabled>
                    <i class="bi bi-check-circle me-1"></i>Konfirmasi Presensi
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// JavaScript will be loaded from dashboard.js
</script>
@endpush