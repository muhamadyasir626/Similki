<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
      {{-- Noble<span>UI</span> --}}
      {{ $user->role->tag }}
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
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item nav-category">LEMBAGA KONSERVASI</li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ route('lembaga-konservasi.index') }}" class="nav-link">
          <i class="link-icon" data-feather="list"></i>
          <span class="link-title">Daftar Isi LK</span>
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
          <span class="link-title">Pendataan LK </span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="" class="nav-link">
          <i class="link-icon" data-feather="upload"></i>
          <span class="link-title">Import File</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="" class="nav-link">
          <i class="link-icon" data-feather="download"></i>
          <span class="link-title">Export File </span>
        </a>
      </li>

      <li class="nav-item nav-category">SATWA</li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ route('satwa.index') }}" class="nav-link">
          <i class="link-icon" data-feather="list"></i>
          <span class="link-title">Daftar Isi Satwa </span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ route('form-satwa') }}" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pendataan Satwa </span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="" class="nav-link">
          <i class="link-icon" data-feather="activity"></i>
          <span class="link-title">Kesehatan Satwa </span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="" class="nav-link">
          <i class="link-icon" data-feather="shield"></i>
          <span class="link-title">Sanitasi Satwa </span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="" class="nav-link">
          <i class="link-icon" data-feather="upload"></i>
          <span class="link-title">Import File </span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="" class="nav-link">
          <i class="link-icon" data-feather="download"></i>
          <span class="link-title">Export File </span>
        </a>
      </li>
     
      {{-- <li class="nav-item {{ active_class(['forms/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#forms" role="button" aria-expanded="{{ is_active_route(['forms/*']) }}" aria-controls="forms">
          <i class="link-icon" data-feather="inbox"></i>
          <span class="link-title">Forms</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['forms/*']) }}" id="forms">
          <ul class="nav sub-menu">            
            <li class="nav-item">
              <a href="{{ route('lembaga-konservasi.index') }}" class="nav-link {{ active_class(['forms/wizard']) }}">Daftar Isi Lembaga Konservasi</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/forms/data_lk') }}" class="nav-link {{ active_class(['forms/data_lk']) }}">Data LK</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/forms/data_lk') }}" class="nav-link {{ active_class(['forms/data_lk']) }}">Profile LK</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/forms/input-investasi') }}" class="nav-link {{ active_class(['forms/input-investasi']) }}">Input Investasi</a>
            </li>
            <li class="nav-ite
              <a href="{{ url('/forms/monitoring-investasi') }}" class="nav-link {{ active_class(['forms/monitoring-investasi']) }}">Monitoring Investasi</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/forms/input-lk') }}" class="nav-link {{ active_class(['forms/input-lk']) }}">Input Data LK</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ active_class(['charts/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#charts" role="button" aria-expanded="{{ is_active_route(['charts/*']) }}" aria-controls="charts">
          <i class="link-icon" data-feather="pie-chart"></i>
          <span class="link-title">Charts</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['charts/*']) }}" id="charts">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ url('/charts/apex') }}" class="nav-link {{ active_class(['charts/apex']) }}">Apex</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/charts/chartjs') }}" class="nav-link {{ active_class(['charts/chartjs']) }}">ChartJs</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/charts/flot') }}" class="nav-link {{ active_class(['charts/flot']) }}">Flot</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/charts/peity') }}" class="nav-link {{ active_class(['charts/peity']) }}">Peity</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/charts/sparkline') }}" class="nav-link {{ active_class(['charts/sparkline']) }}">Sparkline</a>
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
      <li class="nav-item {{ active_class(['icons/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#icons" role="button" aria-expanded="{{ is_active_route(['icons/*']) }}" aria-controls="icons">
          <i class="link-icon" data-feather="smile"></i>
          <span class="link-title">Icons</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['icons/*']) }}" id="icons">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ url('/icons/feather-icons') }}" class="nav-link {{ active_class(['icons/feather-icons']) }}">Feather Icons</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/icons/mdi-icons') }}" class="nav-link {{ active_class(['icons/mdi-icons']) }}">Mdi Icons</a>
            </li>
          </ul>
        </div>
      </li> --}}

      <li class="nav-item nav-category">Verifikasi Akun</li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ route('verifikasi-akun') }}" class="nav-link">
          <i class="link-icon" data-feather="unlock"></i>
          <span class="link-title">Perizinan Akses</span>
        </a>
      </li>
      
      
    </ul>
  </div>
</nav>
{{-- <nav class="settings-sidebar">
  <div class="sidebar-body">
    <a href="#" class="settings-sidebar-toggler">
      <i data-feather="settings"></i>
    </a>
    <h6 class="text-muted mb-2">Sidebar:</h6>
    <div class="mb-3 pb-3 border-bottom">
      <div class="form-check form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight" value="sidebar-light" checked>
          Light
        </label>
      </div>
      <div class="form-check form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark" value="sidebar-dark">
          Dark
        </label>
      </div>
    </div>
    <div class="theme-wrapper">
      <h6 class="text-muted mb-2">Light Version:</h6>
      <a class="theme-item active" href="https://www.nobleui.com/laravel/template/demo1/">
        <img src="{{ url('assets/images/screenshots/light.jpg') }}" alt="light version">
      </a>
      <h6 class="text-muted mb-2">Dark Version:</h6>
      <a class="theme-item" href="https://www.nobleui.com/laravel/template/demo2/">
        <img src="{{ url('assets/images/screenshots/dark.jpg') }}" alt="light version">
      </a>
    </div>
  </div>
</nav> --}}