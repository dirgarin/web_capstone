@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Pendaftaran Dosen</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dosen.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kode_dosen" class="form-label">Kode Dosen</label>
                            <input type="text" class="form-control @error('kode_dosen') is-invalid @enderror" id="kode_dosen"
                                name="kode_dosen" value="{{ old('kode_dosen') }}" required>
                            @error('kode_dosen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIP</label>
                            <input type="number" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                name="nik" value="{{ old('nik') }}" required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">No. Telepon</label>
                            <input type="number" class="form-control @error('no_telp') is-invalid @enderror"
                                id="no_telp" name="no_telp" value="{{ old('no_telp') }}" required>
                            @error('no_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="bidang_minat_id" class="form-label">Bidang Keahlian</label>
                            <select class="form-select @error('bidang_minat_id') is-invalid @enderror"
                                id="bidang_minat_id" name="bidang_minat_id" required>
                                @foreach ($bidang_minat as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('bidang_minat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Sebagai</label>
                            <div class="form-check">
                                <input class="form-check-input @error('role') is-invalid @enderror" type="checkbox"
                                    name="role[]" id="pembimbing" value="pembimbing" {{ old('role') == 'pembimbing' ? 'checked' : '' }}>
                                <label class="form-check-label" for="pembimbing">Pembimbing</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('role') is-invalid @enderror" type="checkbox"
                                    name="role[]" id="penguji" value="penguji" {{ old('role') == 'penguji' ? 'checked' : '' }}>
                                <label class="form-check-label" for="penguji">Penguji</label>
                            </div>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection