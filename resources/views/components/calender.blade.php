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

    .legend-color-box {
        width: 16px;
        height: 16px;
        border-radius: 4px;
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
        null, null, null, 31, null, null, null,
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
        @endphp

        @foreach ($gridOrder as $label)
        @if (is_null($label))
        <div></div>
        @else
        @php
        $tanggal = $tanggalByLabel[$label];
        $baseClass = 'rounded text-center p-2 small transition-all fw-semibold d-flex flex-column justify-content-center
        align-items-center';
        $timeBgClass = match($tanggal['status']) {
        'today' => 'bg-light border border-3 border-dark shadow position-relative text-dark',
        'past' => 'bg-opacity-75 text-white',
        'future' => 'bg-light text-muted border',
        };
        $incidentBgClass = $tanggal['bg'] ?? 'bg-light';
        @endphp

        <div class="{{ $baseClass }} {{ $incidentBgClass }} {{ $timeBgClass }} position-relative {{ !empty($tanggal['categoryBadge']) ? 'clickable-day' : '' }}"
            data-date="{{ $tanggal['tanggal'] }}">
            @if (!empty($tanggal['pica']))
            <a href="{{ route('pica', ['day' => $tanggal['tanggal']]) }}"
                class="stretched-link text-decoration-none text-reset"></a>
            @endif

            @if (!empty($tanggal['categoryBadge']) && is_array($tanggal['categoryBadge']))
            <div class="position-absolute top-0 start-0 d-flex flex-column align-items-start p-1 gap-1"
                style="z-index: 3;">
                @foreach ($tanggal['categoryBadge'] as $badge)
                <span class="badge bg-dark {{ $badge['color'] }}" style="font-size: 0.6rem;">
                    <i class="{{ $badge['icon'] }}"></i>
                </span>
                @endforeach
            </div>
            @endif

            <div class="fs-5">{{ $tanggal['label'] }}</div>

            @if ($tanggal['status'] === 'today')
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark"
                style="font-size: 0.6rem; z-index: 10;">
                Today
            </span>
            @endif
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
            <h5 class="fw-bolder">Legend</h5>
        </div>
        <div class="col-9">
            <div class="row row-cols-3 g-2 justify-content-center mb-3">
                @foreach ($legendDay as $day)
                <div class="col">
                    <div class="card shadow-sm rounded-4 p-2">
                        <div class="d-flex justify-content-between align-items-center small px-2">
                            <span>{{ $day['label'] }}</span>
                            <span class="rounded-circle {{ $day['color'] }}" style="width: 14px; height: 14px;"></span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <hr>

            <div class="row row-cols-3 g-2 justify-content-center">
                @foreach ($legendCategory as $cat)
                <div class="col">
                    <div class="card shadow-sm rounded-4 p-2">
                        <div class="d-flex justify-content-between align-items-center small px-2">
                            <span>{{ $cat['label'] }}</span>
                            <i class="{{ $cat['icon'] }}"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>