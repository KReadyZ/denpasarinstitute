<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const KODE_JENIS_ANGGOTA = [
        'konsultan' => '369',
        'grcs'      => '369',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'nip_nim',
        'phone',
        'address',
        'avatar',
        'position',
        'institution',
        'bio',
        'orcid_id',
        'scopus_id',
        'sinta_id',
        'google_scholar_id',
        'website',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'github',
        'youtube',
        'expertise',
        'education',
        'certifications',
        'publications',
        'membership_type',
        'member_since',
        'profile_completed_at',
        'role',
        'is_active',

        'no_anggota',
        'berlaku_sd',
        'tempat_lahir',
        'tanggal_lahir',
        'kode_provinsi',
        'provinsi',
        'motto_hidup',
        'pendidikan_terakhir',
        'bidang_ilmu',
        'praktisi_bidang',
        'keahlian_utama',
        'keahlian_penunjang',
        'minat_riset_bidang',
        'minat_pengabdian_bidang',
        'profil',
        'publon_id',
        'garuda_id',
        'researcher_id',
        'foto',
        'background',
        'kartu_path',

        'nama_instansi',
        'jenis_instansi',
        'verification_status',
        'verified_at',
        'verified_by',
        'rejection_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'expertise' => 'array',
            'education' => 'array',
            'certifications' => 'array',
            'publications' => 'array',
            'member_since' => 'datetime',
            'profile_completed_at' => 'datetime',
            'tanggal_lahir' => 'date',
            'berlaku_sd' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (User $user) {
            if (in_array($user->role, ['konsultan', 'grcs']) && empty($user->no_anggota)) {
                $user->no_anggota = self::generateNoAnggota(
                    $user->role,
                    $user->tanggal_lahir,
                    $user->kode_provinsi ?? '51'
                );
            }

            if ($user->role === 'mitra' && empty($user->verification_status)) {
                $user->verification_status = 'pending';
            }
        });
    }

    public static function generateNoAnggota(string $role, $tanggalLahir, string $kodeProvinsi = '51'): string
    {
        $kodeJenis = self::KODE_JENIS_ANGGOTA[$role] ?? '999';

        $tgl = $tanggalLahir ? Carbon::parse($tanggalLahir) : now();
        $tglFormat = $tgl->format('dmy');

        $lastUser = self::where('role', $role)
            ->where('kode_provinsi', $kodeProvinsi)
            ->whereNotNull('no_anggota')
            ->whereRaw("DATE_FORMAT(tanggal_lahir, '%d%m%y') = ?", [$tglFormat])
            ->latest('id')
            ->first();

        if ($lastUser) {
            $lastNo = $lastUser->no_anggota;
            $parts = explode('.', $lastNo);
            $lastUrutan = (int) (end($parts) ?? 0);
            $nomorUrut = str_pad($lastUrutan + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nomorUrut = '001';
        }

        return "{$kodeJenis}.{$kodeProvinsi}.{$tglFormat}.{$nomorUrut}";
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=CC0000&color=fff&size=200';
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return Storage::url($this->foto);
        }
        return $this->avatar_url;
    }

    public function getBackgroundUrlAttribute()
    {
        return $this->background ? Storage::url($this->background) : null;
    }

    public function getKartuUrlAttribute()
    {
        return $this->kartu_path ? Storage::url($this->kartu_path) : null;
    }

    public function getProfileCompletionAttribute()
    {
        $fields = ['phone', 'address', 'position', 'institution', 'bio', 'avatar'];
        $filled = 0;

        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filled++;
            }
        }

        return round(($filled / count($fields)) * 100);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isKonsultan(): bool
    {
        return $this->role === 'konsultan';
    }

    public function isGrcs(): bool
    {
        return $this->role === 'grcs';
    }

    public function isMitra(): bool
    {
        return $this->role === 'mitra';
    }

    public function isVerified(): bool
    {
        return $this->verification_status === 'approved';
    }

    public function scopeKonsultan($query)
    {
        return $query->where('role', 'konsultan');
    }

    public function scopeGrcs($query)
    {
        return $query->where('role', 'grcs');
    }

    public function scopeMitra($query)
    {
        return $query->where('role', 'mitra');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePendingVerification($query)
    {
        return $query->where('role', 'mitra')->where('verification_status', 'pending');
    }
}