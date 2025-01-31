<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
</head>
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
<<<<<<< Updated upstream
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item {{ active_class(['/']) }}">
=======
      {{-- <li class="nav-item nav-category">Main</li> --}}
      <li class="nav-item {{ active_class('dashboard') }}">
>>>>>>> Stashed changes
        <a href="{{ url('/dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
<<<<<<< Updated upstream
      <li class="nav-item nav-category">LEMBAGA KONSERVASI</li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ route('lembaga-konservasi.index') }}" class="nav-link">
          <i class="link-icon" data-feather="list"></i>
          <span class="link-title">Daftar Isi LK</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ route('moniotring-lk') }}" class="nav-link">
=======


@if(request()->is('dashboard'))
<li class="nav-item ">
  <a class="nav-link" data-bs-toggle="collapse" href="#filter" role="button" aria-expanded="" aria-controls="filter">
    <i class="link-icon" data-feather="filter"></i>
    <span class="link-title">Filter</span>
    <i class="link-arrow" data-feather="chevron-down"></i>
  </a>
  <div class="collapse" id="filter">
    <ul class="nav sub-menu">
      <!-- Lembaga Konservasi -->
      <li class="nav-item">
        <details class="filter-item details">
          <summary class="filter-item-label link-title" id="name-label">Lembaga Konservasi
            <i class="filter-link-arrow" style="width: 14px; height:14px;" data-feather="chevron-down"></i>
          </summary>
          <summary class="filter-item-label" id="search-input-filter">
            <input type="text" class="conservation-search" placeholder="Filter LK...">
            <button class="btn btn-sm btn-danger mt-2 mb-2 clear-btn clear-conservation">Clear</button>
          </summary>
          @foreach ($lks as $lk )
          <label class="filter-label">
            <input type="checkbox" value="{{ $lk->id }}" data-category="LK">
            {{ $lk->nama }}
          </label>
          @endforeach
        </details>
      </li>
      <!-- UPT -->
      <li class="nav-item">
        <details class="filter-item details">
          <summary class="filter-item-label" id="name-label">UPT
            <i class="filter-link-arrow" style="width: 14px; height:14px;" data-feather="chevron-down"></i>
          </summary>
          <summary class="filter-item-label" id="search-input-filter">
            <input type="text" class="upt-search" placeholder="Filter UPT...">
            <button class="btn btn-sm btn-danger mt-2 mb-2 clear-btn clear-upt">Clear</button>
          </summary>
          @foreach ($upts as $upt )
          <label class="filter-label">
            <input type="checkbox" value="{{ $upt->id }}" data-category="UPT">
            {{ $upt->wilayah }}
          </label>
          @endforeach
        </details>
      </li>
      <!-- Class -->
      <li class="nav-item">
        <details class="filter-item details">
          <summary class="filter-item-label" id="name-label">Class
            <i class="filter-link-arrow" style="width: 14px; height:14px;" data-feather="chevron-down"></i>
          </summary>
          <summary class="filter-item-label" id="search-input-filter">
            <input type="text" class="class-search" placeholder="Filter Class...">
            <button class="btn btn-sm btn-danger mt-2 mb-2 clear-btn  clear-class">Clear</button>
          </summary>
          @foreach ($classes as $class )
          <label class="filter-label">
            <input type="checkbox" value="{{ $class->id }}" data-category="Class">
            {{ $class->class }}
          </label>
          @endforeach
        </details>
      </li>
    </ul>
  </div>
</li>
@endif



<li class="nav-item nav-category">LEMBAGA KONSERVASI</li>
@if (Auth::check() && Auth::user()->role->tag == "LK")
<li class="nav-item {{ active_class('lk') }}">
  <a href="{{ route('detail-pengajuan-lk', ['id' => Auth::user()->id_lk, 'status' => true]) }}" class="nav-link">
    <i class="link-icon" data-feather="user"></i>
    <span class="link-title">Profil Lembaga Konservasi</span>
  </a>
</li>
  
@endif
{{-- <li class="nav-item {{ request()->is('lembaga-konservasi')|| request()->is('lembaga-konservasi/search') ? 'active' : '' }}">
  <a href="{{ route('lembaga-konservasi.index') }}" class="nav-link">
    <i class="link-icon" data-feather="list"></i>
    <span class="link-title">Daftar Isi LK</span>
  </a>
</li> --}}
@if (Auth::check() && (Auth::user()->role->tag == "KKHSG" || Auth::user()->role->tag == "UPT"))
        
      <li class="nav-item {{ active_class('lk') }}">
        <a href="{{ route('lk.index') }}" class="nav-link">
>>>>>>> Stashed changes
          <i class="link-icon" data-feather="monitor"></i>
          <span class="link-title">Monitoring LK</span>
        </a>
      </li>
<<<<<<< Updated upstream
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
=======
      <li class="nav-item {{ active_class('daftar-pengajuan-lk') }}">
        <a href="{{ route('daftar-pengajuan-lk') }}" class="nav-link">
          <i class="link-icon" data-feather="monitor"></i>
          <span class="link-title">Daftar Pengajuan</span>
>>>>>>> Stashed changes
        </a>
      </li>
      @endif

<<<<<<< Updated upstream
      <li class="nav-item nav-category">SATWA</li>
      <li class="nav-item {{ active_class(['/']) }}">
=======
      @if (Auth::check() && Auth::user()->role->tag == "UPT")
      <li class="nav-item {{ active_class('pendataan-lk') }}">
        <a href="{{ route('lembaga-konservasi.create') }}" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pengajuan LK</span>
        </a>
      </li>
      @endif
      
      <li class="nav-item nav-category">Barang KONSERVASI</li>
      <li class="nav-item {{ active_class('barang-konservasi') }}">
        <a href="{{ route('barang-konservasi.index') }}" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Monitoring Barang</span>
        </a>
      </li>
      @if (Auth::check() && Auth::user()->role->tag == "LK")
      <li class="nav-item {{ active_class('barang-konservasi/create') }}">
        <a href="{{ route('barang-konservasi.create') }}" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pengajuan Bebas BEA</span>
        </a>
      </li>
      @endif

      <li class="nav-item {{ active_class('daftar-pengajuan-barang-konservasi') }}">
        <a href="{{ route('daftar-pengajuan-barang') }}" class="nav-link">
          <i class="link-icon" data-feather="list"></i>
          <span class="link-title">Daftar Pengajuan Barang</span>
        </a>
      </li>
      
      @if (Auth::check() && Auth::user()->role->tag == "LK" || 
      Auth::user()->role->tag == "UPT" || 
      Auth::user()->role->tag == "KKHSG")
        
      <li class="nav-item nav-category">Satwa Koleksi</li>
      <li class="nav-item">
        <a href="{{ route('satwa-koleksi.index') }}" class="nav-link {{ request()->is('satwa-koleksi') ? 'active-link' : '' }}">
          <i class="link-icon" data-feather="list"></i>
          <span class="link-title">Monitoring Individu</span>
        </a>
      </li>
      @if (Auth::check() && Auth::user()->role->tag == "LK")
      <li class="nav-item">
        <a href="{{ route('satwa-koleksi.create') }}" class="nav-link {{ request()->is('satwa-koleksi/create') ? 'active-link' : '' }}">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pendataan Individu</span>
        </a>
      </li>
      @endif

      <li class="nav-item nav-category">Satwa Titipan</li>
      <li class="nav-item">
        <a href="{{ route('satwa-titipan.index') }}" class="nav-link {{ request()->is('satwa-titipan') ? 'active-link' : '' }}">
          <i class="link-icon" data-feather="monitor"></i>
          <span class="link-title">Monitoring Titipan</span>
        </a>
      </li>
      
      @if (Auth::check() && Auth::user()->role->tag == "LK")
      <li class="nav-item">
        <a href="{{ route('satwa-titipan.create') }}" class="nav-link {{ request()->is('satwa-titipan/create') ? 'active-link' : '' }}">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pendataan Titipan</span>
        </a>
      </li>
      @endif
      <li class="nav-item nav-category">Satwa Perolehan</li>
      <li class="nav-item">
        <a href="{{ route('satwa-perolehan.index') }}" class="nav-link {{ request()->is('satwa-perolehan') ? 'active-link' : '' }}">
          <i class="link-icon" data-feather="monitor"></i>
          <span class="link-title">Monitoring Satwa</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('daftar-pengajuan-satwa-perolehan') }}" class="nav-link {{ request()->is('daftar-pengajuan-satwa-perolehan') ? 'active-link' : '' }}">
          <i class="link-icon" data-feather="list"></i>
          <span class="link-title">Daftar Pengajuan</span>
        </a>
      </li>
      @if (Auth::check() && Auth::user()->role->tag == "LK")
      <li class="nav-item">
        <a href="{{ route('satwa-perolehan.create') }}" class="nav-link {{ request()->is('satwa-perolehan/create') ? 'active-link' : '' }}">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pendataan Pengajuan</span>
        </a>
      </li>
      @endif
      @endif


      @if (Auth::check() && Auth::user()->role->tag == "KKHSG")
          <li class="nav-item nav-category">Pengaturan</li>
          <li class="nav-item {{ active_class('verification-account') }}">
              <a href="{{ route('verifikasi-akun') }}" class="nav-link">
                  <i class="link-icon" data-feather="unlock"></i>
                  <span class="link-title">Perizinan Akun</span>
              </a>
          </li>
          <li class="nav-item {{ active_class('master-data') }}">
              <a href="{{ route('verifikasi-akun') }}" class="nav-link">
                  <i class="link-icon" data-feather="sliders"></i>
                  <span class="link-title">Master Data</span>
              </a>
          </li>
      @endif
      
      {{-- @endif --}}
     
{{-- DRAFT FIX --}}
      {{-- <li class="nav-item nav-category">SATWA</li>
      <li class="nav-item {{ request()->is('satwa') || request()->is('satwa/search') ? 'active' : '' }}">
>>>>>>> Stashed changes
        <a href="{{ route('satwa.index') }}" class="nav-link">
          <i class="link-icon" data-feather="list"></i>
          <span class="link-title">Daftar Isi Satwa </span>
        </a>
      </li>
<<<<<<< Updated upstream
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
=======
      <li class="nav-item {{ request()->is('satwa/form-genealogy') ? 'active' : '' }}">
        <a href="{{ route('viewSilsilah') }}" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pendataan Silsilah</span>
        </a>
      </li>
      <li class="nav-item {{ request()->is('satwa/genealogy') ? 'active' : '' }}">
        <a href="{{ route('viewSilsilah') }}" class="nav-link">
          <i class="link-icon" data-feather="git-branch"></i>
          <span class="link-title">Silsilah Satwa</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('satwa-koleksi*') ? 'active-link' : '' }}" 
           data-bs-toggle="collapse" 
           href="#satwaKoleksiMenu" 
           role="button" 
           aria-expanded="{{ request()->is('satwa-koleksi*') ? 'true' : 'false' }}" 
           aria-controls="satwaKoleksiMenu">
          <i class="link-icon" data-feather="chevron-right"></i>
          <span class="link-title">Satwa Koleksi</span>
          <i class="menu-arrow"></i>
>>>>>>> Stashed changes
        </a>
        <div class="collapse {{ request()->is('satwa-koleksi*') ? 'show' : '' }}" id="satwaKoleksiMenu">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('satwa-koleksi.index') }}" class="nav-link {{ request()->is('satwa-koleksi') ? 'active-link' : '' }}">
                <i class="link-icon" data-feather="list"></i>
                <span class="link-title">Monitoring Individu</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('satwa-koleksi.create') }}" class="nav-link {{ request()->is('satwa-koleksi/create') ? 'active-link' : '' }}">
                <i class="link-icon" data-feather="plus-circle"></i>
                <span class="link-title">Pendataan Individu</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
<<<<<<< Updated upstream
     
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
            <li class="nav-item">
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
=======
      

      <li class="nav-item">
        <a class="nav-link {{ request()->is('satwa-perolehan*') ? 'active-link' : '' }}" 
           data-bs-toggle="collapse" 
           href="#satwaPerolehanMenu" 
           role="button" 
           aria-expanded="{{ request()->is('satwa-perolehan*') ? 'true' : 'false' }}" 
           aria-controls="satwaPerolehanMenu"">
          <i class="link-icon" data-feather="chevron-right"></i>
          <span class="link-title">Satwa Perolehan</span>
          <i class="menu-arrow"></i>
>>>>>>> Stashed changes
        </a>
        <div class="collapse {{ request()->is('satwa-perolehan*') ? 'show' : '' }}" id="satwaPerolehanMenu"">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('satwa-perolehan.index') }}" class="nav-link {{ request()->is('satwa-perolehan') ? 'active-link' : '' }}">
                <i class="link-icon" data-feather="monitor"></i>
                <span class="link-title">Monitoring Satwa</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('daftar-pengajuan-satwa-perolehan') }}" class="nav-link {{ request()->is('daftar-pengajuan-satwa-perolehan') ? 'active-link' : '' }}">
                <i class="link-icon" data-feather="list"></i>
                <span class="link-title">Daftar Pengajuan</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('satwa-perolehan.create') }}" class="nav-link {{ request()->is('satwa-perolehan/create') ? 'active-link' : '' }}">
                <i class="link-icon" data-feather="plus-circle"></i>
                <span class="link-title">Pendataan Pengajuan</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      
<<<<<<< Updated upstream
      
=======
      <li class="nav-item">
        <a class="nav-link {{ request()->is('satwa-titipan*') ? 'active-link' : '' }}" 
           data-bs-toggle="collapse" 
           href="#satwaTitipanMenu" 
           role="button" 
           aria-expanded="{{ request()->is('satwa-titipan*') ? 'true' : 'false' }}" 
           aria-controls="satwaTitipanMenu"
           id="satwaTitipanLink">
          <i class="link-icon" id="satwaTitipanIcon" data-feather="chevron-right"></i>
          <span class="link-title">Satwa Titipan</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{ request()->is('satwa-titipan*') ? 'show' : '' }}" id="satwaTitipanMenu">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('satwa-titipan.index') }}" class="nav-link {{ request()->is('satwa-titipan') ? 'active-link' : '' }}">
                <i class="link-icon" data-feather="monitor"></i>
                <span class="link-title">Monitoring Titipan</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('satwa-titipan.create') }}" class="nav-link {{ request()->is('satwa-titipan/create') ? 'active-link' : '' }}">
                <i class="link-icon" data-feather="plus-circle"></i>
                <span class="link-title">Pendataan Titipan</span>
              </a>
            </li>
          </ul>
        </div>
      </li> --}}
      

      

     

>>>>>>> Stashed changes
    </ul>
  </div>

</nav>
<<<<<<< Updated upstream
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
=======

<style>
  .nav-item.active > .nav-link,
.nav-link.active-link {
  color: #6571ff !important; /* Warna teks aktif */
  /* font-weight: bold; */
}

.nav-link.active-link .link-icon {
  color: #6571ff; /* Warna ikon aktif */
}

</style>


{{-- <script src="search-filter.js"></script>  --}}

<script>

const link = document.getElementById('satwaTitipanLink');
const icon = document.getElementById('satwaTitipanIcon');

// Pastikan Feather Icons sudah dimuat dengan benar
feather.replace();

link.addEventListener('click', () => {
    // Ambil nilai aria-expanded
    var show = link.getAttribute('aria-expanded');
    console.log('Current aria-expanded:', show);
    
    // Periksa apakah menu terbuka atau tertutup dan ganti ikon sesuai
    if (show === 'true') {
        // Menu terbuka, ganti ikon menjadi 'chevron-right'
        icon.setAttribute('data-feather', 'chevron-right');
        console.log('Icon set to chevron-right');
        link.setAttribute('aria-expanded', 'false');  // Perbarui aria-expanded
    } else {
        // Menu tertutup, ganti ikon menjadi 'chevron-down'
        icon.setAttribute('data-feather', 'chevron-down');
        console.log('Icon set to chevron-down');
        link.setAttribute('aria-expanded', 'true');  // Perbarui aria-expanded
    }
    console.log('New aria-expanded:', link.getAttribute('aria-expanded'));
    
    // Render ulang ikon setelah perubahan data-feather
    feather.replace();
});

  

 
</script>

>>>>>>> Stashed changes
