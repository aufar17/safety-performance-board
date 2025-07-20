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

<body class="g-sidenav-show bg-gray-100">
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <x-navbar-monitoring title="Dashboard" breadcumb="Dashboard" />
        <div class="container-fluid py-1">
            <h2 class="text-center text-uppercase mb-4" style="letter-spacing: 2px;">Safety Performance Board</h2>

            <div class="row align-items-start gy-2">
                <div class="col-lg-8 col-md-12 px-4">
                    <h4 class="text-uppercase fw-bolder mb-2" style="letter-spacing: 1px;">
                        Update Tanggal
                        <span class="badge bg-dark">{{ $now }}</span>
                    </h4>
                    <h5 class="text-uppercase fw-bolder mt-2" style="letter-spacing: 1px;">
                        <span class="badge bg-warning text-dark">Periode Tahun :</span>
                        <span class="badge bg-dark">{{ $year }}</span>
                    </h5>
                </div>
                <div class="col-lg-4 col-md-12 text-center px-4">
                    <h4 class="text-uppercase fw-bolder" style="letter-spacing: 1px; color:#347433;">Safety Calendar
                    </h4>
                    <h4 class="text-uppercase fw-bolder" style="letter-spacing: 1px;">
                        Periode <span class="badge bg-dark">{{ $month }}</span>
                    </h4>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-4 px-4">
                    <h4 class="text-uppercase fw-bolder text-center bg-dark border-radius-sm py-2"
                        style="letter-spacing: 1px;">
                        <span class="text-white">Informasi Kejadian</span>
                    </h4>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-4 col-md-12 px-4">
                    <div class="row g-4">
                        @foreach ($mappings as $mapping)
                        <x-accident-information :title="$mapping['accident']" :total="$mapping['total']"
                            :category="$mapping['categories']" :icon="$mapping['icon']" />
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 mt-4 mt-lg-0 px-4">
                    <div class="row g-4">
                        <x-accumulative-accident title="Monitoring Bulanan Total Akumulatif Accident"
                            icon="fa-solid fa-desktop" :months="$months" :accumulativeAccident="$accumulativeAccident"
                            chartId="accidentChart1" />

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

                <!-- <div class="col-lg-4 col-md-12 mt-4 mt-lg-0 px-4">
                    Tambahkan konten jika ingin membuat kolom ke-3
                </div> -->
            </div>
        </div>
    </main>

    <x-script />
    @stack('scripts')
</body>

</html>