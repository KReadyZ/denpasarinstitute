@extends('backoffice.layouts.app')

@section('title', 'Edit Konsultan')
@section('page-title', 'Edit Anggota Konsultan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-user-edit"></i> Form Edit Konsultan</h3>
        <a href="{{ route('backoffice.konsultan.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('backoffice.konsultan.update', $konsultan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h4 style="margin-bottom: 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;"><i class="fas fa-user"></i> Informasi Dasar</h4>

            @if($konsultan->no_anggota)
            <div class="alert" style="background:#f5f5f5; padding:10px; border-radius:5px; margin-bottom:15px;">
                <strong>No. Anggota:</strong> {{ $konsultan->no_anggota }}
            </div>
            @endif

            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap <span style="color:red;">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $konsultan->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Email <span style="color:red;">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $konsultan->email) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Password Baru (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>NIP/NIM</label>
                    <input type="text" name="nip_nim" class="form-control" value="{{ old('nip_nim', $konsultan->nip_nim) }}">
                </div>
                <div class="form-group">
                    <label>No. HP/WA</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $konsultan->phone) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Posisi/Jabatan</label>
                    <input type="text" name="position" class="form-control" value="{{ old('position', $konsultan->position) }}">
                </div>
                <div class="form-group">
                    <label>Institusi/Perusahaan</label>
                    <input type="text" name="institution" class="form-control" value="{{ old('institution', $konsultan->institution) }}">
                </div>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" rows="2" class="form-control">{{ old('address', $konsultan->address) }}</textarea>
            </div>
            <div class="form-group">
                <label>Bio</label>
                <textarea name="bio" rows="3" class="form-control">{{ old('bio', $konsultan->bio) }}</textarea>
            </div>

            <h4 style="margin: 20px 0 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;"><i class="fas fa-id-badge"></i> Data Pribadi (Kartu Anggota)</h4>

            <div class="form-row">
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $konsultan->tempat_lahir) }}">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', optional($konsultan->tanggal_lahir)->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Kode Provinsi</label>
                    <input type="text" name="kode_provinsi" maxlength="2" class="form-control" value="{{ old('kode_provinsi', $konsultan->kode_provinsi ?? '51') }}">
                </div>
                <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi', $konsultan->provinsi) }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Motto Hidup</label>
                    <input type="text" name="motto_hidup" class="form-control" value="{{ old('motto_hidup', $konsultan->motto_hidup) }}">
                </div>
                <div class="form-group">
                    <label>Kartu Berlaku s.d</label>
                    <input type="date" name="berlaku_sd" class="form-control" value="{{ old('berlaku_sd', optional($konsultan->berlaku_sd)->format('Y-m-d')) }}">
                </div>
            </div>

            <h4 style="margin: 20px 0 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;"><i class="fas fa-graduation-cap"></i> Akademik & Keahlian</h4>

            <div class="form-row">
                <div class="form-group">
                    <label>Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" class="form-control" value="{{ old('pendidikan_terakhir', $konsultan->pendidikan_terakhir) }}">
                </div>
                <div class="form-group">
                    <label>Bidang Ilmu</label>
                    <input type="text" name="bidang_ilmu" class="form-control" value="{{ old('bidang_ilmu', $konsultan->bidang_ilmu) }}">
                </div>
            </div>
            <div class="form-group">
                <label>Praktisi Bidang</label>
                <input type="text" name="praktisi_bidang" class="form-control" value="{{ old('praktisi_bidang', $konsultan->praktisi_bidang) }}">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Keahlian Utama</label>
                    <input type="text" name="keahlian_utama" class="form-control" value="{{ old('keahlian_utama', $konsultan->keahlian_utama) }}">
                </div>
                <div class="form-group">
                    <label>Keahlian Penunjang</label>
                    <input type="text" name="keahlian_penunjang" class="form-control" value="{{ old('keahlian_penunjang', $konsultan->keahlian_penunjang) }}">
                </div>
            </div>
            <div class="form-group">
                <label>Minat Riset Bidang</label>
                <input type="text" name="minat_riset_bidang" class="form-control" value="{{ old('minat_riset_bidang', $konsultan->minat_riset_bidang) }}">
            </div>
            <div class="form-group">
                <label>Minat Pengabdian Masyarakat Bidang</label>
                <input type="text" name="minat_pengabdian_bidang" class="form-control" value="{{ old('minat_pengabdian_bidang', $konsultan->minat_pengabdian_bidang) }}">
            </div>
            <div class="form-group">
                <label>Profil</label>
                <textarea name="profil" rows="4" class="form-control">{{ old('profil', $konsultan->profil) }}</textarea>
            </div>
            <div class="form-group">
                <label>Bidang Keahlian (tag)</label>
                <input type="text" name="expertise" class="form-control" value="{{ old('expertise', $konsultan->expertise) }}">
            </div>
            <div class="form-group">
                <label>Riwayat Pendidikan</label>
                <textarea name="education" rows="2" class="form-control">{{ old('education', $konsultan->education) }}</textarea>
            </div>
            <div class="form-group">
                <label>Sertifikasi</label>
                <textarea name="certifications" rows="2" class="form-control">{{ old('certifications', $konsultan->certifications) }}</textarea>
            </div>
            <div class="form-group">
                <label>Publikasi</label>
                <textarea name="publications" rows="2" class="form-control">{{ old('publications', $konsultan->publications) }}</textarea>
            </div>

            <h4 style="margin: 20px 0 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;"><i class="fas fa-id-card"></i> ID Riset & Abdimas</h4>

            <div class="form-row">
                <div class="form-group">
                    <label>ORCID ID</label>
                    <input type="text" name="orcid_id" class="form-control" value="{{ old('orcid_id', $konsultan->orcid_id) }}">
                </div>
                <div class="form-group">
                    <label>SINTA ID</label>
                    <input type="text" name="sinta_id" class="form-control" value="{{ old('sinta_id', $konsultan->sinta_id) }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Scopus ID</label>
                    <input type="text" name="scopus_id" class="form-control" value="{{ old('scopus_id', $konsultan->scopus_id) }}">
                </div>
                <div class="form-group">
                    <label>Google Scholar ID</label>
                    <input type="text" name="google_scholar_id" class="form-control" value="{{ old('google_scholar_id', $konsultan->google_scholar_id) }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Publon ID</label>
                    <input type="text" name="publon_id" class="form-control" value="{{ old('publon_id', $konsultan->publon_id) }}">
                </div>
                <div class="form-group">
                    <label>Garuda ID</label>
                    <input type="text" name="garuda_id" class="form-control" value="{{ old('garuda_id', $konsultan->garuda_id) }}">
                </div>
            </div>
            <div class="form-group">
                <label>Researcher ID</label>
                <input type="text" name="researcher_id" class="form-control" value="{{ old('researcher_id', $konsultan->researcher_id) }}">
            </div>

            <h4 style="margin: 20px 0 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;"><i class="fas fa-share-alt"></i> Media Sosial & Website</h4>

            <div class="form-group">
                <label>Website</label>
                <input type="url" name="website" class="form-control" value="{{ old('website', $konsultan->website) }}">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Instagram</label>
                    <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $konsultan->instagram) }}">
                </div>
                <div class="form-group">
                    <label>YouTube</label>
                    <input type="url" name="youtube" class="form-control" value="{{ old('youtube', $konsultan->youtube) }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Facebook</label>
                    <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $konsultan->facebook) }}">
                </div>
                <div class="form-group">
                    <label>LinkedIn</label>
                    <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin', $konsultan->linkedin) }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Twitter/X</label>
                    <input type="text" name="twitter" class="form-control" value="{{ old('twitter', $konsultan->twitter) }}">
                </div>
                <div class="form-group">
                    <label>GitHub</label>
                    <input type="text" name="github" class="form-control" value="{{ old('github', $konsultan->github) }}">
                </div>
            </div>

            <h4 style="margin: 20px 0 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;"><i class="fas fa-image"></i> Gambar</h4>

            @if($konsultan->avatar)
                <p><img src="{{ $konsultan->avatar_url }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;"></p>
            @endif
            <div class="form-row">
                <div class="form-group">
                    <label>Avatar (ganti jika perlu)</label>
                    <input type="file" name="avatar" class="form-control" accept="image/jpeg,image/png,image/jpg">
                </div>
                <div class="form-group">
                    <label>Foto Kartu (ganti jika perlu)</label>
                    <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg">
                </div>
            </div>
            <div class="form-group">
                <label>Background Kartu (ganti jika perlu)</label>
                <input type="file" name="background" class="form-control" accept="image/jpeg,image/png,image/jpg">
            </div>

            <h4 style="margin: 20px 0 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;"><i class="fas fa-cog"></i> Pengaturan Akun</h4>

            <div class="form-row">
                <div class="form-group">
                    <label>Tipe Membership <span style="color:red;">*</span></label>
                    <select name="membership_type" class="form-control" required>
                        <option value="regular" {{ old('membership_type', $konsultan->membership_type) == 'regular' ? 'selected' : '' }}>Regular</option>
                        <option value="premium" {{ old('membership_type', $konsultan->membership_type) == 'premium' ? 'selected' : '' }}>Premium</option>
                        <option value="vip" {{ old('membership_type', $konsultan->membership_type) == 'vip' ? 'selected' : '' }}>VIP</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status Akun</label>
                    <select name="is_active" class="form-control">
                        <option value="1" {{ old('is_active', $konsultan->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $konsultan->is_active) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:20px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('backoffice.konsultan.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection