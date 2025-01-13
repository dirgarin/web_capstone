@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Pilih Dosen</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="dosen_id" class="form-label">Dosen</label>
                            <select class="form-select @error('dosen_id') is-invalid @enderror select2-input"
                                id="dosen_id" name="dosen_id" required>
                                @foreach ($bidangMinat as $bm)
                                                                <optgroup class="select2-result-selectable" label="{{ $bm->nama }}">
                                                                    @foreach ($bm->bidang_minat_dosens->map(function ($item) {
                                                                            return $item->dosen;
                                                                        }) as $item)
                                                                                                        <option value="{{ $item->id }}">{{ $item->nama }} ({{$item->kode_dosen}})</option>
                                                                    @endforeach
                                                                </optgroup>
                                @endforeach
                            </select>
                            @error('dosen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection