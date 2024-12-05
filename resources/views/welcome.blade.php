<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-NotifKU</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container" id="container">

        <div class="form-container register-container">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1>Daftar Akun</h1>
                <input id="name" type="text" name="name" :value="old('name')" required autocomplete="name"
                    placeholder="Name">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                <input id="email" type="email" name="email" :value="old('email')" required
                    autocomplete="username" placeholder="Email">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Password">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Confirm Password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                <button>Register</button>
                <!-- <span>or use your account</span>
                <div class="social-container">
                    <a href="#" class="social"><i class="lni lni-facebook-fill"></i></a>
                    <a href="#" class="social"><i class="lni lni-google"></i></a>
                    <a href="#" class="social"><i class="lni lni-linkedin-original"></i></a>
                </div> -->
            </form>
        </div>

        <div class="form-container login-container">
            <form method="post" action="{{ route('login') }}">
                @csrf
                <!-- <h1>Login</h1> -->
                <img src="{{ asset('../image/logo.png') }}" alt="Logo" class="logo">

                <input id="email" type="email" name="email" :value="old('email')" required
                    autocomplete="username" placeholder="Email">

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="Password">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <div class="content">
                    <div class="checkbox">
                        <input type="checkbox" id="remember_me" name="remember">
                        <label>Remember me</label>
                    </div>
                    <div class="pass-link">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>
                </div>
                <button>Login</button>
                <!-- <span>or use your account</span>
                <div class="social-container">
                    <a href="#" class="social"><i class="lni lni-facebook-fill"></i></a>
                    <a href="#" class="social"><i class="lni lni-google"></i></a>
                    <a href="#" class="social"><i class="lni lni-linkedin-original"></i></a>
                </div> -->
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="title">Aplikasi <br> NotifKU</h1>
                    <p>Jika sudah punya akun silahkan login, klik tombol dibawah</p>
                    <button class="ghost" id="login">Login
                        <i class="lni lni-arrow-left login"></i>
                    </button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1 class="title">Aplikasi<br> NotifKU</h1>
                    <p>Jika belum punya akun silahkan daftar, klik tombol dibawah</p>
                    <button class="ghost" id="register">Register
                        <i class="lni lni-arrow-right register"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/script.js') }}"></script>

</body>

</html>
