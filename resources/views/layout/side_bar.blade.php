
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
      <div class="navbar nav_title" style="border: 0;">
        <a href="/" class="site_title"><img src="/images/logo_branco.png" style="width:50px;height:45px;"></a>
      </div>
  
      <div class="clearfix"></div>
        <div class="profile clearfix">
          <div class="profile_info">
          <span>Bem vindo, {{auth()->user()->name}}</span>
            <h2></h2>
          </div>
        </div>
      <br />
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
          <h3>Navegação</h3>
          <ul class="nav side-menu">
            <li><a href="/"><i class="fa fa-home"></i> Home </a></li>
            <li><a>
              <i class="fa fa-search"></i> Pesquisar <span class="fa fa-chevron-down">
                </span>
              </a>
              <ul class="nav child_menu">
                
                  <li><a href="/items">Item</a></li>
                  <li><a href="/categorias">Categoria item</a></li>
                  <li><a href="/kits">Kit</a></li>
                @if (session('grupo')->gerirGrupos)
                <li><a href="/grupos">Grupo</a></li>
                @endif
                @if (session('grupo')->gerirUsers)
                <li><a href="/users">Utilizador</a></li>
                @endif
                    
              </ul>
            </li>
            <li><a href="/carrinho"><i class="fa fa-shopping-cart"></i> Carrinho de Reservas</a></li>
           @if (session('grupo')->reservar||session('grupo')->gerirReservas)
               
           <li><a><i class="fa fa-archive"></i> Reservas <span class="fa fa-chevron-down"></span></a>
             <ul class="nav child_menu">
               @if (session('grupo')->reservar)
               <li><a href="/reservas/create">Criar Reservas</a></li>
              @endif
              @if(session('grupo')->reservar ||session('grupo')->gerirReservas )
               <li><a href="/reservasPendentes">Reservas pendentes</a></li>
               <li><a href="/reservasAtraso">Reservas em atraso</a></li>
               <li><a href="/reservasConcluidas">Reservas Concluidas</a></li>
               <li><a href="/reservasRejeitadas">Reservas Rejeitadas</a></li>
               <li><a href="/reservasDecorrer">Reservas aceites/em progresso </a></li>
               <li><a href="/reservas">Todas as reservas </a></li>
               @endif
             </ul>
           </li>
           @endif
             
            @if (session('grupo')->gerirItemsKits ||session('grupo')->gerirGrupos ||session('grupo')->gerirCategorias)
            <li><a><i class="fa fa-edit"></i> Criar <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                @if (session('grupo')->gerirItemsKits)
                <li><a href="/items/create">Item</a></li>
                <li><a href="/kits/create">Kit</a></li>
                    
                @endif
                @if (session('grupo')->gerirCategorias)
                <li><a href="/categorias/create">Categoria item </a></li>
                    
                @endif
                @if (session('grupo')->gerirGrupos)
                <li><a href="/grupos/create">Grupo</a></li>
                    
                @endif
                
              </ul>
            </li>   
            @endif
            
            <li><a href="/about"><i class="fa fa-info"></i> Sobre </a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>