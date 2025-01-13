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
                    <div class="row g-3">
                        <!-- Bagian Kiri -->
                        <div class="col-12">
                            <div class="card p-3">
                                <h5 class="card-title">Nama Tim</h5>
                                <p class="card-text">{{ $data->daftar_topik_mandiri->tim->nama_ketua }}</p>
                                <h5 class="card-title">Judul</h5>
                                <p class="card-text">{{ $data->judul }}</p>
                                <h5 class="card-title">Dosen</h5>
                                <p class="card-text">{{ $data->dosen->nama ?? "-" }}</p>
                                <h5 class="card-title">Instansi / Organisasi / Perusahaan Objek</h5>
                                <p class="card-text">{{ $data->instansi }}</p>
                                <h5 class="card-title">Deskripsi</h5>
                                <p class="card-text"> {{ $data->deskripsi }}</p>
                                @if ($data->daftar_topik_mandiri->where('status', 'assigned')->count() > 0)
                                    <h5 class="card-title">Status</h5>
                                    <p class="card-text">
                                        <span class="badge bg-success">Sudah Disetujui</span>
                                        <br>
                                        <span class="small text-muted">
                                            Topik mandiri ini sudah memiliki disetujui oleh dosen pembimbing.
                                        </span>
                                    </p>
                                @endif
                                @can('isTim')
                                    <h5 class="card-title">Status Persetujuan</h5>
                                    <p class="card-text">
                                        @if ($data->status == "assigned")
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-warning">Butuh Validasi</span>
                                        @endif
                                    </p>
                                @endcan
                            </div>
                        </div>
                        <!-- Mahasiswa -->
                        @foreach (['mahasiswa1', 'mahasiswa2', 'mahasiswa3'] as $index => $mahasiswa)
                            <div class="col-12">
                                <div class="card p-3">
                                    <div class="card-header text-center">
                                        <h3>Mahasiswa {{ $index + 1 }}</h3>
                                    </div>
                                    <h5 class="card-title">Nama Lengkap</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->$mahasiswa->nama }}</p>
                                    <h5 class="card-title">NIM</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->$mahasiswa->nim }}</p>
                                    <h5 class="card-title">Email</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->$mahasiswa->user->email }}</p>
                                    <h5 class="card-title">No. Telepon</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->$mahasiswa->no_telp }}</p>
                                    <h5 class="card-title">Bidang Minat</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->$mahasiswa->bidang_minat->nama }}</p>
                                    <h5 class="card-title">Kompetensi Keahlian</h5>
                                    <p class="card-text">{{ $data->daftar_topik_mandiri->tim->$mahasiswa->kompetensi }}</p>
                                    <div class="card-footer">
                                        <h5 class="card-title">Penilaian</h5>
                                        @forelse ($data->daftar_topik_mandiri->tim->penilaian_tim->where('target_id', $data->daftar_topik_mandiri->tim->$mahasiswa->id) as $item)
                                            <div class="alert alert-primary" role="alert">
                                                <h4 class="alert-heading">Nilai : {{ $item->nilai }}</h4>
                                                <p>{{ $item->keterangan }}</p>
                                                <hr>
                                                <p class="mb-0">Diberikan oleh : {{ $item->mahasiswa->nama }}</p>
                                            </div>
                                        @empty
                                            <div class="alert alert-warning" role="alert">
                                                Belum ada penilaian
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- Aksi untuk Dosen Pembimbing -->
                        @can('isDosenPembimbing')
                            <div class="col-12 d-flex">
                                <div class="ms-auto d-flex gap-2">
                                    @if ($data->status == "pending" && $data->dosen_id == auth()->user()->dosen->id)
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
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
