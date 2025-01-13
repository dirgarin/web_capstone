@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Tim Mahasiswa</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0">Detail</h5>
                    <a href="{{ route('tim.index') }}" class="btn btn-secondary btn-sm ms-auto rounded-3"><i
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
                                <h5 class="card-title">Tanggal Pendaftaran</h5>
                                <p class="card-text">{{ $data->mahasiswa1->created_at->format('d F Y H:i:s') }}</p>
                                <div class="card-footer">
                                    <h5 class="card-title">Penilaian</h5>
                                    @if ($data->mahasiswa1->id != auth()->user()->mahasiswa->id)
                                        @if($data->penilaian_tim->where('target_id', $data->mahasiswa1->id)->where('mahasiswa_id', auth()->user()->mahasiswa->id)->count() == 0)
                                            <form action="{{ route('penilaian_tim.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="target_id" value="{{ $data->mahasiswa1->id }}">
                                                <input type="hidden" name="tim_id" value="{{ $data->id }}">
                                                <div class="mb-3">
                                                    <label for="nilai" class="form-label">Nilai</label>
                                                    <input type="text" class="form-control" name="nilai" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        @else
                                            <div class="alert alert-primary" role="alert">
                                                <h4 class="alert-heading">Nilai :
                                                    {{ $data->penilaian_tim->where('target_id', $data->mahasiswa1->id)->where('mahasiswa_id', auth()->user()->mahasiswa->id)->first()->nilai }}
                                                </h4>
                                                <p>{{ $data->penilaian_tim->where('target_id', $data->mahasiswa1->id)->where('mahasiswa_id', auth()->user()->mahasiswa->id)->first()->keterangan }}
                                                </p>
                                            </div>
                                        @endif
                                    @else
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
                                    @endif
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
                                <h5 class="card-title">Tanggal Pendaftaran</h5>
                                <p class="card-text">{{ $data->mahasiswa2->created_at->format('d F Y H:i:s') }}</p>
                                <div class="card-footer">
                                    <h5 class="card-title">Penilaian</h5>
                                    @if ($data->mahasiswa2->id != auth()->user()->mahasiswa->id)
                                        @if($data->penilaian_tim->where('target_id', $data->mahasiswa2->id)->where('mahasiswa_id', auth()->user()->mahasiswa->id)->count() == 0)
                                            <form action="{{ route('penilaian_tim.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="target_id" value="{{ $data->mahasiswa2->id }}">
                                                <input type="hidden" name="tim_id" value="{{ $data->id }}">
                                                <div class="mb-3">
                                                    <label for="nilai" class="form-label">Nilai</label>
                                                    <input type="text" class="form-control" name="nilai" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        @else
                                            <div class="alert alert-primary" role="alert">
                                                <h4 class="alert-heading">Nilai :
                                                    {{ $data->penilaian_tim->where('target_id', $data->mahasiswa2->id)->where('mahasiswa_id', auth()->user()->mahasiswa->id)->first()->nilai }}
                                                </h4>
                                                <p>{{ $data->penilaian_tim->where('target_id', $data->mahasiswa2->id)->where('mahasiswa_id', auth()->user()->mahasiswa->id)->first()->keterangan }}
                                                </p>
                                            </div>
                                        @endif
                                    @else
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
                                    @endif
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
                                <h5 class="card-title">Tanggal Pendaftaran</h5>
                                <p class="card-text">{{ $data->mahasiswa3->created_at->format('d F Y H:i:s') }}</p>
                                <div class="card-footer">
                                    <h5 class="card-title">Penilaian</h5>
                                    @if ($data->mahasiswa3->id != auth()->user()->mahasiswa->id)
                                        @if($data->penilaian_tim->where('target_id', $data->mahasiswa3->id)->where('mahasiswa_id', auth()->user()->mahasiswa->id)->count() == 0)
                                            <form action="{{ route('penilaian_tim.store') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="target_id" value="{{ $data->mahasiswa3->id }}">
                                                <input type="hidden" name="tim_id" value="{{ $data->id }}">
                                                <div class="mb-3">
                                                    <label for="nilai" class="form-label">Nilai</label>
                                                    <input type="text" class="form-control" name="nilai" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        @else
                                            <div class="alert alert-primary" role="alert">
                                                <h4 class="alert-heading">Nilai :
                                                    {{ $data->penilaian_tim->where('target_id', $data->mahasiswa3->id)->where('mahasiswa_id', auth()->user()->mahasiswa->id)->first()->nilai }}
                                                </h4>
                                                <p>{{ $data->penilaian_tim->where('target_id', $data->mahasiswa3->id)->where('mahasiswa_id', auth()->user()->mahasiswa->id)->first()->keterangan }}
                                                </p>
                                            </div>
                                        @endif
                                    @else
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
                                    @endif
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
                                    <div class="col-12 d-flex align-items-center justify-content-end gap-2">
                                        <h5 class="card-title mb-0">Status Validasi :</h5>
                                        <p class="card-text">
                                            @if ($data->status == "approved")
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($data->status == "rejected")
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-warning">Butuh Validasi</span>
                                            @endif
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