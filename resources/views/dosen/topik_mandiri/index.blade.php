@extends('layout.app')

@section('contents')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Topik Mandiri Mahasiswa</h1>
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
                                        <th>Judul</th>
                                        <th>Instansi / Organisasi / Perusahaan Objek</th>
                                        <th>Dosen</th>
                                        <th>Status</th>
                                        @foreach ($submission as $item)
                                            <th>{{ $item->judul }}</th>
                                        @endforeach
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $item)
                                        <tr>
                                            <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->daftar_topik_mandiri->tim->nama_ketua }}
                                            </td>
                                            <td class="text-center">{{ $item->judul }}</td>
                                            <td class="text-center">{{ $item->instansi }}</td>
                                            <td class="text-center">{{ $item->dosen->nama ?? '-' }}</td>
                                            <td class="text-center">
                                                @if($item->status == "pending" && $item->dosen_id = null)
                                                    <span class="badge bg-primary">Menunggu Persetujuan Tim Capstone</span>
                                                @elseif ($item->status == 'assigned')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif ($item->status == 'approved' && $item->dosen_id == null)
                                                    <span class="badge bg-danger">Harap Pilih Dosen</span>
                                                @elseif ($item->status == 'pending' )
                                                    <span class="badge bg-warning">Menunggu Konfirmasi Dosen</span>
                                                @else
                                                    <span class="badge bg-danger">Dosen Menolak, Harap Pilih Dosen
                                                        Lain</span>
                                                @endif
                                            </td>
                                            @php
                                                $mahasiswa1ID = $item->daftar_topik_mandiri->tim->mahasiswa1_id;
                                                $mahasiswa2ID = $item->daftar_topik_mandiri->tim->mahasiswa2_id;
                                                $mahasiswa3ID = $item->daftar_topik_mandiri->tim->mahasiswa3_id;
                                                $submis = null;
                                                foreach ($answer as $answe) {
                                                    if (
                                                        $answe->user_id == $mahasiswa1ID ||
                                                        $answe->user_id == $mahasiswa2ID ||
                                                        $answe->user_id == $mahasiswa3ID
                                                    ) {
                                                        $submis = $answe;
                                                    }
                                                }
                                            @endphp

                                            @foreach ($submission as $items)
                                            @if($submis)
                                                @if ($submis->submission_id == $items->id)
                                                    <td class="text-center">
                                                        <a href="{{ url('submission/grade/' . $submis->submission_id) }}"
                                                            class="btn btn-primary">Lihat</a>
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <span class="badge bg-danger">Belum Mengumpulkan</span>
                                                    </td>
                                                @endif
                                                @else 
                                                <td class="text-center">
                                                    <span class="badge bg-danger">Belum Mengumpulkan</span>
                                                </td>
                                            @endif
                                            @endforeach
                                            <td class="text-center" style="width: 100px;">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="{{ route('topik_mandiri.show', $item->id) }}"
                                                        class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
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

