<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="min-vh-100 d-flex justify-content-center align-items-center">
    <div class="container mt-5">
        <div class="card shadow-sm rounded-3">
            <div class="card-body text-center">
                <h1 class="h4 fw-bold">
                    Selamat Datang Di {{ env('APP_NAME') }}!
                </h1>
                <p class="text-muted">
                    Login
                </p>
                <form method="post">
                    @csrf
                    <div class="mb-3 text-start">
                        <label class="form-label" for="email">
                            Email
                        </label>
                        <input class="form-control rounded-pill @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Masukkan Email" type="email" value="{{ old('email') }}" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label" for="password">
                            Password
                        </label>
                        <input class="form-control rounded-pill @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="Masukkan Password" type="password" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-primary bg-primary w-100 rounded-pill" type="submit">
                        LOGIN
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary bg-secondary w-100 rounded-pill mt-3">
                        KEMBALI
                    </a>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/js/all.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session("success") }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session("error") }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
</body>

</html>
