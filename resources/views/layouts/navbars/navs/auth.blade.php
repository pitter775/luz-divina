
<div class="navbar navbar-expand-lg fixed-top bgtop navbar-transparent margtm" style="height: 64px;">
    <div class="container-fluid bgtop" > 
        <div class="navbar-wrapper">
            <div class="navbar-minimize">
                    <span id="minimizeSidebar" >
                        <i class="nc-icon nc-minimal-right text-center visible-on-sidebar-mini"></i>
                        <i class="nc-icon nc-minimal-left text-center visible-on-sidebar-regular"></i>
                        <span style="margin-top: -3PX; margin-left: 20px"><B>SISTEMA LUZ DIVINA</B></span> <span style="margin-left: 50px;">logado como :</span> <span ><b>{{ __(auth()->user()->name)}}</b></span>
                    </span>
                </div>
                <div class="navbar-toggle">
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                </div>
                
            <!-- <a class="navbar-brand"><img src="{{ asset('paper') }}/img/cdhu.png" style="width: 220px;"></a> -->
    
        
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
            aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <!-- <form>
                <div class="input-group no-border">
                    <input type="text" value="" class="form-control" placeholder="Search...">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="nc-icon nc-zoom-split"></i>
                        </div>
                    </div>
                </div>
            </form> -->
            <ul class="navbar-nav navcel">
                <li class="nav-item btn-rotate dropdown navcelint">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Ações') }}</span>
                        </p>
                    </a>
                    <form class="dropdown-item" action="{{ route('logout') }}" id="formLogOut" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        
                        <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="nc-icon nc-planet"></i> {{ __('Meu Perfil') }}</a>
                        <a class="dropdown-item" onclick="document.getElementById('formLogOut').submit();"><i class="nc-icon nc-button-power"></i> {{ __('Sair') }}</a>
                    </div>
                </li>
                <!-- <li class="nav-item btn-rotate dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Account') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink2">
                        <form class="dropdown-item" action="{{ route('logout') }}" id="formLogOut" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" onclick="document.getElementById('formLogOut').submit();">{{ __('Deslogar') }}</a>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('My profile') }}</a>
                        </div>
                    </div>
                </li> -->
            </ul>
        </div>
    </div>
</div>
