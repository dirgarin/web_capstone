@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Tim Mahasiswa</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0">Detail</h5>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm ms-auto rounded-3"><i
                            class="fas fa-arrow-left fa-2x"></i></a>
                </div>
                <div class="card-body">
                    <div class="row align-items-stretch g-3">
                        <div class="col-md-4 h-100">
                            <div class="card p-3 h-100">
                                <div class="card-header text-center">
                                    <h3>Mahasiswa Pertama</h3>
                                </div>
                                <h5 class="card-title">Nama Lengkap</h5>
                                <p class="card-text">{{ $data->mahasiswa1->nama }}</p>
                                <h5 class="card-title">NIM</h5>
                                <p class="card-text">{{ $data->mahasiswa1->nim }}</p>
                                <h5 class="card-title">Email</h5>
                                <p class="card-text">{{ $data->mahasiswa1->user->email }}</p>
                                <h5 class="card-title">No. Telepon</h5>
                                <p class="card-text">{{ $data->mahasiswa1->no_telp }}</p>
                                <h5 class="card-title">Bidang Minat</h5>
                                <p class="card-text">{{ $data->mahasiswa1->bidang_minat->nama }}</p>
                                <h5 class="card-title">Kompetensi Keahlian</h5>
                                <p class="card-text">{{ $data->mahasiswa1->kompetensi }}</p>
                                <div class="card-footer">
                                    <h5 class="card-title">Penilaian</h5>
                                    @forelse ($data->penilaian_tim->where('target_id', $data->mahasiswa1->id) as $item)
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

                        <div class="col-md-4 h-100">
                            <div class="card p-3 h-100">
                                <div class="card-header text-center">
                                    <h3>Mahasiswa Kedua</h3>
                                </div>
                                <h5 class="card-title">Nama Lengkap</h5>
                                <p class="card-text">{{ $data->mahasiswa2->nama }}</p>
                                <h5 class="card-title">NIM</h5>
                                <p class="card-text">{{ $data->mahasiswa2->nim }}</p>
                                <h5 class="card-title">Email</h5>
                                <p class="card-text">{{ $data->mahasiswa2->user->email }}</p>
                                <h5 class="card-title">No. Telepon</h5>
                                <p class="card-text">{{ $data->mahasiswa2->no_telp }}</p>
                                <h5 class="card-title">Bidang Minat</h5>
                                <p class="card-text">{{ $data->mahasiswa2->bidang_minat->nama }}</p>
                                <h5 class="card-title">Kompetensi Keahlian</h5>
                                <p class="card-text">{{ $data->mahasiswa2->kompetensi }}</p>
                                <div class="card-footer">
                                    <h5 class="card-title">Penilaian</h5>
                                    @forelse ($data->penilaian_tim->where('target_id', $data->mahasiswa2->id) as $item)
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


                        <div class="col-md-4 h-100">
                            <div class="card p-3 h-100">
                                <div class="card-header text-center">
                                    <h3>Mahasiswa Ketiga</h3>
                                </div>
                                <h5 class="card-title">Nama Lengkap</h5>
                                <p class="card-text">{{ $data->mahasiswa3->nama }}</p>
                                <h5 class="card-title">NIM</h5>
                                <p class="card-text">{{ $data->mahasiswa3->nim }}</p>
                                <h5 class="card-title">Email</h5>
                                <p class="card-text">{{ $data->mahasiswa3->user->email }}</p>
                                <h5 class="card-title">No. Telepon</h5>
                                <p class="card-text">{{ $data->mahasiswa3->no_telp }}</p>
                                <h5 class="card-title">Bidang Minat</h5>
                                <p class="card-text">{{ $data->mahasiswa3->bidang_minat->nama }}</p>
                                <h5 class="card-title">Kompetensi Keahlian</h5>
                                <p class="card-text">{{ $data->mahasiswa3->kompetensi }}</p>
                                <div class="card-footer">
                                    <h5 class="card-title">Penilaian</h5>
                                    @forelse ($data->penilaian_tim->where('target_id', $data->mahasiswa3->id) as $item)
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
                        <div class="col-12 d-flex">
                            <div class="ms-auto d-flex flex-column gap-2">
                                <div class="row gap-2">
                                    <div class="col-12 d-flex align-items-center justify-content-end gap-2">
                                        <h5 class="card-title mb-0">Nama Tim :</h5>
                                        <p class="card-text">
                                            <span class="badge bg-primary">{{ $data->nama_ketua }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection