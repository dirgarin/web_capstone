@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Segmen - {{ $data->type }}</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0">Upload</h5>
                    <a href="{{ route('template.index') }}" class="btn btn-secondary btn-sm ms-auto rounded-3"><i
                            class="fas fa-arrow-left fa-2x"></i></a>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="daftar_topik_id" class="form-label">Pilih Topik</label>
                            <select class="form-select @error('daftar_topik_id') is-invalid @enderror"
                                id="daftar_topik_id" name="daftar_topik_id" required>
                                <option value="">Pilih Topik</option>
                                @foreach ($daftarTopik as $item)
                                    <option value="{{ $item->id }}">
                                        @if ($item->registerable_type == 'App\Models\DaftarTopikMandiri')
                                            {{ $item->registerable->topik_mandiri->judul }}
                                            ({{ $item->registerable->tim->nama_ketua }})
                                        @else
                                            {{ $item->registerable->topik_dosen->judul }}
                                            ({{ $item->registerable->tim->nama_ketua }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('daftar_topik_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="file_dokumen" class="form-label">File</label>
                            <input type="file" class="form-control @error('file_dokumen') is-invalid @enderror"
                                id="file_dokumen" name="file_dokumen" accept=".doc,.docx,.pdf">
                            @error('file_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
