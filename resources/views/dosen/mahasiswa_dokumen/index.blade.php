@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Dokumen Mahasiswa</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0">Data</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered table-hover"
                            style="width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 100px">No</th>
                                    <th>Nama Tim</th>
                                    <th>Judul Topik</th>
                                    <th>Instansi / Organisasi / Perusahaan Objek</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            {{ $item->daftar_topik->registerable->tim->nama_ketua }}
                                        </td>
                                        <td class="text-center">
                                            @if($item->daftar_topik->registerable_type == 'App\Models\DaftarTopikDosen')
                                                {{ $item->daftar_topik->registerable->topik_dosen->judul}}
                                            @else
                                                {{ $item->daftar_topik->registerable->topik_mandiri->judul}}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($item->daftar_topik->registerable_type == 'App\Models\DaftarTopikDosen')
                                                {{ $item->daftar_topik->registerable->topik_dosen->instansi}}
                                            @else
                                                {{ $item->daftar_topik->registerable->topik_mandiri->instansi}}
                                            @endif
                                        </td>
                                        <td class="text-center" style="width: 100px;">
                                            <a href="{{ route('mahasiswa_dokumen.show', $item->id) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Data tidak ditemukan</td>
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
@endsection
