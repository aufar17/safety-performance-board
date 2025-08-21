<!DOCTYPE html>
<html lang="en">
<x-head />

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2 sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center fw-bold text-danger fs-5 me-3"
                href="{{ route('monitoring') }}">
                <img src="{{ asset('img/logo.png') }}" alt="KYB" height="32" class="me-2" />
            </a>

            <div class="d-none d-lg-block position-absolute top-50 start-50 translate-middle">
                <a class="navbar-brand fw-bold text-danger fs-5" href="{{ route('issue') }}">
                    <i class="fas fa-check-circle me-2"></i> Issue
                </a>
            </div>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('monitoring') ? 'text-danger' : '' }}"
                            href="{{ route('monitoring') }}">
                            <i class="fas fa-tv me-1"></i> Monitoring
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h2 class="fw-bolder text-uppercase mb-0" style="letter-spacing: 2px">
                    Issue List
                </h2>
            </div>
            <div class="col-md-6 text-end">
                <form method="GET" action="">
                    <select name="date_start" class="form-select w-auto d-inline-block"
                        style="width: 180px;padding-right: 30px" onchange="this.form.submit()">
                        <option value="">📅 All Issues (Latest Week)</option>
                        @foreach ($availableDates as $date)
                        <option value="{{ $date }}" {{ $selectedDate==$date ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                        </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="accordion" id="issueAccordion">
            @forelse ($pica as $index => $item)
            <div class="accordion-item mb-3 shadow-sm">
                <h2 class="accordion-header" id="heading{{ $index }}">
                    <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $index }}" aria-expanded="false"
                        aria-controls="collapse{{ $index }}">
                        <div class="w-100 d-flex justify-content-between align-items-center">
                            <span class="fw-semibold text-dark">
                                🔹 {{ $item->title ?? 'Tanpa Judul' }}
                            </span>
                            <small class="text-black ms-3">
                                📅 {{ $item->date_start }}
                            </small>
                        </div>
                    </button>
                </h2>
                <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}"
                    data-bs-parent="#issueAccordion">
                    <div class="accordion-body bg-white">
                        @if ($item->image->count() > 0)
                        <div id="carouselIssue{{ $index }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner rounded">
                                @foreach ($item->image as $key => $img)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $img->image) }}" class="d-block w-100 rounded"
                                        alt="Slide {{ $key + 1 }}">
                                    <div class="carousel-caption d-none d-md-block">
                                        <span class="badge bg-dark">
                                            📷 {{ $key + 1 }} / {{ $item->image->count() }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            @if ($item->image->count() > 1)
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselIssue{{ $index }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselIssue{{ $index }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            @endif
                        </div>
                        @else
                        <div class="text-center mb-0">No issue image</div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-danger text-center fw-bold">
                No Issue to display.
            </div>
            @endforelse
        </div>
    </div>

    <x-script />
</body>

</html>