@extends('layout.app')

@php
    $main_topik = null;
    if ($data->daftar_topik->registerable_type == 'App\Models\DaftarTopikDosen') {
        $main_topik = $data->daftar_topik->registerable->topik_dosen;
    } else {
        $main_topik = $data->daftar_topik->registerable->topik_mandiri;
    }
@endphp

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Dokumen</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0">{{ $main_topik->judul }}
                        ({{ $data->daftar_topik->registerable->tim->nama_ketua }})
                        - {{ $main_topik->dosen->nama }}
                    </h5>
                    </h5>
                    <a href="{{ route('mahasiswa_dokumen.index') }}"
                        class="btn btn-secondary btn-sm ms-auto rounded-3"><i class="fas fa-arrow-left fa-2x"></i></a>
                </div>
                <div class="card-body">
                    <div class="row align-items-stretch g-3">
                        @forelse($dokumen as $item)
                                                @php
                                                    $topik = null;
                                                    if ($item->daftar_topik->registerable_type == 'App\Models\DaftarTopikDosen') {
                                                        $topik = $item->daftar_topik->registerable->topik_dosen;
                                                    } else {
                                                        $topik = $item->daftar_topik->registerable->topik_mandiri;
                                                    }
                                                @endphp
                                                <div class="col-12 h-100">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">
                                                                        {{ $item->mahasiswa->nama }}
                                                                    </h5>
                                                                    <p class="card-text">
                                                                        {{ $item->keterangan }}
                                                                        <object class="pdf" data="{{ Storage::url($item->file_dokumen) }}"
                                                                            width="100%" height="400px"></object>
                                                                    </p>
                                                                    <div class="text-end">
                                                                        <a href="{{ Storage::url($item->file_dokumen) }}"
                                                                            class="btn btn-primary mt-3" download>
                                                                            <i class="fas fa-download"></i>
                                                                            Download
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered dataTable">
                                                                            <thead>
                                                                                <tr class="text-center">
                                                                                    <th style="width: 100px">No</th>
                                                                                    <th>Dosen</th>
                                                                                    <th>Nilai</th>
                                                                                    <th>Feedback</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @forelse($item->penilaian_dosen as $penilaian)
                                                                                    <tr>
                                                                                        <td class="text-center" style="width: 100px">
                                                                                            {{ $loop->iteration }}
                                                                                        </td>
                                                                                        <td class="text-center">{{ $penilaian->dosen->nama }}</td>
                                                                                        <td class="text-center">
                                                                                            {{ $penilaian->nilai }}
                                                                                        </td>
                                                                                        <td class="text-center">{!! nl2br($penilaian->feedback) !!}
                                                                                        </td>
                                                                                    </tr>
                                                                                @empty
                                                                                    <tr>
                                                                                        <td colspan="5" class="text-center">Belum ada
                                                                                            penilaian</td>
                                                                                    </tr>
                                                                                @endforelse
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning" role="alert">
                                    Data tidak ditemukan
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($dokumen as $item)
    <div class="modal fade" id="penilaianDosen{{ $item->id }}" tabindex="-1" aria-labelledby="penilaianDosen{{ $item->id }}"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('penilaian_dosen.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="mahasiswa_dokumen_id" value="{{ $item->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title">Penilaian Dosen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nilai" class="form-label">Nilai</label>
                            <input type="number" class="form-control" name="nilai" id="nilai" required
                                placeholder="0 - 100">
                        </div>
                        <div class="mb-3">
                            <label for="feedback" class="form-label">Feedback</label>
                            <textarea class="form-control" name="feedback" id="feedback" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($item->penilaian_dosen as $penilaian)
        <div class="modal fade" id="editPenilaianDosen{{ $penilaian->id }}" tabindex="-1"
            aria-labelledby="editPenilaianDosen{{ $penilaian->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('penilaian_dosen.update', $penilaian->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="mahasiswa_dokumen_id" value="{{ $item->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title">Penilaian Dosen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nilai" class="form-label">Nilai</label>
                                <input type="number" class="form-control" name="nilai" id="nilai" required placeholder="0 - 100"
                                    value="{{ $penilaian->nilai }}">
                            </div>
                            <div class="mb-3">
                                <label for="feedback" class="form-label">Feedback</label>
                                <textarea class="form-control" name="feedback" id="feedback" rows="3"
                                    required>{{ $penilaian->feedback }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endforeach
@endsection
