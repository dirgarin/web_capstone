@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Mahasiswa</h1>
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
                                    <th>Nama Lengkap</th>
                                    <th>NIM</th>
                                    <th>Tanggal Pendaftaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $item->nama }}</td>
                                        <td class="text-center">{{ $item->nim }}</td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        <td class="text-center">
                                            @if ($item->status == "approved")
                                                <span class="badge bg-success">Terdaftar</span>
                                            @elseif($item->status == "rejected")
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-warning">Butuh Validasi</span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="width: 100px;">
                                            <a href="{{ route('mahasiswa.show', $item->id) }}" class="btn btn-warning">
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
