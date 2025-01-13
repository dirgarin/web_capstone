@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Buat Segmen</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('template.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="type" class="form-label">Jenis</label>
                            <input type="text" class="form-control @error('type') is-invalid @enderror" id="type"
                                name="type" value="{{ old('type') }}" required>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror tinymce-input"
                                rows="10" id="deskripsi" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="file_template" class="form-label">File</label>
                            <input type="file" class="form-control @error('file_template') is-invalid @enderror"
                                id="file_template" name="file_template" required accept=".doc,.docx,.pdf">
                            @error('file_template')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="mulai" class="form-label">Mulai</label>
                            <input type="datetime-local" class="form-control @error('mulai') is-invalid @enderror"
                                id="mulai" name="mulai" value="{{ old('mulai') }}" required>
                            @error('mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deadline" class="form-label">Berakhir</label>
                            <input type="datetime-local" class="form-control @error('deadline') is-invalid @enderror"
                                id="deadline" name="deadline" value="{{ old('deadline') }}" required>
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">Buat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
