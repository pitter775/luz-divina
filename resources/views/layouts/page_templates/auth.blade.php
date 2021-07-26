<div class="wrapper">

    @include('layouts.navbars.auth')

    <div class="main-panel" style="background: linear-gradient(to bottom, #ebf1f5 0%, #f2f9ff 100%);">
        @include('layouts.navbars.navs.auth')
        @yield('content')
        @include('layouts.footer')
    </div>
</div>