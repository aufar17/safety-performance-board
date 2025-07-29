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
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
    }

    .calendar-day {
        height: 100px;
        min-height: 100px;
        max-height: 100px;
        width: 100%;
    }


    .calendar-grid>div {
        min-height: 80px;
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

<div class="container py-4">
    <div class="d-grid calendar-grid" style="grid-template-columns: repeat(7, 1fr);">
        @foreach ($days as $hari)
        <div class="text-center fw-bold text-uppercase small py-1">{{ $hari }}</div>
        @endforeach

        @for ($i = 1; $i < $offsetHariPertama; $i++) <div>
    </div>
    @endfor

    @foreach ($tanggalList as $tanggal)
    @php
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
            class="stretched-link text-decoration-none text-reset">
        </a>
        @endif


        @if (!empty($tanggal['categoryBadge']) && is_array($tanggal['categoryBadge']))
        <div class="position-absolute top-0 start-0 d-flex flex-column align-items-start p-1 gap-1" style="z-index: 3;">
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


    @endforeach
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