@extends('backoffice.layouts.app')

@section('title', 'Tambah GRCS')
@section('page-title', 'Tambah Anggota GRCS Club')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-user-plus"></i> Form Tambah GRCS Club</h3>
        <a href="{{ route('backoffice.grcs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('backoffice.grcs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Informasi Dasar -->
            <h4 style="margin-bottom: 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;">
                <i class="fas fa-user"></i> Informasi Dasar
            </h4>

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nama Lengkap <span style="color: red;">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name') <small style="color: red;">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email <span style="color: red;">*</span></label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email') <small style="color: red;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password <span style="color: red;">*</span></label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    <small style="color: #666;">Minimal 8 karakter</small>
                    @error('password') <br><small style="color: red;">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password <span style="color: red;">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nip_nim">NIP/NIM</label>
                    <input type="text" name="nip_nim" id="nip_nim" class="form-control" value="{{ old('nip_nim') }}">
                </div>
                <div class="form-group">
                    <label for="phone">No. HP/WA</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="position">Posisi/Jabatan</label>
                    <input type="text" name="position" id="position" class="form-control" value="{{ old('position') }}" placeholder="Contoh: Ketua, Sekretaris, Anggota, dll">
                </div>
                <div class="form-group">
                    <label for="institution">Institusi/Perusahaan</label>
                    <input type="text" name="institution" id="institution" class="form-control" value="{{ old('institution') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea name="address" id="address" rows="2" class="form-control">{{ old('address') }}</textarea>
            </div>

            <div class="form-group">
                <label for="bio">Bio / Deskripsi Singkat</label>
                <textarea name="bio" id="bio" rows="3" class="form-control" placeholder="Tuliskan deskripsi singkat tentang anggota GRCS...">{{ old('bio') }}</textarea>
            </div>

            <!-- Data Pribadi untuk Kartu Anggota -->
            <h4 style="margin: 20px 0 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;">
                <i class="fas fa-id-badge"></i> Data Pribadi (Kartu Anggota)
            </h4>

            <div class="form-row">
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}">
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                    <small style="color: #666;">Wajib diisi agar No. Anggota otomatis dibuat</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="kode_provinsi">Kode Provinsi</label>
                    <input type="text" name="kode_provinsi" id="kode_provinsi" maxlength="2" class="form-control" value="{{ old('kode_provinsi', '51') }}">
                </div>
                <div class="form-group">
                    <label for="provinsi">Provinsi</label>
                    <input type="text" name="provinsi" id="provinsi" class="form-control" value="{{ old('provinsi', 'Bali') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="motto_hidup">Motto Hidup</label>
                    <input type="text" name="motto_hidup" id="motto_hidup" class="form-control" value="{{ old('motto_hidup') }}">
                </div>
                <div class="form-group">
                    <label for="berlaku_sd">Kartu Berlaku s.d</label>
                    <input type="date" name="berlaku_sd" id="berlaku_sd" class="form-control" value="{{ old('berlaku_sd') }}">
                </div>
            </div>

            <!-- ID Riset & Abdimas -->
            <h4 style="margin: 20px 0 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;">
                <i class="fas fa-id-card"></i> ID Riset & Abdimas
            </h4>

            <div class="form-row">
                <div class="form-group">
                    <label for="orcid_id">ORCID ID</label>
                    <input type="text" name="orcid_id" id="orcid_id" class="form-control" value="{{ old('orcid_id') }}">
                </div>
                <div class="form-group">
                    <label for="sinta_id">SINTA ID</label>
                    <input type="text" name="sinta_id" id="sinta_id" class="form-control" value="{{ old('sinta_id') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="scopus_id">Scopus ID</label>
                    <input type="text" name="scopus_id" id="scopus_id" class="form-control" value="{{ old('scopus_id') }}">
                </div>
                <div class="form-group">
                    <label for="google_scholar_id">Google Scholar ID</label>
                    <input type="text" name="google_scholar_id" id="google_scholar_id" class="form-control" value="{{ old('google_scholar_id') }}">
                </div>
            </div>

            <!-- Media Sosial -->
            <h4 style="margin: 20px 0 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;">
                <i class="fas fa-share-alt"></i> Media Sosial & Website
            </h4>

            <div class="form-group">
                <label for="website">Website</label>
                <input type="url" name="website" id="website" class="form-control" value="{{ old('website') }}" placeholder="https://example.com">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="instagram"><i class="fab fa-instagram"></i> Instagram</label>
                    <input type="text" name="instagram" id="instagram" class="form-control" value="{{ old('instagram') }}">
                </div>
                <div class="form-group">
                    <label for="youtube"><i class="fab fa-youtube"></i> YouTube</label>
                    <input type="url" name="youtube" id="youtube" class="form-control" value="{{ old('youtube') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="facebook"><i class="fab fa-facebook"></i> Facebook</label>
                    <input type="url" name="facebook" id="facebook" class="form-control" value="{{ old('facebook') }}">
                </div>
                <div class="form-group">
                    <label for="linkedin"><i class="fab fa-linkedin"></i> LinkedIn</label>
                    <input type="url" name="linkedin" id="linkedin" class="form-control" value="{{ old('linkedin') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="twitter"><i class="fab fa-twitter"></i> Twitter/X</label>
                    <input type="text" name="twitter" id="twitter" class="form-control" value="{{ old('twitter') }}">
                </div>
                <div class="form-group">
                    <label for="github"><i class="fab fa-github"></i> GitHub</label>
                    <input type="text" name="github" id="github" class="form-control" value="{{ old('github') }}">
                </div>
            </div>

            <!-- Gambar untuk Kartu -->
            <h4 style="margin: 20px 0 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;">
                <i class="fas fa-image"></i> Gambar
            </h4>

            <div class="form-row">
                <div class="form-group">
                    <label for="avatar">Avatar (foto profil web)</label>
                    <input type="file" name="avatar" id="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                    <small style="color: #666;">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                    @error('avatar') <br><small style="color: red;">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label for="foto">Foto Kartu (350x350)</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/jpeg,image/png,image/jpg">
                </div>
            </div>
            <div class="form-group">
                <label for="background">Background Kartu (1150x350)</label>
                <input type="file" name="background" id="background" class="form-control" accept="image/jpeg,image/png,image/jpg">
            </div>

            <!-- Pengaturan Akun -->
            <h4 style="margin: 20px 0 15px; color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 5px;">
                <i class="fas fa-cog"></i> Pengaturan Akun
            </h4>

            <div class="form-row">
                <div class="form-group">
                    <label for="membership_type">Tipe Membership <span style="color: red;">*</span></label>
                    <select name="membership_type" id="membership_type" class="form-control @error('membership_type') is-invalid @enderror" required>
                        <option value="regular" {{ old('membership_type') == 'regular' ? 'selected' : '' }}>Regular</option>
                        <option value="premium" {{ old('membership_type') == 'premium' ? 'selected' : '' }}>Premium</option>
                        <option value="vip" {{ old('membership_type') == 'vip' ? 'selected' : '' }}>VIP</option>
                    </select>
                    @error('membership_type') <small style="color: red;">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label for="is_active">Status Akun</label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option value="1" {{ old('is_active') == '0' ? '' : 'selected' }}>Aktif</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('backoffice.grcs.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection