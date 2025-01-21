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
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Calon LK</th>
                        <th>Nama Direktur</th>
                        <th>NIB</th>
                        <th>NPWP</th>
                        <th>Email</th>
                        <th>Bentuk LK</th>
                        <th>Alamat LK</th>
                        <th>Jumlah Investasi</th>
                        <th>Jumlah Tenaga Kerja</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
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
                            ],
                            (object) [
                                'nama_calon_lk' => 'Nama Ilmiah 2',
                                'nama_direktur' => 'Direktur 2',
                                'nib' => '234567',
                                'npwp' => '876543210',
                                'email_lk' => 'email2@domain.com',
                                'bentuk_lk' => 'umum',
                                'alamat_lk' => 'jalan hihu',
                                'jumlah_investasi' => 150000000,
                                'jumlah_tenaga_kerja' => 15,
                            ],
                            (object) [
                                'nama_calon_lk' => 'Nama Ilmiah 3',
                                'nama_direktur' => 'Direktur 3',
                                'nib' => '345678',
                                'npwp' => '765432109',
                                'email_lk' => 'email3@domain.com',
                                'bentuk_lk' => 'umum',
                                'alamat_lk' => 'jalan hihu',
                                'jumlah_investasi' => 200000000,
                                'jumlah_tenaga_kerja' => 20,
                            ]
                        ];
                    @endphp
                    @foreach ($persetujuanRKPList as $item)
                    <tr>
                        <td>{{ $item->nama_calon_lk }}</td>
                        <td>{{ $item->nama_direktur }}</td>
                        <td>{{ $item->nib }}</td>
                        <td>{{ $item->npwp }}</td>
                        <td>{{ $item->email_lk }}</td>
                        <td>{{ $item->bentuk_lk }}</td>
                        <td>{{ $item->alamat_lk }}</td>
                        <td>{{ $item->jumlah_investasi }}</td>
                        <td>{{ $item->jumlah_tenaga_kerja }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-danger">Verifikasi</button>
                                
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
