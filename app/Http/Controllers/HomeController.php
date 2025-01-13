<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Submission2;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->guest()) {
            return view('home');
        } else {
            if (auth()->user()->role == 'tim') {
                return view('home');
            } elseif (auth()->user()->role == 'mahasiswa') {
                $data = Submission2::orderBy('created_at', 'desc')->get();
                $sections = \App\Models\Section::orderBy('created_at', 'desc')->get();
                return view('mahasiswa.home', compact('data', 'sections'));
            } elseif (auth()->user()->role == 'dosen' || auth()->user()->role == 'dosen_pembimbing' || auth()->user()->role == 'dosen_penguji') {
                $data = Answer::orderBy('created_at', 'desc')->with(['submission', 'user', 'nilai'])->get();
                $sections = \App\Models\Section::orderBy('created_at', 'desc')->get();
                return view('dosen.home', compact('data', 'sections'));
            } else {
                return view('home');
            }
        }
    }
}
