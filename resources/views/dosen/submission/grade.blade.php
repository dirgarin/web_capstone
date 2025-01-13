@extends('layout.app')

@section('contents')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Submission</h1>
        <div class="row">
            <div class="col-12">
                <div class="">
                    <div class="">
                        <div class="row align-items-stretch g-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Title: {{ $submission->judul }}</p>
                                        <p>{{ $answer->user->name }}</p>
                                        <a href="{{ Storage::url($answer->file) }}" class="mt-3" download>
                                            <i class="fas fa-download"></i>
                                            Download File
                                        </a>
                                        <iframe src="{{ Storage::url($answer->file) }}" width="100%" height="400px">
                                        </iframe>
                                        <p>Nilai</p>
                                        @if(count($answer->nilai) > 0)
                                            <p>Nilai: {{$nilai_akhir}}</p>
                                            <label for="" class="mt-3">Feedback</label>
                                            <textarea name="feedback" class="form-control" id="" readonly>{{$answer->feedback ? $answer->feedback->feedback : null}}</textarea>
                                        @else
                                        <form action="/submission/submit/grade/{{ $answer->id }}" method="POST">
                                            @csrf
                                            @foreach ($submission->penilaian as $i => $value)
                                                <p class="mt-3">{{ $i + 1 }}) {{ $value->text }}</p>
                                                @foreach ($value->choices as $value2)
                                                <input type="hidden" name="value[{{$i}}][penilaian_id]" value="{{$value->id}}">
                                                    <input type="radio" name="value[{{$i}}][choice_id]"
                                                        value="{{ $value2->id }}" class="mt-3">
                                                    <label for="">{{ $value2->text }}</label>
                                                    @if ($value2->image)
                                                        <img src="{{ Storage::url($value2->image) }}" width="200px"
                                                            class="mt-3">
                                                    @endif
                                                    <br>
                                                @endforeach
                                            @endforeach
                                            <label for="" class="mt-3">Feedback</label>
                                            <textarea name="feedback" class="form-control" id=""></textarea>
                                            <button class="btn btn-primary mt-3" type="submit">Submit</button>
                                        </form>
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
