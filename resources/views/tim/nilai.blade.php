@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Nilai</h1>
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
                                    <th>Submission</th>
                                    <th>Mahasiswa</th>
                                    <th>Nilai</th>
                                    <th>Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $item->submission->judul }}</td>
                                        <td class="text-center">{{ $item->user->name }}</td>
                                        <td class="text-center">{{ $item->nilai_akhir }}</td>
                                        <td class="text-center">{{ $item->feedback ? $item->feedback->feedback : null }}</td>
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
