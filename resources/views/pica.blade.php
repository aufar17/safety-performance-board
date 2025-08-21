<!DOCTYPE html>
<html lang="en">
<x-head />

<style>
    html,
    body {
        padding: 0;
        margin: 0;
    }

    .carousel-wrapper {
        width: 95%;
        max-width: 1300px;
        margin: 1rem auto;

    }

    h1.text-center {
        margin-top: 2rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .carousel-16by9 {
        position: relative;
        width: 100%;
        padding-top: 56.25%;
        /* 16:9 */
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        background: #000;
    }

    .carousel-16by9 .carousel-inner,
    .carousel-16by9 .carousel-item,
    .carousel-16by9 .carousel-item img {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .info-box {
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(6px);
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        z-index: 10;
        position: relative;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 50%;
        padding: 1.2rem;
        transition: background 0.3s ease;
    }

    .carousel-control-prev-icon:hover,
    .carousel-control-next-icon:hover {
        background-color: rgba(255, 255, 255, 0.8);
    }
</style>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2 sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center fw-bold text-danger fs-5 me-3"
                href="{{ route('monitoring') }}">
                <img src="{{ asset('img/logo.png') }}" alt="KYB" height="32" class="me-2" />
            </a>

            <div class="d-none d-lg-block position-absolute top-50 start-50 translate-middle">
                <a class="navbar-brand fw-bold text-danger fs-5" href="{{ route('issue') }}">
                    <i class="fas fa-check-circle me-2"></i> PICA
                </a>
            </div>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('monitoring') ? 'text-danger' : '' }}"
                            href="{{ route('monitoring') }}">
                            <i class="fas fa-tv me-1"></i> Monitoring
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="row my-5">
        <div class="col-12">
            <h2 class="text-center text-black">PICA {{ $picaDate }}</h2>
        </div>
    </div>

    <div class="carousel-wrapper">
        @if ($images->count() > 0)
        <div id="picaCarousel" class="carousel slide carousel-16by9" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="position-absolute top-0 start-0 m-3 info-box">
                    <strong>Tanggal:</strong> {{ $picaDate }}
                </div>

                @foreach ($images as $key => $img)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $img->image) }}" alt="Slide {{ $key + 1 }}">

                    <div class="position-absolute bottom-0 start-0 m-3 info-box">
                        <span class="fw-bolder">Description:</span> <br>
                        {{ $pica->description ?? '-' }}
                    </div>

                    <div class="position-absolute bottom-0 end-0 m-3 info-box">
                        Slide {{ $key + 1 }} dari {{ $images->count() }}
                    </div>
                </div>
                @endforeach
            </div>

            @if ($images->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#picaCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#picaCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
        </div>
        @else
        <div class="text-center py-5 text-black fw-bold fs-4">
            Tidak ada PICA untuk ditampilkan.
        </div>
        @endif
    </div>



    <x-script />
</body>

</html>