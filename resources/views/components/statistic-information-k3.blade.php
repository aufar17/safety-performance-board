@props([
'icon',
'title',
'agc',
'sinceLwd',
])

<div class="col-12">
    <div class="card shadow-sm rounded">
        <div class="card-header py-3 bg-danger border-bottom">
            <div class="d-flex align-items-center">
                <i class="{{ $icon }} fs-4 me-3 text-white"></i>
                <h5 class="mb-0 fw-bold text-white">{{ $title }}</h5>
            </div>
        </div>
        <div class="card-body p-1">
            <div class="row g-3 ">
                <div class="col-lg-7">
                    <span class="d-inline-block w-100 py-2 px-3 text-white text-center "
                        style="background-color: #347433;">
                        Jumlah Hari Kecelakaan tanpa LTI (Hari)
                    </span>
                </div>
                <div class="col-lg-5">
                    <span class="d-inline-block w-100 py-2 px-3 text-white  text-center"
                        style="background-color: #347433;">
                        FR (Frequency Rate)
                    </span>
                </div>
            </div>
            <div class="row g-3 mb-1">
                <div class="col-lg-7">
                    <span class="text-center d-inline-block w-100 py-2 px-3 text-white  bg-dark">
                        {{ $sinceLwd ?? 0}}
                    </span>
                </div>
                <div class="col-lg-5">
                    <span class="text-center d-inline-block w-100 py-2 px-3 text-white  bg-dark">
                        {{ $agc->fr ?? 0}}
                    </span>
                </div>
            </div>

            <div class="row g-3 ">
                <div class="col-lg-7">
                    <span class="d-inline-block w-100 py-2 px-3 text-white text-center "
                        style="background-color: #347433;">
                        Jumlah Jam Kecelakaan tanpa LTI (Hari)
                    </span>
                </div>
                <div class="col-lg-5">
                    <span class="d-inline-block w-100 py-2 px-3 text-white  text-center"
                        style="background-color: #347433;">
                        SR (Severity Rate)
                    </span>
                </div>
            </div>
            <div class="row g-3 mb-1">
                <div class="col-lg-7">
                    <span class="text-center d-inline-block w-100 py-2 px-3 text-white bg-dark">
                        {{ $agc->accident_hours ?? 0 }}
                    </span>
                </div>
                <div class=" col-lg-5">
                    <span class="text-center d-inline-block w-100 py-2 px-3 text-white bg-dark">
                        {{ $agc->sr ?? 0 }}
                    </span>
                </div>
            </div>

            <div class="row g-3 align-items-center text-center">
                <div class="col-3 text-end">
                    <img src="{{ asset('img/k3.png') }}" alt="K3" class="img-fluid"
                        style="max-width: 70px; height: auto;">
                </div>

                <div class="col-4 text-dark">
                    <h6 class="mb-1 text-uppercase fw-bolder">AGC</h6>
                    <h6 class="mb-0 text-uppercase fw-bolder">FR-SR Level</h6>
                </div>

                <div class="col-5">
                    <div class="py-2 rounded-4 shadow hover-shadow-lg transition"
                        style="background-color: {{ $agc->agc->color ?? '#000000' }}">
                        <h5 class="text-white mb-0 text-uppercase fw-bold">{{ $agc->agc->category ?? 'Unknown' }}</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>