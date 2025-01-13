@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Dosen</h1>
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
                                    <th>NIP</th>
                                    <th>Bidang Keahlian</th>
                                    <th>Sebagai</th>
                                    <th>Tanggal Pendaftaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $item->nama }}</td>
                                        <td class="text-center">{{ $item->nik }}</td>
                                        <td class="text-center">
                                            <ul>
                                                @foreach ($item->bidangMinat as $bidang)
                                                    <li>{{ $bidang->bidang_minat->nama }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="text-center">
                                            @if ($item->role == "pembimbing")
                                                Pembimbing
                                            @elseif($item->role == "penguji")
                                                Penguji
                                            @else
                                                Pembimbing dan Penguji
                                            @endif
                                        </td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        <td class="text-center" style="width: 100px;">
                                            <a href="{{ route('dosen.show', $item->id) }}" class="btn btn-warning">
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