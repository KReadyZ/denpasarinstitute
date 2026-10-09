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
  <div class="stat-mini">
    <div class="num">{{ $totalAdmission }}</div>
    <div class="lbl">Total Pendaftaran</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalAdmissionPending }}</div>
    <div class="lbl">Pendaftaran Pending</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalDivisi }}</div>
    <div class="lbl">Divisi Aktif</div>
  </div>
  <div class="stat-mini">
    <div class="num">{{ $totalSliders }}</div>
    <div class="lbl">Hero Slider</div>
  </div>
</div>

<div class="card">
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
  <div class="card-header">
    <h3><i class="fas fa-file-signature"></i> Pendaftaran Terbaru</h3>
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