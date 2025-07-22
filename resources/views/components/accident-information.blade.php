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

<div class="card shadow-sm rounded ">
    <div class="card-header py-3 bg-danger border-bottom">
        <div class="d-flex flex-column align-items-start">
            <div class="d-flex align-items-center">
                <i class="{{ $icon }} fs-4 me-2 text-white me-3"></i>
                <h5 class="mb-0 fw-bold text-white">{{ $title }}
                </h5>
            </div>
        </div>
    </div>
    <div class="card-body pt-2 pb-4">
        <div class="row mx-0">
            <div class="col-8 py-1" style="background-color:#347433;">
                <span class="text-white text-uppercase fw-bolder">Total Kejadian</span>
            </div>
            <div class="col-4 bg-dark text-center py-1">
                <span class="text-white">{{ $total }}</span>
            </div>
        </div>

        <div class="row mx-0">
            <div class="col-6">
                <div class="row">
                    <div class="col-6 text-uppercase fw-bolder">First Aid</div>
                    <div class="col-6 bg-dark text-white text-center border border-white">
                        {{ $count['First Aid'] ?? 0 }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 text-uppercase fw-bolder">Non LWD</div>
                    <div class="col-6 bg-dark text-white text-center border border-white">
                        {{ $count['Non LWD'] ?? 0 }}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-6 text-uppercase fw-bolder">LWD</div>
                    <div class="col-6 bg-dark text-white text-center border border-white">
                        {{ $count['LWD'] ?? 0 }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 text-uppercase fw-bolder">Fatal</div>
                    <div class="col-6 bg-dark text-white text-center border border-white">
                        {{ $count['Fatal'] ?? 0 }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>