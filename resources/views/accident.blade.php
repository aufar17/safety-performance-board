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
        <x-navbar title="Accident" breadcumb="Accident" :user="$user" />
        <div class="container-fluid p-5">
            <x-card title="{{ $now }} Accident" icon="fa-solid fa-person-falling">
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newAccidentModal">
                    New Accident
                </button>

                <div class="table-responsive">
                    <table id="accident" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Accident</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($incidents as $incident)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $incident->accident }}</td>
                                <td>{{ $incident->category }}</td>
                                <td>{{ $incident->date }}</td>
                                <td>
                                    <button class="badge bg-warning border-0" data-bs-toggle="modal"
                                        data-bs-target="#editAccidentModal{{ $incident->id }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="badge bg-danger border-0" data-bs-toggle="modal"
                                        data-bs-target="#deleteAccidentModal{{ $incident->id }}">
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
    <x-sidebar-plugin></x-sidebar-plugin>

    @foreach ($incidents as $incident)
    <div class="modal fade" id="editAccidentModal{{ $incident->id }}" tabindex="-1"
        aria-labelledby="editAccidentModalLabel{{ $incident->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="editAccidentModalLabel">Edit Data Accident</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('accident-update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $incident->id }}">

                        <div class="mb-3">
                            <label for="accident" class="form-label">Accident</label>
                            <select name="accident" class="form-select" required>
                                <option disabled>-- Choose Accident --</option>
                                @foreach ($accidents as $accident)
                                <option value="{{ $accident->accident }}" {{ $incident->accident == $accident->accident
                                    ? 'selected' : '' }}>
                                    {{ $accident->accident }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option disabled>-- Choose Category --</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->category }}" {{ $incident->category == $category->category
                                    ? 'selected' : '' }}>
                                    {{ $category->category }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" value="{{ $incident->date }}" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                                Cancel
                            </button> <button type="submit" class="btn btn-warning">Save</button>
                            <input type="hidden" name="id" value="{{ $incident->id }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteAccidentModal{{ $incident->id }}" tabindex="-1"
        aria-labelledby="deleteAccidentModalLabel{{ $incident->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title text-white" id="deleteAccidentModalLabel{{ $incident->id }}">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('accident-delete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $incident->id }}">
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

    <div class="modal fade" id="newAccidentModal" tabindex="-1" aria-labelledby="newAccidentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="newAccidentModalLabel">New Data Accident</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('accident-post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Accident</label>
                            <select name="accident" class="form-select" id="accident" required>
                                <option disabled selected>-- Choose Accident --</option>
                                @foreach ($accidents as $accident)
                                <option value="{{ $accident->accident }}">{{ $accident->accident }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Category</label>
                            <select name="category" class="form-select" id="category" required>
                                <option disabled selected>-- Choose Category --</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->category }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" placeholder="Accident Date"
                                required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        Cancel
                    </button> <button type="submit" class="btn btn-success">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <x-script></x-script>

    <script>
        $(document).ready(function () {
        $('#accident').DataTable({
            responsive: true,
            lengthChange: true,
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search data",
                paginate: {
                    previous: "<",
                    next: ">"
                }
            }
        });
    });
    </script>

</body>

</html>