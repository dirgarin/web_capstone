@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Section</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0">Detail</h5>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm ms-auto rounded-3"><i
                            class="fas fa-arrow-left fa-2x"></i></a>
                </div>
                <div class="card-body">
                    <div class="row align-items-stretch g-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data->judul }}</h5>
                                    <img src="{{ Storage::url($data->image) }}" style="width: 100%;" alt="">
                                    <div class="card-text mt-3">
                                        {!! $data->isi !!}
                                    </div>
                                    @if($data->file)
                                        <div class="text-end">
                                            <a href="{{ Storage::url($data->file) }}" class="btn btn-primary mt-3" download>
                                                <i class="fas fa-download"></i>
                                                Download File
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
