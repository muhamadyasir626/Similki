@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endpush

<nav class="sidebar">
  <div class="sidebar-header">
    {{-- <a href="#" class="sidebar-brand" id="{{ strtolower($user->role->tag) }}">
      {{ $user->role->tag }}
    </a> --}}
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      {{-- <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ url('/dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="home"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li> --}}

      <li class="nav-item {{ active_class(['dashboard']) }}">
        <a href="{{ url('/dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="home"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>
      
      <li class="nav-item nav-category">LEMBAGA KONSERVASI</li>
      
      <li class="nav-item {{ active_class(['lembaga-konservasi']) }}">
        <a href="{{ route('lembaga-konservasi.index') }}" class="nav-link">
          <i class="link-icon" data-feather="monitor"></i>
          <span class="link-title">Daftar isi LK</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['monitoring']) }}">
        <a href="{{ route('monitoring-lk') }}" class="nav-link">
          <i class="link-icon" data-feather="monitor"></i>
          <span class="link-title">Monitoring LK</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['lembaga-konservasi/create']) }}">
        <a href="{{ url('/lembaga-konservasi/create') }}" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pendataan LK </span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['lembaga-konservasi/import']) }}">
        <a href={{ route('import-lk') }} class="nav-link">
          <i class="link-icon" data-feather="upload"></i>
          <span class="link-title">Import File</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['lembaga-konservasi/export']) }}">
        <a href="{{ route('export-lk') }}" class="nav-link">
          <i class="link-icon" data-feather="download"></i>
          <span class="link-title">Export File </span>
        </a>
      </li>

      <li class="nav-item nav-category">SATWA</li>
      <li class="nav-item {{ active_class(['satwa']) }}">
        <a href="{{ route('satwa.index') }}" class="nav-link">
          <i class="link-icon" data-feather="list"></i>
          <span class="link-title">Daftar Isi Satwa </span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['pendataan-satwa']) }}">
        <a href="{{ route('form-satwa') }}" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title">Pendataan Satwa</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/pendataan-satwa-titipan']) }}">
        <a href="{{route('pendataan-satwa-titipan')}}" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title"> Pendataan Satwa Titipan </span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/store-satwa-titipan']) }}">
        <a href="{{route('store-satwa-titipan')}}" class="nav-link">
          <i class="link-icon" data-feather="plus-circle"></i>
          <span class="link-title"> Store Satwa Titipan </span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['/persetujuan-rkp']) }}">
        <a href="{{ route('persetujuan-rkp') }}" class="nav-link">
            <i class="link-icon" data-feather="plus-circle"></i>
            <span class="link-title"> Persetujuan RKP </span>
        </a>
      </li>       
      <li class="nav-item {{ active_class(['/daftar-persetujuan-rkp']) }}">
        <a href="{{ route('daftar-persetujuan-rkp') }}" class="nav-link">
            <i class="link-icon" data-feather="plus-circle"></i>
            <span class="link-title"> Daftar Persetujuan RKP </span>
        </a>
      </li>       
      <li class="nav-item {{ active_class(['/detail-verifikasi-rkp']) }}">
        <a href="{{ route('detail-verifikasi-rkp') }}" class="nav-link">
            <i class="link-icon" data-feather="plus-circle"></i>
            <span class="link-title"> Verifikasi RKP </span>
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
     
      <li class="nav-item nav-category">Log Activity</li>
      <li class="nav-item {{ active_class(['activity-log/index']) }}">
        <a href="{{ route('activity-log') }}" class="nav-link">
          <i class="link-icon" data-feather="lock"></i>
          <span class="link-title">History</span>
        </a>
      </li>

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
