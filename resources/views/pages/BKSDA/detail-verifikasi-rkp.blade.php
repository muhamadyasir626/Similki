@extends('layouts.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Forms</a></li>
    <li class="breadcrumb-item active" aria-current="page">Daftar Persetujuan RKP</li>
  </ol>
</nav>

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Daftar Persetujuan RKP</h4>
            @php
                // Data Dummy
                $persetujuanRKPList = [
                    (object) [
                        'nama_calon_lk' => 'Nama Ilmiah 1',
                        'nama_direktur' => 'Direktur 1',
                        'nib' => '123456',
                        'npwp' => '987654321',
                        'email_lk' => 'email1@domain.com',
                        'bentuk_lk' => 'umum',
                        'alamat_lk' => 'jalan hihu',
                        'jumlah_investasi' => 100000000,
                        'jumlah_tenaga_kerja' => 10,
                    ]
                ];
            @endphp

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($persetujuanRKPList as $item)
                    <tr>
                        <td><strong>Nama Calon LK</strong></td>
                        <td>{{ $item->nama_calon_lk }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Direktur</strong></td>
                        <td>{{ $item->nama_direktur }}</td>
                    </tr>
                    <tr>
                        <td><strong>NIB</strong></td>
                        <td>{{ $item->nib }}</td>
                    </tr>
                    <tr>
                        <td><strong>NPWP</strong></td>
                        <td>{{ $item->npwp }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{ $item->email_lk }}</td>
                    </tr>
                    <tr>
                        <td><strong>Bentuk LK</strong></td>
                        <td>{{ $item->bentuk_lk }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat LK</strong></td>
                        <td>{{ $item->alamat_lk }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah Investasi</strong></td>
                        <td>{{ number_format($item->jumlah_investasi, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah Tenaga Kerja</strong></td>
                        <td>{{ $item->jumlah_tenaga_kerja }}</td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr> <!-- Separator for next item -->
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
