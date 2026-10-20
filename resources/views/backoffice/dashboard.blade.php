{{-- resources/views/backoffice/dashboard.blade.php --}}
@extends('backoffice.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@if($showSuperadminStats)
<div class="stat-grid">
  <div class="stat-mini">
    <div class="num">{{ $totalUsers }}</div>
    <div class="lbl">Total Pengguna</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalKonsultan }}</div>
    <div class="lbl">Konsultan</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalGrcs }}</div>
    <div class="lbl">GRCS Club</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalActive }}</div>
    <div class="lbl">Pengguna Aktif</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalBerita }}</div>
    <div class="lbl">Total Berita</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalBeritaPending }}</div>
    <div class="lbl">Berita Pending</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalEvent }}</div>
    <div class="lbl">Total Event</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalEventPending }}</div>
    <div class="lbl">Event Pending</div>
  </div>
  <a href="{{ route('backoffice.konsultan.verifikasi') }}" class="stat-mini" style="text-decoration:none; border-left: 3.5px solid #CC0000;">
    <div class="num" style="color:#CC0000;">{{ $pendingKonsultanCount ?? 0 }}</div>
    <div class="lbl" style="font-weight:600; color:#333;">Konsultan Perlu Verifikasi</div>
  </a>
  <a href="{{ route('backoffice.grcs.verifikasi') }}" class="stat-mini" style="text-decoration:none; border-left: 3.5px solid #16a34a;">
    <div class="num" style="color:#16a34a;">{{ $pendingGrcsCount ?? 0 }}</div>
    <div class="lbl" style="font-weight:600; color:#333;">GRCS Perlu Verifikasi</div>
  </a>
  <a href="{{ route('backoffice.admission.index') }}" class="stat-mini" style="text-decoration:none; border-left: 3.5px solid #2563eb;">
    <div class="num" style="color:#2563eb;">{{ $totalAdmissionPending }}</div>
    <div class="lbl" style="font-weight:600; color:#333;">Peserta Program Pending</div>
  </a>
  <div class="stat-mini">
    <div class="num">{{ $totalDivisi }}</div>
    <div class="lbl">Divisi Aktif</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalSliders }}</div>
    <div class="lbl">Hero Slider</div>
  </div>
</div>

@if(($pendingKonsultanCount ?? 0) > 0 || ($pendingGrcsCount ?? 0) > 0)
<div class="card" style="margin-top:20px; border: 1.5px solid #fca5a5; background: #fffdfd;">
  <div class="card-header" style="background:#fee2e2; border-bottom:1px solid #fca5a5; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
    <h3 style="color:#991b1b; margin:0; font-size:0.95rem;">
      <i class="fas fa-bell"></i> Antrean Verifikasi Anggota Baru Menunggu Tindakan
    </h3>
    <div style="display:flex; gap:8px;">
      @if(($pendingKonsultanCount ?? 0) > 0)
        <a href="{{ route('backoffice.konsultan.verifikasi') }}" class="btn btn-sm btn-danger" style="background:#CC0000; color:#fff; padding:6px 14px; border-radius:4px; font-weight:600; font-size:0.8rem; text-decoration:none;">
          <i class="fas fa-user-check"></i> Verifikasi Konsultan ({{ $pendingKonsultanCount }})
        </a>
      @endif
      @if(($pendingGrcsCount ?? 0) > 0)
        <a href="{{ route('backoffice.grcs.verifikasi') }}" class="btn btn-sm btn-success" style="background:#16a34a; color:#fff; padding:6px 14px; border-radius:4px; font-weight:600; font-size:0.8rem; text-decoration:none;">
          <i class="fas fa-users-cog"></i> Verifikasi GRCS ({{ $pendingGrcsCount }})
        </a>
      @endif
    </div>
  </div>
  @if(isset($recentPendingKonsultan) && count($recentPendingKonsultan) > 0)
  <div class="card-body table-wrap" style="padding:14px 20px;">
    <table>
      <thead>
        <tr>
          <th>Nama Calon Konsultan</th>
          <th>Kontak / Email</th>
          <th>Tgl Mendaftar</th>
          <th>Dokumen Lampiran</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($recentPendingKonsultan as $pk)
        <tr>
          <td><strong>{{ $pk->name }}</strong></td>
          <td>
            {{ $pk->email }}<br>
            <small style="color:#16a34a;"><i class="fab fa-whatsapp"></i> {{ $pk->phone ?? '-' }}</small>
          </td>
          <td>{{ $pk->created_at->format('d M Y H:i') }}</td>
          <td>
            <span class="badge" style="background:#fef3c7; color:#92400e;">
              {{ $pk->foto ? 'Foto ✓' : 'Tanpa Foto' }} | {{ $pk->cv_path ? 'CV ✓' : 'Tanpa CV' }}
            </span>
          </td>
          <td>
            <a href="{{ route('backoffice.konsultan.verifikasi.show', $pk->id) }}" class="btn btn-sm btn-danger" style="background:#CC0000; color:#fff; font-size:0.75rem; padding:5px 12px; border-radius:4px; text-decoration:none; font-weight:600;">
              <i class="fas fa-check-circle"></i> Tinjau &amp; Verifikasi
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>
@endif

<div class="card" style="margin-top:20px;">
  <div class="card-header">
    <h3><i class="fas fa-tachometer-alt"></i> Selamat Datang, {{ $user->name }}</h3>
  </div>
  <div class="card-body">
    <p style="font-size:0.85rem;color:#666;">Anda login sebagai <strong>Superadmin</strong>.</p>
    <p style="font-size:0.85rem;color:#666;margin-top:8px;">Gunakan menu di sidebar untuk mengelola konten website.</p>
  </div>
</div>

<div class="card" style="margin-top:20px;">
  <div class="card-header">
    <h3><i class="fas fa-user-clock"></i> Pengguna Terbaru</h3>
  </div>
  <div class="card-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Bergabung</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentUsers as $user)
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td><span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
            <td>
              <span class="badge {{ $user->is_active ? 'badge-active' : 'badge-inactive' }}">
                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
              </span>
            </td>
            <td>{{ $user->created_at->format('d M Y') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card" style="margin-top:20px;">
  <div class="card-header">
    <h3><i class="fas fa-newspaper"></i> Berita Terbaru</h3>
  </div>
  <div class="card-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Judul</th>
            <th>Status</th>
            <th>Dibuat</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentBerita as $berita)
          <tr>
            <td>{{ $berita->title }}</td>
            <td>
              <span class="badge {{ $berita->status_badge_class ?? 'badge-regular' }}">
                {{ $berita->status_label ?? $berita->status }}
              </span>
            </td>
            <td>{{ $berita->created_at->format('d M Y') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card" style="margin-top:20px;">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h3><i class="fas fa-graduation-cap"></i> Pendaftaran Peserta Program Terbaru (Admission)</h3>
    <a href="{{ route('backoffice.admission.index') }}" class="btn btn-sm btn-secondary" style="font-size:0.75rem;">Lihat Semua</a>
  </div>
  <div class="card-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Status</th>
            <th>Daftar</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentAdmission as $admission)
          <tr>
            <td>{{ $admission->nama_lengkap }}</td>
            <td>{{ $admission->email }}</td>
            <td>{!! $admission->status_badge !!}</td>
            <td>{{ $admission->created_at->format('d M Y') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endif

@if($showKonsultanStats)
<div class="stat-grid-role">
  <div class="stat-mini">
    <div class="num">{{ $profileCompletion }}%</div>
    <div class="lbl">Kelengkapan Profil</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalBeritaDraft }}</div>
    <div class="lbl">Berita Draft</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalBeritaPublished }}</div>
    <div class="lbl">Berita Terbit</div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3><i class="fas fa-user-tie"></i> Selamat Datang, {{ $user->name }}</h3>
    <span class="badge {{ $membershipStatus === 'active' ? 'badge-active' : ($membershipStatus === 'pending' ? 'badge-pending' : 'badge-inactive') }}">
      {{ ucfirst($membershipStatus) }}
    </span>
  </div>
  <div class="card-body">
    <p style="font-size:0.85rem;color:#666;">Anda login sebagai <strong>Konsultan</strong>.</p>
    
    @if($membershipExpiry)
      <p style="font-size:0.85rem;color:#666;margin-top:8px;">
        <strong>Keanggotaan berlaku hingga:</strong> {{ \Carbon\Carbon::parse($membershipExpiry)->format('d M Y') }}
      </p>
    @else
      <p style="font-size:0.85rem;color:#666;margin-top:8px;">
        Status keanggotaan sedang dalam proses verifikasi.
      </p>
    @endif

    @if($profileCompletion < 100)
      <div class="alert alert-warning" style="margin-top:12px;">
        <i class="fas fa-exclamation-triangle"></i> 
        Lengkapi profil Anda untuk mendapatkan akses penuh. 
        <a href="{{ route('backoffice.profile.edit') }}" class="btn btn-primary btn-sm" style="margin-left:8px;">
          <i class="fas fa-edit"></i> Lengkapi Profil
        </a>
      </div>
    @endif
  </div>
</div>
@endif

@if($showGrcsStats)
<div class="stat-grid-role">
  <div class="stat-mini">
    <div class="num">{{ $profileCompletion }}%</div>
    <div class="lbl">Kelengkapan Profil</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalAdmission }}</div>
    <div class="lbl">Total Pendaftaran</div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3><i class="fas fa-users"></i> Selamat Datang, {{ $user->name }}</h3>
    <span class="badge {{ $membershipStatus === 'active' ? 'badge-active' : ($membershipStatus === 'pending' ? 'badge-pending' : 'badge-inactive') }}">
      {{ ucfirst($membershipStatus) }}
    </span>
  </div>
  <div class="card-body">
    <p style="font-size:0.85rem;color:#666;">Anda login sebagai <strong>GRCS</strong>.</p>
    
    <p style="font-size:0.85rem;color:#666;margin-top:8px;">
      <strong>Divisi:</strong> {{ $division }}
    </p>

    @if($membershipExpiry)
      <p style="font-size:0.85rem;color:#666;margin-top:8px;">
        <strong>Keanggotaan berlaku hingga:</strong> {{ \Carbon\Carbon::parse($membershipExpiry)->format('d M Y') }}
      </p>
    @else
      <p style="font-size:0.85rem;color:#666;margin-top:8px;">
        Status keanggotaan sedang dalam proses verifikasi.
      </p>
    @endif

    @if($profileCompletion < 100)
      <div class="alert alert-warning" style="margin-top:12px;">
        <i class="fas fa-exclamation-triangle"></i> 
        Lengkapi profil Anda untuk mendapatkan akses penuh. 
        <a href="{{ route('backoffice.profile.edit') }}" class="btn btn-primary btn-sm" style="margin-left:8px;">
          <i class="fas fa-edit"></i> Lengkapi Profil
        </a>
      </div>
    @endif
  </div>
</div>
@endif
@endsection