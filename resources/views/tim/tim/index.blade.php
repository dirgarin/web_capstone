@extends('layout.app')

@section('contents')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Tim Mahasiswa</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">Data</h5>
                        <form action="/deadline" method="POST" class="d-flex align-items-center mx-5" style="width: 70%;">
                            @csrf
                            <input type="hidden" name="type" value="tim">
                            <input type="date" name="start" id="" class="form-control"
                                value="{{ $deadline ? $deadline->start : null }}" style="width: 30%;">
                            <span class="mx-2">-</span>
                            <input type="date" name="end" id="" class="form-control"
                                value="{{ $deadline ? $deadline->end : null }}" style="width: 30%;">
                            <button type="submit" class="btn btn-primary mx-3">Set Deadline</button>
                        </form>
                        <a href="{{ route('tim.create') }}"
                            class="btn btn-primary btn-sm ms-auto fs-5 fw-bold d-flex align-items-center gap-2 rounded-3"><i
                                class="fas fa-plus fa-2x"></i> Buat Tim</a>
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
                                        @if ($submission)
                                            @foreach ($submission as $item)
                                                <th>Submission {{ $item->judul }}</th>
                                            @endforeach
                                        @else
                                            <th>Submission</th>
                                        @endif
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
                                                ({{ $item->mahasiswa1->kompetensi }})
                                            </td>
                                            <td class="text-center">
                                                {{ $item->mahasiswa2->nama }} ({{ $item->mahasiswa2->nim }})
                                                ({{ $item->mahasiswa2->kompetensi }})
                                            </td>
                                            <td class="text-center">
                                                {{ $item->mahasiswa3->nama }} ({{ $item->mahasiswa3->nim }})
                                                ({{ $item->mahasiswa3->kompetensi }})
                                            </td>
                                            <td class="text-center">{{ date('d-m-Y', strtotime($item->created_at)) }}</td>

                                            @if ($submission)
                                                @php
                                                    $mahasiswa1ID = $item->mahasiswa1_id;
                                                    $mahasiswa2ID = $item->mahasiswa2_id;
                                                    $mahasiswa3ID = $item->mahasiswa3_id;
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
                                                    @if ($submis)
                                                        @if ($submis->submission_id == $items->id)
                                                            <td class="text-center">
                                                                <a href="{{ route('submission.show', $submis->id) }}"
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
                                            @endif

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
