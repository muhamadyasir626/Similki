<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
      {{-- SIMILKI - {{$user->role->tag}} --}}
      {{$user->role->tag}}
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ url('/dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="home"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
            <li class="nav-item nav-category">LEMBAGA KONSERVASI</li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ route('lembaga-konservasi.index') }}" class="nav-link">
          <i class="link-icon" data-feather="list"></i>
          <span class="link-title">Daftar Lembaga Konservasi</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ route('monitoring-lk') }}" class="nav-link">
          <i class="link-icon" data-feather="monitor"></i>
          <span class="link-title">Monitoring LK</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pendataan Satwa</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ route('satwa.index') }}" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Daftar Data Satwa</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['forms/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#forms" role="button" aria-expanded="{{ is_active_route(['forms/*']) }}" aria-controls="forms">
          <i class="link-icon" data-feather="inbox"></i>
          <span class="link-title">Forms</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['forms/*']) }}" id="forms">
          <ul class="nav sub-menu">            
            {{-- <li class="nav-item">
              <a href="{{ route('lembaga-konservasi.index') }}" class="nav-link {{ active_class(['forms/wizard']) }}">Data Satwa</a>
            </li> --}}
            <li class="nav-item">
              <a href="{{ url('/forms/data_lk') }}" class="nav-link {{ active_class(['forms/data_lk.blade.php']) }}">Data LK</a>
            </li>
            {{-- <li class="nav-item">
              <a href="{{ url('/forms/data_lk') }}" class="nav-link {{ active_class(['forms/data_lk']) }}">Profile LK</a>
            </li> --}}
            <li class="nav-item">
              <a href="{{ url('/forms/input-investasi') }}" class="nav-link {{ active_class(['forms/input-investasi']) }}">Input Investasi</a>
            </li>
            <li class="nav-ite
              <a href="{{ url('/forms/monitoring-investasi') }}" class="nav-link {{ active_class(['forms/monitoring-investasi']) }}">Monitoring Investasi</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/forms/input-lk') }}" class="nav-link {{ active_class(['forms/input-lk']) }}">Input Data LK</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/forms/pendataan-satwa') }}" class="nav-link {{ active_class(['forms/pendataan-satwa']) }}">Input Satwa</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ active_class(['tables/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#tables" role="button" aria-expanded="{{ is_active_route(['tables/*']) }}" aria-controls="tables">
          <i class="link-icon" data-feather="layout"></i>
          <span class="link-title">Tables</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['tables/*']) }}" id="tables">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ url('/tables/basic-tables') }}" class="nav-link {{ active_class(['tables/basic-tables']) }}">Basic Tables</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/tables/data-table') }}" class="nav-link {{ active_class(['tables/data-table']) }}">Data Table</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category">Pages</li>
          {{-- <li class="nav-item {{ active_class(['general/*']) }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#general" role="button" aria-expanded="{{ is_active_route(['general/*']) }}" aria-controls="general">
              <i class="link-icon" data-feather="book"></i>
              <span class="link-title">Special Pages</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['general/*']) }}" id="general">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="{{ url('/general/blank-page') }}" class="nav-link {{ active_class(['general/blank-page']) }}">Blank page</a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/general/faq') }}" class="nav-link {{ active_class(['general/faq']) }}">Faq</a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/general/invoice') }}" class="nav-link {{ active_class(['general/invoice']) }}">Invoice</a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/general/profile') }}" class="nav-link {{ active_class(['general/profile']) }}">Profile</a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/general/pricing') }}" class="nav-link {{ active_class(['general/pricing']) }}">Pricing</a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/general/timeline') }}" class="nav-link {{ active_class(['general/timeline']) }}">Timeline</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item {{ active_class(['auth/*']) }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" role="button" aria-expanded="{{ is_active_route(['auth/*']) }}" aria-controls="auth">
              <i class="link-icon" data-feather="unlock"></i>
              <span class="link-title">Authentication</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['auth/*']) }}" id="auth">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="{{ url('/auth/login') }}" class="nav-link {{ active_class(['auth/login']) }}">Login</a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/auth/register') }}" class="nav-link {{ active_class(['auth/register']) }}">Register</a>
                </li>
              </ul>
            </div>
          </li> --}}
    </ul>
  </div>
</nav>