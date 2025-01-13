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
                                        <table class="w-full">
                                            <tr>
                                                <td class="border px-4 py-2">Submission Status</td>
                                                <td class="border px-4 py-2">{{$answer ? "Submission submited" : "No submissions have been made yet"}}</td>
                                            </tr>
                                            <tr>
                                                <td class="border px-4 py-2">Grading Status</td>
                                                <td class="border px-4 py-2">{{$nilai ? "Graded" : "Not graded"}}</td>
                                            </tr>
                                            <tr>
                                                <td class="border px-4 py-2">Last Modified</td>
                                                <td class="border px-4 py-2">{{$answer ? $answer->updated_at : "-"}}</td>
                                            </tr>
                                        </table>
                                        @if($answer)
                                            <div class="mt-3">
                                                <a href="{{ Storage::url($answer->file) }}" class="mt-3" download>
                                                    <i class="fas fa-download"></i>
                                                    Download Submited Answer
                                                </a>
                                            </div>
                                        @else
                                        <form action="/submission/submit/{{ $data->id }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="file" name="file" class="my-3">
                                                <div>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
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
