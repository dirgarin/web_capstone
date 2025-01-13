<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Deadline;
use App\Models\Dosen;
use App\Models\TopikMandiri;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\NotificationController;
use App\Models\ListNotif;

class TopikMandiriController extends Controller
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
                $deadline = Deadline::where('type', 'topik')->latest()->first();
                $data = TopikMandiri::orderBy('created_at', 'desc')->get();
                $submission = \App\Models\Submission2::all();
                $answer = \App\Models\Answer::all();
                return view('tim.topik_mandiri.index', compact(['data','deadline','submission','answer']));
            } elseif (auth()->user()->role == 'mahasiswa') {
                $deadline = Deadline::where('type', 'topik')->latest()->first();
                $is_create = true;
                if($deadline)
                    $is_create = Carbon::now()->betweenIncluded(Carbon::parse($deadline->start), Carbon::parse($deadline->end)) ? true : false;
                    $submission = \App\Models\Submission2::all();
                    $answer = \App\Models\Answer::all();
                $data = TopikMandiri::orderBy('created_at', 'desc')->get();
                return view('mahasiswa.topik_mandiri.index', compact(['data', 'is_create','deadline','submission','answer']));
            } elseif (auth()->user()->role == 'dosen_pembimbing' || auth()->user()->role == 'dosen') {
                $data = TopikMandiri::with('daftar_topik_mandiri')->where('dosen_id', auth()->user()->dosen->id)->orderBy('created_at', 'desc')->get();
                $submission = \App\Models\Submission2::all();
                $answer = \App\Models\Answer::all();
                return view('dosen.topik_mandiri.index', compact('data','submission','answer'));
            } elseif (auth()->user()->role == 'dosen_penguji') {
                $data = TopikMandiri::with('daftar_topik_mandiri')->orderBy('created_at', 'desc')->get();
                $submission = \App\Models\Submission2::all();
                $answer = \App\Models\Answer::all();
                return view('dosen.topik_mandiri.index', compact('data','submission','answer'));
            } else {
                abort(404);
            }
        }
    }



    public function pilih_dosen(TopikMandiri $topikMandiri)
    {
        if (auth()->guest()) {
            abort(404);
        }

        if (auth()->user()->role == 'mahasiswa') {
            $data = $topikMandiri;
            $dosen = \App\Models\Dosen::where('role', 'pembimbing')->orWhere('role', 'dosen')->get();
            $bidangMinat = \App\Models\BidangMinat::all();
            return view('mahasiswa.topik_mandiri.pilih_dosen', compact('data', 'dosen', 'bidangMinat'));
        } elseif (auth()->user()->role == 'tim') {
            $data = $topikMandiri;
            $dosen = \App\Models\Dosen::where('role', 'pembimbing')->orWhere('role', 'dosen')->get();
            $bidangMinat = \App\Models\BidangMinat::all();
            return view('tim.topik_mandiri.pilih_dosen', compact('data', 'dosen', 'bidangMinat'));
        }

        return abort(404);
    }

    public function proses_dosen(Request $request, TopikMandiri $topikMandiri)
    {
        if (auth()->guest()) {
            abort(404);
        }

        if (auth()->user()->role == 'mahasiswa') {
            $request->validate([
                'dosen_id' => 'required',
            ]);

            $topikMandiri->dosen_id = $request->dosen_id;
            $topikMandiri->status = 'pending';
            $topikMandiri->save();

            //broadcast(new MessageSent("Mahasiswa telah memilih anda untuk menjadi dosen pembimbing", Dosen::where('id',$request->dosen_id)->first()->user_id));

            //$this->notificationController->sendNotification(Dosen::where('id',$request->dosen_id)->first()->user_id, 'Permintaan Pembimbing', 'Mahasiswa ' . auth()->user()->mahasiswa->nama . ' telah memilih anda untuk menjadi dosen pembimbing', route('topik_mandiri.show', $topikMandiri->id));

            $notif = new ListNotif();
            $notif->user_id = Dosen::where('id',$request->dosen_id)->first()->user_id;
            $notif->title = 'Permintaan Pembimbing';
            $notif->content = 'Mahasiswa ' . auth()->user()->mahasiswa->nama . ' telah memilih anda untuk menjadi dosen pembimbing';
            $notif->route = route('topik_mandiri.show', $topikMandiri->id);
            $notif->status = 'unread';
            $notif->save();

            return redirect()->route('topik_mandiri.index')->with('success', 'Berhasil memilih dosen, menunggu persetujuan dosen');
        } elseif (auth()->user()->role == 'tim') {
            $request->validate([
                'dosen_id' => 'required',
            ]);

            $topikMandiri->dosen_id = $request->dosen_id;
            $topikMandiri->status = 'assigned';
            $topikMandiri->save();

            $daftarTopikMandiri = \App\Models\DaftarTopikMandiri::find($topikMandiri->daftar_topik_mandiri->id);
            $daftarTopikMandiri->status = 'assigned';
            $daftarTopikMandiri->save();

            $daftarTopik = new \App\Models\DaftarTopik();
            $daftarTopik->registerable_id = $topikMandiri->daftar_topik_mandiri->id;
            $daftarTopik->registerable_type = 'App\Models\DaftarTopikMandiri';
            $daftarTopik->save();

            return redirect()->route('topik_mandiri.index')->with('success', 'Berhasil assign dosen');
        }

        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->guest()) {
            abort(404);
        }

        if (auth()->user()->role == 'mahasiswa') {
            $tim = auth()->user()->mahasiswa->tim1->where('status', 'approved')->merge(auth()->user()->mahasiswa->tim2->where('status', 'approved'))->merge(auth()->user()->mahasiswa->tim3->where('status', 'approved'));
            return view('mahasiswa.topik_mandiri.create', compact('tim'));
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

        if (auth()->user()->role == 'mahasiswa') {
            $request->validate(
                [
                    'tim_id' => 'required|exists:tims,id',
                    'judul' => 'required',
                    'instansi' => 'required',
                ],
                [
                    'tim_id.required' => 'Tim harus dipilih',
                    'judul.required' => 'Judul harus diisi',
                    'instansi.required' => 'Instansi harus diisi',
                ]
            );

            $topikMandiri = new TopikMandiri();
            $topikMandiri->judul = $request->judul;
            $topikMandiri->instansi = $request->instansi;
            $topikMandiri->save();

            $daftarTopikMandiri = new \App\Models\DaftarTopikMandiri();
            $daftarTopikMandiri->tim_id = $request->tim_id;
            $daftarTopikMandiri->topik_mandiri_id = $topikMandiri->id;
            $daftarTopikMandiri->save();

            //$this->notificationController->sendTimNotification('New Topik Mandiri', 'Mahasiswa ' . auth()->user()->mahasiswa->nama . ' telah mendaftarkan topik mandiri', route('topik_mandiri.show', $topikMandiri->id));

            $notif = new ListNotif();
            $notif->user_id = 1;
            $notif->title = 'New Topik Mandiri';
            $notif->content = 'Mahasiswa ' . auth()->user()->mahasiswa->nama . ' telah mendaftarkan topik mandiri';
            $notif->route = route('topik_mandiri.show', $topikMandiri->id);
            $notif->status = 'unread';
            $notif->save();

            //broadcast(new MessageSent("Mahasiswa mendaftarkan topik", 'tim'));

            return redirect()->route('topik_mandiri.index')->with('success', 'Topik Mandiri berhasil dibuat');
        }

        return abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(TopikMandiri $topikMandiri)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        if (auth()->user()->role == 'mahasiswa') {
            $data = $topikMandiri;
            $tim = auth()->user()->mahasiswa->tim1->where('status', 'approved')->merge(auth()->user()->mahasiswa->tim2->where('status', 'approved'))->merge(auth()->user()->mahasiswa->tim3->where('status', 'approved'));
            $can_register = true;
            // foreach ($topikMandiri->daftar_topik_dosen as $daftarTopikDosen) {
            //     if ($daftarTopikDosen->tim->mahasiswa1_id == auth()->user()->mahasiswa->id || $daftarTopikDosen->tim->mahasiswa2_id == auth()->user()->mahasiswa->id) {
            //         $can_register = false;
            //     }
            // }
            //if ($data->daftar_topik_dosen->where('status', 'assigned')->count() >= $data->jumlah_tim) {
             //   $can_register = false;
            //}
            return view('mahasiswa.topik_mandiri.show', compact('data', 'can_register', 'tim'));
        } else if (auth()->user()->role == 'dosen_pembimbing' || auth()->user()->role == 'dosen_penguji' || auth()->user()->role == 'dosen') {
            $data = $topikMandiri;
            return view('dosen.topik_mandiri.show', compact('data'));
        } else if (auth()->user()->role == 'tim') {
            $data = $topikMandiri;
            return view('tim.topik_mandiri.show', compact('data'));
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TopikMandiri $topikMandiri)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TopikMandiri $topikMandiri)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        if (auth()->user()->role == 'dosen_pembimbing' || auth()->user()->role == 'dosen') {
            $request->validate(
                [
                    'status' => 'required|in:assigned,rejected',
                ],
                [
                    'status.required' => 'Status harus diisi',
                    'status.in' => 'Status tidak valid',
                ]
            );

            $topikMandiri->status = $request->status;
            $topikMandiri->save();

            //$this->notificationController->sendNotification(\App\Models\DaftarTopikMandiri::where('topik_mandiri_id', $topikMandiri->id)->first()->tim->mahasiswa1_id, 'Permintaan Pembingbing disetujui', 'Topik Mandiri anda telah disetujui oleh ' . auth()->user()->dosen->nama, route('home'));
            //$this->notificationController->sendNotification(\App\Models\DaftarTopikMandiri::where('topik_mandiri_id', $topikMandiri->id)->first()->tim->mahasiswa2_id, 'Permintaan Pembingbing disetujui', 'Topik Mandiri anda telah disetujui oleh ' . auth()->user()->dosen->nama, route('home'));
            //$this->notificationController->sendNotification(\App\Models\DaftarTopikMandiri::where('topik_mandiri_id', $topikMandiri->id)->first()->tim->mahasiswa3_id, 'Permintaan Pembingbing disetujui', 'Topik Mandiri anda telah disetujui oleh ' . auth()->user()->dosen->nama, route('home'));

            $notif = new ListNotif();
            $notif->user_id = \App\Models\DaftarTopikMandiri::where('topik_mandiri_id', $topikMandiri->id)->first()->tim->mahasiswa1_id;
            $notif->title = 'Permintaan Pembimbing disetujui';
            $notif->content = 'Topik Mandiri anda telah disetujui oleh ' . auth()->user()->dosen->nama;
            $notif->route = route('home');
            $notif->status = 'unread';
            $notif->save();

            $notif = new ListNotif();
            $notif->user_id = \App\Models\DaftarTopikMandiri::where('topik_mandiri_id', $topikMandiri->id)->first()->tim->mahasiswa2_id;
            $notif->title = 'Permintaan Pembimbing disetujui';
            $notif->content = 'Topik Mandiri anda telah disetujui oleh ' . auth()->user()->dosen->nama;
            $notif->route = route('home');
            $notif->status = 'unread';
            $notif->save();

            $notif = new ListNotif();
            $notif->user_id = \App\Models\DaftarTopikMandiri::where('topik_mandiri_id', $topikMandiri->id)->first()->tim->mahasiswa3_id;
            $notif->title = 'Permintaan Pembimbing disetujui';
            $notif->content = 'Topik Mandiri anda telah disetujui oleh ' . auth()->user()->dosen->nama;
            $notif->route = route('home');
            $notif->status = 'unread';
            $notif->save();


            if ($request->status == 'assigned') {
                $daftarTopikMandiri = \App\Models\DaftarTopikMandiri::find($topikMandiri->daftar_topik_mandiri->id);
                $daftarTopikMandiri->status = 'assigned';
                $daftarTopikMandiri->save();

                $daftarTopik = new \App\Models\DaftarTopik();
                $daftarTopik->registerable_id = $topikMandiri->daftar_topik_mandiri->id;
                $daftarTopik->registerable_type = 'App\Models\DaftarTopikMandiri';
                $daftarTopik->save();

                return redirect()->route('topik_mandiri.index')->with('success', 'Topik Mandiri berhasil disetujui');
            }

            return redirect()->route('topik_mandiri.index')->with('success', 'Topik Mandiri berhasil ditolak');

        } elseif (auth()->user()->role == 'tim') {
            $request->validate(
                [
                    'status' => 'required|in:pending,approved,rejected',
                ],
                [
                    'status.required' => 'Status harus diisi',
                    'status.in' => 'Status tidak valid',
                ]
            );
            $daftarTopikMandiri = \App\Models\DaftarTopikMandiri::where('id', $topikMandiri->daftar_topik_mandiri->id)->with(['tim.mahasiswa1', 'tim.mahasiswa2', 'tim.mahasiswa3'])->first();
            //broadcast(new MessageSent("Topik telah divalidasi tim Capstone", $daftarTopikMandiri->tim->mahasiswa1->user_id));
            //broadcast(new MessageSent("Topik telah divalidasi tim Capstone", $daftarTopikMandiri->tim->mahasiswa2->user_id));
            //broadcast(new MessageSent("Topik telah divalidasi tim Capstone", $daftarTopikMandiri->tim->mahasiswa3->user_id));

            if ($topikMandiri->status == 'pending') {
                $topikMandiri->status = $request->status;
                $topikMandiri->save();

                if ($request->status == 'approved') {
                    //$this->notificationController->sendNotification($daftarTopikMandiri->tim->mahasiswa1->user_id, 'Topik Mandiri telah disetujui', 'Topik Mandiri anda telah disetujui oleh tim', route('home'));
                    //$this->notificationController->sendNotification($daftarTopikMandiri->tim->mahasiswa2->user_id, 'Topik Mandiri telah disetujui', 'Topik Mandiri anda telah disetujui oleh tim', route('home'));
                    //$this->notificationController->sendNotification($daftarTopikMandiri->tim->mahasiswa3->user_id, 'Topik Mandiri telah disetujui', 'Topik Mandiri anda telah disetujui oleh tim', route('home'));

                    $notif = new ListNotif();
                    $notif->user_id = $daftarTopikMandiri->tim->mahasiswa1->user_id;
                    $notif->title = 'Topik Mandiri telah disetujui';
                    $notif->content = 'Topik Mandiri anda telah disetujui oleh tim';
                    $notif->route = route('home');
                    $notif->status = 'unread';
                    $notif->save();

                    $notif = new ListNotif();
                    $notif->user_id = $daftarTopikMandiri->tim->mahasiswa2->user_id;
                    $notif->title = 'Topik Mandiri telah disetujui';
                    $notif->content = 'Topik Mandiri anda telah disetujui oleh tim';
                    $notif->route = route('home');
                    $notif->status = 'unread';
                    $notif->save();

                    $notif = new ListNotif();
                    $notif->user_id = $daftarTopikMandiri->tim->mahasiswa3->user_id;
                    $notif->title = 'Topik Mandiri telah disetujui';
                    $notif->content = 'Topik Mandiri anda telah disetujui oleh tim';
                    $notif->route = route('home');
                    $notif->status = 'unread';
                    $notif->save();

                    return redirect()->route('topik_mandiri.show', $topikMandiri->id)->with('success', 'Topik Mandiri berhasil disetujui');
                } else {
                    //$this->notificationController->sendNotification($daftarTopikMandiri->tim->mahasiswa1->user_id, 'Topik Mandiri ditolak', 'Topik Mandiri anda ditolak oleh tim', route('home'));
                    //$this->notificationController->sendNotification($daftarTopikMandiri->tim->mahasiswa2->user_id, 'Topik Mandiri ditolak', 'Topik Mandiri anda ditolak oleh tim', route('home'));
                    //$this->notificationController->sendNotification($daftarTopikMandiri->tim->mahasiswa3->user_id, 'Topik Mandiri ditolak', 'Topik Mandiri anda ditolak oleh tim', route('home'));
                    
                    $notif = new ListNotif();
                    $notif->user_id = $daftarTopikMandiri->tim->mahasiswa1->user_id;
                    $notif->title = 'Topik Mandiri ditolak';
                    $notif->content = 'Topik Mandiri anda ditolak oleh tim';
                    $notif->route = route('home');
                    $notif->status = 'unread';
                    $notif->save();

                    $notif = new ListNotif();
                    $notif->user_id = $daftarTopikMandiri->tim->mahasiswa2->user_id;
                    $notif->title = 'Topik Mandiri ditolak';
                    $notif->content = 'Topik Mandiri anda ditolak oleh tim';
                    $notif->route = route('home');
                    $notif->status = 'unread';
                    $notif->save();

                    $notif = new ListNotif();
                    $notif->user_id = $daftarTopikMandiri->tim->mahasiswa3->user_id;
                    $notif->title = 'Topik Mandiri ditolak';
                    $notif->content = 'Topik Mandiri anda ditolak oleh tim';
                    $notif->route = route('home');
                    $notif->status = 'unread';
                    $notif->save();

                    return redirect()->route('topik_mandiri.show', $topikMandiri->id)->with('success', 'Topik Mandiri berhasil ditolak');
                }
            }

            $topikMandiri->daftar_topik_mandiri->daftar_topik->status = $request->status;
            $topikMandiri->daftar_topik_mandiri->daftar_topik->save();


            if ($request->status == 'approved') {
                //$this->notificationController->sendNotification($daftarTopikMandiri->tim->mahasiswa1->user_id, 'Pendaftaran Topik Mandiri berhasil disetujui', 'Pendaftaran Topik Mandiri anda berhasil disetujui oleh tim', route('home'));
                //$this->notificationController->sendNotification($daftarTopikMandiri->tim->mahasiswa2->user_id, 'Pendaftaran Topik Mandiri berhasil disetujui', 'Pendaftaran Topik Mandiri anda berhasil disetujui oleh tim', route('home'));
                //$this->notificationController->sendNotification($daftarTopikMandiri->tim->mahasiswa3->user_id, 'Pendaftaran Topik Mandiri berhasil disetujui', 'Pendaftaran Topik Mandiri anda berhasil disetujui oleh tim', route('home'));
                
                $notif = new ListNotif();
                $notif->user_id = $daftarTopikMandiri->tim->mahasiswa1->user_id;
                $notif->title = 'Pendaftaran Topik Mandiri berhasil disetujui';
                $notif->content = 'Pendaftaran Topik Mandiri anda berhasil disetujui oleh tim';
                $notif->route = route('home');
                $notif->status = 'unread';
                $notif->save();
                
                $notif = new ListNotif();
                $notif->user_id = $daftarTopikMandiri->tim->mahasiswa2->user_id;
                $notif->title = 'Pendaftaran Topik Mandiri berhasil disetujui';
                $notif->content = 'Pendaftaran Topik Mandiri anda berhasil disetujui oleh tim';
                $notif->route = route('home');
                $notif->status = 'unread';
                $notif->save();

                $notif = new ListNotif();
                $notif->user_id = $daftarTopikMandiri->tim->mahasiswa3->user_id;
                $notif->title = 'Pendaftaran Topik Mandiri berhasil disetujui';
                $notif->content = 'Pendaftaran Topik Mandiri anda berhasil disetujui oleh tim';
                $notif->route = route('home');
                $notif->status = 'unread';
                $notif->save();

                return redirect()->route('topik_mandiri.show', $topikMandiri->id)->with('success', 'Pendaftaran Topik Mandiri berhasil disetujui');
            } else {
                //$this->notificationController->sendNotification($daftarTopikMandiri->tim->mahasiswa1->user_id, 'Pendaftaran Topik Mandiri berhasil ditolak', 'Pendaftaran Topik Mandiri anda berhasil ditolak oleh tim', route('home'));
                //$this->notificationController->sendNotification($daftarTopikMandiri->tim->mahasiswa2->user_id, 'Pendaftaran Topik Mandiri berhasil ditolak', 'Pendaftaran Topik Mandiri anda berhasil ditolak oleh tim', route('home'));
                //$this->notificationController->sendNotification($daftarTopikMandiri->tim->mahasiswa3->user_id, 'Pendaftaran Topik Mandiri berhasil ditolak', 'Pendaftaran Topik Mandiri anda berhasil ditolak oleh tim', route('home'));
                
                $notif = new ListNotif();
                $notif->user_id = $daftarTopikMandiri->tim->mahasiswa1->user_id;
                $notif->title = 'Pendaftaran Topik Mandiri berhasil ditolak';
                $notif->content = 'Pendaftaran Topik Mandiri anda berhasil ditolak oleh tim';
                $notif->route = route('home');
                $notif->status = 'unread';
                $notif->save();

                $notif = new ListNotif();
                $notif->user_id = $daftarTopikMandiri->tim->mahasiswa2->user_id;
                $notif->title = 'Pendaftaran Topik Mandiri berhasil ditolak';
                $notif->content = 'Pendaftaran Topik Mandiri anda berhasil ditolak oleh tim';
                $notif->route = route('home');
                $notif->status = 'unread';
                $notif->save();

                $notif = new ListNotif();
                $notif->user_id = $daftarTopikMandiri->tim->mahasiswa3->user_id;
                $notif->title = 'Pendaftaran Topik Mandiri berhasil ditolak';
                $notif->content = 'Pendaftaran Topik Mandiri anda berhasil ditolak oleh tim';
                $notif->route = route('home');
                $notif->status = 'unread';
                $notif->save();                

                return redirect()->route('topik_mandiri.show', $topikMandiri->id)->with('success', 'Pendaftaran Topik Mandiri berhasil ditolak');
            }
        }

        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TopikMandiri $topikMandiri)
    {
        //
    }
}
