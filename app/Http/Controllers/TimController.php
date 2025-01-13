<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Deadline;
use App\Models\Submission2;
use App\Models\Answer;
use App\Models\Tim;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\NotificationController;
use App\Models\ListNotif;


class TimController extends Controller
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
                $deadline = Deadline::where('type', 'tim')->latest()->first();
                $data = Tim::orderBy('created_at', 'desc')->get();
                $submission = Submission2::all();
                $answer = Answer::all();
                return view('tim.tim.index', compact(['data', 'deadline', 'submission', 'answer']));
            } elseif (auth()->user()->role == 'mahasiswa') {
                $data = Tim::where('mahasiswa1_id', auth()->user()->mahasiswa->id)
                    ->orWhere('mahasiswa2_id', auth()->user()->mahasiswa->id)
                    ->orWhere('mahasiswa3_id', auth()->user()->mahasiswa->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                $deadline = Deadline::where('type', 'tim')->latest()->first();
                if($deadline){
                    if(count($data) > 0){
                        $is_create = $data[0]->status == 'approved' || !Carbon::now()->betweenIncluded(Carbon::parse($deadline->start), Carbon::parse($deadline->end)) ? false : true;
                    }else{
                        $is_create = !Carbon::now()->betweenIncluded(Carbon::parse($deadline->start), Carbon::parse($deadline->end)) ? false : true;
                    }
    
                    return view('mahasiswa.tim.index', compact(['data', 'is_create']));
                }else{
                    Alert::error('Error', 'Deadline belum diatur. Hubungi admin untuk mengatur deadline')->persistent(true);
                    return redirect()->route('home')->with('error', 'Deadline belum diatur. Hubungi admin untuk mengatur deadline');
                }
                
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

        if (auth()->user()->role == 'mahasiswa') {
            $mahasiswa = \App\Models\Mahasiswa::where('user_id', '!=', auth()->user()->id)
                ->where('status', 'approved')
                ->where(function ($query) {
                    $query->whereDoesntHave('tim1', function ($query) {
                        $query->where('status', 'approved');
                    })->WhereDoesntHave('tim2', function ($query) {
                        $query->where('status', 'approved');
                    })->WhereDoesntHave('tim3', function ($query) {
                        $query->where('status', 'approved');
                    });
                })
                ->get();
            $bidangMinat = \App\Models\BidangMinat::all();
            return view('mahasiswa.tim.create', compact('mahasiswa','bidangMinat'));
        } else if (auth()->user()->role == 'tim') {
            $mahasiswa = \App\Models\Mahasiswa::where('status', 'approved')
                ->where(function ($query) {
                    $query->whereDoesntHave('tim1', function ($query) {
                        $query->where('status', 'approved');
                    })->WhereDoesntHave('tim2', function ($query) {
                        $query->where('status', 'approved');
                    })->whereDoesntHave('tim3', function ($query) {
                        $query->where('status', 'approved');
                    });
                })
                ->get();
            $bidangMinat = \App\Models\BidangMinat::all();
            return view('tim.tim.create', compact('mahasiswa', 'bidangMinat'));
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
                    'nama_ketua' => 'required',
                    'mahasiswa2_id' => 'required|exists:mahasiswas,id',
                    'mahasiswa3_id' => 'required|exists:mahasiswas,id',
                ],
                [
                    'nama_ketua.required' => 'Nama ketua harus diisi',
                    'mahasiswa2_id.required' => 'Mahasiswa harus dipilih',
                    'mahasiswa2_id.exists' => 'Mahasiswa tidak valid',
                    'mahasiswa3_id.required' => 'Mahasiswa harus dipilih',
                    'mahasiswa3_id.exists' => 'Mahasiswa tidak valid',
                ]
            );

            $mahasiswa1 = auth()->user()->mahasiswa;
            $mahasiswa2 = \App\Models\Mahasiswa::find($request->mahasiswa2_id);
            $mahasiswa3 = \App\Models\Mahasiswa::find($request->mahasiswa3_id);

            $sameProvinceCount = 0;
            if ($mahasiswa1->asal_provinsi == $mahasiswa2->asal_provinsi) $sameProvinceCount++;
            if ($mahasiswa1->asal_provinsi == $mahasiswa3->asal_provinsi) $sameProvinceCount++;
            if ($mahasiswa2->asal_provinsi == $mahasiswa3->asal_provinsi) $sameProvinceCount++;

            if ($sameProvinceCount > 0) {
                return redirect()->back()->with('error', 'Mahasiswa tidak boleh memiliki provinsi asal yang sama');
            }

            $sameInterestCount = 0;
            if ($mahasiswa1->bidang_minat_id == $mahasiswa2->bidang_minat_id) $sameInterestCount++;
            if ($mahasiswa1->bidang_minat_id == $mahasiswa3->bidang_minat_id) $sameInterestCount++;
            if ($mahasiswa2->bidang_minat_id == $mahasiswa3->bidang_minat_id) $sameInterestCount++;

            if ($sameInterestCount > 1) {
                return redirect()->back()->with('error', 'Maksimal dua mahasiswa boleh memiliki bidang minat yang sama');
            }

            $tim = new Tim();
            $tim->nama_ketua = $request->nama_ketua;
            $tim->mahasiswa1_id = auth()->user()->mahasiswa->id;
            $tim->mahasiswa2_id = $request->mahasiswa2_id;
            $tim->mahasiswa3_id = $request->mahasiswa3_id;
            $tim->status = 'approved';
            $tim->save();

            //$this->notificationController->sendNotification($mahasiswa2->user_id, 'Berhasil didaftarkan ke tim', 'Anda berhasil didaftarkan ke tim oleh ' . auth()->user()->mahasiswa->nama, route('tim.index'));
            //$this->notificationController->sendNotification($mahasiswa3->user_id, 'Berhasil didaftarkan ke tim', 'Anda berhasil didaftarkan ke tim oleh ' . auth()->user()->mahasiswa->nama, route('tim.index'));

            $notif = new ListNotif();
            $notif->user_id = $mahasiswa2->user_id;
            $notif->title = 'Berhasil didaftarkan ke tim';
            $notif->content = 'Anda berhasil didaftarkan ke tim oleh ' . auth()->user()->nama;
            $notif->route = route('tim.index');
            $notif->status = 'unread';
            $notif->save();

            $notif = new ListNotif();
            $notif->user_id = $mahasiswa3->user_id;
            $notif->title = 'Berhasil didaftarkan ke tim';
            $notif->content = 'Anda berhasil didaftarkan ke tim oleh ' . auth()->user()->nama;
            $notif->route = route('tim.index');
            $notif->status = 'unread';
            $notif->save();

            return redirect()->route('home')->with('success', 'Pendaftaran tim berhasil');
        } else if (auth()->user()->role == 'tim') {
            $request->validate(
                [
                    'nama_ketua' => 'required',
                    'mahasiswa1_id' => 'required|exists:mahasiswas,id',
                    'mahasiswa2_id' => 'required|exists:mahasiswas,id',
                    'mahasiswa3_id' => 'required|exists:mahasiswas,id',
                ],
                [
                    'nama_ketua.required' => 'Nama ketua harus diisi',
                    'mahasiswa1_id.required' => 'Mahasiswa Pertama harus dipilih',
                    'mahasiswa1_id.exists' => 'Mahasiswa Pertama tidak valid',
                    'mahasiswa2_id.required' => 'Mahasiswa Kedua harus dipilih',
                    'mahasiswa2_id.exists' => 'Mahasiswa Kedua tidak valid',
                    'mahasiswa3_id.required' => 'Mahasiswa Ketiga harus dipilih',
                    'mahasiswa3_id.exists' => 'Mahasiswa Ketiga tidak valid',
                ]
            );

            $mahasiswa1 = \App\Models\Mahasiswa::find($request->mahasiswa1_id);
            $mahasiswa2 = \App\Models\Mahasiswa::find($request->mahasiswa2_id);
            $mahasiswa3 = \App\Models\Mahasiswa::find($request->mahasiswa3_id);

            $sameProvinceCount = 0;
            if ($mahasiswa1->asal_provinsi == $mahasiswa2->asal_provinsi) $sameProvinceCount++;
            if ($mahasiswa1->asal_provinsi == $mahasiswa3->asal_provinsi) $sameProvinceCount++;
            if ($mahasiswa2->asal_provinsi == $mahasiswa3->asal_provinsi) $sameProvinceCount++;

            if ($sameProvinceCount > 1) {
                return redirect()->back()->with('error', 'Maksimal dua mahasiswa boleh memiliki provinsi asal yang sama');
            }

            $sameInterestCount = 0;
            if ($mahasiswa1->bidang_minat_id == $mahasiswa2->bidang_minat_id) $sameInterestCount++;
            if ($mahasiswa1->bidang_minat_id == $mahasiswa3->bidang_minat_id) $sameInterestCount++;
            if ($mahasiswa2->bidang_minat_id == $mahasiswa3->bidang_minat_id) $sameInterestCount++;

            if ($sameInterestCount > 1) {
                return redirect()->back()->with('error', 'Maksimal dua mahasiswa boleh memiliki bidang minat yang sama');
            }


            $tim = new Tim();
            $tim->nama_ketua = $request->nama_ketua;
            $tim->mahasiswa1_id = $request->mahasiswa1_id;
            $tim->mahasiswa2_id = $request->mahasiswa2_id;
            $tim->mahasiswa3_id = $request->mahasiswa3_id;
            $tim->status = 'approved';
            $tim->save();

            broadcast(new MessageSent("Anda berhasil didaftarkan ke tim", $request->mahasiswa2_id));
            broadcast(new MessageSent("Anda berhasil didaftarkan ke tim", $request->mahasiswa3_id));

            $notif = new ListNotif();
            $notif->user_id = $request->mahasiswa1_id;
            $notif->title = 'Berhasil didaftarkan ke tim';
            $notif->content = 'Anda berhasil didaftarkan ke tim oleh admin';
            $notif->route = route('tim.index');
            $notif->status = 'unread';
            $notif->save();

            $notif = new ListNotif();
            $notif->user_id = $request->mahasiswa2_id;
            $notif->title = 'Berhasil didaftarkan ke tim';
            $notif->content = 'Anda berhasil didaftarkan ke tim oleh admin';
            $notif->route = route('tim.index');
            $notif->status = 'unread';
            $notif->save();

            $notif = new ListNotif();
            $notif->user_id = $request->mahasiswa3_id;
            $notif->title = 'Berhasil didaftarkan ke tim';
            $notif->content = 'Anda berhasil didaftarkan ke tim oleh admin';
            $notif->route = route('tim.index');
            $notif->status = 'unread';
            $notif->save();

            return redirect()->route('tim.index')->with('success', 'Pendaftaran tim berhasil');
        }

        return abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tim $tim)
    {
        if (auth()->guest()) {
            return abort(404);
        }

        if (auth()->user()->role == 'tim') {
            $data = $tim;
            return view('tim.tim.show', compact('data'));
        } elseif (auth()->user()->role == 'mahasiswa') {
            $data = $tim;
            return view('mahasiswa.tim.show', compact('data'));
        } elseif (auth()->user()->role == 'dosen_pembimbing' || auth()->user()->role == 'dosen_penguji' || auth()->user()->role == 'dosen') {
            $data = $tim;
            return view('dosen.tim.show', compact('data'));
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tim $tim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tim $tim)
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

        $tim->status = $request->status;
        if( $request->status == 'rejected') {
            $tim->alasan_penolakan = $request->alasan_penolakan;
        }
        $tim->save();

        return redirect()->route('tim.index')->with('success', 'Status tim berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tim $tim)
    {
        //
    }
}
