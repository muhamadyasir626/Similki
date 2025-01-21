{{-- @extends('layouts.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Forms</a></li>
    <li class="breadcrumb-item active" aria-current="page">Daftar Satwa Titipan</li>
  </ol>
</nav>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Daftar Satwa Titipan</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama ilmiah</th>
                        <th>Nama lokal</th>
                        <th>English name</th>
                        <th>No BAP</th>
                        <th>Asal Satwa</th>
                        <th>Jumlah Jantan</th>
                        <th>Jumlah Betina</th>
                        <th>Jumlah Unknown</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @foreach ($satwaTitipan as $satwa)
                    <tr>
                        <td>{{ $satwa->nama_ilmiah }}</td>
                        <td>{{ $satwa->nama_lokal }}</td>
                        <td>{{ $satwa->english_name }}</td>
                        <td>{{ $satwa->no_bap_titipan }}</td>
                        <td>{{ $satwa->asal_satwa }}</td>
                        <td>{{ $satwa->jumlah_satwa_jantan }}</td>
                        <td>{{ $satwa->jumlah_satwa_betina }}</td>
                        <td>{{ $satwa->jumlah_satwa_unknown }}</td>
                        <td>
                            <!-- Add actions like view, edit, delete if needed -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection --}}


@extends('layouts.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Forms</a></li>
    <li class="breadcrumb-item active" aria-current="page">Daftar Satwa Titipan</li>
  </ol>
</nav>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Daftar Satwa Titipan</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama ilmiah</th>
                        <th>Nama lokal</th>
                        <th>English name</th>
                        <th>No BAP</th>
                        <th>Asal Satwa</th>
                        <th>Jumlah Jantan</th>
                        <th>Jumlah Betina</th>
                        <th>Jumlah Unknown</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $satwaTitipan = [
                            [
                                'nama_ilmiah' => 'Panthera tigris',
                                'nama_lokal' => 'Harimau Sumatera',
                                'english_name' => 'Sumatran Tiger',
                                'no_bap_titipan' => 'BAP001',
                                'asal_satwa' => 'Sumatera',
                                'jumlah_satwa_jantan' => 2,
                                'jumlah_satwa_betina' => 1,
                                'jumlah_satwa_unknown' => 0,
                            ],
                            [
                                'nama_ilmiah' => 'Elephas maximus',
                                'nama_lokal' => 'Gajah Asia',
                                'english_name' => 'Asian Elephant',
                                'no_bap_titipan' => 'BAP002',
                                'asal_satwa' => 'Kalimantan',
                                'jumlah_satwa_jantan' => 1,
                                'jumlah_satwa_betina' => 2,
                                'jumlah_satwa_unknown' => 1,
                            ],
                            [
                                'nama_ilmiah' => 'Orangutan pygmaeus',
                                'nama_lokal' => 'Orangutan Kalimantan',
                                'english_name' => 'Bornean Orangutan',
                                'no_bap_titipan' => 'BAP003',
                                'asal_satwa' => 'Kalimantan',
                                'jumlah_satwa_jantan' => 0,
                                'jumlah_satwa_betina' => 1,
                                'jumlah_satwa_unknown' => 2,
                            ],
                        ];
                    @endphp

                    @foreach ($satwaTitipan as $satwa)
                    <tr>
                        <td>{{ $satwa['nama_ilmiah'] }}</td>
                        <td>{{ $satwa['nama_lokal'] }}</td>
                        <td>{{ $satwa['english_name'] }}</td>
                        <td>{{ $satwa['no_bap_titipan'] }}</td>
                        <td>{{ $satwa['asal_satwa'] }}</td>
                        <td>{{ $satwa['jumlah_satwa_jantan'] }}</td>
                        <td>{{ $satwa['jumlah_satwa_betina'] }}</td>
                        <td>{{ $satwa['jumlah_satwa_unknown'] }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    &#x22EE;
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#">View</a></li>
                                    <li><a class="dropdown-item" href="#">Edit</a></li>
                                    <li><a class="dropdown-item" href="#">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection