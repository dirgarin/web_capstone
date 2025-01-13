<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Answer;
use App\Models\Feedback;
use App\Models\Nilai;
use App\Models\Penilaian;
use App\Models\PenilaianChoices;
use App\Models\Submission2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;

class SubmissionController extends Controller
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
                $data = Submission2::orderBy('created_at', 'desc')->get();
                return view('tim.submission.index', compact('data'));
            } elseif (auth()->user()->role == 'mahasiswa') {
                $data = Submission2::orderBy('created_at', 'desc')->get();
                return view('mahasiswa.submission.index', compact('data'));
            }elseif (auth()->user()->role == 'dosen_pembimbing' ||auth()->user()->role == 'dosen_penguji'||auth()->user()->role == 'dosen') {
                $data = Answer::orderBy('created_at', 'desc')->with(['submission', 'user', 'nilai'])->get();
                return view('dosen.submission.index', compact('data'));
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
            return view('tim.submission.create');
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
                    'deskripsi' => 'required',
                    'open' => 'required',
                    'deadline' => 'required',
                ],
                [
                    'judul.required' => 'Judul section wajib diisi',
                    'isi.required' => 'Isi konten wajib diisi',
                    'open.required' => 'Open wajib diisi',
                    'deadline.required' => 'Deadline wajib diisi',
                ]
            );

            $submission = new Submission2();
            $submission->judul = $request->judul;
            $submission->deskripsi = $request->deskripsi;
            $submission->open = $request->open;
            $submission->deadline = $request->deadline;
            if ($request->hasFile('file'))
                $submission->dokumen = $request->file('file')->store('submission', 'public');
            $submission->save();
            $user = \App\Models\User::all();
            foreach($user as $u){
                if($u->id == 1){

                }else{
                    $notif = new \App\Models\ListNotif();
                    $notif->user_id = $u->id;
                    $notif->title = 'Submission baru';
                    $notif->content = 'Submission baru dari tim capstone.';
                    $notif->status = 'unread';
                    $notif->route = route('home');
                    $notif->save();
                }
            foreach($request->segments as $value){
                $penilaian = new Penilaian();
                $penilaian->id_submission = $submission->id;
                $penilaian->text = $value['description'];
                $penilaian->bobot = $value['bobot'];
                $penilaian->save();

                $data = $value['data'] ?? [];
                foreach($data as $value2){
                    $penilaian_choices = new PenilaianChoices();
                    $penilaian_choices->id_penilaian = $penilaian->id;
                    $penilaian_choices->text = $value2['values'];

                    if (isset($value2['files']) && $value2['files']->isValid()) {
                        $penilaian_choices->image = $value2['files']->store('submission', 'public');
                    }
                    $penilaian_choices->save();
                }
            }



            return redirect()->route('submission.index')->with('success', 'Submission updated successfully');        }

        return abort(404);
    }

}

    /**
     * Display the specified resource.
     */
    public function show($id){
        if (auth()->guest()) {
            return abort(404);
        }

        $data = Submission2::where('id', $id)->first();
        return view('mahasiswa.submission.show', compact('data'));
    }


    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (auth()->guest()) {
            abort(404);
        }

        if (auth()->user()->role == 'tim') {
            $submission = Submission2::where('id', $id)->with(['penilaian.choices'])->first();
            return view('tim.submission.edit', compact('submission'));
            // return $submission;
        }

        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Ambil data submission yang akan diupdate
    $submission = Submission2::findOrFail($id);

    // Validasi input
    $request->validate([
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'open' => 'required|date',
        'deadline' => 'required|date',
    ]);

    // Update submission
    $submission->judul = $request->judul;
    $submission->deskripsi = $request->deskripsi;
    $submission->open = $request->open;
    $submission->deadline = $request->deadline;

    if ($request->hasFile('file')) {
        $submission->dokumen = $request->file('file')->store('submission', 'public');
    }

    $submission->save();

    $submission->penilaian()->delete();

    foreach ($request->segments as $value) {
        $penilaian = new Penilaian();
        $penilaian->id_submission = $submission->id;
        $penilaian->text = $value['description'];
        $penilaian->bobot = $value['bobot'];
        $penilaian->save();

        $data = $value['data'] ?? [];
        foreach ($data as $value2) {
            $penilaian_choices = new PenilaianChoices();
            $penilaian_choices->id_penilaian = $penilaian->id;
            $penilaian_choices->text = $value2['values'];

            if (isset($value2['files']) && $value2['files']->isValid()) {
                $penilaian_choices->image = $value2['files']->store('submission', 'public');
            }
            $penilaian_choices->save();
        }
    }

    return redirect()->route('submission.index')->with('success', 'Submission updated successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }

    public function submit($id){
        $data = Submission2::where('id', $id)->first();
        $answer = Answer::where('submission_id', $id)->where('user_id', Auth::id())->first();
        $nilai = null;
        if($answer){
            $nilai = Nilai::where('answer_id', $answer->id)->first();
        }
        return view('mahasiswa.submission.submit', compact(['data', 'answer', 'nilai']));
    }

    public function submitAnswer(Request $request, $id){
        $answer = new Answer();
        $answer->user_id = Auth::id();
        $answer->submission_id = $id;
        if ($request->hasFile('file'))
            $answer->file = $request->file('file')->store('submission', 'public');
        $answer->save();

        $tim = auth()->user()->mahasiswa->tim1->where('status', 'approved')->merge(auth()->user()->mahasiswa->tim2->where('status', 'approved'))->merge(auth()->user()->mahasiswa->tim3->where('status', 'approved'))->first();
        $daftarTopikMandiri = \App\Models\DaftarTopikMandiri::where('tim_id', $tim->id)->first();
        $daftarTopikDosen = \App\Models\DaftarTopikDosen::where('tim_id', $tim->id)->first();

        if($daftarTopikMandiri){
            $topikMandiri = \App\Models\TopikMandiri::where('id', $daftarTopikMandiri->topik_mandiri_id)->first();
            $dosen = \App\Models\Dosen::where('id', $topikMandiri->dosen_id)->first();

            $notif = new \App\Models\ListNotif();
            $notif->user_id = $dosen->user_id;
            $notif->title = 'Submission baru';
            $notif->content = 'Submission baru dari tim '.$tim->nama_tim;
            $notif->status = 'unread';
            $notif->route = route('home');
            $notif->save();
        }
        
        if($daftarTopikDosen){
            $topikDosen = \App\Models\TopikDosen::where('id', $daftarTopikDosen->topik_dosen_id)->first();
            $dosen = \App\Models\Dosen::where('id', $topikDosen->dosen_id)->first();

            $notif = new \App\Models\ListNotif();
            $notif->user_id = $dosen->user_id;
            $notif->title = 'Submission baru';
            $notif->content = 'Submission baru dari tim '.$tim->nama_tim;
            $notif->status = 'unread';
            $notif->route = route('home');
            $notif->save();
        }

        //broadcast(new MessageSent("Mahasiswa telah mengumpulkan submission", 'dosen'));

        return redirect()->back()->with('success', 'Submission updated successfully');
    }

    public function grade ($id){
        $answer = Answer::where('id', $id)->with(['user', 'nilai.penilaian', 'feedback'])->first();
        $submission = Submission2::where('id', $answer->submission_id)->with(['penilaian.choices'])->first();
        $nilai_akhir = 0;
        foreach($answer->nilai as $value){
            $nilai_akhir = $nilai_akhir + ((int)$value->choice->text) * $value->penilaian->bobot;
        }
        $nilai_akhir = $nilai_akhir/100;
        return view('dosen.submission.grade', compact(['answer', 'submission', 'nilai_akhir']));
    }

    public function submitGrade(Request $request, $id){
        foreach($request->value as $value){
            $nilai = new Nilai();
            $nilai->answer_id = $id;
            $nilai->penilaian_id = $value['penilaian_id'];
            $nilai->choice_id = $value['choice_id'];
            $nilai->save();
        }
        $feedback = new Feedback();
        $feedback->answer_id = $id;
        $feedback->feedback = $request->feedback;
        $feedback->save();

        $user = Answer::where('id', $id)->with('user')->first();
        //$this->notificationController->sendNotification($user->user->id, 'Submission telah dinilai', 'Submission anda telah dinilai oleh dosen', route('home'));
        //broadcast(new MessageSent("Dosen telah menilai submission", $user->user->id));
        $notif = new \App\Models\ListNotif();
        $notif->user_id = $user->user->id;
        $notif->title = 'Submission telah dinilai';
        $notif->content = 'Submission anda telah dinilai oleh dosen';
        $notif->status = 'unread';
        $notif->route = route('home');
        $notif->save();
        return redirect()->route('submission.index')->with('success', 'Submission updated successfully');
    }

    public function nilai (){
        if (auth()->guest()) {
            abort(404);
        } else {
            if (auth()->user()->role == 'mahasiswa') {
                $data = Answer::orderBy('created_at', 'desc')->where('user_id', Auth::id())->with(['submission', 'nilai.choice', 'nilai.penilaian', 'feedback'])->get();
                $total = 0;
                $nilai_akhir = 0;
                foreach($data as $value){
                    $value->nilai_akhir = 0;
                    foreach($value->nilai as $value2){
                        $nilai_akhir = $nilai_akhir + ((int)$value2->choice->text) * $value2->penilaian->bobot;
                    }
                    $value->nilai_akhir = $nilai_akhir/100;
                    $total = $total + $value->nilai_akhir;
                    $nilai_akhir = 0;
                }
                return view('mahasiswa.nilai', compact(['data', 'total']));
            } else if (auth()->user()->role == 'tim'||auth()->user()->role == 'dosen_pembimbing' ||auth()->user()->role == 'dosen_penguji'||auth()->user()->role == 'dosen') {
                $data = Answer::orderBy('created_at', 'desc')->with(['submission', 'nilai.choice', 'nilai.penilaian', 'feedback', 'user'])->whereHas('nilai')->get();
                $nilai_akhir = 0;
                foreach($data as $value){
                    $value->nilai_akhir = 0;
                    foreach($value->nilai as $value2){
                        $nilai_akhir = $nilai_akhir + ((int)$value2->choice->text) * $value2->penilaian->bobot;
                    }
                    $value->nilai_akhir = $nilai_akhir/100;
                    $nilai_akhir = 0;
                }
                return view('tim.nilai', compact('data'));
            }else {
                abort(404);
            }
        }
    }
}
