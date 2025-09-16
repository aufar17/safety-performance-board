<!DOCTYPE html>
<html lang="en">
<x-head></x-head>

    <!-- Sidebar -->
    <x-sidebar></x-sidebar>

    <!-- Main Content -->
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        
        <!-- Navbar -->
        <x-navbar title="Mapping Potention Area" breadcumb="Mapping Potention Area" :user="$user"></x-navbar>
        
        <!-- Page Content -->
        <div class="card shadow-sm border-0" style="height: 700px;">
            <div class="card-body d-flex justify-content-center align-items-center" style="height: 100%;">
                <img src="{{ asset('img/map1.jpg') }}" 
                    alt="Mapping Potention Area" 
                    style="max-width: 100%; max-height: 100%; border-radius: 10px;">
            </div>
        </div>

        <!-- Tambahan teks setelah kotak -->
        <div class="mt-3 text-center" style="height: 100px;">
            <h4 style="color: red;">- "THIS PAGE UNDER DEVELOPMENT" -</h4>
        </div>


        <!-- Footer -->
        <x-footer></x-footer>
    </main>

    <!-- JS -->
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
    </body>
</html>
