<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
      <img src="../assets/img/favicon.png" width="26px" height="26px" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold"> mutuotech </span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" href="/">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-tv-2 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="/barang">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-bag-17 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">List barang</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="/peminjaman">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-archive-2 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Peminjaman</span>
        </a>
      </li>
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
      </li>

      @auth
      <li class="nav-item">
        <a class="nav-link" href="/profile">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
          </div>
          <div class="d-flex flex-column">
            <span class="nav-link-text ms-1 font-weight-bold">{{ Auth::user()->name }}</span>
            <span class="nav-link-text ms-1 text-xs text-secondary">{{ Auth::user()->sekolah }}</span>
          </div>
        </a>
      </li>

      <li class="nav-item">
        <form action="/logout" method="POST" id="logout-form">
          @csrf
          <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-user-run text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </form>
      </li>
      @else
      <li class="nav-item">
        <a class="nav-link " href="/register">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-copy-04 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Sign In</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="/login">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-collection text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Login</span>
        </a>
      </li>
      @endauth
  </div>
  <a href="https://wa.me/6281572049208" target="_blank" class="btn btn-dark btn-sm w-100 mb-3">Whatsapp</a>
  <div class="card-body text-center p-3 w-100 pt-0">
    <p class="text-xs font-weight-bold mb-0">trusted place to borrow electronic goods</p>

  </div>
  </div>
</aside>