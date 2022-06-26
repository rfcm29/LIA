<!DOCTYPE html>
<html lang="en">
  @include('partials.heads')
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
          
          @include('layout.side_bar')<!-- Side bar-->
          
          @include('layout.nav_bar')<!-- nav bar -->
          
          <div class="right_col" role="main">
            @yield('content')<!-- page content -->
          </div>
        
          @include('layout.footer')<!-- footer content -->
      </div>
    </div>

    @include('partials.scripts')
    
    
  </body>
</html>