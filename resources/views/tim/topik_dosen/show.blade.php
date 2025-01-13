@extends('layout.app')

@section('contents')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Topik Dosen</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">Detail Topik</h5>
                        <a href="{{ route('topik_dosen.index') }}" class="btn btn-secondary btn-sm ms-auto rounded-3">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Detail Laporan -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Informasi Topik</h5>
                                        <p><strong>Judul:</strong> {{ $data->judul }}</p>
                                        <p><strong>Dosen:</strong> {{ $data->dosen->nama }}</p>
                                        <p><strong>Instansi:</strong> {{ $data->instansi }}</p>
                                        <p><strong>Deskripsi:</strong> {{ $data->deskripsi }}</p>
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
                            @can('isTim')
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
                            @endcan
                        </div>

                        <!-- Daftar Tim -->
                        <h5 class="card-title">Daftar Tim</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Tim</th>
                                        <th>Mahasiswa Pertama</th>
                                        <th>Mahasiswa Kedua</th>
                                        <th>Mahasiswa Ketiga</th>
                                        <th>Nilai Tambah</th> 
                                        //submision
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data->daftar_topik_dosen as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
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
                                                @if ($item->status == 'assigned')
                                                    <span class="badge bg-success">Terpilih</span>
                                                @elseif ($item->status == 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Terpilih</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada tim yang terdaftar</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Actions -->
                        @can('isMahasiswa')
                            @if ($can_register)
                                <div class="text-end mt-4">
                                    <form action="{{ route('daftar_topik_dosen.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="topik_dosen_id" value="{{ $data->id }}">
                                        <button type="submit" class="btn btn-primary"
                                            onclick="return confirm('Yakin ingin mendaftar?')">
                                            Daftar
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endcan

                        {{-- @can('isTim')
                        @if ($data->status == 'pending')
                            <div class="text-end mt-4 d-flex gap-2">
                                <form action="{{ route('topik_dosen.update', $data->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="assigned">
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Setujui topik ini?')">
                                        <i class="fas fa-check"></i> Setuju
                                    </button>
                                </form>
                                <form action="{{ route('topik_dosen.update', $data->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak topik ini?')">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endcan --}}

                        @can('isTim')
                            @if ($data->status == 'pending')
                                <div class="text-end mt-4 d-flex gap-2">
                                    <!-- Form untuk menyetujui -->
                                    <form action="{{ route('topik_dosen.update', $data->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="assigned">
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Setujui topik ini?')">
                                            <i class="fas fa-check"></i> Setuju
                                        </button>
                                    </form>

                                    <!-- Tombol untuk membuka modal penolakan -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#rejectModal">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </div>

                                <!-- Modal untuk alasan penolakan -->
                                <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('topik_dosen.update', $data->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="rejected">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="alasan_penolakan" class="form-label">Masukkan alasan
                                                            penolakan</label>
                                                        <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control" rows="4"
                                                            placeholder="Tuliskan alasan Anda..." required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rejectModal = document.getElementById("rejectModal");
            const rejectForm = rejectModal.querySelector("form");
            const alasanField = rejectModal.querySelector("#alasanPenolakan");

            rejectForm.addEventListener("submit", function(event) {
                // Validasi jika alasan kosong
                if (!alasanField.value.trim()) {
                    event.preventDefault();
                    alert("Harap isi alasan penolakan.");
                }
            });
        });
    </script>

@endsection
