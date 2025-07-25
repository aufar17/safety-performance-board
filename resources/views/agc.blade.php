<!--
=========================================================
* Soft UI Dashboard - v1.0.3
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================
    
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<x-head></x-head>
<style>
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 0.5rem;
        padding: 10px 15px;
        margin-right: 15px;
        margin-top: 15px;
        font-size: 12px;
        border: 1px solid #dee2e6;
    }

    .dataTables_wrapper .dataTables_length select {
        border-radius: 0.5rem;
        padding: 10px 30px;
        font-size: 12px;
        margin-top: 15px;

    }
</style>

<body class="g-sidenav-show  bg-gray-100">
    <x-sidebar></x-sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <x-navbar title="AGC Level" breadcumb="AGC Level" :user="$user" />
        <div class="container-fluid p-5">
            <x-card title="{{ $month }} {{ $year }} AGC Level" icon="fa-solid fa-turn-up">
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newAgcModal">
                    New Data
                </button>
                <div class="row mb-3 align-items-end">
                    <div class="col-sm-2">
                        <label for="filterMonthYear" class="form-label">PERIODE</label>
                        <form action="{{ route('agc') }}" method="GET">
                            <input type="month" name="filterMonthYear"
                                value="{{ request('filterMonthYear',  now()->format('Y-m')), }}"
                                class="form-control form-control-sm" onchange="this.form.submit()">
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="agc" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category</th>
                                <th>FR</th>
                                <th>SR</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($agcLevels as $agc)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $agc->agc->category }}</td>
                                <td>{{ $agc->fr }}</td>
                                <td>{{ $agc->sr }}</td>
                                <td>{{ $agc->date }}</td>
                                <td>
                                    <button class="badge bg-warning border-0" data-bs-toggle="modal"
                                        data-bs-target="#editAgcModal{{ $agc->id }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="badge bg-danger border-0" data-bs-toggle="modal"
                                        data-bs-target="#deleteAgcModal{{ $agc->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </main>
    @foreach ($agcLevels as $agc)
    <div class="modal fade" id="editAgcModal{{ $agc->id }}" tabindex="-1"
        aria-labelledby="editAgcModalLabel{{ $agc->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="editAgcModalLabel">Edit Data FR & SR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('agc-update') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" value="{{ $agc->date }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="accident_hours" class="form-label">Total Accident Hours (Without LTI)</label>
                            <input type="number" class="form-control" name="accident_hours"
                                value="{{ $agc->accident_hours }}" required>
                        </div>

                        <div class="separator my-3 d-flex align-items-center text-muted">
                            <hr class="flex-grow-1">
                            <span class="px-3 small fw-bolder text-dark text-uppercase">Frequency Rate (FR)</span>
                            <hr class="flex-grow-1">
                        </div>

                        <div class="mb-3">
                            <label for="total_accident" class="form-label">Total Accident</label>
                            <input type="number" class="form-control" id="total_accident"
                                value="{{ $agc->total_accident }}" name="total_accident" required>
                        </div>
                        <div class="mb-3">
                            <label for="fr" class="form-label">FR</label>
                            <input id="fr" type="number" class="form-control" name="fr" value="{{ $agc->fr }}" readonly>
                        </div>

                        <div class="separator my-3 d-flex align-items-center text-muted">
                            <hr class="flex-grow-1">
                            <span class="px-3 small fw-bolder text-dark text-uppercase">Severity Rate (SR)</span>
                            <hr class="flex-grow-1">
                        </div>
                        <div class="mb-3">
                            <label for="loss_day" class="form-label">Loss Day</label>
                            <input type="number" class="form-control" id="loss_day" name="loss_day"
                                value="{{ $agc->loss_day }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="sr" class="form-label">SR</label>
                            <input type="number" id="sr" class="form-control" name="sr" value="{{ $agc->sr }}" readonly>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary px-4"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Save</button>
                            <input type="hidden" name="id" value="{{ $agc->id }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteAgcModal{{ $agc->id }}" tabindex="-1"
        aria-labelledby="deleteAgcModalLabel{{ $agc->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title text-white" id="deleteAgcModalLabel{{ $agc->id }}">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('agc-delete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $agc->id }}">
                    <div class="modal-body py-4">
                        <div class="text-center">
                            <i class="fa-solid fa-circle-exclamation text-danger fs-1 mb-3"></i>
                            <p class="fw-semibold text-secondary mb-0">
                                Are you sure you want to delete this data?
                            </p>
                            <small class="text-muted">This action cannot be undone.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="fa-solid fa-trash me-1"></i> Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endforeach

    <div class="modal fade" id="newAgcModal" tabindex="-1" aria-labelledby="newAgcModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="newAgcModalLabel">New Data Accident</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('agc-post') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" required>
                        </div>


                        <div class="mb-3">
                            <label for="accident_hours" class="form-label">Total Accident Hours (Without LTI)</label>
                            <input type="number" class="form-control" name="accident_hours" required>
                        </div>

                        <div class="separator my-3 d-flex align-items-center text-muted">
                            <hr class="flex-grow-1">
                            <span class="px-3 small fw-bolder text-dark text-uppercase">Frequency Rate (FR)</span>
                            <hr class="flex-grow-1">
                        </div>

                        <div class="mb-3">
                            <label for="total_accident" class="form-label">Total Accident</label>
                            <input type="number" class="form-control" id="total_accident" name="total_accident"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="fr" class="form-label">FR</label>
                            <input id="fr" type="number" class="form-control" name="fr" readonly>
                        </div>

                        <div class="separator my-3 d-flex align-items-center text-muted">
                            <hr class="flex-grow-1">
                            <span class="px-3 small fw-bolder text-dark text-uppercase">Severity Rate (SR)</span>
                            <hr class="flex-grow-1">
                        </div>
                        <div class="mb-3">
                            <label for="loss_day" class="form-label">Loss Day</label>
                            <input type="number" class="form-control" id="loss_day" name="loss_day" required>
                        </div>
                        <div class="mb-3">
                            <label for="sr" class="form-label">SR</label>
                            <input type="number" id="sr" class="form-control" name="sr" readonly>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary px-4"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <x-script></x-script>

        <script>
            $(document).ready(function () {
        $('#agc').DataTable({
            responsive: true,
            lengthChange: true,
            pageLength: 10,
            language: {
                search: " _INPUT_", searchPlaceholder: "Search data" , paginate: { previous: "<" , next: ">" } } });
                        }); 
        </script>

        <script>
            function calculateFR(el) {
        const container = el.closest('form');
        const totalAccident = parseFloat(container.querySelector('[name="total_accident"]').value) || 0;
        const accidentHours = parseFloat(container.querySelector('[name="accident_hours"]').value) || 0;

        const fr = (accidentHours > 0) ? (totalAccident / accidentHours) * 1000000 : 0;
        container.querySelector('[name="fr"]').value = fr.toFixed(2);
    }

    function calculateSR(el) {
        const container = el.closest('form');
        const lossDay = parseFloat(container.querySelector('[name="loss_day"]').value) || 0;
        const accidentHours = parseFloat(container.querySelector('[name="accident_hours"]').value) || 0;

        const sr = (accidentHours > 0) ? (lossDay / accidentHours) * 1000000 : 0;
        container.querySelector('[name="sr"]').value = sr.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[name="total_accident"], [name="accident_hours"]').forEach(input => {
            input.addEventListener('input', function () {
                calculateFR(this);
            });
        });

        document.querySelectorAll('[name="loss_day"], [name="accident_hours"]').forEach(input => {
            input.addEventListener('input', function () {
                calculateSR(this);
            });
        });
    });
        </script>


</body>

</html>