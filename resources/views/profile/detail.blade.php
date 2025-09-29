@extends('layouts.hris')

@section('title', 'Profil Lengkap - HRIS')

@section('content')
<div class="container mt-4">
    <div class="card card-custom">
        <div class="card-body">
            <div class="row">
                <!-- Profile Sidebar -->
                <div class="col-lg-3 col-md-4 text-center border-end">
                    <img src="https://via.placeholder.com/200" class="img-fluid rounded-circle mb-3" alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover;">
                    <h4 class="card-title">{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->status_kepegawaian ?? 'Pegawai' }}</p>
                    <button class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil me-2"></i>Edit Profile
                    </button>
                </div>

                <!-- Profile Content -->
                <div class="col-lg-9 col-md-8">
                    <ul class="nav nav-tabs" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="biodata-tab" data-bs-toggle="tab" data-bs-target="#biodata" type="button" role="tab" aria-controls="biodata" aria-selected="true">
                                <i class="bi bi-person me-2"></i>Biodata
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="alamat-tab" data-bs-toggle="tab" data-bs-target="#alamat" type="button" role="tab" aria-controls="alamat" aria-selected="false">
                                <i class="bi bi-house me-2"></i>Alamat
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="keputusan-tab" data-bs-toggle="tab" data-bs-target="#keputusan" type="button" role="tab" aria-controls="keputusan" aria-selected="false">
                                <i class="bi bi-file-earmark-text me-2"></i>Keputusan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="fasilitas-tab" data-bs-toggle="tab" data-bs-target="#fasilitas" type="button" role="tab" aria-controls="fasilitas" aria-selected="false">
                                <i class="bi bi-building me-2"></i>Fasilitas
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab" aria-controls="files" aria-selected="false">
                                <i class="bi bi-folder me-2"></i>Files
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content pt-3" id="profileTabContent">
                        <!-- Biodata Tab -->
                        <div class="tab-pane fade show active" id="biodata" role="tabpanel" aria-labelledby="biodata-tab">
                            <h5 class="mb-3">Informasi Pribadi</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>NIK:</strong> -</p>
                                    <p><strong>NPWP:</strong> -</p>
                                    <p><strong>Nama:</strong> {{ $user->name }}</p>
                                    <p><strong>Tempat, Tgl Lahir:</strong> -</p>
                                    <p><strong>Agama:</strong> -</p>
                                    <p><strong>Kelamin:</strong> -</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Pendidikan Terakhir:</strong> -</p>
                                    <p><strong>Status Perkawinan:</strong> -</p>
                                    <p><strong>Nomor HP:</strong> -</p>
                                    <p><strong>Nomor Telp:</strong> -</p>
                                    <p><strong>Email Kantor:</strong> {{ $user->email }}</p>
                                    <p><strong>Email Pribadi:</strong> -</p>
                                </div>
                            </div>
                            <hr>
                            <h5 class="mb-3">Informasi Kepegawaian</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>NIP:</strong> {{ $user->id ? str_pad($user->id, 8, '0', STR_PAD_LEFT) : '-' }}</p>
                                    <p><strong>Jenis Pegawai:</strong>
                                        <span class="badge {{ $user->status_pns === 'PNS' ? 'bg-success' : 'bg-info' }}">
                                            {{ $user->status_kepegawaian ?? 'Pegawai' }}
                                        </span>
                                    </p>
                                    <p><strong>Unit Kerja:</strong> {{ $user->unit_kerja ?? '-' }}</p>
                                    <p><strong>Jabatan:</strong> -</p>
                                    <p><strong>Eselon/Setara:</strong> -</p>
                                    <p><strong>Status PNS:</strong> {{ $user->status_pns }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Asal Universitas:</strong> -</p>
                                    <p><strong>Bank:</strong> -</p>
                                    <p><strong>Rekening:</strong> -</p>
                                    <p><strong>Status Kepegawaian:</strong>
                                        <span class="badge bg-success">Aktif</span>
                                    </p>
                                    <p><strong>Sisa Cuti:</strong>
                                        <span class="badge bg-warning text-dark">{{ $user->sisa_cuti }} hari</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat Tab -->
                        <div class="tab-pane fade" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
                            <h5 class="mb-3">Informasi Alamat</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary">Alamat Domisili</h6>
                                    <p><strong>Alamat:</strong> -</p>
                                    <p><strong>RT/RW:</strong> -</p>
                                    <p><strong>Kelurahan:</strong> -</p>
                                    <p><strong>Kecamatan:</strong> -</p>
                                    <p><strong>Kota/Kabupaten:</strong> -</p>
                                    <p><strong>Provinsi:</strong> -</p>
                                    <p><strong>Kode Pos:</strong> -</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary">Alamat KTP</h6>
                                    <p><strong>Alamat:</strong> -</p>
                                    <p><strong>RT/RW:</strong> -</p>
                                    <p><strong>Kelurahan:</strong> -</p>
                                    <p><strong>Kecamatan:</strong> -</p>
                                    <p><strong>Kota/Kabupaten:</strong> -</p>
                                    <p><strong>Provinsi:</strong> -</p>
                                    <p><strong>Kode Pos:</strong> -</p>
                                </div>
                            </div>
                        </div>

                        <!-- Keputusan Tab -->
                        <div class="tab-pane fade" id="keputusan" role="tabpanel" aria-labelledby="keputusan-tab">
                            <h5 class="mb-3">Informasi Keputusan</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Jenis Keputusan</th>
                                            <th>Nomor SK</th>
                                            <th>Tanggal SK</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox display-6"></i>
                                                <p class="mt-2">Belum ada data keputusan</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fasilitas Tab -->
                        <div class="tab-pane fade" id="fasilitas" role="tabpanel" aria-labelledby="fasilitas-tab">
                            <h5 class="mb-3">Informasi Fasilitas</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Jenis Fasilitas</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Laptop/PC</td>
                                            <td><span class="badge bg-secondary">Tidak Ada</span></td>
                                        </tr>
                                        <tr>
                                            <td>Handphone</td>
                                            <td><span class="badge bg-secondary">Tidak Ada</span></td>
                                        </tr>
                                        <tr>
                                            <td>Kendaraan Dinas</td>
                                            <td><span class="badge bg-secondary">Tidak Ada</span></td>
                                        </tr>
                                        <tr>
                                            <td>Seragam</td>
                                            <td><span class="badge bg-secondary">Tidak Ada</span></td>
                                        </tr>
                                        <tr>
                                            <td>Kartu Akses</td>
                                            <td><span class="badge bg-secondary">Tidak Ada</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Files Tab -->
                        <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                            <h5 class="mb-3">Dokumen & File</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Jenis File</th>
                                            <th>Keterangan</th>
                                            <th>Upload</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><i class="bi bi-file-earmark-image text-info me-2"></i>KTP</td>
                                            <td><span class="badge bg-secondary">Belum diupload</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadModal" data-file-type="ktp">
                                                    <i class="bi bi-upload me-1"></i>Upload
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i class="bi bi-file-earmark-person text-success me-2"></i>Kartu Keluarga</td>
                                            <td><span class="badge bg-secondary">Belum diupload</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadModal" data-file-type="kk">
                                                    <i class="bi bi-upload me-1"></i>Upload
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i class="bi bi-file-earmark-medical text-primary me-2"></i>BPJS Kesehatan</td>
                                            <td><span class="badge bg-secondary">Belum diupload</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadModal" data-file-type="bpjs_kesehatan">
                                                    <i class="bi bi-upload me-1"></i>Upload
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i class="bi bi-file-earmark-person text-warning me-2"></i>BPJS Tenaga Kerja</td>
                                            <td><span class="badge bg-secondary">Belum diupload</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadModal" data-file-type="bpjs_tenaga_kerja">
                                                    <i class="bi bi-upload me-1"></i>Upload
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i class="bi bi-file-earmark-text text-danger me-2"></i>NPWP</td>
                                            <td><span class="badge bg-secondary">Belum diupload</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadModal" data-file-type="npwp">
                                                    <i class="bi bi-upload me-1"></i>Upload
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i class="bi bi-file-earmark-check text-purple me-2"></i>Spesimen Tanda Tangan</td>
                                            <td><span class="badge bg-secondary">Belum diupload</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadModal" data-file-type="spesimen">
                                                    <i class="bi bi-upload me-1"></i>Upload
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">
                    <i class="bi bi-pencil me-2"></i>Edit Profile
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="editProfileForm">
                    @csrf
                    @method('PATCH')

                    <!-- Navigation Tabs -->
                    <div class="px-4 pt-3 pb-0">
                        <ul class="nav nav-pills nav-fill" id="editProfileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active d-flex align-items-center justify-content-center"
                                        id="personal-info-tab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#personal-info"
                                        type="button"
                                        role="tab"
                                        aria-controls="personal-info"
                                        aria-selected="true">
                                    <i class="bi bi-person me-2"></i>
                                    <span class="d-none d-sm-inline">Informasi Pribadi</span>
                                    <span class="d-sm-none">Pribadi</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center justify-content-center"
                                        id="address-tab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#address"
                                        type="button"
                                        role="tab"
                                        aria-controls="address"
                                        aria-selected="false">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    <span class="d-none d-sm-inline">Alamat</span>
                                    <span class="d-sm-none">Alamat</span>
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content p-4" id="editProfileTabContent">
                        <!-- Personal Information Tab -->
                        <div class="tab-pane fade show active" id="personal-info" role="tabpanel" aria-labelledby="personal-info-tab">
                            <!-- Profile Picture -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="text-center mb-3">
                                        <img src="https://via.placeholder.com/120x120/007bff/ffffff?text={{ substr($user->name, 0, 1) }}"
                                             class="rounded-circle mb-3"
                                             width="120"
                                             height="120"
                                             id="profilePreview"
                                             alt="Profile Preview">
                                    </div>
                                    <div class="mb-3">
                                        <label for="profilePictureInput" class="form-label fw-medium">
                                            <i class="bi bi-camera me-2"></i>Profile Picture
                                        </label>
                                        <input class="form-control" type="file" id="profilePictureInput" name="profile_picture" accept="image/*">
                                        <small class="form-text text-muted">Upload gambar dengan format JPG, PNG (Max: 2MB)</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Basic Information -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fullName" class="form-label fw-medium">
                                            <i class="bi bi-person me-1"></i>Nama Lengkap
                                        </label>
                                        <input type="text" class="form-control" id="fullName" name="name" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nik" class="form-label fw-medium">
                                            <i class="bi bi-card-text me-1"></i>NIK
                                        </label>
                                        <input type="text" class="form-control" id="nik" name="nik" value="" maxlength="16">
                                    </div>
                                    <div class="mb-3">
                                        <label for="npwp" class="form-label fw-medium">
                                            <i class="bi bi-file-earmark-text me-1"></i>NPWP
                                        </label>
                                        <input type="text" class="form-control" id="npwp" name="npwp" value="" maxlength="20">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tempat_lahir" class="form-label fw-medium">
                                            <i class="bi bi-geo me-1"></i>Tempat Lahir
                                        </label>
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_lahir" class="form-label fw-medium">
                                            <i class="bi bi-calendar me-1"></i>Tanggal Lahir
                                        </label>
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label fw-medium">
                                            <i class="bi bi-gender-ambiguous me-1"></i>Jenis Kelamin
                                        </label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="agama" class="form-label fw-medium">
                                            <i class="bi bi-heart me-1"></i>Agama
                                        </label>
                                        <select class="form-select" id="agama" name="agama">
                                            <option value="">Pilih Agama</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Katolik">Katolik</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Buddha">Buddha</option>
                                            <option value="Khonghucu">Khonghucu</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status_perkawinan" class="form-label fw-medium">
                                            <i class="bi bi-heart-fill me-1"></i>Status Perkawinan
                                        </label>
                                        <select class="form-select" id="status_perkawinan" name="status_perkawinan">
                                            <option value="">Pilih Status</option>
                                            <option value="Belum Menikah">Belum Menikah</option>
                                            <option value="Menikah">Menikah</option>
                                            <option value="Cerai">Cerai</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pendidikan_terakhir" class="form-label fw-medium">
                                            <i class="bi bi-mortarboard me-1"></i>Pendidikan Terakhir
                                        </label>
                                        <input type="text" class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="unitKerja" class="form-label fw-medium">
                                            <i class="bi bi-building me-1"></i>Unit Kerja
                                        </label>
                                        <input type="text" class="form-control" id="unitKerja" name="unit_kerja" value="{{ $user->unit_kerja }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <hr class="my-4">
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-telephone me-2"></i>Informasi Kontak
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-medium">
                                            <i class="bi bi-envelope me-1"></i>Email Kantor
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_hp" class="form-label fw-medium">
                                            <i class="bi bi-phone me-1"></i>Nomor HP
                                        </label>
                                        <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email_pribadi" class="form-label fw-medium">
                                            <i class="bi bi-envelope-open me-1"></i>Email Pribadi
                                        </label>
                                        <input type="email" class="form-control" id="email_pribadi" name="email_pribadi" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_telp" class="form-label fw-medium">
                                            <i class="bi bi-telephone me-1"></i>Nomor Telepon
                                        </label>
                                        <input type="text" class="form-control" id="nomor_telp" name="nomor_telp" value="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information Tab -->
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                            <!-- Alamat Domisili -->
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-house me-2"></i>Alamat Domisili
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="alamat_domisili" class="form-label fw-medium">
                                            <i class="bi bi-geo-alt me-1"></i>Alamat Lengkap
                                        </label>
                                        <textarea class="form-control" id="alamat_domisili" name="alamat_domisili" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rt_rw_domisili" class="form-label fw-medium">RT/RW</label>
                                        <input type="text" class="form-control" id="rt_rw_domisili" name="rt_rw_domisili" value="" placeholder="001/002">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelurahan_domisili" class="form-label fw-medium">Kelurahan/Desa</label>
                                        <input type="text" class="form-control" id="kelurahan_domisili" name="kelurahan_domisili" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kecamatan_domisili" class="form-label fw-medium">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan_domisili" name="kecamatan_domisili" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kota_domisili" class="form-label fw-medium">Kota/Kabupaten</label>
                                        <input type="text" class="form-control" id="kota_domisili" name="kota_domisili" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="provinsi_domisili" class="form-label fw-medium">Provinsi</label>
                                        <input type="text" class="form-control" id="provinsi_domisili" name="provinsi_domisili" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kode_pos_domisili" class="form-label fw-medium">Kode Pos</label>
                                        <input type="text" class="form-control" id="kode_pos_domisili" name="kode_pos_domisili" value="" maxlength="5">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Alamat KTP -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-primary mb-0">
                                    <i class="bi bi-card-text me-2"></i>Alamat KTP
                                </h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sameAsResidence">
                                    <label class="form-check-label" for="sameAsResidence">
                                        <small>Sama dengan alamat domisili</small>
                                    </label>
                                </div>
                            </div>
                            <div class="row" id="ktpAddressSection">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="alamat_ktp" class="form-label fw-medium">
                                            <i class="bi bi-geo-alt me-1"></i>Alamat Lengkap
                                        </label>
                                        <textarea class="form-control" id="alamat_ktp" name="alamat_ktp" rows="3" placeholder="Masukkan alamat lengkap sesuai KTP"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rt_rw_ktp" class="form-label fw-medium">RT/RW</label>
                                        <input type="text" class="form-control" id="rt_rw_ktp" name="rt_rw_ktp" value="" placeholder="001/002">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelurahan_ktp" class="form-label fw-medium">Kelurahan/Desa</label>
                                        <input type="text" class="form-control" id="kelurahan_ktp" name="kelurahan_ktp" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kecamatan_ktp" class="form-label fw-medium">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan_ktp" name="kecamatan_ktp" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kota_ktp" class="form-label fw-medium">Kota/Kabupaten</label>
                                        <input type="text" class="form-control" id="kota_ktp" name="kota_ktp" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="provinsi_ktp" class="form-label fw-medium">Provinsi</label>
                                        <input type="text" class="form-control" id="provinsi_ktp" name="provinsi_ktp" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kode_pos_ktp" class="form-label fw-medium">Kode Pos</label>
                                        <input type="text" class="form-control" id="kode_pos_ktp" name="kode_pos_ktp" value="" maxlength="5">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <button type="submit" form="editProfileForm" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Upload File Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">
                    <i class="bi bi-upload me-2"></i>Upload Dokumen
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="fileType" name="file_type" value="">
                    <div class="mb-3">
                        <label for="documentFile" class="form-label">Pilih File</label>
                        <input class="form-control" type="file" id="documentFile" name="document_file" accept=".pdf,.jpg,.jpeg,.png" required>
                        <small class="form-text text-muted">Format yang didukung: PDF, JPG, PNG (Max: 5MB)</small>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Tambahkan catatan atau keterangan..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i>Upload File
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Upload Modal Handler
    const uploadModal = document.getElementById('uploadModal');
    const fileTypeInput = document.getElementById('fileType');
    const modalTitle = uploadModal.querySelector('.modal-title');

    if (uploadModal) {
        uploadModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const fileType = button.getAttribute('data-file-type');

            fileTypeInput.value = fileType;

            // Update modal title based on file type
            const fileTypeNames = {
                'ktp': 'KTP',
                'kk': 'Kartu Keluarga',
                'bpjs_kesehatan': 'BPJS Kesehatan',
                'bpjs_tenaga_kerja': 'BPJS Tenaga Kerja',
                'npwp': 'NPWP',
                'spesimen': 'Spesimen Tanda Tangan'
            };

            modalTitle.innerHTML = `<i class="bi bi-upload me-2"></i>Upload ${fileTypeNames[fileType] || 'Dokumen'}`;
        });
    }

    // Profile Picture Preview
    const profilePictureInput = document.getElementById('profilePictureInput');
    const profilePreview = document.getElementById('profilePreview');

    if (profilePictureInput && profilePreview) {
        profilePictureInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Same as Residence Address Checkbox
    const sameAsResidenceCheckbox = document.getElementById('sameAsResidence');
    const ktpAddressSection = document.getElementById('ktpAddressSection');

    if (sameAsResidenceCheckbox) {
        sameAsResidenceCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // Copy values from residence to KTP address
                copyResidenceToKtp();
                // Disable KTP address fields
                toggleKtpAddressFields(true);
            } else {
                // Enable KTP address fields
                toggleKtpAddressFields(false);
            }
        });
    }

    function copyResidenceToKtp() {
        const residenceFields = [
            'alamat_domisili',
            'rt_rw_domisili',
            'kelurahan_domisili',
            'kecamatan_domisili',
            'kota_domisili',
            'provinsi_domisili',
            'kode_pos_domisili'
        ];

        const ktpFields = [
            'alamat_ktp',
            'rt_rw_ktp',
            'kelurahan_ktp',
            'kecamatan_ktp',
            'kota_ktp',
            'provinsi_ktp',
            'kode_pos_ktp'
        ];

        residenceFields.forEach((residenceField, index) => {
            const residenceElement = document.getElementById(residenceField);
            const ktpElement = document.getElementById(ktpFields[index]);

            if (residenceElement && ktpElement) {
                ktpElement.value = residenceElement.value;
            }
        });
    }

    function toggleKtpAddressFields(disable) {
        const ktpFields = [
            'alamat_ktp',
            'rt_rw_ktp',
            'kelurahan_ktp',
            'kecamatan_ktp',
            'kota_ktp',
            'provinsi_ktp',
            'kode_pos_ktp'
        ];

        ktpFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.disabled = disable;
                field.style.backgroundColor = disable ? '#f8f9fa' : '';
            }
        });
    }

    // Listen for changes in residence address when checkbox is checked
    if (sameAsResidenceCheckbox) {
        const residenceFields = document.querySelectorAll('#personal-info input, #address input[id*="domisili"], #address textarea[id*="domisili"]');
        residenceFields.forEach(field => {
            field.addEventListener('input', function() {
                if (sameAsResidenceCheckbox.checked) {
                    copyResidenceToKtp();
                }
            });
        });
    }

    // Form validation
    const editProfileForm = document.getElementById('editProfileForm');
    if (editProfileForm) {
        editProfileForm.addEventListener('submit', function(event) {
            // Add any custom validation here if needed
            const requiredFields = editProfileForm.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                event.preventDefault();
                // Show first tab if validation fails
                const firstTab = document.getElementById('personal-info-tab');
                if (firstTab) {
                    firstTab.click();
                }
            }
        });
    }
});
</script>
@endpush

@endsection