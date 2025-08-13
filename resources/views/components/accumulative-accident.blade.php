@props([
'icon',
'title',
'months',
'accumulativeAccident',
'chartId'
])

<div class="col-lg-12">
    <div class="card shadow-sm" style="border: 1px solid #FB4141">
        <div class="card-header py-3 border-bottom" style="background-color: #FB4141;">
            <div class="d-flex flex-column align-items-start">
                <div class="d-flex align-items-center">
                    <i class="{{ $icon }} fs-4 me-2 text-white me-3"></i>
                    <h5 class="mb-0 fw-bold text-white">{{ $title }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive" id="table-responsive-{{ $chartId }}" style="overflow-x:auto;"
                style="overflow-x:auto;">
                <table class="table table-sm table-bordered table-striped mb-4"
                    style="font-size: 12px; min-width: 800px;">
                    @php
                    $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Agt','Sep','Oct','Nov','Dec'];
                    $bulanSekarang = strtolower(now()->locale('id')->translatedFormat('M'));
                    @endphp
                    <thead class="table-danger">
                        <tr>
                            <th style="position: sticky; left: 0; z-index: 2;">Accident</th>
                            @foreach ($months as $month)
                            <th @if(strtolower($month)===$bulanSekarang) data-bulan-ini="true" @endif>{{ $month }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($accumulativeAccident as $accident => $info)
                        <tr>
                            <td style="position: sticky; left: 0; background: #fff; z-index: 1;">{{ $accident }}</td>
                            @foreach ($info['data'] as $count)
                            <td class="text-center">{{ $count }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <canvas id="{{ $chartId }}" height="90"></canvas>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('{{ $chartId }}').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [
                    @foreach ($accumulativeAccident as $accident => $info)
                        {
                            label: '{{ $accident }}',
                            data: @json($info['data']),
                            borderColor: '{{ $info['color'] }}',
                            backgroundColor: 'transparent',
                            tension: 0.4
                        },
                    @endforeach
                ]
            },
           options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            },
                            stepSize: 1, 
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                    },
                },
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        const container = document.getElementById("table-responsive-{{ $chartId }}");
        const bulanIni = container.querySelector('thead th[data-bulan-ini="true"]');

        if (container && bulanIni) {
            const containerRect = container.getBoundingClientRect();
            const bulanRect = bulanIni.getBoundingClientRect();
            const jarakKeKiri = bulanRect.left - containerRect.left;

            container.scrollLeft = jarakKeKiri - (container.clientWidth / 2) + (bulanIni.clientWidth / 2);
        }
    }, 300);
});
</script>
@endpush