@extends('layout.app')

@section('contents')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Section</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">Data</h5>
                        <a href="{{ route('sections.create') }}"
                            class="btn btn-primary btn-sm ms-auto fs-5 fw-bold d-flex align-items-center gap-2 rounded-3"><i
                                class="fas fa-plus fa-2x"></i> Buat Section</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered table-hover"
                                style="width: 100%;">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 100px">No</th>
                                        <th>Judul</th>
                                        <th>Image</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $item)
                                        <tr>
                                            <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->judul }}</td>
                                            <td class="text-center"> <img src="{{ Storage::url($item->image) }}"
                                                    style="width: 200px;" alt="">
                                            </td>
                                            <td class="text-center" style="width: 100px;">
                                                <a href="{{ route('sections.show', $item->id) }}" class="btn btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('sections.edit', $item->id) }}" class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
