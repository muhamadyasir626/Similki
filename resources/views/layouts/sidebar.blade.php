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
      <li class="nav-item ">
        <a class="nav-link" data-bs-toggle="collapse" href="#filter" role="button" aria-expanded="" aria-controls="filter">
          <i class="link-icon" data-feather="filter"></i>
          <span class="link-title">Filter</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
      <form method="GET" action="{{ route('dashboard') }}">
        <div class="collapse" id="filter">
          <ul class="nav sub-menu">
            <!-- Filter Lembaga Konservasi -->
            <li class="nav-item">
              <details class="filter-item details">
                <summary class="filter-item-label">Lembaga Konservasi</summary>
                <div class="filter-search">
                  <input type="text" class="search-input" data-filter-type="lk" placeholder="Cari Lembaga Konservasi...">
                </div>
                @foreach ($lks as $lk)
                <label class="filter-label lk">
                <input type="checkbox" name="lks[]" value="{{ $lk->id }}">
                  <span class="dot dot-yellow"></span>
                  {{ $lk->nama }}
                </label>
                @endforeach
              </details>
            </li>

            <!-- Filter UPT -->
            <li class="nav-item">
              <details class="filter-item details">
                <summary class="filter-item-label">UPT</summary>
                <div class="filter-search">
                  <input type="text" class="search-input" data-filter-type="upt" placeholder="Cari UPT...">
                </div>
                @foreach ($upts as $upt)
                <label class="filter-label upt">
                <input type="checkbox" name="upts[]" value="{{ $upt->id }}">
                  <span class="dot dot-yellow"></span>
                  {{ $upt->wilayah }}
                </label>
                @endforeach
              </details>
            </li>

            <!-- Filter Class -->
            <li class="nav-item">
              <details class="filter-item details">
                <summary class="filter-item-label">Class</summary>
                <div class="filter-search">
                  <input type="text" class="search-input" data-filter-type="class" placeholder="Cari Class...">
                </div>
                @foreach ($classes as $class)
                <label class="filter-label class">
                <input type="checkbox" name="classes[]" value="{{ $class->id }}">
                  <span class="dot dot-yellow"></span>
                  {{ $class->class }}
                </label>
                @endforeach
              </details>
            </li>
          </ul>
      </div>
    <button type="submit">Filter</button>
  </form>
    
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

<script>
 document.addEventListener("DOMContentLoaded", function () {
  // Fungsi untuk filter item
  function filterItems(event) {
    const searchTerm = event.target.value.toLowerCase(); // Ambil input pencarian
    const filterType = event.target.getAttribute("data-filter-type"); // Jenis filter

    // Seleksi elemen yang sesuai dengan tipe filter
    document.querySelectorAll(`.filter-label.${filterType}`).forEach(label => {
      const text = label.textContent.toLowerCase(); // Ambil teks label
      if (text.includes(searchTerm)) {
        label.style.display = ""; // Tampilkan jika cocok
      } else {
        label.style.display = "none"; // Sembunyikan jika tidak cocok
      }
    });
  }

  // Tambahkan event listener untuk setiap input pencarian
  document.querySelectorAll(".search-input").forEach(input => {
    input.addEventListener("input", filterItems);
  });
});

</script>
