<?php

namespace App\Http\Controllers;

use App\Models\PenilaianTim;
use Illuminate\Http\Request;

class PenilaianTimController extends Controller
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

        if (auth()->user()->role == 'mahasiswa') {
            $request->validate([
                'tim_id' => 'required',
                'target_id' => 'required',
                'nilai' => 'required',
                'keterangan' => 'required',
            ]);

            $penilaianTim = new PenilaianTim();
            $penilaianTim->mahasiswa_id = auth()->user()->mahasiswa->id;
            $penilaianTim->tim_id = $request->tim_id;
            $penilaianTim->target_id = $request->target_id;
            $penilaianTim->nilai = $request->nilai;
            $penilaianTim->keterangan = $request->keterangan;
            $penilaianTim->save();

            return redirect()->route('tim.show', $request->tim_id)->with('success', 'Penilaian tim berhasil disimpan');
        }

        return abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(PenilaianTim $penilaianTim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenilaianTim $penilaianTim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PenilaianTim $penilaianTim)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenilaianTim $penilaianTim)
    {
        //
    }
}
