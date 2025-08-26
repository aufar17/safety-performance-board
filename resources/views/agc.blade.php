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
        padding: 10px 40px;
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

                            <div class="modal fade" id="editAgcModal{{ $agc->id }}" tabindex="-1"
                                aria-labelledby="editAgcModalLabel{{ $agc->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h5 class="modal-title" id="editAgcModalLabel{{ $agc->id }}">Edit Data
                                                Statistic K3 & AGC
                                                Level</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('agc-update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $agc->id }}">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-md-5">
                                                        <div
                                                            class="separator my-3 d-flex align-items-center text-muted">
                                                            <hr class="flex-grow-1">
                                                            <span
                                                                class="px-3 small fw-bolder text-dark text-uppercase">Information
                                                                Statistic K3</span>
                                                            <hr class="flex-grow-1">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="accident_days_{{ $agc->id }}"
                                                                class="form-label">Accident Hours Without LTI
                                                                (Days)</label>
                                                            <input type="number" class="form-control"
                                                                id="accident_days_{{ $agc->id }}" name="accident_days"
                                                                value="{{ $sinceLwd }}" readonly required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="man_power_{{ $agc->id }}"
                                                                class="form-label">Total Man Power</label>
                                                            <input type="number" class="form-control"
                                                                id="man_power_{{ $agc->id }}" name="man_power"
                                                                value="{{ $agc->man_power }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="accident_hours_{{ $agc->id }}"
                                                                class="form-label">Accident Hours Without LTI
                                                                (Hours)</label>
                                                            <input type="number" class="form-control"
                                                                id="accident_hours_{{ $agc->id }}" name="accident_hours"
                                                                value="{{ $agc->accident_hours }}" readonly required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1 d-flex justify-content-center">
                                                        <div class="vr"></div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div
                                                            class="separator my-3 d-flex align-items-center text-muted">
                                                            <hr class="flex-grow-1">
                                                            <span
                                                                class="px-3 small fw-bolder text-dark text-uppercase">AGC
                                                                Level</span>
                                                            <hr class="flex-grow-1">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="total_accident_{{ $agc->id }}"
                                                                class="form-label">Total Accident</label>
                                                            <input type="number" class="form-control"
                                                                id="total_accident_{{ $agc->id }}" name="total_accident"
                                                                value="{{ $agc->total_accident }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="work_hours_fr_{{ $agc->id }}"
                                                                class="form-label">Total Work Hours</label>
                                                            <input type="number" class="form-control"
                                                                id="work_hours_fr_{{ $agc->id }}" name="work_hours_fr"
                                                                value="{{ $agc->work_hours }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="fr_{{ $agc->id }}" class="form-label">FR</label>
                                                            <input type="number" class="form-control"
                                                                id="fr_{{ $agc->id }}" name="fr" value="{{ $agc->fr }}"
                                                                readonly>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="loss_day_{{ $agc->id }}" class="form-label">Loss
                                                                Day</label>
                                                            <input type="number" class="form-control"
                                                                id="loss_day_{{ $agc->id }}" name="loss_day"
                                                                value="{{ $agc->loss_day }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="work_hours_sr_{{ $agc->id }}"
                                                                class="form-label">Total Work Hours</label>
                                                            <input type="number" class="form-control"
                                                                id="work_hours_sr_{{ $agc->id }}" name="work_hours_sr"
                                                                value="{{ $agc->work_hours }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="sr_{{ $agc->id }}" class="form-label">SR</label>
                                                            <input type="number" class="form-control"
                                                                id="sr_{{ $agc->id }}" name="sr" value="{{ $agc->sr }}"
                                                                readonly>
                                                        </div>
                                                    </div>
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
                            </div>


                            <div class="modal fade" id="deleteAgcModal{{ $agc->id }}" tabindex="-1"
                                aria-labelledby="deleteAgcModalLabel{{ $agc->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow-lg border-0 rounded-4">
                                        <div class="modal-header bg-danger text-white rounded-top-4">
                                            <h5 class="modal-title text-white" id="deleteAgcModalLabel{{ $agc->id }}">
                                                <i class="fa-solid fa-triangle-exclamation me-2"></i> Confirm Deletion
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
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
                                                <button type="button" class="btn btn-outline-secondary px-4"
                                                    data-bs-dismiss="modal">
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
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </main>

    <div class="modal fade" id="newAgcModal" tabindex="-1" aria-labelledby="newAgcModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="newAgcModalLabel">New Data Statistic K3 & AGC Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="newAgcForm" action="{{ route('agc-post') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-5">
                                <div class="separator my-3 d-flex align-items-center text-muted">
                                    <hr class="flex-grow-1">
                                    <span class="px-3 small fw-bolder text-dark text-uppercase">Information
                                        Statistic K3</span>
                                    <hr class="flex-grow-1">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Accident Days</label>
                                    <input type="number" class="form-control" id="new_accident_days"
                                        value="{{ $sinceLwd }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Total Man Power</label>
                                    <input type="number" class="form-control" id="new_man_power" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Accident Hours</label>
                                    <input type="number" class="form-control" id="new_accident_hours" readonly>
                                </div>
                            </div>

                            <div class="col-md-1 d-flex justify-content-center">
                                <div class="vr"></div>
                            </div>

                            <div class="col-md-5">
                                <div class="separator my-3 d-flex align-items-center text-muted">
                                    <hr class="flex-grow-1">
                                    <span class="px-3 small fw-bolder text-dark text-uppercase">AGC
                                        Level</span>
                                    <hr class="flex-grow-1">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Total Accident</label>
                                    <input type="number" class="form-control" id="new_total_accident" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Total Work Hours (FR)</label>
                                    <input type="number" class="form-control" id="new_work_hours_fr" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">FR</label>
                                    <input type="number" class="form-control" id="new_fr" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Loss Day</label>
                                    <input type="number" class="form-control" id="new_loss_day" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Total Work Hours (SR)</label>
                                    <input type="number" class="form-control" id="new_work_hours_sr" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">SR</label>
                                    <input type="number" class="form-control" id="new_sr" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
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
        document.addEventListener("DOMContentLoaded", function () {
            // === Accident Hours (New) ===
            const manPowerNew = document.getElementById("new_man_power");
            const accidentDaysNew = document.getElementById("new_accident_days");
            const accidentHoursNew = document.getElementById("new_accident_hours");

            function calcAccidentHoursNew() {
                const manpower = parseInt(manPowerNew.value) || 0;
                const days = parseInt(accidentDaysNew.value) || 0;
                accidentHoursNew.value = manpower * 8 * days;
            }
            manPowerNew.addEventListener("input", calcAccidentHoursNew);
            calcAccidentHoursNew();

            // === FR (New) ===
            const totalAccidentNew = document.getElementById("new_total_accident");
            const workHoursFrNew = document.getElementById("new_work_hours_fr");
            const frNew = document.getElementById("new_fr");

            function calcFrNew() {
                const ta = parseFloat(totalAccidentNew.value) || 0;
                const wh = parseFloat(workHoursFrNew.value) || 0;
                frNew.value = (wh > 0) ? ((ta / wh) * 1000000).toFixed(2) : 0;
            }
            totalAccidentNew.addEventListener("input", calcFrNew);
            workHoursFrNew.addEventListener("input", calcFrNew);

            // === SR (New) ===
            const lossDayNew = document.getElementById("new_loss_day");
            const workHoursSrNew = document.getElementById("new_work_hours_sr");
            const srNew = document.getElementById("new_sr");

            function calcSrNew() {
                const ld = parseFloat(lossDayNew.value) || 0;
                const wh = parseFloat(workHoursSrNew.value) || 0;
                srNew.value = (wh > 0) ? ((ld / wh) * 1000000).toFixed(2) : 0;
            }
            lossDayNew.addEventListener("input", calcSrNew);
            workHoursSrNew.addEventListener("input", calcSrNew);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('[id^="editAgcModal"]').forEach(modal => {
                const id = modal.id.replace("editAgcModal", "");

                const manpowerInput = modal.querySelector(`#man_power_${id}`);
                const accidentDays = modal.querySelector(`#accident_days_${id}`);
                const accidentHours = modal.querySelector(`#accident_hours_${id}`);

                function calculateAccidentHours() {
                    const manpower = parseInt(manpowerInput.value) || 0;
                    const days = parseInt(accidentDays.value) || 0;
                    accidentHours.value = manpower * 8 * days;
                }
                manpowerInput.addEventListener("input", calculateAccidentHours);

                // FR
                const totalAccident = modal.querySelector(`#total_accident_${id}`);
                const workHoursFR = modal.querySelector(`#work_hours_fr_${id}`);
                const frInput = modal.querySelector(`#fr_${id}`);

                function calculateFR() {
                    const total = parseFloat(totalAccident.value) || 0;
                    const hours = parseFloat(workHoursFR.value) || 0;
                    frInput.value = hours > 0 ? ((total / hours) * 1000000).toFixed(2) : 0;
                }
                totalAccident.addEventListener("input", calculateFR);
                workHoursFR.addEventListener("input", calculateFR);

                // SR
                const lossDay = modal.querySelector(`#loss_day_${id}`);
                const workHoursSR = modal.querySelector(`#work_hours_sr_${id}`);
                const srInput = modal.querySelector(`#sr_${id}`);

                function calculateSR() {
                    const loss = parseFloat(lossDay.value) || 0;
                    const hours = parseFloat(workHoursSR.value) || 0;
                    srInput.value = hours > 0 ? ((loss / hours) * 1000000).toFixed(2) : 0;
                }
                lossDay.addEventListener("input", calculateSR);
                workHoursSR.addEventListener("input", calculateSR);

                // Trigger awal biar value langsung terhitung
                calculateAccidentHours();
                calculateFR();
                calculateSR();
            });
        });
    </script>

</body>

</html>