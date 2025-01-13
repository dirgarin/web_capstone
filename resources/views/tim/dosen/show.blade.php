@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Dosen</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0">Detail</h5>
                    <a href="{{ route('dosen.index') }}" class="btn btn-secondary btn-sm ms-auto rounded-3"><i
                            class="fas fa-arrow-left fa-2x"></i></a>
                </div>
                <div class="card-body">
                    <div class="row align-items-stretch g-3">
                            <div class="card p-3 h-100">
                                <h5 class="card-title">Nama Lengkap</h5>
                                <p class="card-text">{{ $data->nama }}</p>
                                <h5 class="card-title">NIP</h5>
                                <p class="card-text">{{ $data->nik }}</p>
                                <h5 class="card-title">Email</h5>
                                <p class="card-text">{{ $data->user->email }}</p>
                                <h5 class="card-title">No. Telepon</h5>
                                <p class="card-text">{{ $data->no_telp }}</p>
                                <h5 class="card-title">Bidang Keahlian</h5>
                                <p class="card-text">
                                <ul class="px-3">
                                    @foreach ($data->bidangMinat as $bidang)
                                        <li>{{ $bidang->bidang_minat->nama }}</li>
                                    @endforeach
                                </ul>
                                </p>
                                <h5 class="card-title">Sebagai</h5>
                                <p class="card-text">
                                    @if ($data->role == "pembimbing")
                                        Pembimbing
                                    @elseif($data->role == "penguji")
                                        Penguji
                                    @else
                                        Pembimbing dan Penguji
                                    @endif
                                </p>
                                <h5 class="card-title">Tanggal Pendaftaran</h5>
                                <p class="card-text">{{ $data->created_at->format('d F Y H:i:s') }}</p>
                            </div>
                        @if ($data->status == "pending")
                            <div class="col-12 d-flex">
                                <div class="ms-auto d-flex gap-2">
                                    <form action="{{ route('dosen.update', $data->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirmMessage('Apakah anda yakin untuk menerima dosen ini?', event)">
                                            <i class="fas fa-check"></i> Terima
                                        </button>
                                    </form>
                                    <form action="{{ route('dosen.update', $data->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirmMessage('Apakah anda yakin untuk menolak dosen ini?', event)">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
