@extends('layout.app')

@section('contents')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">{{ $data->judul }}</h1>
        <div class="row">
            <div class="col-12">
                <div class="">
                    <div class="">
                        <div class="row align-items-stretch g-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-text mt-3">
                                            <p>{!! $data->deskripsi !!}</p>
                                            <b>Open: {{ $data->open }}</b><br>
                                            <b>Deadline: {{ $data->deadline }}</b>
                                        </div>
                                        @if ($data->dokumen)
                                            <div class="">
                                                <a href="{{ Storage::url($data->dokumen) }}" class="btn btn-primary mt-3"
                                                    download>
                                                    <i class="fas fa-download"></i>
                                                    Download File
                                                </a>
                                            </div>
                                        @endif
                                        <a href="/submission/submit/{{ $data->id }}">
                                            <button class="btn btn-primary" style="margin-top: 10px;">Submit</button>
                                        </a>
                                        <!-- <form action="/submission/submit/{{ $data->id }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="file" name="file" class="my-3">
                                                <div>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form> -->
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
