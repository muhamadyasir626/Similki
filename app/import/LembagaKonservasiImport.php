<?php

namespace App\Imports;

use App\Models\LembagaKonservasi;
use Maatwebsite\Excel\Concerns\ToModel;

class LembagaKonservasiImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return LembagaKonservasi|null
     */
    public function model(array $row)
    {
        return new LembagaKonservasi([
            'nama'                 => $row[0],
            'slug'                 => $row[1],
            'id_upt'               => $row[2],
            'alamat'               => $row[3],
            'provinsi'             => $row[4],
            'kota_kab'             => $row[5],
            'kelurahan'            => $row[6],
            'kecamatan'            => $row[7],
            'kode_pos'             => $row[8],
            'tahun_izin'           => $row[9],
            'no_izin_peroleh'      => $row[10],
            'link_sk'              => $row[11],
            'legalitas_perizinan'  => $row[12],
            'nomor_tanggal_surat'  => $row[13],
            'bentuk_lk'            => $row[14],
            'pengelola'            => $row[15],
            'nama_pimpinan'        => $row[16],
            'izin_perolehan_tsl'   => $row[17],
            'tahun_akreditasi'     => $row[18],
            'nilai_akreditasi'     => $row[19],
            'pks_dengan_lk_lain'   => $row[20],
        ]);
    }
}
