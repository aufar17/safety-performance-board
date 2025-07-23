@props(['breadcumb','title','user'])

<style>
    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #000000;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        margin: 0 auto;
    }
</style>

<nav class="navbar navbar-main navbar-expand-lg px-0 py-0 mx-4 shadow-none border-radius-xl" id="navbarBlur">
    <div class="container-fluid py-1 px-3 d-flex align-items-center justify-content-between flex-wrap">

        <div class="d-flex align-items-center">
            <a href="/" class="d-flex align-items-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="img-fluid"
                    style="max-width: 120px; height: auto;">
            </a>
        </div>

        <div class="flex-grow-1 mx-5 py-3 text-center d-none d-lg-block" style="background-color: #347433">
            <h2 class="mb-0 fw-bold text-white" style="letter-spacing: 2px;">PT KAYABA INDONESIA</h2>
        </div>

        <div class="d-flex align-items-center">
            <span class="px-3 py-2 me-3">
                <img src="{{ asset('img/k3.png') }}" alt="K3" class="img-fluid" style="max-width: 70px; height: auto;">
            </span>

            <a href="javascript:;" class="nav-link text-body p-0 d-xl-none" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                </div>
            </a>
        </div>

    </div>
</nav>