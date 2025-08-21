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

<body class="g-sidenav-show bg-gray-100 d-flex flex-column min-vh-100">

    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">


        <x-navbar-monitoring title="Dashboard" breadcumb="Dashboard" />
        <div class="container-fluid pb-2
        ">
            {{-- <h2 class="text-center text-uppercase mb-4" style="letter-spacing: 2px;">Safety Performance Board</h2>
            --}}

            <div class="row justify-content-between gy-2">
                <div class="col-lg-4 col-md-12 px-4 text-center">
                    <h4 class="text-white text-uppercase fw-bolder mb-2 px-3 py-2 me-2"
                        style="letter-spacing: 1px;background-color: #001BB7">
                        Update Tanggal :
                        <span class="text-center">{{ $now }}</span>
                    </h4>
                </div>
                <div class="col-lg-4 col-md-12 text-center d-flex justify-content-center px-4">
                    <a href="{{ route('issue') }}"
                        class="btn bg-gradient-warning text-white text-uppercase fw-bolder mb-2 px-3 py-2 me-2 w-25 fs-5 d-flex align-items-center justify-content-center">Issue</a>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-4 col-md-12 px-4">
                    <h4 class="text-uppercase fw-bolder text-center border-radius-sm py-2"
                        style="letter-spacing: 1px; background-color: #FB4141;background-color: #FB4141;">
                        <span class="text-white">Informasi Kejadian</span>
                    </h4>
                    <div class="row g-4 align-items-stretch">
                        <div class="col-12"></div>
                        @foreach ($mappings as $mapping)
                        <x-accident-information :title="$mapping['accident']" :total="$mapping['total']"
                            :category="$mapping['categories']" :icon="$mapping['icon']" />
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 mt-4 mt-lg-0 px-4">
                    <div class="row g-4 align-items-stretch">
                        <x-accumulative-accident title="Monitoring Bulanan Total Akumulatif Accident"
                            icon="fa-solid fa-desktop" :months="$months" :accumulativeAccident="$accumulativeAccident"
                            chartId="accidentChart1" />

                        <x-statistic-information-k3 title="Informasi Statistik K3" icon="fa-solid fa-desktop"
                            :agc="$agc['agc']" :sinceLwd="$agc['sinceLwd']" />
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 mt-4 mt-lg-0 px-4">
                    <div class="text-center">
                        <h4 class="text-uppercase fw-bolder" style="letter-spacing: 1px; color:#347433;">Safety Calendar
                        </h4>
                        <h4 class="text-uppercase fw-bolder" style="letter-spacing: 1px;">
                            Periode <span class="badge" style=" background-color: #001BB7">{{ $month }}</span>
                        </h4>
                    </div>
                    <div class="row g-4 align-items-stretch">
                        <x-calender title="Legend" icon="fa-solid fa-calendar" :bulan="$calender['bulan']"
                            :tanggalList="$calender['tanggalList']" :days=" $calender['days']" />
                    </div>
                </div>
            </div>
        </div>
    </main>


    <x-footer></x-footer>

    <x-script />
    @stack('scripts')
    <script>
        setTimeout(() => {
    location.reload();
  }, 300000); 
    </script>

</body>

</html>