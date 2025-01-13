@extends('layout.app')

@section('contents')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Home</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0">Section</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered table-hover"
                            style="width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 100px">No</th>
                                    <th>Judul</th>
                                    <th>Image</th>
                                    <th style="width: 100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sections as $item)
                                    <tr>
                                        <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $item->judul }}</td>
                                        <td class="text-center"> <img src="{{ Storage::url($item->image) }}"
                                            style="width: 200px;" alt="">
                                    </td>
                                        <td class="text-center" style="width: 100px;">
                                            <a href="{{ route('sections.show', $item->id) }}" class="btn btn-warning">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0">Submission</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered table-hover"
                            style="width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 100px">No</th>
                                    <th>Judul</th>
                                    <th>Open</th>
                                    <th>Deadline</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                <tr>
                                    <td class="text-center" style="width: 100px">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $item->judul }}</td>
                                    <td class="text-center">{{ $item->open }}</td>
                                    <td class="text-center">{{ $item->deadline }}</td>
                                    <td class="text-center" style="width: 100px;">
                                        <a href="{{ route('submission.show', $item->id) }}" class="btn btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<form id="subscription-form" style="display: none;">
    <input type="text" name="endpoint" id="endpoint">
    <input type="text" name="p256dh" id="p256dh">
    <input type="text" name="auth" id="auth">
</form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var isLogin = "{{ Auth::check() }}";
    document.addEventListener('DOMContentLoaded', function() {
        if (Notification.permission === 'default' && isLogin) {
            askForPermission();
        }
    });

    navigator.serviceWorker.register("{{ URL::asset('service-worker.js') }}");

    function askForPermission() {
        Notification.requestPermission().then((result) => {
            if (result === 'granted') {
                console.log('Notification permission granted.');
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

                        $.ajax({
                            url: '{{ route('save-sub') }}',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: $('#subscription-form').serialize(),
                            success: function(data) {
                                if (data.message == "success") {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Subscribed!',
                                        text: 'You have successfully subscribed to notifications.',
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Subscription Already Active',
                                        text: 'You have already subscribed to notifications before.',
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Notification.permission = 'default';
                                if (xhr.status === 200) {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Langganan Sudah Aktif',
                                        text: 'Anda sudah berlangganan notifikasi sebelumnya.',
                                    });
                                } else {
                                    console.error(
                                        error + "\n" + xhr.responseText);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal Menyimpan Data!',
                                        text: 'Terjadi kesalahan saat menyimpan langganan ke server. Silakan coba lagi.',
                                    });
                                }
                            }
                        });
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
