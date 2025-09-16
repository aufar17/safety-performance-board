@props([
    'title',
    'icon',
    'bulan',
    'tanggalList',
    'days',
    'offsetHariPertama'
])

<style>
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 4.0625rem);
        grid-template-rows: repeat(7, 4.0625rem);
        gap: 10px;
    }

    .calendar-cell {
        background: green;
        color: white;
        text-align: center;
        padding: 1rem;
        font-weight: bold;
        border: 2px solid black;
    }

    .calendar-grid>div {
        height: 4.0625rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .highlight-col {
        border-left: 3px solid #000;
        border-right: 3px solid #000;
    }

    .highlight-row {
        border-top: 3px solid #000;
        border-bottom: 3px solid #000;
    }

    .transition-all {
        transition: all 0.2s ease-in-out;
    }

    .transition-all:hover {
        transform: scale(1.1);
        z-index: 2;
        cursor: pointer;
    }

    /* Legend styling */
    .legend-color-box {
        width: 24px; /* lebih besar */
        height: 24px;
        border-radius: 6px;
    }
    .legend-icon {
        font-size: 1.8rem; /* icon lebih besar */
    }
    .legend-label {
        font-size: 1rem;
        font-weight: 600;
    }

    /* Sinkronisasi warna legend dengan warna kalender */
    .legend-color-box.bg-success {
        background-color: #198754 !important; /* Hijau bootstrap (safe, work) */
    }
    .legend-color-box.bg-warning {
        background-color: #ffc107 !important; /* Kuning bootstrap (accident, traffic) */
    }
    .legend-color-box.bg-danger {
        background-color: #dc3545 !important; /* Merah bootstrap (fatal, fire) */
    }

    /* Supaya icon legend konsisten dengan palet bootstrap */
    .fa-notes-medical.text-success {
        color: #198754 !important;
    }
    .fa-triangle-exclamation.text-warning {
        color: #ffc107 !important;
    }
    .fa-fire.text-danger {
        color: #dc3545 !important;
    }
</style>

<div class="container py-4 d-flex justify-content-center">
    @php
    use Carbon\Carbon;

    $tanggalByLabel = collect($tanggalList)->keyBy('label');
    $jumlahHari = $tanggalList[count($tanggalList) - 1]['label'];
    $offsetHariPertama = $offsetHariPertama ?? 0;
    $totalGrid = ceil(($jumlahHari + $offsetHariPertama) / 7) * 7;
    @endphp

    <div class="calendar-grid">
        @php
        $tanggalByLabel = collect($tanggalList)->keyBy('label');
        $jumlahHari = count($tanggalList);

        $gridOrder31 = [
            null, null, 1, 2, 3, null, null,
            null, null, 4, 5, 6, null, null,
            7, 8, 9, 10, 11, 12, 13,
            14, 15, 16, 17, 18, 19, 20,
            21, 22, 23, 24, 25, 26, 27,
            null, null, 28, 29, 30, null, null,
            null, null, ' ', 31, ' ', null, null,
        ];

        $gridOrder30 = $gridOrder31;
        $gridOrder30[array_search(31, $gridOrder30)] = null;

        $gridOrder28 = $gridOrder30;
        $gridOrder28[array_search(30, $gridOrder28)] = null;
        $gridOrder28[array_search(29, $gridOrder28)] = null;

        $gridOrder = match($jumlahHari) {
            28 => $gridOrder28,
            30 => $gridOrder30,
            default => $gridOrder31
        };

        $baseClass = 'rounded text-center p-2 small transition-all fw-semibold d-flex flex-column
            justify-content-center
            align-items-center';
        @endphp

        @foreach ($gridOrder as $label)
            @if (is_null($label))
                <div></div>
            @elseif (is_numeric($label))
                @php
                $tanggal = $tanggalByLabel[$label];
                $timeBgClass = $tanggal['status'] === 'today'
                    ? 'bg-light border border-3 border-dark shadow position-relative text-dark'
                    : ($tanggal['status'] === 'past'
                        ? 'bg-opacity-75 text-white'
                        : 'bg-secondary text-dark border');
                $incidentBgClass = $tanggal['bg'] ?? '#727D73';
                @endphp

                <div class="{{ $baseClass }} {{ $timeBgClass }} position-relative {{ !empty($tanggal['categoryBadge']) ? 'clickable-day' : '' }}"
                    data-date="{{ $tanggal['tanggal'] }}" style="background-color:{{ $incidentBgClass }}">

                    @if (!empty($tanggal['pica']))
                        <a href="{{ route('pica', ['day' => $tanggal['tanggal']]) }}"
                            class="stretched-link text-decoration-none text-reset"></a>
                    @endif

                    @if (!empty($tanggal['categoryBadge']) && is_array($tanggal['categoryBadge']))
                        <div class="position-absolute top-0 start-0 d-flex flex-column align-items-start p-1 gap-1"
                            style="z-index: 3;">
                            @foreach ($tanggal['categoryBadge'] as $badge)
                                <span class="badge {{ $badge['color'] }}" style="font-size: 1rem;">
                                    <i class="{{ $badge['icon'] }}"></i>
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="fs-5">{{ $tanggal['label'] }}</div>

                    @if ($tanggal['status'] === 'today')
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark"
                            style="font-size: 0.8rem; z-index: 10;">
                            Today
                        </span>
                    @endif
                </div>
            @else
                <div class="{{ $baseClass }} bg-secondary text-dark border">
                    {{ $label }}
                </div>
            @endif
        @endforeach
    </div>
</div>

@php
$legendDay = [
    1 => ['color' => 'bg-success', 'label' => 'Safe'],
    2 => ['color' => 'bg-warning', 'label' => 'Accident'],
    3 => ['color' => 'bg-danger', 'label' => 'Fatal'],
];

$legendCategory = [
    1 => ['icon' => 'fa-solid fa-notes-medical text-success', 'label' => 'Work'],
    2 => ['icon' => 'fa-solid fa-fire text-danger', 'label' => 'Fire'],
    3 => ['icon' => 'fa-solid fa-triangle-exclamation text-warning', 'label' => 'Traffic'],
];
@endphp

<div class="container mt-5">
    <div class="row">
        <div class="col-3 d-flex align-items-center justify-content-center">
            <h5 class="fw-bolder">LEGEND</h5>
        </div>
        <div class="col-9">
            <!-- Legend Day -->
            <div class="row row-cols-3 g-2 justify-content-center mb-3">
                @foreach ($legendDay as $day)
                    <div class="col">
                        <div class="card shadow-sm rounded-4 p-3">
                            <div class="d-flex justify-content-between align-items-center legend-label">
                                <span>{{ $day['label'] }}</span>
                                <span class="legend-color-box {{ $day['color'] }}"></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr>

            <!-- Legend Category -->
            <div class="row row-cols-3 g-2 justify-content-center">
                @foreach ($legendCategory as $cat)
                    <div class="col">
                        <div class="card shadow-sm rounded-4 p-3">
                            <div class="d-flex justify-content-between align-items-center legend-label">
                                <span>{{ $cat['label'] }}</span>
                                <i class="{{ $cat['icon'] }} legend-icon"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
