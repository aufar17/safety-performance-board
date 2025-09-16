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

<nav class="navbar navbar-main navbar-expand-lg px-0 py-0 mx-4 shadow-none border-radius-xl mb-5" id="navbarBlur">
    <div class="container-fluid py-1 px-3 d-flex align-items-center justify-content-between flex-wrap">

        <div class="d-flex align-items-center">
            <a href="http://172.16.16.253/indi40/safety-performance-board/public/index.php" class="d-flex align-items-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="img-fluid"
                    style="max-width: 120px; height: auto;">
            </a>
        </div>

        <!-- <div class="flex-grow-1 mx-4 py-3 text-center d-none d-lg-block" style="background-color: #06923E">
            <h2 class="mb-0 fw-bold text-white" style="letter-spacing: 2px;">SAFETY INFORMATION BOARD</h2>
        </div> -->

        <div class="flex-grow-1 mx-4 py-3 text-center d-none d-lg-block" style="background-color: #06923E">
            <h2 class="mb-0 fw-bold text-white fade-text" style="letter-spacing: 2px;">
                SAFETY INFORMATION BOARD
            </h2>
        </div>

        <style>
        .fade-text {
            animation: fadeInOut 4s ease-in-out infinite;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; }
            25% { opacity: 1; }   /* muncul */
            75% { opacity: 1; }   /* tetap terlihat sebentar */
            100% { opacity: 0; }  /* hilang lagi */
        }
        </style>

        <div class="d-flex align-items-center">
            <span class="py-2 me-4 ">
                <img src="{{ asset('img/add-logo.png') }}" alt="K3" class="img-fluid"
                    style="max-width: 70px; height: auto;">
            </span>
            <span class="py-2 me-3">
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