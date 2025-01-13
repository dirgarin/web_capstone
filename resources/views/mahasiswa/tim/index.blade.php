@extends('layout.app')

@section('contents')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Tim Mahasiswa</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">Data</h5>
                        @if ($is_create)
                            <a href="{{ route('tim.create') }}"
                                class="btn btn-primary btn-sm ms-auto fs-5 fw-bold d-flex align-items-center gap-2 rounded-3"><i
                                    class="fas fa-plus fa-2x"></i> Buat Tim</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered table-hover"
                                style="width: 100%;">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 100px">No</th>
                                        <th>Nama Tim</th>
                                        <th>Mahasiswa Pertama</th>
                                        <th>Mahasiswa Kedua</th>
                                        <th>Mahasiswa Ketiga</th>
                                        <th>Tanggal Pendaftaran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $item)
                                        <tr>
                                            <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->nama_ketua }}</td>
                                            <td class="text-center">
                                                {{ $item->mahasiswa1->nama }} ({{ $item->mahasiswa1->nim }})
                                            </td>
                                            <td class="text-center">
                                                {{ $item->mahasiswa2->nama }} ({{ $item->mahasiswa2->nim }})
                                            </td>
                                            <td class="text-center">
                                                {{ $item->mahasiswa3->nama }} ({{ $item->mahasiswa3->nim }})
                                            </td>
                                            <td class="text-center">{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                            <td class="text-center">
                                                @if ($item->status == 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif($item->status == 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-warning">Butuh Validasi</span>
                                                @endif
                                            </td>
                                            <td class="text-center" style="width: 100px;">
                                                <a href="{{ route('tim.show', $item->id) }}" class="btn btn-warning">
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
