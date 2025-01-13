@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Pendaftaran Mahasiswa</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="text-center" id="show" style="display: none;">
                        Allow notifications untuk membuat akun.
                    </p>
                    <form action="{{ route('mahasiswa.store') }}" method="post" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="number" class="form-control @error('nim') is-invalid @enderror" id="nim"
                                name="nim" value="{{ old('nim') }}" required>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas"
                                name="kelas" value="{{ old('kelas') }}" required>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">No. Telepon</label>
                            <input type="number" class="form-control @error('no_telp') is-invalid @enderror"
                                id="no_telp" name="no_telp" value="{{ old('no_telp') }}" required>
                            @error('no_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="asal_kota" class="form-label">Asal Kota</label>
                            <input type="text" class="form-control @error('asal_kota') is-invalid @enderror"
                                id="asal_kota" name="asal_kota" value="{{ old('asal_kota') }}" required>
                            @error('asal_kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="asal_provinsi" class="form-label">Asal Provinsi</label>
                            <select class="form-select @error('asal_provinsi') is-invalid @enderror" id="asal_provinsi"
                                name="asal_provinsi" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('asal_provinsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                name="alamat" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="bidang_minat_id" class="form-label">Bidang Minat</label>
                            <select class="form-select @error('bidang_minat_id') is-invalid @enderror"
                                id="bidang_minat_id" name="bidang_minat_id" required>
                                <option value="">Pilih Bidang Minat</option>
                                @foreach ($bidang_minat as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('bidang_minat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kompetensi" class="form-label">Kompetensi yang Dimiliki</label>
                            <textarea class="form-control @error('kompetensi') is-invalid @enderror" id="kompetensi"
                                name="kompetensi" required>{{ old('kompetensi') }}</textarea>
                            @error('kompetensi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="total_sks" class="form-label">Total SKS Lulus</label>
                            <input type="number" class="form-control @error('total_sks') is-invalid @enderror"
                                id="total_sks" name="total_sks" value="{{ old('total_sks') }}" required>
                            @error('total_sks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Mata Kuliah Prasyarat</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkbox_analisis" name="checkbox_analisis" 
                                    value="Analisis Perancangan Sistem Informasi" 
                                    onchange="toggleField('field_analisis', this)" required>
                                <label class="form-check-label" for="checkbox_analisis">
                                    Analisis Perancangan Sistem Informasi
                                </label>
                            @error('checkbox_analisis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                            <div id="field_analisis" class="mt-2" style="display: none;">
                                <div class="mb-2">
                                    <label for="apsi_semester" class="form-label">Semester</label>
                                    <input type="number" class="form-control" id="apsi_semester" name="apsi_semester" required>
                                    @error('apsi_semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="apsi_nilai" class="form-label">Nilai</label>
                                    <input type="number" class="form-control" id="apsi_nilai" name="apsi_nilai" required>
                                    @error('apsi_nilai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="checkbox_manajemen" name="checkbox_manajemen" 
                                    value="Manajemen Project" 
                                    onchange="toggleField('field_manajemen', this)" required>
                                <label class="form-check-label" for="checkbox_manajemen">
                                    Manajemen Project
                                </label>
                                @error('checkbox_manajemen')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="field_manajemen" class="mt-2" style="display: none;">
                                <div class="mb-2">
                                    <label for="manpro_semester" class="form-label">Semester</label>
                                    <input type="number" class="form-control" id="manpro_semester" name="manpro_semester" required>
                                    @error('manpro_semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="manpro_nilai" class="form-label">Nilai</label>
                                    <input type="number" class="form-control" id="manpro_nilai" name="manpro_nilai" required>
                                    @error('manpro_nilai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>                        


                        <div class="mb-3">
                            <label for="file_ktp" class="form-label">File KTP (PDF)</label>
                            <input type="file" class="form-control @error('file_ktp') is-invalid @enderror"
                                id="file_ktp" name="file_ktp" required accept="application/pdf">
                            @error('file_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </>
                            <div class="mb-3">
                                <label for="file_khs" class="form-label">File KHS (PDF)</label>
                                <input type="file" class="form-control @error('file_khs') is-invalid @enderror"
                                    id="file_khs" name="file_khs" required accept="application/pdf">
                                @error('file_khs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="file_prasyarat" class="form-label">Screenshoot bukti kelulusan mata kuliah prasyarat (PDF)</label>
                                <input type="file" class="form-control @error('file_prasyarat') is-invalid @enderror"
                                    id="file_prasyarat" name="file_prasyarat" required accept="application/pdf">
                                @error('file_prasyarat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" name="endpoint" id="endpoint">
                            <input type="hidden" name="p256dh" id="p256dh">`
                            <input type="hidden" name="auth" id="auth">
                            
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (Notification.permission === 'default') {
            askForPermission();
        } else if (Notification.permission === 'denied') {
            document.getElementById('show').style.display = '';
        } else {
            document.querySelector('form').style.display = '';
        }
    });

    navigator.serviceWorker.register("{{ URL::asset('service-worker.js') }}");

    function askForPermission() {
        var form = document.querySelector('form');
        var endpoint = document.getElementById('endpoint');
        var p256dh = document.getElementById('p256dh');
        var auth = document.getElementById('auth');
        var show = document.getElementById('show');
        Notification.requestPermission().then((result) => {
            if (result === 'granted') {
                form.style.display = '';
                navigator.serviceWorker.ready.then((permission) => {
                    permission.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: urlBase64ToUint8Array(
                            '{{ env('VAPID_PUBLIC_KEY') }}')
                    }).then((subscription) => {
                        var subscription = subscription.toJSON();
                        var endpoint = subscription.endpoint;
                        var key = subscription.keys.p256dh;
                        var token = subscription.keys.auth;
                        
                        $('#endpoint').val(endpoint);
                        $('#p256dh').val(key);
                        $('#auth').val(token);

                    }).catch((error) => {
                        Notification.permission = 'default';
                        console.error('Error subscribing:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Langganan Gagal!',
                            text: 'Kami tidak dapat mengaktifkan notifikasi untuk Anda. Periksa koneksi atau coba lagi.',
                        });
                    });
                });
            } else {
                Notification.permission = 'default';
                show.style.display = '';
                console.log('Notification permission denied.');
                Swal.fire({
                    icon: 'warning',
                    title: 'Izin Ditolak',
                    text: 'Anda telah menolak izin untuk menerima notifikasi. Aktifkan izin di pengaturan browser jika berubah pikiran.',
                });
            }
        });
    }

    function sendNotification() {
        $.ajax({
            type: 'post',
            url: '{{ URL('send-push-notification') }}',
            data: {
                '_token': "{{ csrf_token() }}",
                'title': $("#title").val(),
                'body': $("#body").val(),
                'idOfProduct': $("#idOfProduct").val(),
            },
            success: function(data) {
                alert('Notification sent successfully');
                console.log(data);
            },
            error: function(xhr) {
                console.error('Error sending notification:', xhr.responseText);
            }
        });
    }

    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
        const base64 = (base64String + padding)
            .replace(/-/g, '+')
            .replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }
</script>

<script>
    function toggleField(fieldId, checkbox) {
        const field = document.getElementById(fieldId);
        if (checkbox.checked) {
            field.style.display = 'block';
        } else {
            field.style.display = 'none';
        }
    }
</script>

@endsection
