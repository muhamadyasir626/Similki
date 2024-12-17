<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand" id="{{ strtolower($user->role->tag) }}">
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
      <li class="nav-item {{ active_class('dashboard') }}">
        <a href="{{ url('/dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="home"></i>
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
      <li class="nav-item {{ active_class('lembaga-konservasi') }}">
        <a href="{{ route('lembaga-konservasi.index') }}" class="nav-link">
          <i class="link-icon" data-feather="list"></i>
          <span class="link-title">Daftar Isi LK</span>
        </a>
      </li>
      <li class="nav-item {{ active_class('monitoring-lk') }}">
        <a href="{{ route('monitoring-lk') }}" class="nav-link">
          <i class="link-icon" data-feather="monitor"></i>
          <span class="link-title">Monitoring LK</span>
        </a>
      </li>
      <li class="nav-item {{ active_class('pendataan-lk') }}">
        <a href="#" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pendataan LK</span>
        </a>
      </li>
      <li class="nav-item {{ active_class('import-lk') }}">
        <a href="#" class="nav-link">
          <i class="link-icon" data-feather="upload"></i>
          <span class="link-title">Import File</span>
        </a>
      </li>
      <li class="nav-item {{ active_class('export-lk') }}">
        <a href="#" class="nav-link">
          <i class="link-icon" data-feather="download"></i>
          <span class="link-title">Export File</span>
        </a>
      </li>

      <li class="nav-item nav-category">SATWA</li>
      <li class="nav-item {{ active_class('satwa') }}">
        <a href="{{ route('satwa.index') }}" class="nav-link">
          <i class="link-icon" data-feather="list"></i>
          <span class="link-title">Daftar Isi Satwa</span>
        </a>
      </li>
      <li class="nav-item {{ active_class('pendataan-satwa') }}">
        <a href="{{ route('form-satwa') }}" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pendataan Satwa</span>
        </a>
      <li class="nav-item {{ active_class('pendataan-silsilah') }}">
        <a href="{{ route('form-silsilah') }}" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pendataan Silsilah Satwa</span>
        </a>
      </li>
      <li class="nav-item {{ active_class('kesehatan-satwa') }}">
        <a href="#" class="nav-link">
          <i class="link-icon" data-feather="activity"></i>
          <span class="link-title">Kesehatan Satwa</span>
        </a>
      </li>
      <li class="nav-item {{ active_class('sanitasi-satwa') }}">
        <a href="#" class="nav-link">
          <i class="link-icon" data-feather="shield"></i>
          <span class="link-title">Sanitasi Satwa</span>
        </a>
      </li>
      <li class="nav-item {{ active_class('import-satwa') }}">
        <a href="#" class="nav-link">
          <i class="link-icon" data-feather="upload"></i>
          <span class="link-title">Import File</span>
        </a>
      </li>
      <li class="nav-item {{ active_class('export-satwa') }}">
        <a href="#" class="nav-link">
          <i class="link-icon" data-feather="download"></i>
          <span class="link-title">Export File</span>
        </a>
      </li>

      <li class="nav-item nav-category">Verifikasi Akun</li>
      <li class="nav-item {{ active_class('verifikasi-akun') }}">
        <a href="{{ route('verifikasi-akun') }}" class="nav-link">
          <i class="link-icon" data-feather="unlock"></i>
          <span class="link-title">Perizinan Akses</span>
        </a>
      </li>
    </ul>
  </div>
</nav>


<script src="search-filter.js"></script> 

