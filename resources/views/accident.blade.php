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
                                <th>PICA</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($incidents as $incident)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $incident->accident->accident }}</td>
                                <td>{{ $incident->category->category }}</td>
                                <td>{{ $incident->date }}</td>
                                <td>
                                    <button class="badge bg-success border-0" data-bs-toggle="modal"
                                        data-bs-target="#picaAccidentModal{{ $incident->id }}">Lihat Pica</button>
                                </td>
                                <td>
                                    <button class="badge bg-warning border-0" data-bs-toggle="modal"
                                        data-bs-target="#editAccidentModal{{ $incident->id }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="badge bg-danger border-0" data-bs-toggle="modal"
                                        data-bs-target="#deleteAccidentModal{{ $incident->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <button class="badge bg-info border-0" data-bs-toggle="modal"
                                        data-bs-target="#picaModal{{ $incident->id }}">
                                        <i class="fa-solid fa-info"></i>
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
                                <option value="{{ $accident->id }}">{{ $accident->accident }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Category</label>
                            <select name="category" class="form-select" id="category" required>
                                <option disabled selected>-- Choose Category --</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
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
                                <option value="{{ $accident->id }}" {{ $incident->accident == $accident->accident
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
                                <option value="{{ $category->id }}" {{ $incident->category == $category->category
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

    <div class="modal fade" id="picaModal{{ $incident->id }}" tabindex="-1"
        aria-labelledby="picaModalLabel{{ $incident->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-sm border-0">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="picaModalLabel{{ $incident->id }}">
                        PICA
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form action="{{ route('pica-post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="incident_id" value="{{ $incident->id }}">
                        <div id="image-container">
                            <div class="mb-3 image-input">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="images[]" class="form-control" required multiple>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            Save
                        </button>
                        <input type="hidden" name="incident_id" value="{{ $incident->id }}">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="picaAccidentModal{{ $incident->id }}" tabindex="-1"
        aria-labelledby="picaAccidentModalLabel{{ $incident->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title text-white" id="picaAccidentModalLabel{{ $incident->id }}">
                        PICA
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if ($incident->pica && $incident->pica->image->count())
                <div class="p-3">
                    <div id="carouselPica{{ $incident->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($incident->pica->image as $key => $img)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $img->image) }}" class="d-block w-100 rounded"
                                    style="max-height: 400px; object-fit: contain;" alt="Pica Image {{ $key + 1 }}">
                            </div>
                            @endforeach
                        </div>

                        @if ($incident->pica->image->count() > 1)
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselPica{{ $incident->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark " aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselPica{{ $incident->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        @endif
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

    @endforeach

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