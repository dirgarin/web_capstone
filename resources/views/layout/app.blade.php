<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <title>Admin - {{ env('APP_NAME') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminkit/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/select2/dist/css/select2.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    @stack('styles')

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('33af827e4f25e7e5e659', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('notifications{{ Auth::check() ? Auth::user()->role : null }}');
        channel.bind('my-event', function(data) {
            alert(JSON.stringify(data));
        });

        var channel2 = pusher.subscribe('notifications{{ Auth::check() ? Auth::id() : null }}');
        channel2.bind('my-event', function(data) {
            alert(JSON.stringify(data));
        });
    </script>

</head>
@include('sweetalert::alert')

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar" data-simplebar="init">
                <div class="simplebar-wrapper" style="margin: 0px;">
                    <div class="simplebar-height-auto-observer-wrapper">
                        <div class="simplebar-height-auto-observer"></div>
                    </div>
                    <div class="simplebar-mask">
                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                            <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                <div class="simplebar-content" style="padding: 0px;">
                                    <a class="sidebar-brand text-center" href="{{ route('home') }}">
                                        <span class="sidebar-brand-text align-middle">
                                            {{ env('APP_NAME') }}
                                        </span>
                                    </a>

                                    <div class="sidebar-user text-white">
                                        <div class="d-flex justify-content-center gap-3">
                                            @auth
                                                <div class="flex-shrink-0 ps-3">
                                                    <i class="fas fa-user fa-2x"></i>
                                                </div>
                                                <div class="flex-grow-1 ps-2">
                                                    <span class="sidebar-user-title">
                                                        {{ auth()->user()->name }}
                                                    </span>
                                                </div>
                                            @endauth
                                        </div>
                                    </div>

                                    <ul class="sidebar-nav">
                                        <li class="sidebar-header">
                                            Halaman
                                        </li>
                                        <li class="sidebar-item {{ Route::is('home') ? 'active' : '' }}">
                                            <a class="sidebar-link" href="{{ route('home') }}">
                                                <i class="fas fa-home"></i>
                                                <span class="align-middle">Home</span>
                                            </a>
                                        </li>
                                        @guest
                                            <li class="sidebar-item {{ Route::is('mahasiswa.*') ? 'active' : '' }}">
                                                <a class="sidebar-link" href="{{ route('mahasiswa.create') }}">
                                                    <i class="fas fa-user-graduate"></i>
                                                    <span class="align-middle">Pendaftaran Mahasiswa</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-item {{ Route::is('dosen.*') ? 'active' : '' }}">
                                                <a class="sidebar-link" href="{{ route('dosen.index') }}">
                                                    <i class="fas fa-chalkboard-teacher"></i>
                                                    <span class="align-middle">Pendaftaran Dosen</span>
                                                </a>
                                            </li>
                                        @else
                                            @can('isTim')
                                                <li class="sidebar-item {{ Route::is('mahasiswa.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('mahasiswa.index') }}">
                                                        <i class="fas fa-user-graduate"></i>
                                                        <span class="align-middle">Mahasiswa</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item {{ Route::is('dosen.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('dosen.index') }}">
                                                        <i class="fas fa-chalkboard-teacher"></i>
                                                        <span class="align-middle">Dosen</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item {{ Route::is('tim.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('tim.index') }}">
                                                        <i class="fas fa-users"></i>
                                                        <span class="align-middle">Tim Mahasiswa</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item {{ Route::is('topik_dosen.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('topik_dosen.index') }}">
                                                        <i class="fas fa-chalkboard-teacher"></i>
                                                        <span class="align-middle">Topik Dosen</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item {{ Route::is('topik_mandiri.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('topik_mandiri.index') }}">
                                                        <i class="fas fa-chalkboard-teacher"></i>
                                                        <span class="align-middle">Topik Mandiri</span>
                                                    </a>
                                                </li>
                                                {{-- <li class="sidebar-item {{ Route::is('daftar_topik.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('daftar_topik.index') }}">
                                                        <i class="fas fa-tasks"></i>
                                                        <span class="align-middle">Topik yang Disetujui</span>
                                                    </a>
                                                </li> --}}
                                                <li class="sidebar-item {{ Route::is('sections.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('sections.index') }}">
                                                        <i class="fas fa-file"></i>
                                                        <span class="align-middle">Section</span>
                                                    </a>
                                                </li>
                                                {{-- <li class="sidebar-item {{ Route::is('template.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('template.index') }}">
                                                        <i class="fas fa-file"></i>
                                                        <span class="align-middle">Segmen Dokumen</span>
                                                    </a>
                                                </li> --}}
                                                <li class="sidebar-item {{ Route::is('template.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('submission.index') }}">
                                                        <i class="fas fa-file"></i>
                                                        <span class="align-middle">Submission</span>
                                                    </a>
                                                </li>
                                                {{-- <li
                                                    class="sidebar-item {{ Route::is('mahasiswa_dokumen.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('mahasiswa_dokumen.index') }}">
                                                        <i class="fas fa-file"></i>
                                                        <span class="align-middle">Dokumen Mahasiswa</span>
                                                    </a>
                                                </li> --}}
                                                <li class="sidebar-item {{ Route::is('template.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('nilai') }}">
                                                        <i class="fas fa-file"></i>
                                                        <span class="align-middle">Nilai</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('isMahasiswa')
                                                <li class="sidebar-item {{ Route::is('tim.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('tim.index') }}">
                                                        <i class="fas fa-users"></i>
                                                        <span class="align-middle">Tim</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item {{ Route::is('topik_dosen.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('topik_dosen.index') }}">
                                                        <i class="fas fa-chalkboard-teacher"></i>
                                                        <span class="align-middle">Topik Dosen</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item {{ Route::is('topik_mandiri.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('topik_mandiri.index') }}">
                                                        <i class="fas fa-chalkboard-teacher"></i>
                                                        <span class="align-middle">Topik Mandiri</span>
                                                    </a>
                                                </li>

                                                <li class="sidebar-item {{ Route::is('template.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('submission.index') }}">
                                                        <i class="fas fa-file"></i>
                                                        <span class="align-middle">Submission</span>
                                                    </a>
                                                </li>

                                                <li class="sidebar-item {{ Route::is('template.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('nilai') }}">
                                                        <i class="fas fa-file"></i>
                                                        <span class="align-middle">Nilai</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('isDosen')
                                                <li class="sidebar-item {{ Route::is('topik_dosen.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('topik_dosen.index') }}">
                                                        <i class="fas fa-chalkboard-teacher"></i>
                                                        <span class="align-middle">Topik Dosen</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item {{ Route::is('topik_mandiri.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('topik_mandiri.index') }}">
                                                        <i class="fas fa-chalkboard-teacher"></i>
                                                        <span class="align-middle">Topik Mandiri</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item {{ Route::is('template.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('submission.index') }}">
                                                        <i class="fas fa-file"></i>
                                                        <span class="align-middle">Submission</span>
                                                    </a>
                                                </li>
                                                <li class="sidebar-item {{ Route::is('template.*') ? 'active' : '' }}">
                                                    <a class="sidebar-link" href="{{ route('nilai') }}">
                                                        <i class="fas fa-file"></i>
                                                        <span class="align-middle">Nilai</span>
                                                    </a>
                                                </li>
                                            @endcan
                                        @endguest
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simplebar-placeholder" style="width: auto; height: 1490px;"></div>
                </div>
                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                </div>
                <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                    <div class="simplebar-scrollbar"
                        style="height: 298px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                </div>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
                @guest
                    <div class="ms-auto">
                        <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
                    </div>
                @else
                    @php
                        $user = Auth::user();
                        $notif = \App\Models\ListNotif::where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->take(10)
                            ->get();

                        $unread = \App\Models\ListNotif::where('user_id', $user->id)
                            ->where('status', 'unread')
                            ->get();
                        $count = $unread->count();
                    @endphp

                    <div class="ms-auto d-flex align-items-center">
                        <!-- Lonceng dengan Dropdown -->
                        <div class="dropdown me-3 position-relative">
                            <a href="#" class="btn btn-outline-secondary" id="notificationDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                                @if ($count > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $count }}
                                    </span>
                                @endif
                            </a>
                            <!-- Dropdown Menu -->
                            <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="notificationDropdown" style="min-width: 300px;">
                                <center>
                                    <h6 class="dropdown-header">Notifikasi</h6>
                                </center>
                                <!-- Tambahkan div pembungkus untuk membuat area scroll -->
                                <div class="notif-scrollable" style="max-height: 300px; overflow-y: auto;">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($notif as $item)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <a href="{{ $item->route }}">
                                                    <div>
                                                        <strong>{{ $item->title }}</strong>
                                                        <p class="mb-0 text-muted small">{{ $item->content }}</p>
                                                    </div>
                                                    <span class="text-muted small">{{ $item->created_at->diffForHumans() }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                @endguest
            </nav>

            <script>
                $(document).ready(function() {
                    $('#notificationDropdown').on('click', function() {
                        $.ajax({
                            url: "{{ route('notifications.readAll') }}",
                            type: "GET", 
                            success: function(response) {
                                console.log(response.message); 
                                $('#notificationDropdown .badge').remove();
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error); 
                            }
                        });
                    });
                });
            </script>



            <main class="content">
                @yield('contents')
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                Copyright © 2024 All rights reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src=" {{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/js/all.min.js') }}"></script>
    <script src="{{ asset('adminkit/js/app.js') }}"></script>
    <script src=" {{ asset('vendors/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script src=" {{ asset('vendors/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>
    <script src="https://cdn.tiny.cloud/1/ue6wka9vf4pdb68yar2jsuaql5gpoiiisscnj7n0zjawrjx3/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data yang dihapus tidak dapat dikembalikan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function confirmMessage(msg, event) {
            event.preventDefault();
            const form = event.target.closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }



        $(document).ready(function() {
            $('#datatable').DataTable();
            $('.dataTable').DataTable();
            $('.select2-input').select2({
                matcher(params, data) {
                    const originalMatcher = $.fn.select2.defaults.defaults.matcher;
                    const result = originalMatcher(params, data);

                    if (
                        result &&
                        data.children &&
                        result.children &&
                        data.children.length
                    ) {
                        if (
                            data.children.length !== result.children.length &&
                            data.text.toLowerCase().includes(params.term.toLowerCase())
                        ) {
                            result.children = data.children;
                        }
                        return result;
                    }

                    return null;
                },
            });

            tinymce.init({
                selector: 'textarea.tinymce-input',
                width: "100%",
                autosave_ask_before_unload: false,
                powerpaste_allow_local_images: true,
                plugins: [
                    'a11ychecker', 'advcode', 'advlist', 'anchor', 'autolink', 'codesample',
                    'fullscreen', 'help',
                    'image', 'editimage', 'tinydrive', 'lists', 'link', 'media', 'powerpaste',
                    'preview',
                    'searchreplace', 'table', 'tinymcespellchecker', 'visualblocks', 'wordcount'
                ],
                toolbar: 'insertfile a11ycheck undo redo | bold italic | forecolor backcolor | codesample | alignleft aligncenter alignright alignjustify | bullist numlist | link image',
                spellchecker_dialog: true,
                spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
                // tinydrive_demo_files_url: '../_images/tiny-drive-demo/demo_files.json',
                tinydrive_token_provider: (success, failure) => {
                    success({
                        token: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqb2huZG9lIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.Ks_BdfH4CWilyzLNk8S2gDARFhuxIauLa8PwhdEQhEo'
                    });
                },
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    @stack('scripts')
</body>

</html>
