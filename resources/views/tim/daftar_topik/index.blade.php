@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Topik yang Disetujui</h1>
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
                                    <th>Judul</th>
                                    <th>Instansi / Organisasi / Perusahaan Objek</th>
                                    <th>Dosen</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                                            <tr>
                                                                @if($item->registerable_type == 'App\Models\DaftarTopikDosen')
                                                                                                <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                                                                                <td class="text-center">{{ $item->registerable->topik_dosen->judul }}</td>
                                                                                                <td class="text-center">{{ $item->registerable->topik_dosen->instansi }}</td>
                                                                                                <td class="text-center">{{ $item->registerable->topik_dosen->dosen->nama }}</td>
                                                                                                <td class="text-center">
                                                                                                    <span class="badge bg-primary">Dosen</span>
                                                                                                </td>
                                                                                                @php
                                                                                                    $daftarTopikDosen = $item->registerable->where('status', 'assigned');
                                                                                                @endphp
                                                                                                <td class="text-center">
                                                                                                    @if ($item->status == "approved")
                                                                                                        <span class="badge bg-success">Disetujui Tim Capstone</span>
                                                                                                    @elseif ($daftarTopikDosen->count() >= $item->registerable->jumlah_tim)
                                                                                                        <span class="badge bg-success">Penuh</span>
                                                                                                    @elseif ($item->registerable->status == "assigned")
                                                                                                        <span class="badge bg-success">Disetujui</span>
                                                                                                    @else
                                                                                                        <span class="badge bg-warning">Butuh Validasi</span>
                                                                                                    @endif
                                                                                                </td>
                                                                                                <td class="text-center" style="width: 100px;">
                                                                                                    <a href="{{ route('topik_dosen.show', $item->registerable->topik_dosen->id) }}"
                                                                                                        class="btn btn-warning">
                                                                                                        <i class="fas fa-eye"></i>
                                                                                                    </a>
                                                                                                </td>
                                                                @else
                                                                                                <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                                                                                <td class="text-center">{{ $item->registerable->topik_mandiri->judul }}</td>
                                                                                                <td class="text-center">{{ $item->registerable->topik_mandiri->instansi }}</td>
                                                                                                <td class="text-center">{{ $item->registerable->topik_mandiri->dosen->nama }}</td>
                                                                                                <td class="text-center">
                                                                                                    <span class="badge bg-secondary">Mandiri</span>
                                                                                                </td>
                                                                                                @php
                                                                                                    $daftarTopikMandiri = $item->registerable->where('status', 'assigned');
                                                                                                @endphp
                                                                                                <td class="text-center">
                                                                                                    @if ($item->status == "approved")
                                                                                                        <span class="badge bg-success">Disetujui Tim Capstone</span>
                                                                                                    @elseif ($item->registerable->status == "assigned")
                                                                                                        <span class="badge bg-success">Disetujui Dosen, <br> Butuh Konfirmasi Tim
                                                                                                            Capstone</span>
                                                                                                    @elseif ($item->registerable->topik_mandiri->status == "pending" && $item->registerable->topik_mandiri->dosen_id == null)
                                                                                                        <span class="badge bg-danger">Tidak Memiliki Dosen</span>
                                                                                                    @elseif ($item->registerable->topik_mandiri->status == "pending" && $item->registerable->topik_mandiri->dosen_id != null)
                                                                                                        <span class="badge bg-warning">Menunggu Konfirmasi Dosen</span>
                                                                                                    @else
                                                                                                        <span class="badge bg-danger">Ditolak Dosen</span>
                                                                                                    @endif
                                                                                                </td>
                                                                                                <td class="text-center" style="width: 100px;">
                                                                                                    <a href="{{ route('topik_mandiri.show', $item->registerable->topik_mandiri->id) }}"
                                                                                                        class="btn btn-warning">
                                                                                                        <i class="fas fa-eye"></i>
                                                                                                    </a>
                                                                                                </td>
                                                                @endif
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
