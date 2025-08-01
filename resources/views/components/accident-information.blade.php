@props([
'title',
'icon',
'category',
'total',
'count' => [],
])

@php
$count = [
'First Aid' => $category['First Aid'] ?? 0,
'Non LWD' => $category['Non LWD'] ?? 0,
'LWD' => $category['LWD'] ?? 0,
'Fatal' => $category['Fatal'] ?? 0,
];
@endphp

<div class="col-lg-12 col-xl-12 col-md-12 h-100">
    <div class="card shadow-sm rounded h-100 d-flex flex-column">
        <div class="card-header py-3 bg-danger border-bottom">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center">
                <i class="{{ $icon }} fs-4 me-2 text-white me-md-3"></i>
                <h5 class="mb-0 fw-bold text-white">{{ $title }}</h5>
            </div>
        </div>

        <div class="card-body pt-3 pb-4 d-flex flex-column h-100">
            <div class="row mx-0 mb-3">
                <div class="col-8 col-sm-9 py-1" style="background-color:#347433;">
                    <span class="text-white text-uppercase fw-bolder">Total Kejadian</span>
                </div>
                <div class="col-4 col-sm-3 bg-dark text-center py-1">
                    <span class="text-white">{{ $total }}</span>
                </div>
            </div>

            <div class="row mx-0 flex-grow-1">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <div class="row gy-2">
                        <div class="col-6 text-uppercase fw-bolder">First Aid</div>
                        <div class="col-6 bg-dark text-white text-center border border-white">
                            {{ $count['First Aid'] ?? 0 }}
                        </div>
                        <div class="col-6 text-uppercase fw-bolder">Non LWD</div>
                        <div class="col-6 bg-dark text-white text-center border border-white">
                            {{ $count['Non LWD'] ?? 0 }}
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row gy-2">
                        <div class="col-6 text-uppercase fw-bolder">LWD</div>
                        <div class="col-6 bg-dark text-white text-center border border-white">
                            {{ $count['LWD'] ?? 0 }}
                        </div>
                        <div class="col-6 text-uppercase fw-bolder">Fatal</div>
                        <div class="col-6 bg-dark text-white text-center border border-white">
                            {{ $count['Fatal'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>