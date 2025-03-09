       <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->
        

       <nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
        <a class="navbar-brand me-lg-5" href="../../index.html">
            <img class="navbar-brand-dark" src="../../assets/img/brand/light.svg" alt="Volt logo" /> <img class="navbar-brand-light" src="../../assets/img/brand/dark.svg" alt="Volt logo" />
        </a>
        <div class="d-flex align-items-center">
            <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    
            <nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
      <div class="sidebar-inner px-4 pt-3">

        <ul class="nav flex-column pt-3 pt-md-0">
          <li class="nav-item">
            <a href="" class="nav-link d-flex align-items-center">
              
              <span class="mt-1 ms-1 sidebar-text">Signet</span>
            </a>
          </li>
          <li class="nav-item  active ">
            <a href="/" class="nav-link">
              <span class="sidebar-icon">
                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
              </span> 
              <span class="sidebar-text">Dashboard</span>
            </a>
          </li>
          @if (Auth::user()->role == 'admin')
          <li class="nav-item  ">
            <a href="{{ route('setup.google.auth', auth::user()->id) }}" class="nav-link">
              <span class="sidebar-icon">
                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
              </span> 
              <span class="sidebar-text">Google Auth Setup</span>
            </a>
          </li>
          @endif
          @if (Auth::user()->role == 'admin' ||  Auth::user()->role == 'user' || Auth::user()->role == 'agent')
          <li class="nav-item">
            <a href="{{route('token.share')}}" class="nav-link d-flex justify-content-between">
              <span>
                <span class="sidebar-icon">
                  <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </span>
                <span class="sidebar-text">Token Share</span>
              </span>
              
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('buy.package.history')}}" class="nav-link d-flex justify-content-between">
              <span>
                <span class="sidebar-icon">
                  <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </span>
                <span class="sidebar-text">Top Up</span>
              </span>
            </a>
          </li>
          @endif
          @if (Auth::user()->role == 'admin' ||  Auth::user()->role == 'company' )
          <li class="nav-item">
            @if (Auth::user()->role == 'admin')
              <a href="{{route('admin.pending.activation')}}" class="nav-link d-flex justify-content-between">
            @else
              <a href="{{route('company.pending.activation')}}" class="nav-link d-flex justify-content-between">  
            @endif
            
              <span>
                <span class="sidebar-icon">
                  <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </span>
                <span class="sidebar-text">Activations</span>
              </span>
              
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{route('my.geneology')}}" class="nav-link d-flex justify-content-between">
              <span>
                <span class="sidebar-icon">
                  <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </span>
                <span class="sidebar-text">Geneology</span>
              </span>
            </a>
          </li>
        
          
          
          
          
         
          
         
          <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
          <li class="nav-item">
            <a href="javascript:void(0);" target="_blank"
              class="nav-link d-flex align-items-center">
              <span class="sidebar-icon">
                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
              </span>
              <span class="sidebar-text">Support <span class="badge badge-sm bg-secondary ms-1 text-gray-800"></span></span>
            </a>
          </li>
          
          
        </ul>
      </div>
    </nav>

