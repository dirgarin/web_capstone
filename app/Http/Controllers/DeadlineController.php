<?php

namespace App\Http\Controllers;

use App\Models\Deadline;
use App\Models\Tim;
use Illuminate\Http\Request;
use App\Events\MessageSent;

class DeadlineController extends Controller
{
    public function createDeadline(Request $request){
        $deadline = new Deadline();
        $deadline->type = $request->type;
        $deadline->start = $request->start;
        $deadline->end = $request->end;
        $deadline->save();
        return redirect()->back();
    }

    public function notif(){
        broadcast(new MessageSent("Notifikasi untuk", 'mahasiswa'));
        return 'notif sent';
    }
}
