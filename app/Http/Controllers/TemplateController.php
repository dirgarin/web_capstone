<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
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
                $data = Template::orderBy('created_at', 'desc')->get();
                return view('tim.template.index', compact('data'));
            } elseif (auth()->user()->role == 'mahasiswa') {
                $data = Template::where('mulai', '<=', now())
                    ->where('deadline', '>=', now())
                    ->orderBy('created_at', 'desc')
                    ->get();
                return view('mahasiswa.template.index', compact('data'));
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
            return view('tim.template.create');
        }

        return abort(404);
    }

    public function uploadDescriptionImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'filename' => 'required',
        ]);

        $imageName = $request->image->storeAs('images', $request->filename . '.' . $request->image->extension(), 'public');
        return response()->json(['success' => 'You have successfully uploaded an image', 'location' => Storage::url($imageName)]);
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
                    'type' => 'required',
                    'deskripsi' => 'required',
                    'file_template' => 'required|file|mimes:pdf,doc,docx',
                    'mulai' => 'required',
                    'deadline' => 'required',
                ],
                [
                    'type.required' => 'Jenis template wajib diisi',
                    'deskripsi.required' => 'Deskripsi wajib diisi',
                    'file_template.required' => 'File template wajib diisi',
                    'file_template.file' => 'File template harus berupa file',
                    'file_template.mimes' => 'File template harus berupa file pdf, doc, atau docx',
                    'mulai.required' => 'Tanggal mulai wajib diisi',
                    'deadline.required' => 'Tanggal deadline wajib diisi',
                ]
            );

            $template = new Template();
            $template->type = $request->type;
            $template->deskripsi = $request->deskripsi;
            $template->file_template = $request->file('file_template')->store('template', 'public');
            $template->mulai = $request->mulai;
            $template->deadline = $request->deadline;
            $template->save();

            return redirect()->route('home')->with('success', 'Pembuatan segmen berhasil');
        }

        return abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        if (auth()->user()->role == 'mahasiswa') {
            $data = $template;
            $dokumen = \App\Models\MahasiswaDokumen::where('mahasiswa_id', auth()->user()->mahasiswa->id)
                ->where('template_id', $template->id)
                ->orderBy('created_at', 'desc')
                ->get();
            return view('mahasiswa.template.show', compact('data', 'dokumen'));
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        if (auth()->guest()) {
            abort(404);
        }

        if (auth()->user()->role == 'tim') {
            $data = $template;
            return view('tim.template.edit', compact('data'));
        }

        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        if (auth()->user()->role != 'tim') {
            return abort(404);
        }

        $request->validate(
            [
                'type' => 'required',
                'deskripsi' => 'required',
                'file_template' => 'file|mimes:pdf,doc,docx',
                'mulai' => 'required',
                'deadline' => 'required',
            ],
            [
                'type.required' => 'Jenis template wajib diisi',
                'deskripsi.required' => 'Deskripsi wajib diisi',
                'file_template.file' => 'File template harus berupa file',
                'file_template.mimes' => 'File template harus berupa file pdf, doc, atau docx',
                'mulai.required' => 'Tanggal mulai wajib diisi',
                'deadline.required' => 'Tanggal deadline wajib diisi',
            ]
        );

        $template->type = $request->type;
        $template->deskripsi = $request->deskripsi;
        if ($request->hasFile('file_template')) {
            $template->file_template = $request->file('file_template')->store('template', 'public');
        }
        $template->mulai = $request->mulai;
        $template->deadline = $request->deadline;
        $template->save();

        return redirect()->route('home')->with('success', 'Edit segmen berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        //
    }

    public function download(Template $template)
    {
        return response()->download(Storage::disk('public')->path($template->file_template));
    }

    public function upload(Template $template)
    {
        if (auth()->guest()) {
            abort(404);
        }

        if (auth()->user()->role == 'mahasiswa') {
            $data = $template;
            $topikMandiri = \App\Models\DaftarTopikMandiri::whereHas('tim', function ($query) {
                $query->where('mahasiswa1_id', auth()->user()->mahasiswa->id)
                    ->orWhere('mahasiswa2_id', auth()->user()->mahasiswa->id)
                    ->orWhere('mahasiswa3_id', auth()->user()->mahasiswa->id);
            })->get()
                ->map(function ($item) {
                    return $item->daftar_topik;
                });
            $topikDosen = \App\Models\DaftarTopikDosen::whereHas('tim', function ($query) {
                $query->where('mahasiswa1_id', auth()->user()->mahasiswa->id)
                    ->orWhere('mahasiswa2_id', auth()->user()->mahasiswa->id)
                    ->orWhere('mahasiswa3_id', auth()->user()->mahasiswa->id);
            })
                ->get()
                ->groupBy('topik_dosen_id')
                ->map(function ($item) {
                    return $item->first();
                })
                ->map(function ($item) {
                    return $item->daftar_topik;
                });
            $daftarTopik = $topikMandiri->merge($topikDosen);
            return view('mahasiswa.template.upload', compact('data', 'daftarTopik'));
        }

        return abort(404);
    }

    public function proses_upload(Request $request, Template $template)
    {
        if (auth()->guest()) {
            abort(404);
        }

        if (auth()->user()->role == 'mahasiswa') {
            $request->validate(
                [
                    'daftar_topik_id' => 'required|exists:daftar_topiks,id',
                    'file_dokumen' => 'required|file|mimes:pdf,doc,docx',
                    'keterangan' => 'required',
                ],
                [
                    'daftar_topik_id.required' => 'Topik wajib diisi',
                    'daftar_topik_id.exists' => 'Topik tidak valid',
                    'file_dokumen.required' => 'File dokumen wajib diisi',
                    'file_dokumen.file' => 'File dokumen harus berupa file',
                    'file_dokumen.mimes' => 'File dokumen harus berupa file pdf, doc, atau docx',
                    'keterangan.required' => 'Keterangan wajib diisi',
                ]
            );

            $mahasiswaDokumen = new \App\Models\MahasiswaDokumen();
            $mahasiswaDokumen->mahasiswa_id = auth()->user()->mahasiswa->id;
            $mahasiswaDokumen->daftar_topik_id = $request->daftar_topik_id;
            $mahasiswaDokumen->template_id = $template->id;
            $mahasiswaDokumen->file_dokumen = $request->file('file_dokumen')->store('dokumen', 'public');
            $mahasiswaDokumen->keterangan = $request->keterangan;
            $mahasiswaDokumen->save();

            return redirect()->route('home')->with('success', 'Upload dokumen berhasil');
        }

        return abort(404);
    }
}
