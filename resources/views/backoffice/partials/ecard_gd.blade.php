@php
    $u               = $user ?? $konsultan;
    $sudahPunyaKartu = !empty($u->no_anggota);
    $bisaGenerate    = !empty($u->tanggal_lahir);
    $isSuperadmin    = Auth::user()->role === 'superadmin';
    $isOwner         = Auth::id() == $u->id;

    $berlakuSd = $u->berlaku_sd
        ? \Carbon\Carbon::parse($u->berlaku_sd)
        : null;
    $expired = $berlakuSd ? $berlakuSd->isPast() : false;

    $urlDepan    = route('backoffice.kartu.depan',    $u->id);
    $urlBelakang = route('backoffice.kartu.belakang', $u->id);

    $dlDepan    = $urlDepan    . '?download=1';
    $dlBelakang = $urlBelakang . '?download=1';

    $v = $u->updated_at ? $u->updated_at->timestamp : time();
    $cacheBust = md5($u->id . $u->updated_at . time());
@endphp

<style>
.ecard-section .card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-bottom: 2px solid #CC0000;
}
.ecard-section .card-header h3 {
    margin: 0;
    font-size: 1rem;
    font-weight: 700;
    color: #111;
}

.ecard-alert-expired {
    background: #fff3cd;
    border: 1px solid #ffc107;
    color: #856404;
    padding: 10px 15px;
    border-radius: 6px;
    margin-bottom: 16px;
    font-weight: 600;
    font-size: 0.88rem;
}

.ecard-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 22px;
}

.ecard-preview-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
    justify-content: center;
}
.ecard-preview-item {
    text-align: center;
    flex: 0 0 auto;
}
.ecard-preview-item p {
    font-size: 0.78rem;
    color: #666;
    margin-bottom: 8px;
}
.ecard-preview-item img {
    max-width: 400px;
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.13);
    border: 1px solid #e5e5e5;
    display: block;
}

.ecard-berlaku-info {
    text-align: center;
    margin-top: 14px;
    font-size: 0.85rem;
    color: #555;
}
.ecard-berlaku-info strong {
    color: {{ $expired ? '#CC0000' : '#111' }};
}

.ecard-empty {
    text-align: center;
    padding: 36px 16px;
    color: #666;
}
.ecard-empty i { font-size: 48px; color: #ccc; margin-bottom: 14px; display: block; }
.ecard-empty p { margin: 6px 0; font-size: 0.9rem; }
.ecard-empty .text-danger { color: #CC0000 !important; font-size: 0.88rem; }

.ecard-img-wrap {
    position: relative;
    display: inline-block;
}
.ecard-spinner {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5f5f5;
    border-radius: 12px;
    font-size: 0.8rem;
    color: #888;
}

@media (max-width: 600px) {
    .ecard-preview-item img { max-width: 100%; }
    .ecard-actions { flex-direction: column; }
    .ecard-actions .btn { width: 100%; text-align: center; }
}
</style>

<div class="card ecard-section" style="margin-bottom: 25px;">
    <div class="card-header">
        <h3><i class="fas fa-id-card" style="color:#CC0000; margin-right:8px;"></i>Kartu Anggota Digital</h3>
        @if($sudahPunyaKartu)
            <span style="font-size:0.8rem; color:#555;">
                No. {{ $u->no_anggota }}
            </span>
        @endif
    </div>

    <div class="card-body" style="padding: 20px;">

        @if(!$sudahPunyaKartu)
        <div class="ecard-empty">
            <i class="fas fa-id-badge"></i>
            <p>Belum memiliki nomor anggota. Kartu anggota belum dapat diterbitkan.</p>

            @if(!$bisaGenerate)
                <p class="text-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    Lengkapi <strong>Tanggal Lahir</strong> pada profil terlebih dahulu.
                </p>
            @elseif($isSuperadmin)
                <form action="{{ route('backoffice.profile.ecard.generate', $u->id) }}" method="POST" style="margin-top:14px;">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-magic"></i> Generate e-Card
                    </button>
                </form>
            @else
                <p style="font-size:0.88rem; color:#888; margin-top:10px;">
                    <i class="fas fa-info-circle"></i>
                    Hubungi administrator untuk menerbitkan kartu anggota Anda.
                </p>
            @endif
        </div>

        @else

        @if($expired)
            <div class="ecard-alert-expired">
                <i class="fas fa-exclamation-triangle"></i>
                Kartu sudah kedaluwarsa sejak <strong>{{ $berlakuSd->format('d-m-Y') }}</strong>.
                Silakan perpanjang masa berlaku.
            </div>
        @endif

        <div class="ecard-actions">
            <a href="{{ $dlDepan }}" class="btn btn-primary" download>
                <i class="fas fa-download"></i> Unduh Kartu Depan
            </a>
            <a href="{{ $dlBelakang }}" class="btn btn-secondary" download>
                <i class="fas fa-download"></i> Unduh Kartu Belakang
            </a>

            @if($isSuperadmin || $isOwner)
                <form action="{{ route('backoffice.profile.ecard.renew', $u->id) }}" method="POST"
                      onsubmit="return confirm('Perpanjang masa berlaku kartu 1 tahun dari hari ini?');">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-redo"></i> Perpanjang Masa Berlaku
                    </button>
                </form>
            @endif
        </div>

        <div class="ecard-preview-wrap">

            <div class="ecard-preview-item">
                <p><i class="fas fa-credit-card"></i> Kartu Depan</p>
                <div class="ecard-img-wrap">
                    <div class="ecard-spinner" id="spinner-depan">
                        <span><i class="fas fa-spinner fa-spin"></i> Memuat...</span>
                    </div>
                    <img src="{{ $urlDepan }}?v={{ $v }}&cb={{ $cacheBust }}"
                         alt="Kartu Depan – {{ $u->name }}"
                         onload="document.getElementById('spinner-depan').style.display='none';"
                         onerror="document.getElementById('spinner-depan').innerHTML='<span style=\'color:#CC0000\'>Gagal memuat.<br>Cek template PNG.</span>';"
                         style="min-height:200px;">
                </div>
            </div>

            <div class="ecard-preview-item">
                <p><i class="fas fa-credit-card"></i> Kartu Belakang</p>
                <div class="ecard-img-wrap">
                    <div class="ecard-spinner" id="spinner-belakang">
                        <span><i class="fas fa-spinner fa-spin"></i> Memuat...</span>
                    </div>
                    <img src="{{ $urlBelakang }}?v={{ $v }}&cb={{ $cacheBust }}"
                         alt="Kartu Belakang – {{ $u->name }}"
                         onload="document.getElementById('spinner-belakang').style.display='none';"
                         onerror="document.getElementById('spinner-belakang').innerHTML='<span style=\'color:#CC0000\'>Gagal memuat.<br>Cek template PNG.</span>';"
                         style="min-height:200px;">
                </div>
            </div>

        </div>

        <div class="ecard-berlaku-info">
            Berlaku s.d:
            <strong>{{ $berlakuSd ? $berlakuSd->format('d-m-Y') : '-' }}</strong>
            @if(!$expired && $berlakuSd)
                &nbsp;·&nbsp;
                <span style="color:#2e7d32;">
                    Aktif ({{ $berlakuSd->diffForHumans() }})
                </span>
            @endif
        </div>

        @endif

    </div>
</div>