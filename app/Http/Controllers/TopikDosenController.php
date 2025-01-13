<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\TopikDosen;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificationController;
use App\Models\ListNotif;

class TopikDosenController extends Controller
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
            abort(404);
        } else {
            if (auth()->user()->role == 'tim') {
                $data = TopikDosen::orderBy('created_at', 'desc')->get();
                return view('tim.topik_dosen.index', compact('data'));
            } elseif (auth()->user()->role == 'mahasiswa') {
                $data = TopikDosen::where('status', 'assigned')->orderBy('created_at', 'desc')->get();
                return view('mahasiswa.topik_dosen.index', compact('data'));
            } elseif (auth()->user()->role == 'dosen_pembimbing' || auth()->user()->role == 'dosen_penguji' || auth()->user()->role == 'dosen') {
                $data = TopikDosen::orderBy('created_at', 'desc')->get();
                return view('dosen.topik_dosen.index', compact('data'));
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

        if (auth()->user()->role == 'dosen_pembimbing' || auth()->user()->role == 'dosen') {
            return view('dosen.topik_dosen.create');
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

        if (auth()->user()->role == 'dosen_pembimbing' || auth()->user()->role == 'dosen') {
            $request->validate(
                [
                    'judul' => 'required',
                    'instansi' => 'required',
                    'jumlah_tim' => 'required|numeric',
                    'deskripsi'=> 'required',
                    'kompetensi'=> 'required',
                ],
                [
                    'judul.required' => 'Judul harus diisi',
                    'instansi.required' => 'Instansi harus diisi',
                    'jumlah_tim.required' => 'Jumlah tim harus diisi',
                    'jumlah_tim.numeric' => 'Jumlah tim harus berupa angka',
                    'deskripsi.required' => 'Deskripsi harus diisi',
                    'kompetensi.required' => 'Kompetensi harus diisi',
                ]
            );

            $topikDosen = new TopikDosen();
            $topikDosen->dosen_id = auth()->user()->dosen->id;
            $topikDosen->judul = $request->judul;
            $topikDosen->instansi = $request->instansi;
            $topikDosen->jumlah_tim = $request->jumlah_tim;
            $topikDosen->deskripsi = $request->deskripsi;
            $topikDosen->kompetensi_diharapkan = $request->kompetensi;
            $topikDosen->save();

            //$this->notificationController->sendTimNotification('Topik Dosen Baru', auth()->user()->name . ' telah mendaftarkan topik baru yang berjudul ' . $request->judul, route('topik_dosen.show', $topikDosen->id));

            $notif = new ListNotif();
            $notif->user_id = 1;
            $notif->title = 'Topik Dosen Baru';
            $notif->content = auth()->user()->name . ' telah mendaftarkan topik baru yang berjudul ' . $request->judul;
            $notif->status = 'unread';
            $notif->route = route('topik_dosen.show', $topikDosen->id);
            $notif->save();
            

            //broadcast(new MessageSent("Dosen Telah mendaftarkan topik", 'tim'));

            return redirect()->route('topik_dosen.index')->with('success', 'Topik Dosen berhasil dibuat');
        }

        return abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(TopikDosen $topikDosen)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        if (auth()->user()->role == 'mahasiswa') {
            $data = $topikDosen;
            $tim = auth()->user()->mahasiswa->tim1->where('status', 'approved')->merge(auth()->user()->mahasiswa->tim2->where('status', 'approved'))->merge(auth()->user()->mahasiswa->tim3->where('status', 'approved'))->first();
            $can_register = true;
            $submission = \App\Models\Submission2::all();
            $answer = \App\Models\Answer::all();
            // foreach ($topikDosen->daftar_topik_dosen as $daftarTopikDosen) {
            //     if ($daftarTopikDosen->tim->mahasiswa1_id == auth()->user()->mahasiswa->id || $daftarTopikDosen->tim->mahasiswa2_id == auth()->user()->mahasiswa->id) {
            //         $can_register = false;
            //     }
            // }
            if ($data->daftar_topik_dosen->where('status', 'assigned')->count() >= $data->jumlah_tim) {
                $can_register = false;
            }
            return view('mahasiswa.topik_dosen.show', compact('data', 'can_register', 'tim', 'submission', 'answer'));
        } else if (auth()->user()->role == 'dosen_pembimbing' || auth()->user()->role == 'dosen_penguji' || auth()->user()->role == 'dosen') {
            $data = $topikDosen;
            $submission = \App\Models\Submission2::all();
            $answer = \App\Models\Answer::all();
            return view('dosen.topik_dosen.show', compact('data', 'submission', 'answer'));
        } else if (auth()->user()->role == 'tim') {
            $data = $topikDosen;
            $submission = \App\Models\Submission2::all();
            $answer = \App\Models\Answer::all();
            return view('tim.topik_dosen.show', compact('data', 'submission', 'answer'));
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TopikDosen $topikDosen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TopikDosen $topikDosen)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        if (auth()->user()->role != 'tim') {
            return abort(404);
        }

        $request->validate(
            [
                'status' => 'required|in:assigned,approved,rejected'

            ],
            [
                'status.required' => 'Status harus diisi',
                'status.in' => 'Status tidak valid',
            ]
        );
        if ($topikDosen->status == 'pending') {
            $topikDosen->status = $request->status;
            if($request->status == 'rejected') {
                $topikDosen->alasan_penolakan = $request->alasan_penolakan;
                $topikDosen->save();

                //$this->notificationController->sendNotification($topikDosen->dosen->user_id, 'Topik Ditolak', 'Topik anda telah ditolak oleh tim', route('topik_dosen.show', $topikDosen->id));
                
                $notif = new ListNotif();
                $notif->user_id = $topikDosen->dosen->user_id;
                $notif->title = 'Topik Ditolak';
                $notif->content = 'Topik anda telah ditolak oleh tim';
                $notif->status = 'unread';
                $notif->route = route('topik_dosen.show', $topikDosen->id);
                $notif->save();

            }else{
                //$this->notificationController->sendNotification($topikDosen->dosen->user_id, 'Topik Disetujui', 'Topik anda telah disetujui oleh tim', route('topik_dosen.show', $topikDosen->id));
                
                $notif = new ListNotif();
                $notif->user_id = $topikDosen->dosen->user_id;
                $notif->title = 'Topik Disetujui';
                $notif->content = 'Topik anda telah disetujui oleh tim';
                $notif->status = 'unread';
                $notif->route = route('topik_dosen.show', $topikDosen->id);
                $notif->save();

                $topikDosen->save();
            }
            
        } elseif ($topikDosen->status == 'assigned') {
            foreach ($topikDosen->daftar_topik_dosen as $daftarTopikDosen) {
                $daftar_topik = $daftarTopikDosen->daftar_topik;
                $d_id = $daftar_topik->id;
                $daftar_topik = \App\Models\DaftarTopik::find($d_id);
                $daftar_topik->status = $request->status;
                $daftar_topik->save();
            }
        }

        // $topik = TopikDosen::where('id', $topikDosen->id)->with(['daftar_topik_dosen.tim.mahasiswa1','daftar_topik_dosen.tim.mahasiswa2','daftar_topik_dosen.tim.mahasiswa3'])->first();

        // broadcast(new MessageSent("Topik telah disetujui oleh dosen", $topik->daftar_topik_dosen->tim->mahasiswa1->user_id));
        // broadcast(new MessageSent("Topik telah disetujui oleh dosen", $topik->daftar_topik_dosen->tim->mahasiswa2->user_id));
        // broadcast(new MessageSent("Topik telah disetujui oleh dosen", $topik->daftar_topik_dosen->tim->mahasiswa3->user_id));

        // $notif = new ListNotif();
        // $notif->user_id = $topik->daftar_topik_dosen->tim->mahasiswa1->user_id;
        // $notif->title = 'Topik Disetujui';
        // $notif->content = 'Topik anda telah disetujui oleh dosen';
        // $notif->status = 'unread';
        // $notif->route = route('topik_dosen.show', $topikDosen->id);
        // $notif->save();

        // $notif = new ListNotif();
        // $notif->user_id = $topik->daftar_topik_dosen->tim->mahasiswa2->user_id;
        // $notif->title = 'Topik Disetujui';
        // $notif->content = 'Topik anda telah disetujui oleh dosen';
        // $notif->status = 'unread';
        // $notif->route = route('topik_dosen.show', $topikDosen->id);
        // $notif->save();

        // $notif = new ListNotif();
        // $notif->user_id = $topik->daftar_topik_dosen->tim->mahasiswa3->user_id;
        // $notif->title = 'Topik Disetujui';
        // $notif->content = 'Topik anda telah disetujui oleh dosen';
        // $notif->status = 'unread';
        // $notif->route = route('topik_dosen.show', $topikDosen->id);
        // $notif->save();


        return redirect()->route('topik_dosen.index')->with('success', 'Status topik dosen berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TopikDosen $topikDosen)
    {
        //
    }
}
