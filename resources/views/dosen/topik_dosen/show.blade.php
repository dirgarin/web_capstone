@extends('layout.app')

@section('contents')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Topik Dosen</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">Detail </h5>
                        <a href="{{ route('topik_dosen.index') }}" class="btn btn-secondary btn-sm ms-auto rounded-3"><i
                                class="fas fa-arrow-left fa-2x"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 flex-column"> <!-- Ubah row agar layout default ke arah kolom -->
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Informasi Topik</h5>
                                            <p><strong>Judul:</strong> {{ $data->judul }}</p>
                                            <p><strong>Dosen:</strong> {{ $data->dosen->nama }}</p>
                                            <p><strong>Instansi:</strong> {{ $data->instansi }}</p>
                                            <p><strong>Jumlah Tim Maksimal:</strong> {{ $data->jumlah_tim }}</p>
                                            <p><strong>Jumlah Tim yang Disetujui:</strong>
                                                {{ $data->daftar_topik_dosen->where('status', 'assigned')->count() }}</p>
                                            <p><strong>Status:</strong>
                                                @if ($data->daftar_topik_dosen->where('status', 'assigned')->count() >= $data->jumlah_tim)
                                                    <span class="badge bg-success">Sudah Terpilih</span>
                                                @else
                                                    <span class="badge bg-warning">Masih Tersedia</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Persetujuan Topik</h5>
                                            @if ($data->status == 'assigned')
                                                <span class="badge bg-success">Sudah Disetujui</span>
                                            @elseif ($data->status == 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-warning">Belum Diverifikasi</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col h-100">
                                <div class="card p-3">
                                    <h5 class="card-title">Tim</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" style="width: 100%;">
                                            <thead>
                                                <tr class="text-center">
                                                    <th style="width: 100px">No</th>
                                                    <th>Nama Tim</th>
                                                    <th>Mahasiswa Pertama</th>
                                                    <th>Mahasiswa Kedua</th>
                                                    <th>Mahasiswa Ketiga</th>
                                                    <th>Nilai Tambahan</th>
                                                    <th>Terpilih</th>
                                                    @foreach ($submission as $item)
                                                        <th>{{ $item->judul }}</th>
                                                    @endforeach
                                                    @can('isDosenPembimbing')
                                                        <th>Aksi</th>
                                                    @endcan
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($data->daftar_topik_dosen as $item)
                                                    <tr>
                                                        <td class="text-center" style="width: 100px">{{ $loop->iteration }}
                                                        </td>
                                                        <td class="text-center">{{ $item->tim->nama_ketua }}</td>
                                                        <td class="text-center">
                                                            {{ $item->tim->mahasiswa1->user->name }}
                                                            ({{ $item->tim->mahasiswa1->nim }})
                                                            ({{ $item->tim->mahasiswa1->kompetensi }})
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->tim->mahasiswa2->user->name }}
                                                            ({{ $item->tim->mahasiswa2->nim }})
                                                            ({{ $item->tim->mahasiswa2->kompetensi }})
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->tim->mahasiswa3->user->name }}
                                                            ({{ $item->tim->mahasiswa3->nim }})
                                                            ({{ $item->tim->mahasiswa3->kompetensi }})
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->alasan_daftar }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($item->status == 'assigned')
                                                                <span class="badge bg-success">Terpilih</span>
                                                            @elseif ($item->status == 'rejected')
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @else
                                                                <span class="badge bg-warning">Belum Terpilih</span>
                                                            @endif
                                                        </td>
                                                        @php
                                                            $mahasiswa1ID = $item->tim->mahasiswa1_id;
                                                            $mahasiswa2ID = $item->tim->mahasiswa2_id;
                                                            $mahasiswa3ID = $item->tim->mahasiswa3_id;
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
                                                        @if ($submis && $submis->submission_id == $items->id)
                                                                <td class="text-center">
                                                                    <a href="{{ url('submission/grade/' . $submis->id) }}"
                                                                        class="btn btn-primary">Lihat</a>
                                                                </td>
                                                            @else
                                                                <td class="text-center">
                                                                    <span class="badge bg-danger">Belum Mengumpulkan</span>
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                        <td class="text-center">
                                                            <a href="{{ route('tim.show', $item->tim->id) }}"
                                                                class="btn btn-warning">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            @can('isDosenPembimbing')
                                                                @if ($item->status == 'pending')
                                                                    <form
                                                                        action="{{ route('daftar_topik_dosen.update', $item->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="status" value="assigned">
                                                                        <button type="submit" class="btn btn-success"
                                                                            onclick="return confirmMessage('Apakah anda yakin untuk memilih tim ini dan menolak tim lain?', event)">
                                                                            <i class="fas fa-check"></i> Pilih
                                                                        </button>
                                                                    </form>
                                                                    <form
                                                                        action="{{ route('daftar_topik_dosen.update', $item->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="status" value="rejected">
                                                                        <button type="submit" class="btn btn-danger"
                                                                            onclick="return confirmMessage('Apakah anda yakin untuk menolak tim ini?', event)">
                                                                            <i class="fas fa-times"></i> Tolak
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="10" class="text-center">Belum ada tim yang terdaftar
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Add conditional registration and approval buttons -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
