<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaDokumen;
use Illuminate\Http\Request;

class MahasiswaDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->guest()) {
            abort(404);
        } else {
            if (auth()->user()->role == 'tim') {
                $data = MahasiswaDokumen::orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy('daftar_topik_id')
                    ->map(function ($item) {
                        return $item->first();
                    });
                return view('tim.mahasiswa_dokumen.index', compact('data'));
            } elseif (auth()->user()->role == 'dosen_pembimbing' || auth()->user()->role == 'dosen_penguji' || auth()->user()->role == 'dosen') {
                $data = MahasiswaDokumen::orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy('daftar_topik_id')
                    ->map(function ($item) {
                        return $item->first();
                    });

                return view('dosen.mahasiswa_dokumen.index', compact('data'));
            } elseif (auth()->user()->role == 'mahasiswa') {
                $data = MahasiswaDokumen::whereHas('daftar_topik', function ($query) {
                    $query->whereHasMorph('registerable', ['App\Models\DaftarTopikMandiri', 'App\Models\DaftarTopikDosen'], function ($query) {
                        $query->whereHas('tim', function ($query) {
                            $query->where('mahasiswa1_id', auth()->user()->mahasiswa->id)
                                ->orWhere('mahasiswa2_id', auth()->user()->mahasiswa->id)
                                ->orWhere('mahasiswa3_id', auth()->user()->mahasiswa->id);
                        });
                    });
                })
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy('daftar_topik_id')
                    ->map(function ($item) {
                        return $item->first();
                    });
                return view('mahasiswa.mahasiswa_dokumen.index', compact('data'));
            } else {
                abort(404);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($mahasiswa_dokumen)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        if (auth()->user()->role == 'tim') {
            $data = MahasiswaDokumen::find($mahasiswa_dokumen);
            $dokumen = MahasiswaDokumen::where('daftar_topik_id', $data->daftar_topik_id)
                ->where('template_id', $data->template_id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('mahasiswa_id')
                ->map(function ($item) {
                    return $item->first();
                });
            return view('tim.mahasiswa_dokumen.show', compact('data', 'dokumen'));
        } elseif (auth()->user()->role == 'mahasiswa') {
            $data = MahasiswaDokumen::find($mahasiswa_dokumen);
            $dokumen = MahasiswaDokumen::where('daftar_topik_id', $data->daftar_topik_id)
                ->where('template_id', $data->template_id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('mahasiswa_id')
                ->map(function ($item) {
                    return $item->first();
                });
            return view('mahasiswa.mahasiswa_dokumen.show', compact('data', 'dokumen'));
        } elseif (auth()->user()->role == 'dosen_pembimbing' || auth()->user()->role == 'dosen_penguji' || auth()->user()->role == 'dosen') {
            $data = MahasiswaDokumen::find($mahasiswa_dokumen);
            $dokumen = MahasiswaDokumen::where('daftar_topik_id', $data->daftar_topik_id)
                ->where('template_id', $data->template_id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('mahasiswa_id')
                ->map(function ($item) {
                    return $item->first();
                });
            return view('dosen.mahasiswa_dokumen.show', compact('data', 'dokumen'));
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MahasiswaDokumen $mahasiswaDokumen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MahasiswaDokumen $mahasiswaDokumen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MahasiswaDokumen $mahasiswaDokumen)
    {
        //
    }
}
