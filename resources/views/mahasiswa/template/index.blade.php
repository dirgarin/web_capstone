@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Segmen Dokumen</h1>
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
                                    <th>Jenis</th>
                                    <th>Mulai</th>
                                    <th>Berakhir</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $item->type }}</td>
                                        <td class="text-center">{{ date('d-m-Y H:i', strtotime($item->mulai)) }}</td>
                                        <td class="text-center">{{ date('d-m-Y H:i', strtotime($item->deadline)) }}</td>
                                        <td class="text-center">
                                            @if (date('Y-m-d H:i:s') < $item->mulai)
                                                <span class="badge bg-secondary">Belum Dimulai</span>
                                            @elseif (date('Y-m-d H:i:s') > $item->deadline)
                                                <span class="badge bg-danger">Berakhir</span>
                                            @else
                                                <span class="badge bg-success">Aktif</span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="width: 100px;">
                                            <a href="{{ route('template.show', $item->id) }}" class="btn btn-warning">
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
