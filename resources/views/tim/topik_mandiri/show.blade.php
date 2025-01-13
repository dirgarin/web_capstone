@extends('layout.app')

@section('contents')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Topik Mandiri</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">Detail</h5>
                        <a href="{{ route('topik_mandiri.index') }}" class="btn btn-secondary btn-sm ms-auto rounded-3"><i
                                class="fas fa-arrow-left fa-2x"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-stretch g-3">
                            <!-- Card Tim Information -->
                            <div class="col-12">
                                <div class="card p-3">
                                    <h5 class="card-title">Nama Tim</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->nama_ketua }}</p>
                                    <h5 class="card-title">Judul</h5>
                                    <p class="card-text">{{ $data->judul }}</p>
                                    <h5 class="card-title">Dosen Pembimbing</h5>
                                    <p class="card-text">{{ $data->dosen->nama ?? '-' }}</p>
                                    <h5 class="card-title">Instansi / Organisasi / Perusahaan Objek</h5>
                                    <p class="card-text">{{ $data->instansi }}</p>
                                    <h5 class="card-title">Deskripsi</h5>
                                    <p class="card-text">{{ $data->deskripsi }}</p>
                                    @can('isTim')
                                        <h5 class="card-title">Status Persetujuan</h5>
                                        <p class="card-text">
                                            @if (
                                                $data->daftar_topik_mandiri &&
                                                    $data->daftar_topik_mandiri->daftar_topik &&
                                                    $data->daftar_topik_mandiri->daftar_topik->status == 'approved')
                                                <span class="badge bg-success">Disetujui Tim Capstone</span>
                                            @elseif($data->status == 'pending')
                                                <span class="badge bg-primary">Menunggu Persetujuan Tim Capstone</span>
                                            @elseif ($data->status == 'assigned')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif ($data->status == 'approved' && $data->dosen_id == null)
                                                <span class="badge bg-danger">Harap Pilih Dosen</span>
                                            @elseif ($data->status == 'approved' && $data->dosen_id != null)
                                                <span class="badge bg-warning">Menunggu Konfirmasi Dosen</span>
                                            @else
                                                <span class="badge bg-danger">Dosen Menolak, Harap Pilih Dosen Lain</span>
                                            @endif
                                        </p>
                                    @endcan
                                </div>
                            </div>

                            <!-- Mahasiswa Pertama -->
                            <div class="col-12">
                                <div class="card p-3">
                                    <div class="card-header text-center">
                                        <h3>Mahasiswa Pertama</h3>
                                    </div>
                                    <h5 class="card-title">Nama Lengkap</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa1->nama }}</p>
                                    <h5 class="card-title">NIM</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa1->nim }}</p>
                                    <h5 class="card-title">Email</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa1->user->email }}</p>
                                    <h5 class="card-title">No. Telepon</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa1->no_telp }}</p>
                                    <h5 class="card-title">Bidang Minat</h5>
                                    <p class="card-text">
                                        {{ $data->daftar_topik_mandiri->tim->mahasiswa1->bidang_minat->nama }}</p>
                                    <h5 class="card-title">Kompetensi Keahlian</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa1->kompetensi }}</p>
                                </div>
                            </div>

                            <!-- Mahasiswa Kedua -->
                            <div class="col-12">
                                <div class="card p-3">
                                    <div class="card-header text-center">
                                        <h3>Mahasiswa Kedua</h3>
                                    </div>
                                    <h5 class="card-title">Nama Lengkap</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa2->nama }}</p>
                                    <h5 class="card-title">NIM</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa2->nim }}</p>
                                    <h5 class="card-title">Email</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa2->user->email }}
                                    </p>
                                    <h5 class="card-title">No. Telepon</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa2->no_telp }}</p>
                                    <h5 class="card-title">Bidang Minat</h5>
                                    <p class="card-text">
                                        {{ $data->daftar_topik_mandiri->tim->mahasiswa2->bidang_minat->nama }}</p>
                                    <h5 class="card-title">Kompetensi Keahlian</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa2->kompetensi }}</p>
                                </div>
                            </div>

                            <!-- Mahasiswa Ketiga -->
                            <div class="col-12">
                                <div class="card p-3">
                                    <div class="card-header text-center">
                                        <h3>Mahasiswa Ketiga</h3>
                                    </div>
                                    <h5 class="card-title">Nama Lengkap</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa3->nama }}</p>
                                    <h5 class="card-title">NIM</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa3->nim }}</p>
                                    <h5 class="card-title">Email</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa3->user->email }}
                                    </p>
                                    <h5 class="card-title">No. Telepon</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa3->no_telp }}</p>
                                    <h5 class="card-title">Bidang Minat</h5>
                                    <p class="card-text">
                                        {{ $data->daftar_topik_mandiri->tim->mahasiswa3->bidang_minat->nama }}</p>
                                    <h5 class="card-title">Kompetensi Keahlian</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->mahasiswa3->kompetensi }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Dosen Action Buttons (if applicable) -->
                        @can('isDosen')
                            <div class="col-12 d-flex">
                                <div class="ms-auto d-flex gap-2">
                                    <!-- Form for Approving or Rejecting -->
                                    @if ($data->status == 'pending' && $data->dosen_id == auth()->user()->dosen->id)
                                        <!-- Button Actions -->
                                        <form action="{{ route('topik_mandiri.update', $data->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="assigned">
                                            <button type="submit" class="btn btn-success"
                                                onclick="return confirmMessage('Apakah anda yakin untuk masuk sebagai dosen pembimbing pada topik ini?', event)">
                                                <i class="fas fa-check"></i> Setuju
                                            </button>
                                        </form>
                                        <form action="{{ route('topik_mandiri.update', $data->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirmMessage('Apakah anda yakin untuk menolak topik ini?', event)">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endcan

                        @can('isTim')
                            <div class="col-12 d-flex">
                                <div class="ms-auto d-flex gap-2">
                                    <!-- Status Update Buttons -->
                                    @if ($data->status == 'pending')
                                        <!-- Buttons for Tim Approval -->
                                        <form action="{{ route('topik_mandiri.update', $data->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-success"
                                                onclick="return confirmMessage('Apakah anda yakin untuk menyetujui topik ini?', event)">
                                                <i class="fas fa-check"></i> Konfirmasi
                                            </button>
                                        </form>
                                        <form action="{{ route('topik_mandiri.update', $data->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirmMessage('Apakah anda yakin untuk menolak topik ini?', event)">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    @elseif ($data->status == 'assigned' && $data->daftar_topik_mandiri->daftar_topik->status != 'approved')
                                        <!-- Confirm or Reject Buttons for Tim -->
                                        <form action="{{ route('topik_mandiri.update', $data->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-success"
                                                onclick="return confirmMessage('Apakah anda yakin untuk menyetujui topik ini?', event)">
                                                <i class="fas fa-check"></i> Konfirmasi
                                            </button>
                                        </form>
                                        <form action="{{ route('topik_mandiri.update', $data->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirmMessage('Apakah anda yakin untuk menolak topik ini?', event)">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endcan
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
