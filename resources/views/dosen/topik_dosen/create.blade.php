@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Pengajuan Topik</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('topik_dosen.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                                name="judul" value="{{ old('judul') }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="instansi" class="form-label">Instansi / Organisasi / Perusahaan Objek</label>
                            <input type="text" class="form-control @error('instansi') is-invalid @enderror"
                                id="instansi" name="instansi" value="{{ old('instansi') }}" required>
                            @error('instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_tim" class="form-label">Jumlah Tim</label>
                            <input type="number" class="form-control @error('jumlah_tim') is-invalid @enderror"
                                id="jumlah_tim" name="jumlah_tim" value="{{ old('jumlah_tim') }}" required>
                            @error('jumlah_tim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control form-control-lg @error('deskripsi') is-invalid @enderror"
                                id="deskripsi" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kompetensi" class="form-label">Kompetensi yang diharapkan</label>
                            <textarea class="form-control form-control-lg @error('kompetensi') is-invalid @enderror"
                                id="kompetensi" name="kompetensi" required>{{ old('kompetensi') }}</textarea>
                            @error('kompetensi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">Ajukan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection