<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Verifikasi;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function verifikasi(){
        return $this->hasOne(Verifikasi::class);
    }
    public function role(){
        return $this->belongsTo(Role::class,'id_role');
    }
    public function upt(){
        return $this->belongsTo(ListUpt::class,'id_upt');
    }
    public function spesies(){
        return $this->belongsTo(ListSpecies::class,'id_spesies');
    }
    public function lk(){
        return $this->belongsTo(LembagaKonservasi::class,'id_lk');
    }
    public function riwayat_satwa(){
        return $this->hasMany(RiwayatSatwa::class);
    }
    public function riwayat_lk(){
        return $this->hasMany(RiwayatLk::class);
    }
    public function satwaperolehan(){
        return $this->hasOne(SatwaPerolehan::class);
    }
}
