@props([
'icon',
'title',
'months',
'accumulativeAccident',
'chartId'
])

<div class="col-12">
    <div class="card shadow-sm rounded">
        <div class="card-header py-3 bg-danger border-bottom">
            <div class="d-flex flex-column align-items-start">
                <div class="d-flex align-items-center">
                    <i class="{{ $icon }} fs-4 me-2 text-white me-3"></i>
                    <h5 class="mb-0 fw-bold text-white">{{ $title }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive mb-1">
                <table class="table table-sm table-bordered table-striped mb-4" style="font-size: 12px;">
                    <thead class="table-danger">
                        <tr>
                            <th>Accident</th>
                            @foreach ($months as $month)
                            <th class="text-center">{{ $month }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accumulativeAccident as $accident => $info)
                        <tr>
                            <td>{{ $accident }}</td>
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
@endpush