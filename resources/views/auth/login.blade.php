<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="login-link">
            <div class="logo">
                <img src="img/klhk.png" alt="klhk" />
            </div>
            <p class="side-big-heading">Belum punya akun?</p>
            <a href="/register" class="registerbtn">Daftar</a>
        </div>

        <div class="login-form-container">
            <p class="big-heading">Login Akun</p>
            <form method="POST" action="{{ route('authenticate') }}">
                @csrf

                <div class="text-fields email">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" 
                           placeholder="abcd@gmail.com" 
                           required 
                           pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z]+(\.[a-zA-Z]{2,})+" 
                           title="Format email tidak valid. Harus memiliki huruf setelah '@' dan diikuti oleh '.'" />
                </div>

                {{-- <div class="text-fields">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" required placeholder="Password">
                        <span onclick="togglePasswordVisibility('password')" class="toggle-password">👁️</span>
                    </div>
                </div> --}}

                <div class="text-fields"> 
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" required placeholder="Password">
                        <span onclick="togglePasswordVisibility('password', this)" class="toggle-password" data-show="{{ asset('assets/images/others/eye-show-password.png') }}" data-hide="{{ asset('assets/images/others/eye-hide-password.png') }}">
                            <img src="{{ asset('assets/images/others/eye-hide-password.png') }}" alt="hide password" />
                        </span>
                    </div>
                </div>

                <div class="checkbox-container">
                    <label for="remember_me" class="checkbox-label">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Ingat Saya</span>
                    </label>
                </div>

                <div class="pagination-btns">
                    <button type="submit" class="login-btn">Login</button>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">Lupa Password?</a>
                @endif
            </form>
        </div>
    </div>

    <script src="js/register.js"></script>
</body>
</html>
