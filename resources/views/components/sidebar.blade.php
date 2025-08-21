<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('index') }}">
            <img src="{{ url('https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/KYB_Corporation_company_logo.svg/2560px-KYB_Corporation_company_logo.svg.png') }}"
                class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Kayaba Indonesia</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100 h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <x-navlink href="{{ route('index') }}" :active="request()->is('/') " icon="fa-house">Dashboard</x-navlink>

            <x-navlink href="{{ route('accident') }}" :active="request()->is('accident')" icon="fa-car-burst">Accident
            </x-navlink>
            <x-navlink href="{{ route('agc') }}" :active="request()->is('agc')" icon="fa-turn-up">AGC Level
            </x-navlink>
            <x-navlink href="{{ route('pica-admin') }}" :active="request()->is('pica-admin')" icon="fa-file-contract">
                PICA
            </x-navlink>
            <x-navlink href="{{ route('issue-admin') }}" :active="request()->is('issue-admin')" icon="fa-file">
                Issue
            </x-navlink>

            <li class="
            nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Monitoring</h6>
            </li>

            <x-navlink href="{{ route('monitoring') }}" :active="request()->is('monitoring')" icon="fa-desktop">
                Monitoring
            </x-navlink>
        </ul>
    </div>
</aside>