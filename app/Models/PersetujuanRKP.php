<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersetujuanRKP extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini (jika tabel tidak menggunakan penamaan default 'persetujuan_r_k_p')
    protected $table = 'persetujuan_rkp';

    // Tentukan kolom-kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'nama_calon_lk',
        'nama_direktur',
        'bentuk_lk',
        'nib',
        'npwp',
        'email_lk',
        'jumlah_investasi',
        'jumlah_tenaga_kerja',
        'site_plan',
        'dokumen_persetujuan_lingkungan',
        'draft_rkp',
        'surat_permohonan',
    ];

    // Tentukan kolom yang harus diperlakukan sebagai tipe data tanggal jika ada (misalnya, 'created_at', 'updated_at')
    protected $dates = [
        'created_at', 
        'updated_at',
    ];

    // Jika Anda ingin menggunakan timestamp (created_at dan updated_at), biarkan properti ini
    public $timestamps = true;

    // Tentukan kolom yang tidak bisa diisi (bukan mass assignable)
    // protected $guarded = ['id'];
}
