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

<body class="g-sidenav-show  bg-gray-100">
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <x-navbar-monitoring title="Dashboard" breadcumb="Dashboard"></x-navbar-monitoring>
        <div class="container-fluid py-4">
            <h2 class="text-center text-uppercase mt-0" style="letter-spacing: 2px;">Safety Performance Board</h2>
            <div class="row d-flex justify-content-between">
                <div class="col-md-12 col-lg-8 px-4">
                    <h4 class="text-uppercase fw-bolder" style="letter-spacing: 1px;">Update Tanggal <span
                            class="badge bg-dark">{{ $now }}</span>
                    </h4>
                    <h5 class="text-uppercase fw-bolder mt-4 " style="letter-spacing: 1px;"><span
                            class="badge bg-warning text-dark">Periode
                            Tahun :</span>
                        <span class="badge bg-dark">{{ $year }}</span>
                    </h5>
                </div>
                <div class="col-md-12 col-lg-4 text-center">
                    <h4 class="text-uppercase fw-bolder" style="letter-spacing: 1px;color:#347433;">Safety Calender</h4>
                    <h4 class="text-uppercase fw-bolder" style="letter-spacing: 1px;">Periode <span
                            class="badge bg-dark">{{ $month }}</span></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-4 px-4 ">
                    <h4 class="text-uppercase fw-bolder text-center bg-dark border-radius-sm"
                        style="letter-spacing: 1px;"><span class="text-white">Informasi
                            Kejadian</span>
                    </h4>
                </div>
                <div class="col-12 col-md-4 text-center">
                    <h4 class="text-uppercase fw-bolder text-center bg-dark border-radius-sm"
                        style="letter-spacing: 1px;"><span class="text-white">Monitoring Bulanan Total Akumulatif
                            Accident</span>
                        </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-4 px-4">
                    <div class="row g-4">
                        @foreach ($mappings as $mapping)
                        <x-accident-information :title="$mapping['accident']" :total="$mapping['total']"
                            :category="$mapping['categories']" />
                        @endforeach

                    </div>
                </div>

                <div class="col-md-12 col-lg-4 px-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="card shadow-sm border-0 rounded-4 h-100">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold text-primary">Judul Card 4</h5>
                                    <p class="card-text text-muted">Deskripsi card pertama di kolom tengah.</p>
                                    <a href="#" class="btn btn-success btn-sm rounded-pill">Lihat Detail</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card shadow-sm border-0 rounded-4 h-100">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold text-primary">Judul Card 5</h5>
                                    <p class="card-text text-muted">Deskripsi card kedua di kolom tengah.</p>
                                    <a href="#" class="btn btn-warning btn-sm rounded-pill text-dark">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

    </main>
    <x-script></x-script>
</body>

</html>