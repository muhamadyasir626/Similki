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
      {{-- <li class="nav-item nav-category">Main</li> --}}
      <li class="nav-item {{ active_class('dashboard') }}">
        <a href="{{ url('/dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="box"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>


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
          <i class="link-icon" data-feather="monitor"></i>
          <span class="link-title">Monitoring LK</span>
        </a>
      </li>
      <li class="nav-item {{ active_class('daftar-pengajuan-lk') }}">
        <a href="{{ route('daftar-pengajuan-lk') }}" class="nav-link">
          <i class="link-icon" data-feather="monitor"></i>
          <span class="link-title">Daftar Pengajuan</span>
        </a>
      </li>
      @endif

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
        <a href="{{ route('satwa.index') }}" class="nav-link">
          <i class="link-icon" data-feather="list"></i>
          <span class="link-title">Daftar Isi Satwa </span>
        </a>
      </li>
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
      

      

     

    </ul>
  </div>

</nav>

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

