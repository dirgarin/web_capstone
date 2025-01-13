<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Mahasiswa;
use App\Models\Provinsi;
use App\Models\ListNotif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\NotificationController;

class MahasiswaController extends Controller
{
    public function __construct(NotificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->guest()) {
            return redirect()->route('mahasiswa.create');
        } else {
            if (auth()->user()->role == 'tim') {
                $data = Mahasiswa::orderBy('created_at', 'desc')->get();
                return view('tim.mahasiswa.index', compact('data'));
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
        $bidang_minat = \App\Models\BidangMinat::all();
        $provinsi = Provinsi::select('nama')->get();
        return view('guest.mahasiswa.create', compact('bidang_minat', 'provinsi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required',
                'nim' => 'required',
                'kelas' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'no_telp' => 'required',
                'asal_kota' => 'required',
                'asal_provinsi' => 'required',
                'alamat' => 'required',
                'bidang_minat_id' => 'required|exists:bidang_minats,id',
                'kompetensi' => 'required',
                'file_ktp' => 'required|file|mimes:pdf',
                'file_khs' => 'required|file|mimes:pdf',
                'file_prasyarat' => 'required|file|mimes:pdf',
                'checkbox_analisis'=>'required',
                'checkbox_manajemen'  => 'required',
                'apsi_semester' => 'required',
                'apsi_nilai' => 'required',
                'manpro_semester' => 'required',
                'manpro_nilai' => 'required',
            ],
            [
                'nama.required' => 'Nama harus diisi',
                'nim.required' => 'NIM harus diisi',
                'kelas.required' => 'Kelas harus diisi',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password harus diisi',
                'no_telp.required' => 'No. Telp harus diisi',
                'asal_kota.required' => 'Asal Kota harus diisi',
                'asal_provinsi.required' => 'Asal Provinsi harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'bidang_minat_id.required' => 'Bidang Minat harus diisi',
                'bidang_minat_id.exists' => 'Bidang Minat tidak valid',
                'kompetensi.required' => 'Kompetensi harus diisi',
                'file_ktp.required' => 'File KTP harus diisi',
                'file_ktp.file' => 'File KTP harus berupa file',
                'file_ktp.mimes' => 'File KTP harus berformat PDF',
                'file_khs.required' => 'File KHS harus diisi',
                'file_khs.file' => 'File KHS harus berupa file',
                'file_khs.mimes' => 'File KHS harus berformat PDF',
                'file_prasyarat.required' => 'File Prasyarat harus diisi',
                'file_prasyarat.file' => 'File Prasyarat harus berupa file',
                'file_prasyarat.mimes' => 'File Prasyarat harus berformat PDF',
                'checkbox_analisis.required' => 'Checkbox Analisis harus dicentang',
                'checkbox_manajemen.required' => 'Checkbox Manajemen harus dicentang',
                'apsi_semester.required' => 'Semester APSI harus diisi',
                'apsi_nilai.required' => 'Nilai APSI harus diisi',
                'manpro_semester.required' => 'Semester Manajemen harus diisi',
                'manpro_nilai.required' => 'Nilai Manajemen harus diisi',
            ]
        );

        $user = new \App\Models\User();
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'mahasiswa';
        $user->save();

        $mahasiswa = new Mahasiswa();
        $mahasiswa->user_id = $user->id;
        $mahasiswa->nama = $request->nama;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->kelas = $request->kelas;
        $mahasiswa->no_telp = $request->no_telp;
        $mahasiswa->asal_kota = $request->asal_kota;
        $mahasiswa->asal_provinsi = $request->asal_provinsi;
        $mahasiswa->alamat = $request->alamat;
        $mahasiswa->bidang_minat_id = $request->bidang_minat_id;
        $mahasiswa->kompetensi = $request->kompetensi;
        $mahasiswa->file_ktp = $request->file_ktp->store('file_ktp', 'public');
        $mahasiswa->file_khs = $request->file_khs->store('file_khs', 'public');
        $mahasiswa->file_prasyarat = $request->file_prasyarat->store('file_prasyarat', 'public');
        $mahasiswa->apsi_semester = $request->apsi_semester;
        $mahasiswa->apsi_nilai = $request->apsi_nilai;
        $mahasiswa->manpro_semester = $request->manpro_semester;
        $mahasiswa->manpro_nilai = $request->manpro_nilai;
        $mahasiswa->SKSLulus = $request->total_sks;
        $mahasiswa->save();

        // $this->notificationController->sendTimNotification('Mahasiswa Baru', 'Ada mahasiswa yang melakukan registrasi, cek segera!', route('mahasiswa.show', $mahasiswa->id));
        // $this->notificationController->saveNotif($user->id, $request->endpoint, $request->p256dh, $request->auth);

        $notif = new ListNotif();
        $notif->user_id = 1;
        $notif->title = 'Mahasiswa Baru';
        $notif->content = 'Ada mahasiswa yang melakukan registrasi, cek segera!';
        $notif->route = route('mahasiswa.show', $mahasiswa->id);
        $notif->status = 'unread';
        $notif->save();

        broadcast(new MessageSent("Ada mahasiswa yang melakukan registrasi", 'tim'));

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil, silahkan menunggu konfirmasi dari tim capstone');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        if (auth()->user()->role != 'tim') {
            return abort(404);
        }

        $data = $mahasiswa;
        return view('tim.mahasiswa.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        if (auth()->user()->role != 'tim') {
            return abort(404);
        }

        $request->validate(
            [
                'status' => 'required|in:approved,rejected',
            ],
            [
                'status.required' => 'Status harus diisi',
                'status.in' => 'Status tidak valid',
            ]
        );

        $mahasiswa->status = $request->status;
        if( $request->status == 'rejected') {
            $mahasiswa->alasan_penolakan = $request->alasan_penolakan;
        }
        $mahasiswa->save();

        //$this->notificationController->sendNotification($mahasiswa->user_id, 'Pendaftaran telah disetujui', 'Pendaftaran anda telah disetujui oleh tim', route('home'));

        $notif = new ListNotif();
        $notif->user_id = $mahasiswa->user_id;
        $notif->title = 'Pendaftaran telah disetujui';
        $notif->content = 'Pendaftaran anda telah disetujui oleh tim';
        $notif->route = route('home');
        $notif->status = 'unread';
        $notif->save();

        broadcast(new MessageSent("Pendaftaran mahasiswa telah disetujui", 'mahasiswa'));

        return redirect()->route('mahasiswa.index')->with('success', 'Status mahasiswa berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        abort(404);
    }
}
