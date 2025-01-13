<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test-notif', [App\Http\Controllers\NotificationController::class, 'test']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate']);
});

Route::resource('mahasiswa', App\Http\Controllers\MahasiswaController::class);
Route::resource('dosen', App\Http\Controllers\DosenController::class);

Route::middleware('auth')->group(function () {
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::resource('tim', App\Http\Controllers\TimController::class);
    Route::resource('topik_dosen', App\Http\Controllers\TopikDosenController::class);
    Route::resource('daftar_topik_dosen', App\Http\Controllers\DaftarTopikDosenController::class);
    Route::get('topik_mandiri/{topik_mandiri}/pilih_dosen', [App\Http\Controllers\TopikMandiriController::class, 'pilih_dosen'])->name('topik_mandiri.pilih_dosen');
    Route::post('topik_mandiri/{topik_mandiri}/pilih_dosen', [App\Http\Controllers\TopikMandiriController::class, 'proses_dosen'])->name('topik_mandiri.proses_dosen');
    Route::resource('topik_mandiri', App\Http\Controllers\TopikMandiriController::class);
    Route::resource('daftar_topik_mandiri', App\Http\Controllers\DaftarTopikMandiriController::class);
    Route::resource('daftar_topik', App\Http\Controllers\DaftarTopikController::class);
    Route::post('template/uploadDescriptionImage', [App\Http\Controllers\TemplateController::class, 'uploadDescriptionImage'])->name('template.uploadDescriptionImage');
    Route::get('template/{template}/download', [App\Http\Controllers\TemplateController::class, 'download'])->name('template.download');
    Route::get('template/{template}/upload', [App\Http\Controllers\TemplateController::class, 'upload'])->name('template.upload');
    Route::post('template/{template}/upload', [App\Http\Controllers\TemplateController::class, 'proses_upload'])->name('template.proses_upload');
    Route::resource('template', App\Http\Controllers\TemplateController::class);
    Route::resource('mahasiswa_dokumen', App\Http\Controllers\MahasiswaDokumenController::class);
    Route::resource('penilaian_dosen', App\Http\Controllers\PenilaianDosenController::class);
    Route::resource('penilaian_tim', App\Http\Controllers\PenilaianTimController::class);

    Route::resource('sections', App\Http\Controllers\SectionController::class);

    Route::resource('submission', App\Http\Controllers\SubmissionController::class);
    Route::get('/submission/submit/{id}',[App\Http\Controllers\SubmissionController::class, 'submit']);
    Route::post('/submission/submit/{id}',[App\Http\Controllers\SubmissionController::class, 'submitAnswer']);
    Route::get('/submission/grade/{id}',[App\Http\Controllers\SubmissionController::class, 'grade']);
    Route::post('/submission/submit/grade/{id}',[App\Http\Controllers\SubmissionController::class, 'submitGrade']);
    Route::get('/nilai',[App\Http\Controllers\SubmissionController::class, 'nilai'])->name('nilai');

    Route::post('/deadline',[App\Http\Controllers\DeadlineController::class, 'createDeadline']);
    Route::get('/notif', [App\Http\Controllers\DeadlineController::class, 'notif']);

    Route::post('/save-sub', [App\Http\Controllers\NotificationController::class, 'saveSub'])->name('save-sub');

    Route::get('/read-all', [App\Http\Controllers\NotificationController::class, 'readAll'])->name('notifications.readAll');
});
