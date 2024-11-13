@extends('layouts.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Forms</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pendataan LK</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title" style="background-color: #6572ff; padding:10px; border-radius:3px; color:white;">Pendataan Lembaga Konservasi</h4>
        {{-- <p class="text-muted mb-3">Read the <a href="http://www.jquery-steps.com/GettingStarted" target="_blank"> Official jQuery Steps Documentation </a>for a full list of instructions and other options.</p> --}}
        <div id="wizard">
          <h2>Informasi Status Satwa</h2>
          <section>
            {{-- NAMA LK --}}
            <div id="nama_lk" style="margin:10px 0px; padding-bottom:10px;">
              <h5 style="margin-bottom:7px;">Lembaga Konservasi</h5>
              {{-- <input class="" type="text" name="nama_lk" id="nama_lk" placeholder="Lembaga Konservasi" style="width: 400px; padding:10px;" readonly> --}}
              <div id="nama_lk" style="width: 400px; padding:10px; outline:1px solid rgb(120, 119, 119); color:rgb(120, 119, 119);">
                Lembaga Konservasi
              </div>
            </div>        
        </div>
      </div>
    </div>
  </div>
</div>

{{-- <div class="row">
  <div class="col-md-12 stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Vertical Wizard</h4>
        <div id="wizardVertical">
          <h2>First Step</h2>
          <section>
            <h4>First Step</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut nulla nunc. Maecenas arcu sem, hendrerit a tempor quis, 
                sagittis accumsan tellus. In hac habitasse platea dictumst. Donec a semper dui. Nunc eget quam libero. Nam at felis metus. 
                Nam tellus dolor, tristique ac tempus nec, iaculis quis nisi.</p>
          </section>

          <h2>Second Step</h2>
          <section>
            <h4>Second Step</h4>
            <p>Donec mi sapien, hendrerit nec egestas a, rutrum vitae dolor. Nullam venenatis diam ac ligula elementum pellentesque. 
                In lobortis sollicitudin felis non eleifend. Morbi tristique tellus est, sed tempor elit. Morbi varius, nulla quis condimentum 
                dictum, nisi elit condimentum magna, nec venenatis urna quam in nisi. Integer hendrerit sapien a diam adipiscing consectetur. 
                In euismod augue ullamcorper leo dignissim quis elementum arcu porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Vestibulum leo velit, blandit ac tempor nec, ultrices id diam. Donec metus lacus, rhoncus sagittis iaculis nec, malesuada a diam. 
                Donec non pulvinar urna. Aliquam id velit lacus.</p>
          </section>         
        </div>
      </div>
    </div>
  </div>
</div> --}}
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data_lk.js') }}"></script>  
@endpush