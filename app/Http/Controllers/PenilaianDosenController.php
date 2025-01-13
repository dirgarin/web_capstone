<?php

namespace App\Http\Controllers;

use App\Models\PenilaianDosen;
use Illuminate\Http\Request;

class PenilaianDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        if (auth()->guest()) {
            abort(404);
        }

        if (auth()->user()->role == 'dosen_pembimbing' || auth()->user()->role == 'dosen_penguji' || auth()->user()->role == 'dosen') {
            $request->validate([
                'mahasiswa_dokumen_id' => 'required',
                'nilai' => 'required',
                'feedback' => 'required',
            ]);

            $penilaianDosen = new PenilaianDosen();
            $penilaianDosen->mahasiswa_dokumen_id = $request->mahasiswa_dokumen_id;
            $penilaianDosen->dosen_id = auth()->user()->dosen->id;
            $penilaianDosen->nilai = $request->nilai;
            $penilaianDosen->feedback = $request->feedback;
            $penilaianDosen->save();

            return redirect()->route('mahasiswa_dokumen.show', $request->mahasiswa_dokumen_id)->with('success', 'Penilaian berhasil disimpan');
        }

        return abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(PenilaianDosen $penilaianDosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenilaianDosen $penilaianDosen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PenilaianDosen $penilaianDosen)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        if (auth()->user()->role != 'dosen_pembimbing' && auth()->user()->role != 'dosen_penguji') {
            return abort(404);
        }

        $request->validate(
            [
                'nilai' => 'required',
                'feedback' => 'required',
            ],
            [
                'nilai.required' => 'Nilai wajib diisi',
                'feedback.required' => 'Feedback wajib diisi',
            ]
        );

        $penilaianDosen->nilai = $request->nilai;
        $penilaianDosen->feedback = $request->feedback;
        $penilaianDosen->save();

        return redirect()->route('mahasiswa_dokumen.show', $penilaianDosen->mahasiswa_dokumen_id)->with('success', 'Penilaian berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenilaianDosen $penilaianDosen)
    {
        //
    }
}
