@props([
'icon',
'title',
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
                    <span class="d-inline-block w-100 py-2 px-3 text-white rounded" style="background-color: #347433;">
                        Jumlah Hari Kecelakaan tanpa LTI (Hari)
                    </span>
                </div>
                <div class="col-lg-5">
                    <span class="d-inline-block w-100 py-2 px-3 text-white rounded text-center"
                        style="background-color: #347433;">
                        FR (Frequency Rate)
                    </span>
                </div>
            </div>
            <div class="row g-3 mb-1">
                <div class="col-lg-7">
                    <span class="text-center d-inline-block w-100 py-2 px-3 text-white rounded bg-dark">
                        10
                    </span>
                </div>
                <div class="col-lg-5">
                    <span class="text-center d-inline-block w-100 py-2 px-3 text-white rounded bg-dark">
                        10
                    </span>
                </div>
            </div>

            <div class="row g-3 ">
                <div class="col-lg-7">
                    <span class="d-inline-block w-100 py-2 px-3 text-white rounded" style="background-color: #347433;">
                        Jumlah Jam Kecelakaan tanpa LTI (Hari)
                    </span>
                </div>
                <div class="col-lg-5">
                    <span class="d-inline-block w-100 py-2 px-3 text-white rounded text-center"
                        style="background-color: #347433;">
                        FR (Frequency Rate)
                    </span>
                </div>
            </div>
            <div class="row g-3 mb-1">
                <div class="col-lg-7">
                    <span class="text-center d-inline-block w-100 py-2 px-3 text-white rounded bg-dark">
                        10
                    </span>
                </div>
                <div class=" col-lg-5">
                    <span class="text-center d-inline-block w-100 py-2 px-3 text-white rounded bg-dark">
                        10
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>