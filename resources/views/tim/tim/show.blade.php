@extends('layout.app')

@section('contents')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Tim Mahasiswa</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">Detail</h5>
                        <a href="{{ route('tim.index') }}" class="btn btn-secondary btn-sm ms-auto rounded-3"><i
                                class="fas fa-arrow-left fa-2x"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-stretch g-3">
                            <!-- Mahasiswa Pertama -->
                            <div class="col-12 mb-3">
                                <div class="card p-3">
                                    <div class="card-header bg-light border-bottom">
                                        <h3>Mahasiswa Pertama</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="card-title">Nama Lengkap</h5>
                                            <p class="card-text">{{ $data->mahasiswa1->nama }}</p>
                                            <h5 class="card-title">NIM</h5>
                                            <p class="card-text">{{ $data->mahasiswa1->nim }}</p>
                                            <h5 class="card-title">Email</h5>
                                            <p class="card-text">{{ $data->mahasiswa1->user->email }}</p>
                                            <h5 class="card-title">No. Telepon</h5>
                                            <p class="card-text">{{ $data->mahasiswa1->no_telp }}</p>
                                            <h5 class="card-title">Bidang Minat</h5>
                                            <p class="card-text">{{ $data->mahasiswa1->bidang_minat->nama }}</p>
                                            <h5 class="card-title">Kompetensi Keahlian</h5>
                                            <p class="card-text">{{ $data->mahasiswa1->kompetensi }}</p>
                                            <h5 class="card-title">Tanggal Pendaftaran</h5>
                                            <p class="card-text">{{ $data->mahasiswa1->created_at->format('d F Y H:i:s') }}
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-footer border-top">
                                                <h5 class="card-title">Penilaian</h5>
                                                @forelse ($data->penilaian_tim->where('target_id', $data->mahasiswa1->id) as $item)
                                                    <div class="alert alert-primary" role="alert">
                                                        <h4 class="alert-heading">Nilai : {{ $item->nilai }}</h4>
                                                        <p>{{ $item->keterangan }}</p>
                                                        <hr>
                                                        <p class="mb-0">Diberikan oleh : {{ $item->mahasiswa->nama }}</p>
                                                    </div>
                                                @empty
                                                    <div class="alert alert-warning" role="alert">
                                                        Belum ada penilaian
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="card p-3">
                                                <h5 class="card-title">File KTP</h5>
                                                <div class="container-fluid p-0">
                                                    <object class="pdf" data="{{ Storage::url($data->mahasiswa1->file_ktp) }}" type="application/pdf">
                                                        <p>Your browser does not support PDF embedding.</p>
                                                    </object>
                                                </div>
                                                
                                                <style>
                                                    .pdf {
                                                        width: 100%;  
                                                        height: 100vh; 
                                                        object-fit: contain; 
                                                        border: none;
                                                    }
                                                </style>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card p-3">
                                                <h5 class="card-title">File KHS</h5>
                                                <object class="pdf"
                                                    data="{{ Storage::url($data->mahasiswa1->file_khs) }}" width="100%"
                                                    height="400px"></object>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card p-3">
                                                <h5 class="card-title">File Prasyarat</h5>
                                                <object class="pdf"
                                                    data="{{ Storage::url($data->mahasiswa1->file_prasyarat) }}"
                                                    width="100%" height="400px"></object>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mahasiswa Kedua -->
                            <div class="col-12 mb-3">
                                <div class="card p-3">
                                    <div class="card-header bg-light border-bottom">
                                        <h3>Mahasiswa Kedua</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="card-title">Nama Lengkap</h5>
                                            <p class="card-text">{{ $data->mahasiswa2->nama }}</p>
                                            <h5 class="card-title">NIM</h5>
                                            <p class="card-text">{{ $data->mahasiswa2->nim }}</p>
                                            <h5 class="card-title">Email</h5>
                                            <p class="card-text">{{ $data->mahasiswa2->user->email }}</p>
                                            <h5 class="card-title">No. Telepon</h5>
                                            <p class="card-text">{{ $data->mahasiswa2->no_telp }}</p>
                                            <h5 class="card-title">Bidang Minat</h5>
                                            <p class="card-text">{{ $data->mahasiswa2->bidang_minat->nama }}</p>
                                            <h5 class="card-title">Kompetensi Keahlian</h5>
                                            <p class="card-text">{{ $data->mahasiswa2->kompetensi }}</p>
                                            <h5 class="card-title">Tanggal Pendaftaran</h5>
                                            <p class="card-text">{{ $data->mahasiswa2->created_at->format('d F Y H:i:s') }}
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-footer border-top">
                                                <h5 class="card-title">Penilaian</h5>
                                                @forelse ($data->penilaian_tim->where('target_id', $data->mahasiswa2->id) as $item)
                                                    <div class="alert alert-primary" role="alert">
                                                        <h4 class="alert-heading">Nilai : {{ $item->nilai }}</h4>
                                                        <p>{{ $item->keterangan }}</p>
                                                        <hr>
                                                        <p class="mb-0">Diberikan oleh : {{ $item->mahasiswa->nama }}</p>
                                                    </div>
                                                @empty
                                                    <div class="alert alert-warning" role="alert">
                                                        Belum ada penilaian
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="card p-3">
                                                <h5 class="card-title">File KTP</h5>
                                                <object class="pdf"
                                                    data="{{ Storage::url($data->mahasiswa2->file_ktp) }}" width="100%"
                                                    height="400px"></object>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card p-3">
                                                <h5 class="card-title">File KHS</h5>
                                                <object class="pdf"
                                                    data="{{ Storage::url($data->mahasiswa2->file_khs) }}" width="100%"
                                                    height="400px"></object>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card p-3">
                                                <h5 class="card-title">File Prasyarat</h5>
                                                <object class="pdf"
                                                    data="{{ Storage::url($data->mahasiswa2->file_prasyarat) }}"
                                                    width="100%" height="400px"></object>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mahasiswa Ketiga -->
                            <div class="col-12 mb-3">
                                <div class="card p-3">
                                    <div class="card-header bg-light border-bottom">
                                        <h3>Mahasiswa Ketiga</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="card-title">Nama Lengkap</h5>
                                            <p class="card-text">{{ $data->mahasiswa3->nama }}</p>
                                            <h5 class="card-title">NIM</h5>
                                            <p class="card-text">{{ $data->mahasiswa3->nim }}</p>
                                            <h5 class="card-title">Email</h5>
                                            <p class="card-text">{{ $data->mahasiswa3->user->email }}</p>
                                            <h5 class="card-title">No. Telepon</h5>
                                            <p class="card-text">{{ $data->mahasiswa3->no_telp }}</p>
                                            <h5 class="card-title">Bidang Minat</h5>
                                            <p class="card-text">{{ $data->mahasiswa3->bidang_minat->nama }}</p>
                                            <h5 class="card-title">Kompetensi Keahlian</h5>
                                            <p class="card-text">{{ $data->mahasiswa3->kompetensi }}</p>
                                            <h5 class="card-title">Tanggal Pendaftaran</h5>
                                            <p class="card-text">
                                                {{ $data->mahasiswa3->created_at->format('d F Y H:i:s') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-footer border-top">
                                                <h5 class="card-title">Penilaian</h5>
                                                @forelse ($data->penilaian_tim->where('target_id', $data->mahasiswa3->id) as $item)
                                                    <div class="alert alert-primary" role="alert">
                                                        <h4 class="alert-heading">Nilai : {{ $item->nilai }}</h4>
                                                        <p>{{ $item->keterangan }}</p>
                                                        <hr>
                                                        <p class="mb-0">Diberikan oleh : {{ $item->mahasiswa->nama }}
                                                        </p>
                                                    </div>
                                                @empty
                                                    <div class="alert alert-warning" role="alert">
                                                        Belum ada penilaian
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="card p-3">
                                                <h5 class="card-title">File KTP</h5>
                                                <object class="pdf"
                                                    data="{{ Storage::url($data->mahasiswa3->file_ktp) }}" width="100%"
                                                    height="400px"></object>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card p-3">
                                                <h5 class="card-title">File KHS</h5>
                                                <object class="pdf"
                                                    data="{{ Storage::url($data->mahasiswa3->file_khs) }}" width="100%"
                                                    height="400px"></object>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card p-3">
                                                <h5 class="card-title">File Prasyarat</h5>
                                                <object class="pdf"
                                                    data="{{ Storage::url($data->mahasiswa3->file_prasyarat) }}"
                                                    width="100%" height="400px"></object>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 d-flex">
                                <div class="ms-auto d-flex flex-column gap-2">
                                    <div class="row gap-2">
                                        <div class="col-12 d-flex align-items-center justify-content-end gap-2">
                                            <h5 class="card-title mb-0">Nama Tim :</h5>
                                            <p class="card-text">
                                                <span class="badge bg-primary">{{ $data->nama_ketua }}</span>
                                            </p>
                                        </div>
                                        <div class="col-12 d-flex align-items-center justify-content-end gap-2">
                                            <h5 class="card-title mb-0">Status Validasi :</h5>
                                            <p class="card-text">
                                                @if ($data->status == 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif($data->status == 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-warning">Butuh Validasi</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    @if ($data->status == 'pending')
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <form action="{{ route('tim.update', $data->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-success"
                                                    onclick="return confirm('Apakah anda yakin untuk menyetujui tim ini?')">
                                                    <i class="fas fa-check"></i> Setujui
                                                </button>
                                            </form>
                                            <!-- Tombol Tolak yang memunculkan modal -->
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </div>
                                    @endif

                                    <!-- Modal untuk alasan penolakan -->
                                    <div class="modal fade" id="rejectModal" tabindex="-1"
                                        aria-labelledby="rejectModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <!-- Menambahkan modal-dialog-centered untuk posisi tengah -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="rejectForm" action="{{ route('tim.update', $data->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <div class="mb-3">
                                                            <label for="alasan_penolakan" class="form-label">Masukkan
                                                                Alasan Penolakan</label>
                                                            <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control" required rows="4"></textarea>
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="card-body">
                    <div class="row align-items-stretch g-3">
                        <div class="col-md-2 h-100">
                            <div class="card p-3 h-100">
                                <div class="card-header">
                                    <h3>Mahasiswa Pertama</h3>
                                </div>
                                <h5 class="card-title">Nama Lengkap</h5>
                                <p class="card-text">{{ $data->mahasiswa1->nama }}</p>
                                <h5 class="card-title">NIM</h5>
                                <p class="card-text">{{ $data->mahasiswa1->nim }}</p>
                                <h5 class="card-title">Email</h5>
                                <p class="card-text">{{ $data->mahasiswa1->user->email }}</p>
                                <h5 class="card-title">No. Telepon</h5>
                                <p class="card-text">{{ $data->mahasiswa1->no_telp }}</p>
                                <h5 class="card-title">Bidang Minat</h5>
                                <p class="card-text">{{ $data->mahasiswa1->bidang_minat->nama }}</p>
                                <h5 class="card-title">Kompetensi Keahlian</h5>
                                <p class="card-text">{{ $data->mahasiswa1->kompetensi }}</p>
                                <h5 class="card-title">Tanggal Pendaftaran</h5>
                                <p class="card-text">{{ $data->mahasiswa1->created_at->format('d F Y H:i:s') }}</p>
                                <div class="card-footer">
                                    <h5 class="card-title">Penilaian</h5>
                                    @forelse ($data->penilaian_tim->where('target_id', $data->mahasiswa1->id) as $item)
                                        <div class="alert alert-primary" role="alert">
                                            <h4 class="alert-heading">Nilai : {{ $item->nilai }}</h4>
                                            <p>{{ $item->keterangan }}</p>
                                            <hr>
                                            <p class="mb-0">Diberikan oleh : {{ $item->mahasiswa->nama }}</p>
                                        </div>
                                    @empty
                                        <div class="alert alert-warning" role="alert">
                                            Belum ada penilaian
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 h-100">
                            <div class="row h-100">
                                <div class="col-md-4">
                                    <div class="card p-3">
                                        <h5 class="card-title">File KTP</h5>
                                        <object class="pdf" data="{{ Storage::url($data->mahasiswa1->file_ktp) }}"
                                            width="100%" height="400px"></object>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3">
                                        <h5 class="card-title">File KHS</h5>
                                        <object class="pdf" data="{{ Storage::url($data->mahasiswa1->file_khs) }}"
                                            width="100%" height="400px"></object>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3">
                                        <h5 class="card-title">File Prasyarat</h5>
                                        <object class="pdf" data="{{ Storage::url($data->mahasiswa1->file_prasyarat) }}"
                                            width="100%" height="400px"></object>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-2 h-100">
                            <div class="card p-3 h-100">
                                <div class="card-header">
                                    <h3>Mahasiswa Kedua</h3>
                                </div>
                                <h5 class="card-title">Nama Lengkap</h5>
                                <p class="card-text">{{ $data->mahasiswa2->nama }}</p>
                                <h5 class="card-title">NIM</h5>
                                <p class="card-text">{{ $data->mahasiswa2->nim }}</p>
                                <h5 class="card-title">Email</h5>
                                <p class="card-text">{{ $data->mahasiswa2->user->email }}</p>
                                <h5 class="card-title">No. Telepon</h5>
                                <p class="card-text">{{ $data->mahasiswa2->no_telp }}</p>
                                <h5 class="card-title">Bidang Minat</h5>
                                <p class="card-text">{{ $data->mahasiswa2->bidang_minat->nama }}</p>
                                <h5 class="card-title">Kompetensi Keahlian</h5>
                                <p class="card-text">{{ $data->mahasiswa2->kompetensi }}</p>
                                <h5 class="card-title">Tanggal Pendaftaran</h5>
                                <p class="card-text">{{ $data->mahasiswa2->created_at->format('d F Y H:i:s') }}</p>
                                <div class="card-footer">
                                    <h5 class="card-title">Penilaian</h5>
                                    @forelse ($data->penilaian_tim->where('target_id', $data->mahasiswa2->id) as $item)
                                        <div class="alert alert-primary" role="alert">
                                            <h4 class="alert-heading">Nilai : {{ $item->nilai }}</h4>
                                            <p>{{ $item->keterangan }}</p>
                                            <hr>
                                            <p class="mb-0">Diberikan oleh : {{ $item->mahasiswa->nama }}</p>
                                        </div>
                                    @empty
                                        <div class="alert alert-warning" role="alert">
                                            Belum ada penilaian
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 h-100">
                            <div class="row h-100">
                                <div class="col-md-4">
                                    <div class="card p-3">
                                        <h5 class="card-title">File KTP</h5>
                                        <object class="pdf" data="{{ Storage::url($data->mahasiswa2->file_ktp) }}"
                                            width="100%" height="400px"></object>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3">
                                        <h5 class="card-title">File KHS</h5>
                                        <object class="pdf" data="{{ Storage::url($data->mahasiswa2->file_khs) }}"
                                            width="100%" height="400px"></object>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3">
                                        <h5 class="card-title">File Prasyarat</h5>
                                        <object class="pdf" data="{{ Storage::url($data->mahasiswa2->file_prasyarat) }}"
                                            width="100%" height="400px"></object>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-2 h-100">
                            <div class="card p-3 h-100">
                                <div class="card-header">
                                    <h3>Mahasiswa Ketiga</h3>
                                </div>
                                <h5 class="card-title">Nama Lengkap</h5>
                                <p class="card-text">{{ $data->mahasiswa3->nama }}</p>
                                <h5 class="card-title">NIM</h5>
                                <p class="card-text">{{ $data->mahasiswa3->nim }}</p>
                                <h5 class="card-title">Email</h5>
                                <p class="card-text">{{ $data->mahasiswa3->user->email }}</p>
                                <h5 class="card-title">No. Telepon</h5>
                                <p class="card-text">{{ $data->mahasiswa3->no_telp }}</p>
                                <h5 class="card-title">Bidang Minat</h5>
                                <p class="card-text">{{ $data->mahasiswa3->bidang_minat->nama }}</p>
                                <h5 class="card-title">Kompetensi Keahlian</h5>
                                <p class="card-text">{{ $data->mahasiswa3->kompetensi }}</p>
                                <h5 class="card-title">Tanggal Pendaftaran</h5>
                                <p class="card-text">{{ $data->mahasiswa3->created_at->format('d F Y H:i:s') }}</p>
                                <div class="card-footer">
                                    <h5 class="card-title">Penilaian</h5>
                                    @forelse ($data->penilaian_tim->where('target_id', $data->mahasiswa3->id) as $item)
                                        <div class="alert alert-primary" role="alert">
                                            <h4 class="alert-heading">Nilai : {{ $item->nilai }}</h4>
                                            <p>{{ $item->keterangan }}</p>
                                            <hr>
                                            <p class="mb-0">Diberikan oleh : {{ $item->mahasiswa->nama }}</p>
                                        </div>
                                    @empty
                                        <div class="alert alert-warning" role="alert">
                                            Belum ada penilaian
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 h-100">
                            <div class="row h-100">
                                <div class="col-md-4">
                                    <div class="card p-3">
                                        <h5 class="card-title">File KTP</h5>
                                        <object class="pdf" data="{{ Storage::url($data->mahasiswa3->file_ktp) }}"
                                            width="100%" height="400px"></object>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3">
                                        <h5 class="card-title">File KHS</h5>
                                        <object class="pdf" data="{{ Storage::url($data->mahasiswa3->file_khs) }}"
                                            width="100%" height="400px"></object>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3">
                                        <h5 class="card-title">File Prasyarat</h5>
                                        <object class="pdf" data="{{ Storage::url($data->mahasiswa3->file_prasyarat) }}"
                                            width="100%" height="400px"></object>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex">
                            <div class="ms-auto d-flex flex-column gap-2">
                                <div class="row gap-2">
                                    <div class="col-12 d-flex align-items-center justify-content-end gap-2">
                                        <h5 class="card-title mb-0">Nama Tim :</h5>
                                        <p class="card-text">
                                            <span class="badge bg-primary">{{ $data->nama_ketua }}</span>
                                        </p>
                                    </div>
                                    <div class="col-12 d-flex align-items-center justify-content-end gap-2">
                                        <h5 class="card-title mb-0">Status Validasi :</h5>
                                        <p class="card-text">
                                            @if ($data->status == 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($data->status == "rejected")
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-warning">Butuh Validasi</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if ($data->status == 'pending')
                                <div class="d-flex align-items-center justify-content-end gap-2">
                                    <form action="{{ route('tim.update', $data->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Apakah anda yakin untuk menyetujui tim ini?')">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>
                                    <!-- Tombol Tolak yang memunculkan modal -->
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </div>
                            @endif
                            
                            <!-- Modal untuk alasan penolakan -->
                            <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"> <!-- Menambahkan modal-dialog-centered untuk posisi tengah -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="rejectForm" action="{{ route('tim.update', $data->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="rejected">
                                                <div class="mb-3">
                                                    <label for="alasan_penolakan" class="form-label">Masukkan Alasan Penolakan</label>
                                                    <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control" required rows="4"></textarea>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rejectForm = document.getElementById("rejectForm");
            const alasanInput = rejectForm.querySelector("#alasan");

            rejectForm.addEventListener("submit", function(event) {
                // Validasi jika alasan kosong
                if (!alasanInput.value.trim()) {
                    event.preventDefault();
                    alert("Harap isi alasan penolakan.");
                }
            });
        });
    </script>
@endsection
