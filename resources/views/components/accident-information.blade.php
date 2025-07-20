@props([
'title',
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

<div class="col-12">
    <div class="card shadow-sm border-0 rounded-4 h-100">
        <div class="card-body">
            <h5 class="card-title fw-bold text-white text-uppercase text-center bg-danger">
                {{ $title }}
            </h5>

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
</div>