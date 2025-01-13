<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
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
                $data = Section::orderBy('created_at', 'desc')->get();
                return view('tim.section.index', compact('data'));
            } elseif (auth()->user()->role == 'mahasiswa') {
                $data = Section::orderBy('created_at', 'desc')->get();
                return view('mahasiswa.section.index', compact('data'));
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
        if (auth()->guest()) {
            abort(404);
        }

        if (auth()->user()->role == 'tim') {
            return view('tim.section.create');
        }

        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->guest()) {
            abort(404);
        }

        if (auth()->user()->role == 'tim') {
            $request->validate(
                [
                    'judul' => 'required',
                    'isi' => 'required',
                    'file' => 'file|mimes:pdf,doc,docx',
                ],
                [
                    'judul.required' => 'Judul section wajib diisi',
                    'isi.required' => 'Isi konten wajib diisi',
                    'file.file' => 'File section harus berupa file',
                    'file.mimes' => 'File section harus berupa file pdf, doc, atau docx',
                ]
            );

            $section = new Section();
            $section->judul = $request->judul;
            $section->isi = $request->isi;
            if ($request->hasFile('file'))
                $section->file = $request->file('file')->store('section', 'public');
                if ($request->hasFile('image'))
                $section->image = $request->file('image')->store('section', 'public');
            $section->save();

            return redirect()->route('sections.show', $section->id)->with('success', 'Pembuatan section berhasil');
        }

        return abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        $data = $section;
        return view('tim.section.show', compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        if (auth()->guest()) {
            abort(404);
        }

        if (auth()->user()->role == 'tim') {
            $data = $section;
            return view('tim.section.edit', compact('data'));
        }

        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        if (auth()->user()->role != 'tim') {
            return abort(404);
        }

        $request->validate(
            [
                'judul' => 'required',
                'isi' => 'required',
                'file_template' => 'file|mimes:pdf,doc,docx',
            ],
            [
                'judul.required' => 'Jenis template wajib diisi',
                'isi.required' => 'Deskripsi wajib diisi',
                'file_template.file' => 'File template harus berupa file',
                'file_template.mimes' => 'File template harus berupa file pdf, doc, atau docx',
            ]
        );

        $section->judul = $request->judul;
        $section->isi = $request->isi;
        if ($request->hasFile('file')) {
            $section->file = $request->file('file')->store('section', 'public');
        }
        if ($request->hasFile('image')) {
            $section->image = $request->file('image')->store('section', 'public');
        }
        $section->save();

        return redirect()->route('sections.show', $section->id)->with('success', 'Edit section berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        //
    }
}
