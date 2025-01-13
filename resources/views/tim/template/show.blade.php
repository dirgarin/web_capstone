@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Dokumen</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0">Detail</h5>
                    <a href="{{ route('template.index') }}" class="btn btn-secondary btn-sm ms-auto rounded-3"><i
                            class="fas fa-arrow-left fa-2x"></i></a>
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
                                                                        {{ $topik->judul }}
                                                                        ({{ $item->daftar_topik->registerable->tim->nama_ketua }})
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
                                                                                        <td colspan="4" class="text-center">Belum ada
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
@endsection