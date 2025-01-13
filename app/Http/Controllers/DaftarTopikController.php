<?php

namespace App\Http\Controllers;

use App\Models\DaftarTopik;
use Illuminate\Http\Request;

class DaftarTopikController extends Controller
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
                $data = DaftarTopik::with('registerable')->orderBy('created_at', 'desc')->get()->groupBy(function ($item) {
                    if ($item->registerable->topik_mandiri_id != null) {
                        return $item->registerable->topik_mandiri_id;
                    } else {
                        return $item->registerable->topik_dosen_id;
                    }
                })->map(function ($item) {
                    return $item->first();
                });
                return view('tim.daftar_topik.index', compact('data'));
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
    public function show(DaftarTopik $daftarTopik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DaftarTopik $daftarTopik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DaftarTopik $daftarTopik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DaftarTopik $daftarTopik)
    {
        //
    }
}
