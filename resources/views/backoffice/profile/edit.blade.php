@extends('backoffice.layouts.app')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil Saya')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-user-edit"></i> Edit Profil</h3>
        <a href="{{ route('backoffice.profile.show', $user->id) }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('backoffice.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if($user->no_anggota)
            <div class="alert alert-success">No. Anggota: {{ $user->no_anggota }}</div>
            @endif

            <h4 style="margin-bottom:15px; color:var(--red); border-bottom:2px solid var(--red); padding-bottom:5px;"><i class="fas fa-user"></i> Informasi Dasar</h4>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap <span style="color:red;">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Email <span style="color:red;">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
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
                    <label>No. HP/WA</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>
                <div class="form-group">
                    <label>Posisi/Jabatan</label>
                    <input type="text" name="position" class="form-control" value="{{ old('position', $user->position) }}">
                </div>
            </div>
            <div class="form-group">
                <label>Institusi/Perusahaan</label>
                <input type="text" name="institution" class="form-control" value="{{ old('institution', $user->institution) }}">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" rows="2" class="form-control">{{ old('address', $user->address) }}</textarea>
            </div>
            <div class="form-group">
                <label>Bio</label>
                <textarea name="bio" rows="3" class="form-control">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <h4 style="margin:20px 0 15px; color:var(--red); border-bottom:2px solid var(--red); padding-bottom:5px;"><i class="fas fa-id-badge"></i> Data Pribadi (Kartu Anggota)</h4>
            <div class="form-row">
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $user->tempat_lahir) }}">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', optional($user->tanggal_lahir)->format('Y-m-d')) }}">
                    <small style="color:#666;">Wajib diisi agar No. Anggota otomatis terbuat</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi', $user->provinsi ?? 'Bali') }}">
                    <input type="hidden" name="kode_provinsi" value="{{ old('kode_provinsi', $user->kode_provinsi ?? '51') }}">
                </div>
                <div class="form-group">
                    <label>Motto Hidup</label>
                    <input type="text" name="motto_hidup" class="form-control" value="{{ old('motto_hidup', $user->motto_hidup) }}">
                </div>
            </div>

            <h4 style="margin:20px 0 15px; color:var(--red); border-bottom:2px solid var(--red); padding-bottom:5px;"><i class="fas fa-graduation-cap"></i> Akademik & Keahlian</h4>
            <div class="form-row">
                <div class="form-group">
                    <label>Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" class="form-control" value="{{ old('pendidikan_terakhir', $user->pendidikan_terakhir) }}">
                </div>
                <div class="form-group">
                    <label>Bidang Ilmu</label>
                    <input type="text" name="bidang_ilmu" class="form-control" value="{{ old('bidang_ilmu', $user->bidang_ilmu) }}">
                </div>
            </div>
            <div class="form-group">
                <label>Praktisi Bidang</label>
                <input type="text" name="praktisi_bidang" class="form-control" value="{{ old('praktisi_bidang', $user->praktisi_bidang) }}">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Keahlian Utama</label>
                    <input type="text" name="keahlian_utama" class="form-control" value="{{ old('keahlian_utama', $user->keahlian_utama) }}">
                </div>
                <div class="form-group">
                    <label>Keahlian Penunjang</label>
                    <input type="text" name="keahlian_penunjang" class="form-control" value="{{ old('keahlian_penunjang', $user->keahlian_penunjang) }}">
                </div>
            </div>
            <div class="form-group">
                <label>Minat Riset Bidang</label>
                <input type="text" name="minat_riset_bidang" class="form-control" value="{{ old('minat_riset_bidang', $user->minat_riset_bidang) }}">
            </div>
            <div class="form-group">
                <label>Minat Pengabdian Masyarakat Bidang</label>
                <input type="text" name="minat_pengabdian_bidang" class="form-control" value="{{ old('minat_pengabdian_bidang', $user->minat_pengabdian_bidang) }}">
            </div>
            <div class="form-group">
                <label>Profil</label>
                <textarea name="profil" rows="4" class="form-control">{{ old('profil', $user->profil) }}</textarea>
            </div>
            <div class="form-group">
                <label>Bidang Keahlian (tag, pisah koma)</label>
                <input type="text" name="expertise" class="form-control" value="{{ old('expertise', $user->expertise) }}">
            </div>
            <div class="form-group">
                <label>Riwayat Pendidikan (pisah koma)</label>
                <textarea name="education" rows="2" class="form-control">{{ old('education', $user->education) }}</textarea>
            </div>
            <div class="form-group">
                <label>Sertifikasi (pisah koma)</label>
                <textarea name="certifications" rows="2" class="form-control">{{ old('certifications', $user->certifications) }}</textarea>
            </div>
            <div class="form-group">
                <label>Publikasi (pisah koma)</label>
                <textarea name="publications" rows="2" class="form-control">{{ old('publications', $user->publications) }}</textarea>
            </div>

            <h4 style="margin:20px 0 15px; color:var(--red); border-bottom:2px solid var(--red); padding-bottom:5px;"><i class="fas fa-id-card"></i> ID Riset & Abdimas</h4>
            <div class="form-row">
                <div class="form-group">
                    <label>ORCID ID</label>
                    <input type="text" name="orcid_id" class="form-control" value="{{ old('orcid_id', $user->orcid_id) }}">
                </div>
                <div class="form-group">
                    <label>SINTA ID</label>
                    <input type="text" name="sinta_id" class="form-control" value="{{ old('sinta_id', $user->sinta_id) }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Scopus ID</label>
                    <input type="text" name="scopus_id" class="form-control" value="{{ old('scopus_id', $user->scopus_id) }}">
                </div>
                <div class="form-group">
                    <label>Google Scholar ID</label>
                    <input type="text" name="google_scholar_id" class="form-control" value="{{ old('google_scholar_id', $user->google_scholar_id) }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Publon ID</label>
                    <input type="text" name="publon_id" class="form-control" value="{{ old('publon_id', $user->publon_id) }}">
                </div>
                <div class="form-group">
                    <label>Garuda ID</label>
                    <input type="text" name="garuda_id" class="form-control" value="{{ old('garuda_id', $user->garuda_id) }}">
                </div>
            </div>
            <div class="form-group">
                <label>Researcher ID</label>
                <input type="text" name="researcher_id" class="form-control" value="{{ old('researcher_id', $user->researcher_id) }}">
            </div>

            <h4 style="margin:20px 0 15px; color:var(--red); border-bottom:2px solid var(--red); padding-bottom:5px;"><i class="fas fa-share-alt"></i> Media Sosial</h4>
            <div class="form-group">
                <label>Website</label>
                <input type="url" name="website" class="form-control" value="{{ old('website', $user->website) }}">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Instagram</label>
                    <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $user->instagram) }}">
                </div>
                <div class="form-group">
                    <label>YouTube</label>
                    <input type="url" name="youtube" class="form-control" value="{{ old('youtube', $user->youtube) }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Facebook</label>
                    <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $user->facebook) }}">
                </div>
                <div class="form-group">
                    <label>LinkedIn</label>
                    <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin', $user->linkedin) }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Twitter/X</label>
                    <input type="text" name="twitter" class="form-control" value="{{ old('twitter', $user->twitter) }}">
                </div>
                <div class="form-group">
                    <label>GitHub</label>
                    <input type="text" name="github" class="form-control" value="{{ old('github', $user->github) }}">
                </div>
            </div>

            <h4 style="margin:20px 0 15px; color:var(--red); border-bottom:2px solid var(--red); padding-bottom:5px;"><i class="fas fa-image"></i> Gambar</h4>
            <div style="display:flex; gap:20px; margin-bottom:14px; align-items:center;">
                <img src="{{ $user->foto_url }}" style="width:70px;height:70px;border-radius:50%;object-fit:cover;">
                @if($user->background_url)
                    <img src="{{ $user->background_url }}" style="width:160px;height:50px;object-fit:cover;border-radius:6px;">
                @endif
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Avatar (ganti jika perlu)</label>
                    <input type="file" name="avatar" class="form-control" accept="image/jpeg,image/png,image/jpg">
                </div>
                <div class="form-group">
                    <label>Foto Kartu 350x350 (ganti jika perlu)</label>
                    <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg">
                </div>
            </div>
            <div class="form-group">
                <label>Background Kartu 1150x350 (ganti jika perlu)</label>
                <input type="file" name="background" class="form-control" accept="image/jpeg,image/png,image/jpg">
            </div>

            <div style="display:flex; gap:10px; margin-top:20px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="{{ route('backoffice.profile.show', $user->id) }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection