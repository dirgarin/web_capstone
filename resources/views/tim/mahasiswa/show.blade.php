@extends('layout.app')

@section('contents')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Mahasiswa</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">Detail</h5>
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-sm ms-auto rounded-3"><i
                                class="fas fa-arrow-left fa-2x"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-stretch g-3">

                            <div class="col-12 mb-3">
                                <div class="card p-3">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="card-title">Nama Lengkap</h5>
                                            <p class="card-text">{{ $data->nama }}</p>
                                            <h5 class="card-title">NIM</h5>
                                            <p class="card-text">{{ $data->nim }}</p>
                                            <h5 class="card-title">Email</h5>
                                            <p class="card-text">{{ $data->user->email }}</p>
                                            <h5 class="card-title">No. Telepon</h5>
                                            <p class="card-text">{{ $data->no_telp }}</p>
                                            <h5 class="card-title">Bidang Minat</h5>
                                            <p class="card-text">{{ $data->bidang_minat->nama }}</p>
                                            <h5 class="card-title">Kompetensi Keahlian</h5>
                                            <p class="card-text">{{ $data->kompetensi }}</p>
                                            <h5 class="card-title">Tanggal Pendaftaran</h5>
                                            <p class="card-text">{{ $data->created_at->format('d F Y H:i:s') }}
                                            <h5 class="card-title">Total SKS Lulus</h5>
                                            <p class="card-text">{{ $data->SKSLulus }}</p>
                                            <h5 class="card-title">Semester pengambilan mata kuliah Analisis Perancangan Sistem Informasi</h5>                                            
                                            <p class="card-text">{{ $data->apsi_semester }}</p>
                                            <h5 class="card-title">Nilai mata kuliah Analisis Perancangan Sistem Informasi</h5>                                            
                                            <p class="card-text">{{ $data->apsi_nilai }}</p>
                                            <h5 class="card-title">Semester pengambilan mata kuliah Manajemen Proyek</h5>                                            
                                            <p class="card-text">{{ $data->manpro_semester }}</p>
                                            <h5 class="card-title">Nilai mata kuliah Manajemen Proyek</h5>                                            
                                            <p class="card-text">{{ $data->manpro_nilai }}</p>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="card-title">Status pendaftaran</h5>
                                            <div class="card-footer border-top">
                                                @if ($data->status == 'approved')
                                                    <span class="badge bg-success">Terdaftar</span>
                                                @elseif($data->status == 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-warning">Butuh Validasi</span>
                                                @endif
                                            </div>
                                            <h5 class="card-title">Semester pengambilan mata kuliah Analisis Perancangan Sistem Informasi</h5>                                            
                                            <p class="card-text">{{ $data->apsi_semester }}</p>
                                            <h5 class="card-title">Nilai mata kuliah Analisis Perancangan Sistem Informasi</h5>                                            
                                            <p class="card-text">{{ $data->apsi_nilai }}</p>
                                            <h5 class="card-title">Semester pengambilan mata kuliah Manajemen Proyek</h5>                                            
                                            <p class="card-text">{{ $data->manpro_semester }}</p>
                                            <h5 class="card-title">Nilai mata kuliah Manajemen Proyek</h5>                                            
                                            <p class="card-text">{{ $data->manpro_nilai }}</p>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="card p-3">
                                                <h5 class="card-title">File KTP</h5>
                                                <div class="container-fluid p-0">
                                                    <object class="pdf"
                                                        data="{{ Storage::url($data->file_ktp) }}"
                                                        type="application/pdf">
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
                                                    data="{{ Storage::url($data->file_khs) }}" width="100%"
                                                    height="400px"></object>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card p-3">
                                                <h5 class="card-title">File Prasyarat</h5>
                                                <object class="pdf"
                                                    data="{{ Storage::url($data->file_prasyarat) }}"
                                                    width="100%" height="400px"></object>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Data Mahasiswa
                            <div class="col-md-2 h-100">
                                <div class="card p-3 h-100">
                                    <h5 class="card-title">Nama Lengkap</h5>
                                    <p class="card-text">{{ $data->nama }}</p>
                                    <h5 class="card-title">NIM</h5>
                                    <p class="card-text">{{ $data->nim }}</p>
                                    <h5 class="card-title">Kelas</h5>
                                    <p class="card-text">{{ $data->kelas }}</p>
                                    <h5 class="card-title">Email</h5>
                                    <p class="card-text">{{ $data->user->email }}</p>
                                    <h5 class="card-title">No. Telepon</h5>
                                    <p class="card-text">{{ $data->no_telp }}</p>
                                    <h5 class="card-title">Asal Kota</h5>
                                    <p class="card-text">{{ $data->asal_kota }}</p>
                                    <h5 class="card-title">Asal Provinsi</h5>
                                    <p class="card-text">{{ $data->asal_provinsi }}</p>
                                    <h5 class="card-title">Alamat</h5>
                                    <p class="card-text">{{ $data->alamat }}</p>
                                    <h5 class="card-title">Bidang Minat</h5>
                                    <p class="card-text">{{ $data->bidang_minat->nama }}</p>
                                    <h5 class="card-title">Kompetensi Keahlian</h5>
                                    <p class="card-text">{{ $data->kompetensi }}</p>
                                    <h5 class="card-title">Tanggal Pendaftaran</h5>
                                    <p class="card-text">{{ $data->created_at->format('d F Y H:i:s') }}</p>
                                    <h5 class="card-title">Status Validasi</h5>
                                    <p class="card-text">
                                        @if ($data->status == 'approved')
                                            <span class="badge bg-success">Terdaftar</span>
                                        @elseif($data->status == 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning">Butuh Validasi</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-10 h-100">
                                <div class="row h-100">
                                    <div class="col-md-4">
                                        <div class="card p-3">
                                            <h5 class="card-title">File KTP</h5>
                                            <object class="pdf" data="{{ Storage::url($data->file_ktp) }}"
                                                width="100%" height="400px"></object>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card p-3">
                                            <h5 class="card-title">File KHS</h5>
                                            <object class="pdf" data="{{ Storage::url($data->file_khs) }}"
                                                width="100%" height="400px"></object>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card p-3">
                                            <h5 class="card-title">File Prasyarat</h5>
                                            <object class="pdf" data="{{ Storage::url($data->file_prasyarat) }}"
                                                width="100%" height="400px"></object>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            @if ($data->status == 'pending')
                                <div class="col-12 d-flex">
                                    <div class="ms-auto d-flex gap-2">
                                        <form action="{{ route('mahasiswa.update', $data->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-success"
                                                onclick="return confirmMessage('Apakah anda yakin untuk menerima mahasiswa ini?', event)">
                                                <i class="fas fa-check"></i> Terima
                                            </button>
                                        </form>
                                        <!-- Tombol Tolak yang memunculkan modal -->
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <!-- Modal untuk alasan penolakan -->
                            <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <!-- Menambahkan modal-dialog-centered untuk posisi tengah -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="rejectForm" action="{{ route('mahasiswa.update', $data->id) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="rejected">
                                                <div class="mb-3">
                                                    <label for="alasan" class="form-label">Masukkan Alasan
                                                        Penolakan</label>
                                                    <textarea name="alasan" id="alasan" class="form-control" required rows="4"></textarea>
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
