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
    <x-sidebar></x-sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <x-navbar title="Accident" breadcumb="Accident" />
        <div class="container-fluid p-5">
            <x-card title="Accident Table" icon="fa-solid fa-person-falling">
            </x-card>
        </div>
    </main>
    <x-sidebar-plugin></x-sidebar-plugin>

    <x-script></x-script>
    <script>
        $(document).ready(function () {
        $('#accident').DataTable();
    });
    </script>
</body>

</html>