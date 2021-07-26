<div class="sidebar"> 
  
    <div class="divfiltro anima"> </div>
    <div class="logo">
        <a href="" class="simple-text logo-mini">
            <img class="avatar border-gray" src="{{ asset('paper') }}/img/avatar3.png" alt="...">
        </a>
        <a href="" class="simple-text logo-normal" style="padding: 0; margin:0; margin-left: 70px"><img style="height: 50px;" src="{{ asset('paper') }}/img/cdhu.png" alt="..."></a>
        <!-- <a href="" class="simple-text logo-normal">{{ __(auth()->user()->name)}}</a> -->
        <!-- <img class="simple-text logo-normal" src="{{ asset('paper') }}/img/cdhu.png" alt="..."> -->
       
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <?php
                //Controle de acesso ao menu
                use Illuminate\Support\Facades\Auth;
                $menu = [];
                $menu_adm = ['home','clientes','contratos','gerenciadoras','regiaos','ois','tipo_contratos','servico_tipos','locals','usuarios','areas'];
                $menu_consulta = ['home','ois','clientes'];
                $menu_operacional_adm = ['home','contratos','clientes','gerenciadoras','regiaos','ois','tipo_contratos','servico_tipos','locals','areas'];
                $menu_operacional_gestor_tecnico = ['home','ois'];

                $acesso1 = Auth::user()->acesso;
                $acesso2 = Auth::user()->tipo_gestor;
                if($acesso1 == 'Admin'){$menu =  $menu_adm;}             
                if($acesso1 == 'Vendedor'){$menu =  $menu_consulta;}
                if($acesso2 == 'GestorADM' || $acesso2 == 'CDHU'){$menu =  $menu_operacional_adm;}  
                if($acesso2 == 'Gestor' || $acesso2 == 'Técnico'){$menu =  $menu_operacional_gestor_tecnico;}  
            ?>            
            <li class="{{ $elementActive == 'home' ? 'active' : '' }}">
                <a href="/home">
                    <i class="nc-icon nc-bank" style="color:#fff !important"></i>
                    <p>{{ __('Acesso ao site') }}</p>
                </a>
            </li>
            <!-- <li class="{{ $elementActive == 'icons' ? 'active' : '' }} " >
                <a style="opacity: 1 !important;">                   
                    <p class="tit" >Cadastros</p>
                </a>
            </li> -->

            <li class="{{ $elementActive == 'clientes' ? 'active' : '' }}" <?php if(!array_search('clientes', $menu)){echo 'style="display:none"';} ?>>
                <a href="/clientes">
                    <i class="nc-icon nc-app" style="color:#fff !important"></i>
                    <p>{{ __('Clientes') }}</p>
                </a>
            </li> 

            <!--

            <li class="{{ $elementActive == 'contratos' ? 'active' : '' }}" <?php if(!array_search('contratos', $menu)){echo 'style="display:none"';} ?>>
                <a href="/contratos">
                    <i class="nc-icon nc-paper" style="color:#fff !important"></i>
                    <p>{{ __('Contratos') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'locals' ? 'active' : '' }}" <?php if(!array_search('locals', $menu)){echo 'style="display:none"';} ?>>
                <a href="/locals">
                    <i class="nc-icon nc-pin-3" style="color:#fff !important"></i>
                    <p>{{ __('Locais') }}</p>
                </a>
            </li>
            
            
            <li class="{{ $elementActive == 'ois' ? 'active' : '' }}" <?php if(!array_search('ois', $menu)){echo 'style="display:none"';} ?>>
                <a href="/ois">
                    <i class="nc-icon nc-settings-gear-65" style="color:#fff !important"></i>
                    <p>{{ __('OIS') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'tipo_contratos' ? 'active' : '' }}" <?php if(!array_search('tipo_contratos', $menu)){echo 'style="display:none"';} ?>>
                <a href="/tipo_contratos">
                    <i class="nc-icon nc-tile-56" style="color:#fff !important"></i>
                    <p>{{ __('Tipos de Contrato') }}</p>
                </a>
            </li>
           

                

            <li class="{{ $elementActive == 'servico_tipos' ? 'active' : '' }}" <?php if(!array_search('servico_tipos', $menu)){echo 'style="display:none"';} ?>>
                <a href="/servico_tipos">
                    <i class="nc-icon nc-settings" style="color:#fff !important"></i>
                    <p>{{ __('Serviços') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'areas' ? 'active' : '' }}" <?php if(!array_search('areas', $menu)){echo 'style="display:none"';} ?>>
                <a href="/areas">
                    <i class="nc-icon nc-map-big" style="color:#fff !important"></i>
                    <p>{{ __('Áreas') }}</p>
                </a>
            </li>

 
            
            <li class="{{ $elementActive == 'gerenciadoras' ? 'active' : '' }}" <?php if(!array_search('gerenciadoras', $menu)){echo 'style="display:none"';} ?>>
                <a href="/gerenciadoras">
                    <i class="nc-icon nc-atom" style="color:#fff !important"></i>
                    <p>{{ __('Gerenciadoras') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'regiaos' ? 'active' : '' }}" <?php if(!array_search('regiaos', $menu)){echo 'style="display:none"';} ?>>
                <a href="/regiaos">
                    <i class="nc-icon nc-world-2" style="color:#fff !important"></i>
                    <p>{{ __('Regiões') }}</p>
                </a>
            </li>

-->
   
            
            <li class="{{ $elementActive == 'usuarios' ? 'active' : '' }}" <?php if(!array_search('usuarios', $menu)){echo 'style="display:none"';} ?>>
                <a href="/usuarios">
                    <i class="nc-icon nc-single-02" style="color:#fff !important"></i>
                    <p>{{ __('Usuários') }}</p>
                </a>
            </li>
            <!-- <li class="{{ $elementActive == 'icons' ? 'active' : '' }} ">
                <a  style="opacity: 1 !important;">
                   
                    <p class="tit">Relatórios</p>
                </a>
            </li>
            <li class="{{ $elementActive == '3' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'construcao') }}">
                    <i class="nc-icon nc-bullet-list-67" style="color:#fff !important"></i>
                    <p>{{ __('Serviços / Contrato') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == '1' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'construcao') }}">
                    <i class="nc-icon nc-globe-2" style="color:#fff !important"></i>
                    <p>{{ __('Cidades / Gerenciadoras') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == '2' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'construcao') }}">
                    <i class="nc-icon nc-ruler-pencil" style="color:#fff !important"></i>
                    <p>{{ __('Medições') }}</p>
                </a>
            </li> -->
        </ul>        
    </div>
    
</div>

