<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="icon" href="{{ asset('/assets/images/klhk.png') }}" type="image/png">
</head>
<body>
    <div class="container">
        <div class="login-link">
            <div class="logo">
                <img src="/assets/images/klhk.png" alt="klhk" />
            </div>
            <p class="side-big-heading">Belum punya akun?</p>
            <a href="/register" class="registerbtn">Daftar</a>
        </div>

        <div class="login-form-container">
            <p class="big-heading">Welcome to SIMILKI </p>
            {{-- <form method="POST" action="{{ route('authenticate') }}"> --}}
                <div id="error-message" style="color: red; display: none; padding:10px;"></div>
            <form method="POST">
                @csrf

                @if (session('error'))
                <div class="validation" id="validation">
                    {{ session('error') }}
                </div>
                @endif


                <div class="text-fields email">
                    <label for="login">Username atau Email</label>
                    <input type="text" name="login" id="login" 
                           placeholder="Masukkan username atau email" 
                           required 
                           oninput="validateInput()" />
                    <span id="error-message" style="color: red; font-size: 12px; display: none; margin-bottom:10px">
                        Input harus berupa username atau email yang valid.
                    </span>
                </div>

                <div class="text-fields "> 
                    <label for="password">Password</label>
                    <div class="input-wrapper password">
                        <input type="password" id="password" name="password" required placeholder="Password">
                        <span onclick="togglePasswordVisibility('password', this)" class="toggle-password" data-show="{{ asset('assets/images/others/eye-show-password.png') }}" data-hide="{{ asset('assets/images/others/eye-hide-password.png') }}">
                            <img src="{{ asset('assets/images/others/eye-hide-password.png') }}" alt="hide password" />
                        </span>
                    </div>
                </div>

                <div class="checkbox-container">
                    <label for="remember_me" class="checkbox-label" style="cursor: pointer;">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Ingat Saya</span>
                    </label>
                </div>

                <div class="pagination-btns">
                    <button type="submit" id="submitBtn" class="login-btn">Login</button>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">Lupa Password?</a>
                @endif
            </form>
        </div>
    </div>

    <script src="js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

   
</body>
</html>