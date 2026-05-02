<link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.1.0') }}" rel="stylesheet" />
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

<div class="main-content position-relative" style="background-color: #7ce4e9; min-height: 100vh;">

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

        <div class="row shadow-xl overflow-hidden" style="border-radius: 20px; width: 100%; max-width: 900px; height: 500px;">

            <div class="col-lg-5 text-white d-flex flex-column justify-content-center align-items-center p-5 text-center" style="background-color: #4a86bd;">
                <h3 class="text-white font-weight-bolder text-uppercase mb-4">Welcome Back</h3>
                <p class="text-white opacity-8 text-sm px-3 mb-5">
                    Silakan login untuk mengakses kembali inventaris elektronik dan layanan mutuotech. Belum punya akun? Klik tombol di bawah.
                </p>
                <a href="/register" class="btn btn-white text-dark btn-md border-radius-lg px-4 font-weight-bold text-capitalize">
                    Create An Account
                </a>
            </div>

            <div class="col-lg-7 bg-white p-5 d-flex flex-column justify-content-center">
                <h3 class="font-weight-bolder text-info mb-4 text-center text-uppercase">Login Form</h3>

                <form action="/login" method="post" role="form">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label text-xs font-weight-bold text-secondary mb-1">Your Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="fas fa-envelope text-info text-xs"></i></span>
                            <input type="email" id="email" name="email" class="form-control form-control-md" placeholder="name@example.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold text-secondary mb-1">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="fas fa-lock text-info text-xs"></i></span>
                            <input type="password" id="password" name="password" class="form-control form-control-md" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label text-xs text-secondary" for="rememberMe">Remember me</label>
                        </div>
                        <a href="javascript:;" class="text-xs text-info font-weight-bold">Forgot Password?</a>
                    </div>

                    <div class="text-left mt-4">
                        <button type="submit" class="btn btn-info btn-md px-5 border-radius-md font-weight-bold text-capitalize" style="background-color: #4a86bd !important;">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>