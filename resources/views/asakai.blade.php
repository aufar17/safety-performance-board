<!DOCTYPE html>
<html lang="en">

<x-head></x-head>

<body class="g-sidenav-show bg-gray-100 d-flex flex-column min-vh-100">

    <!-- 🔹 Tambah flex-grow-1 di sini -->
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg flex-grow-1">

        <x-navbar-monitoring title="Dashboard" breadcumb="Dashboard" />
        <div class="container-fluid pb-2">

            <div class="row justify-content-between gy-2">
                <div class="col-lg-4 col-md-12 px-4 text-center">
                    <div class="update-tanggal marquee w-100">
                        <span>Update Tanggal : <span class="tanggal">{{ $now }}</span></span>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 text-center d-flex justify-content-center px-4">
                    <a href="{{ route('issue') }}"
                        class="btn-issue-modern text-uppercase fw-bold mb-2 px-3 py-2 w-50 fs-6 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-hand-pointer me-2"></i> Safety Issue
                    </a>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-4 col-md-12 px-4">
                    <h4 class="text-uppercase fw-bolder text-center border-radius-sm py-2"
                        style="letter-spacing: 1px; background-color: #FB4141;border-radius: 12px;">
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
                            :tanggalList="$calender['tanggalList']" :days="$calender['days']" />
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- 🔹 Footer otomatis nempel di bawah -->
    <x-footer class="mt-auto" />

    <x-script />
    @stack('scripts')
    <script>
        // Auto refresh tiap 5 menit (300000ms)
        setTimeout(() => {
            location.reload();
        }, 180000);

    </script>

    <style>
        /* ✅ Zoom untuk TV tanpa ganggu flexbox */
        body {
            zoom: 0.6; /* 60% zoom */
        }

        .update-tanggal {
            display: block;
            overflow: hidden;
            white-space: nowrap;
            font-size: 15px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #5d5f69ff, #494c4dff);
            color: #fff;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: left;
            position: relative;
        }

        .update-tanggal span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 12s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0%);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        .tanggal {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 8px;
            margin-left: 8px;
            font-weight: 600;
        }

        .btn-issue-modern {
            background: linear-gradient(135deg, #5d5f69ff, #494c4dff);
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            padding: 8px 18px;
            font-size: 0.95rem;
        }

        .btn-issue-modern:hover {
            background: linear-gradient(135deg, #494c4dff, #3a3c3dff);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.35);
            transform: translateY(-2px) scale(1.02);
            color: #fff;
        }

        .btn-issue-modern:active {
            transform: translateY(1px) scale(0.96);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        }
    </style>

</body>

</html>
