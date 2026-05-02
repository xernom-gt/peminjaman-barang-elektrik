<link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.1.0') }}" rel="stylesheet" />
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

<div class="main-content position-relative" style="background-color: #7ce4e9; min-height: 100vh;">

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

        <div class="row shadow-xl overflow-hidden" style="border-radius: 20px; width: 100%; max-width: 900px; height: 500px;">

            <div class="col-lg-5 text-white d-flex flex-column justify-content-center align-items-center p-5 text-center" style="background-color: #4a86bd;">
                <h3 class="text-white font-weight-bolder text-uppercase mb-4">Infomation</h3>
                <p class="text-white opacity-8 text-sm px-3 mb-5">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                </p>
                <a href="/login" class="btn btn-white text-dark btn-md border-radius-lg px-4 font-weight-bold text-capitalize">
                    Have An Account?
                </a>
            </div>

            <div class="col-lg-7 bg-white p-5 d-flex flex-column justify-content-center">
                <h3 class="font-weight-bolder text-info mb-4 text-center text-uppercase">Register Form</h3>

                <form action="/register" method="post" role="form">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold text-secondary text-capitalize mb-1">Your Name</label>
                        <input type="text" name="name" class="form-control form-control-md" placeholder="lukmana" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold text-secondary mb-1">Your Email</label>
                        <input type="email" id="email" name="email" class="form-control form-control-md" placeholder="john.doe@example.com" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label text-xs font-weight-bold text-secondary mb-1">Password</label>
                            <div class="input-group input-group-md border-radius-md is-valid">
                                <input type="password" id="password" name="password" class="form-control border-success" placeholder="••••••••" required>
                                <span class="input-group-text bg-transparent border-success"><i class="fas fa-check-circle text-success text-xs"></i></span>
                            </div>
                        </div>
                        <div class="col">
                            <label class="form-label text-xs font-weight-bold text-secondary mb-1">Confirm Password</label>
                            <div class="input-group input-group-md border-radius-md is-invalid">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control border-warning" placeholder="••••••••" required>
                                <span class="input-group-text bg-transparent border-warning"><i class="fas fa-exclamation-triangle text-warning text-xs"></i></span>
                            </div>
                            <p class="text-warning text-xxs font-weight-bold mt-1 mb-0">Wrong Password</p>
                        </div>
                    </div>

                    <div class="form-check form-check-info mb-3">
                        <input class="form-check-input" type="checkbox" id="flexCheckDefault" checked>
                        <label class="form-check-label text-xs text-secondary" for="flexCheckDefault">
                            I agree to the <a href="javascript:;" class="text-info font-weight-bold">Terms and Conditions</a>
                        </label>
                    </div>

                    <div class="text-left mt-4">
                        <button type="submit" class="btn btn-info btn-md px-5 border-radius-md font-weight-bold text-capitalize" style="background-color: #4a86bd !important;">
                            Register
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>